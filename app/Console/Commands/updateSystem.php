<?php

namespace App\Console\Commands;

use App\Models\active_orders_person_data;
use App\Models\device_data;
use App\Models\device_orders;
use App\Models\einkauf;
use App\Models\hinweis;
use App\Models\inventar;
use App\Models\inventar_bestellung;
use App\Models\maindata;
use App\Models\phone_history;
use App\Models\seal;
use App\Models\versand_statuscode;
use App\Models\überwachung;
use Database\Seeders\active_orders_person_datas;
use DateTime;
use Illuminate\Console\Command;

class updateSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateSystem';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $this->updateStatusCodes();
        $this->updateTagesabschluss();
        $this->updateStatuses();
        $this->checkRechnungforLoss();
        $this->updateEntsorgungsliste();

        return Command::SUCCESS;
    }

    public function updateEntsorgungsliste() {
        $devices = device_orders::all();
        foreach($devices as $device) {
            $order = active_orders_person_data::where("process_id", $device->process_id)->first();

            if($order != null) {
                $seconddate      = date($order->updated_at->format("Y-m-d H:i:s"));
                $seconddate      = date_create($seconddate);
                $seconddate      = $seconddate->modify("+2 days");
                
                $firstdate      = date("Y-m-d H:i:s"); 
                $firstdate      = date_create($firstdate);
                $diff           = date_diff($firstdate, $seconddate);
                if($diff->days >= 1 && $seconddate > $firstdate) {
                   
                    $history = new phone_history();
                    $history->process_id = $order->process_id;
                    $history->lead_name = "";
                    $history->status = "Entsorgung";
                    $history->message = "Gerät $device->component_number steht nun auf der Entsorgungsliste";
                    $history->employee = "System";
                    $history->save();
                }
            }
        }
    }

    public function updateStatusCodes() {
        $codes = versand_statuscode::where("bezeichnung", null)->first();

        if($codes != null) {

            $warning = hinweis::where("hinweis", "Es wurden Statuscodes ohne eigene Bezeichnung gefunden")->first();

            if($warning == null) {
                $warning = new überwachung();
                $warning->employee = "System";
                $warning->type = "Statuscodes";
                $warning->text = "Es wurden Statuscodes ohne eigene Bezeichnung gefunden";
                $warning->save();
    
                $warning = new hinweis();
                $warning->employee = "System";
                $warning->area = "Auftragsübersicht";
                $warning->hinweis = "Es wurden Statuscodes ohne eigene Bezeichnung gefunden";
                $warning->color = "#ffffff";
                $warning->save();
            }

           
        }
    }

    public function updateTagesabschluss() {

        $inventar = inventar::all();
        
        foreach($inventar as $inv) {
            $bestellung = inventar_bestellung::where("itemid", $inv->id)->latest()->first();
            
           if($inv->timediff != null) {

            if($bestellung != null) {

                

                $now = new DateTime();
                $diff = $bestellung->created_at->diff($now);

                if($diff->d < $inv->timediff) {

                    $warning = hinweis::where("hinweis", "Das Material " . $inv->name . " wurde in zu kurzer Zeit wieder bestellt.")->first();

                    if($warning == null) {
                        $warning = new hinweis();
                        $warning->employee = "System";
                        $warning->area = "Auftragsübersicht";
                        $warning->hinweis = "Das Material " . $inv->name . " wurde in zu kurzer Zeit wieder bestellt.";
                        $warning->color = "#ffffff";
                        $warning->save();

                        $warning = new überwachung();
                        $warning->employee = "System";
                        $warning->type = "Materialinventur";
                        $warning->text = "Das Material " . $inv->name . " wurde in zu kurzer Zeit wieder bestellt.";
                        $warning->save();
                    }
                }
            }
           }
            
        }
    }

    public function updateStatuses() {
        $order = active_orders_person_data::with("statuse")->get();
        foreach($order as $o) {
            if($o->statuse->sortByDesc("created_at")->first()->last_status == 1) {
                $o->archiv = true;
                $o->save();
            }
        }
    }

    public function checkRechnungforLoss() {
        $orders = active_orders_person_data::with("rechnungen")->get();

        foreach($orders as $order) {
            $total = 0;
            foreach($order->rechnungen as $rechnung) {
                $total += $rechnung->bruttobetrag;
            }

            $einkäufe = einkauf::where("process_id", $order->process_id)->get();
            foreach($einkäufe as $einkauf) {
                $total -= $einkauf->price;
                
            }

            if($total < 0) {
                $hinweisText = "Der Auftrag $order->process_id geht ins Negative";
                $hinweis = hinweis::where("process_id", $order->process_id)->where("hinweis", $hinweisText)->first();
                if($hinweis == null) {

                    $hinweis = überwachung::where("text", $hinweisText)->first();
                    if($hinweis == null) {
                        $info = new hinweis();
                        $info->employee = "System";
                        $info->area = "Auftragsübersicht";
                        $info->hinweis = $hinweisText;
                        $info->color = "#ffffff";
                        $info->process_id = $order->process_id;
                        $info->save();
                    }
                    
                }
            }
        }
    }

    public function deleteSiegelAfterDays() {
        $finalDays = maindata::where("id", "1")->first()->seal_days;
        $seals = seal::where('created_at', '<', now()->subDays($finalDays))->get();
    
        foreach ($seals as $seal) {
            $seal->delete();
        }
    }
}
