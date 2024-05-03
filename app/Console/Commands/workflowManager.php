<?php

namespace App\Console\Commands;

use App\Http\Controllers\auftrags_CONTROLLER;
use App\Mail\mail_template;
use App\Models\active_orders_person_data;
use App\Models\email_template;
use App\Models\emailinbox;
use App\Models\new_leads_person_data;
use App\Models\phone_history;
use App\Models\status_histori;
use App\Models\statuse;
use App\Models\user_workflow;
use App\Models\warenausgang;
use App\Models\wareneingang;
use App\Models\workflow;
use App\Models\workflow_addon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class workflowManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:workflowManager';

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
        $this->workflowCases("workflow", "addon");
        return Command::SUCCESS;
    }

    public function workflowCases($workflow, $addon) {

        $workflows = user_workflow::all();

        $usedWorkflows = array();

        $used = false;
        foreach($workflows as $wf) {

            if(!in_array($wf->team_id, $usedWorkflows)) {
                $order = active_orders_person_data::where("process_id", $wf->process_id)->first();
                if($order == null) {
                    $order = new_leads_person_data::where("process_id", $wf->process_id)->first();
                }
                
                if($order != null) {
                    if($order->workflowpause != "pause") {
                        
                        //get the latest index of user_workflow where the checked state is true
                    $newestWF = user_workflow::where("process_id", $wf->process_id)->where("checked", true)->latest()->get();
    
                    if($newestWF->isEmpty()) {
                        $newestWF = user_workflow::where("process_id", $wf->process_id)->first();
                    } else {
                        
                        $newestWF = user_workflow::where("id", $newestWF[0]->id + $newestWF->count())->first();
                    }
                    if($newestWF != null) {
                       
                        $result = null;
                    
                        if($newestWF != null) {
                            
                            if($newestWF->checked != 1) {
                                
                                switch ($newestWF->aktion) {
        
                                    case 'Status prüfen':
                                        $result = $this->statusPrüfen($newestWF->id, $newestWF->addon);
                                        break;
            
                                    case 'Status setzen':
                                        $result = $this->statusSetzen($newestWF->process_id, $newestWF->addon);
                                        break;
            
                                    case 'E-Mail senden':
                                        $result = $this->emailSenden($newestWF->process_id, $newestWF->addon);
                                        break;
    
                                    case 'Verschieben':
                                        $result = $this->verschieben($newestWF->process_id, $newestWF->addon);
                                        break;

                                    case 'Wareneingang prüfen':
                                        $result = $this->wareneingangPrüfen($newestWF->process_id, $newestWF->id);
                                        break;

                                    case 'Packtisch':
                                        $result = $this->packtischPrüfen($newestWF->process_id, $newestWF->addon);
                                        break;

                                    case 'Posteingang prüfen':
                                        $result = $this->posteingangPrüfen($newestWF->process_id, $newestWF->addon);
                                        break;

                                    case 'Versandauftrag Kunde':
                                        $result = $this->versandauftragKunde($newestWF->process_id, $newestWF->addon, $newestWF->id);
                                        break;

                                    case 'Versandauftrag Techniker':
                                        $result = $this->versandauftragTechniker($newestWF->process_id, $newestWF->addon, $newestWF->id);
                                        break;
                                        
                            
                                    default:
                
                                        break;
                                }
                                $newestWF->checked = $result;
                                if($result == true) {
                                    $used = true;
                                }
                            } 
                            
                        }
                        $newestWF->save();
                    }
    
            
                    }
                }

                array_push($usedWorkflows, $wf->team_id);
            }
        }
        if($used == true) {
            $this->workflowCases($workflow, $addon);
        }
    }

    public function versandauftragTechniker($id, $type ,$workflowid) {
        $addon = workflow_addon::where("workflowid", $workflowid)->first();
        if($addon != null) {

            $warenausgang = new warenausgang();
            $warenausgang->process_id = $id;
            $warenausgang->component_number = $addon->component_number;
            $warenausgang->save();

            $order = active_orders_person_data::where("process_id", $id)->first();
            if($order == null) {
                $order = new_leads_person_data::where("process_id", $id)->first();
            }
            $order->workflowpause = "";
            $order->save();

            return true;
        } else {
            $order = active_orders_person_data::where("process_id", $id)->first();
            if($order == null) {
                $order = new_leads_person_data::where("process_id", $id)->first();
            }
            $order->workflowpause = "error";
            $order->save();
            

            return "Error, Techniker & Gerät muss ausgewählt werden!";
        }
    }

    public function packtischPrüfen($id, $type) {

        return null;
    }

    public function versandauftragKunde($id, $type ,$workflowid) {
        $addon = workflow_addon::where("workflowid", $workflowid)->first();
        if($addon != null) {

            $warenausgang = new warenausgang();
            $warenausgang->process_id = $id;
            $warenausgang->component_number = $addon->component_number;
            $warenausgang->save();

            $order = active_orders_person_data::where("process_id", $id)->first();
            if($order == null) {
                $order = new_leads_person_data::where("process_id", $id)->first();
            }
            $order->workflowpause = "";
            $order->save();

            return true;
        } else {
            $order = active_orders_person_data::where("process_id", $id)->first();
            if($order == null) {
                $order = new_leads_person_data::where("process_id", $id)->first();
            }
            $order->workflowpause = "error";
            $order->save();
            

            return "Error, Gerät muss ausgewählt werden!";
        }
    }

    public function posteingangPrüfen($id, $type) {

        $inbox = emailinbox::where("assigned", $id)->first();
        if($inbox != null) {
            return true;
        } else {
            return null;
        }

    }

    public function wareneingangPrüfen($id ,$workflowid) {

        $addon = workflow_addon::where("workflowid", $workflowid)->first();

        if($addon == null) {

            $order = active_orders_person_data::where("process_id", $id)->first();
            if($order == null) {
                $order = new_leads_person_data::where("process_id", $id)->first();
            }
            $order->workflowpause = "error";
            $order->save();

            return "Error, Gerät muss ausgewählt werden!";

        } else {

            

            $device = wareneingang::where("process_id", $id)->first();

            if($device != null) {
                return true;
            } else {

                return null;
            }
        }

        
    }

    public function verschieben($id, $type) {

        $parts = explode("-", $type);

        $oldType = "Auftrag";

        $order = active_orders_person_data::where("process_id", $id)->first();
        if($order == null) {
            $oldType = "Leads";
            $order = new_leads_person_data::where("process_id", $id)->first();
        }

        if($parts[0] == "Auftrag") {
            if($parts[1] == "Aktiv") {

                if($oldType == "Leads") {

                    $auftrag = new auftrags_CONTROLLER();
                    $auftrag->moveto_orders($order->process_id);

                } else {

                    $order->archiv = false;
                    $order->save();
                }

            } else {
                   
                    if($oldType == "Leads") {
    
                        $auftrag = new auftrags_CONTROLLER();
                        $auftrag->moveto_orders($order->process_id);
                        $order = active_orders_person_data::where("process_id", $id)->first();
                        $order->archiv = true;
                        $order->save();
    
                    } else {

                        $order->archiv = true;
                        $order->save();
                    }
            }
        }


        if($parts[0] == "Interessenten") {
            if($parts[1] == "Aktiv") {

                if($oldType == "Leads") {

                    $auftrag = new auftrags_CONTROLLER();
                    $auftrag->moveto_leads($order->process_id);

                } else {

                    $order->archiv = false;
                    $order->save();
                }

            } else {
                   
                    if($oldType == "Leads") {
    
                        $auftrag = new auftrags_CONTROLLER();
                        $auftrag->moveto_leads($order->process_id);
                        $order = new_leads_person_data::where("process_id", $id)->first();
                        $order->archiv = true;
                        $order->save();
    
                    } else {

                        $order->archiv = true;
                        $order->save();
                    }
            }
        }
        return true;

    }

    public function emailSenden($id, $emailid) {
        $order = active_orders_person_data::where("process_id", $id)->first();
        
        $email = email_template::where("id", $emailid)->first();

        Mail::to($order->email)->send(new mail_template($order, $email->subject , $email->body));

        $phone = new phone_history();
        $phone->process_id = $id;
        $phone->lead_name = "E-Mail";
        $phone->message = $email->body;
        $phone->employee = "System";
        $phone->save();

        return true;

    }
    
    public function statusSetzen($id, $status) {

        $history = new status_histori();
        $history->process_id = $id;
        $history->last_status = $status;
        $history->changed_employee = "System";
        $history->save();

        $status = statuse::where("id", $status)->first();

        $phone = new phone_history();
        $phone->process_id = $id;
        $phone->lead_name = "Status";
        $phone->message = $status->name;
        $phone->employee = "System";
        $phone->save();

        return true;
    }

    public function statusPrüfen($id, $status) {
        $workflow = user_workflow::where("id", $id)->first();
        $history = status_histori::where("process_id", $workflow->process_id)->latest()->first();

        

        if ($history->last_status == $status) {

            $phone = new phone_history();
            $phone->process_id = $id;
            $phone->lead_name = "Status prüfen";
            $phone->message = $status;
            $phone->employee = "System";
            $phone->save();

            return true;
        } else {
            return null;
        }
    }
}
