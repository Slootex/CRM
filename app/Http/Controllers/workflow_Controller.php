<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

class workflow_Controller extends Controller
{
    

    public function workflowCases($id) {

        $workflows = user_workflow::where("process_id", $id)->get();

        foreach($workflows as $wf) {


                $order = active_orders_person_data::where("process_id", $wf->process_id)->first();
                if($order == null) {
                    $order = new_leads_person_data::where("process_id", $wf->process_id)->first();
                }
                
                if($order != null) {
                        

                       
                        $result = null;
                    
                            
                                
                                switch ($wf->aktion) {
        
                                    case 'Status prüfen':
                                        $result = $this->statusPrüfen($wf->id, $wf->addon);
                                        break;
            
                                    case 'Status setzen':
                                        $result = $this->statusSetzen($wf->process_id, $wf->addon);
                                        break;
            
                                    case 'E-Mail senden':
                                        $result = $this->emailSenden($wf->process_id, $wf->addon);
                                        break;
    
                                    case 'Verschieben':
                                        $result = $this->verschieben($wf->process_id, $wf->addon);
                                        break;

                                    case 'Wareneingang prüfen':
                                        $result = $this->wareneingangPrüfen($wf->process_id, $wf->id);
                                        break;

                                    case 'Packtisch':
                                        $result = $this->packtischPrüfen($wf->process_id, $wf->addon);
                                        break;

                                    case 'Posteingang prüfen':
                                        $result = $this->posteingangPrüfen($wf->process_id, $wf->addon);
                                        break;

                                    case 'Versandauftrag Kunde':
                                        $result = $this->versandauftragKunde($wf->process_id, $wf->addon, $wf->id);
                                        break;

                                    case 'Versandauftrag Techniker':
                                        $result = $this->versandauftragTechniker($wf->process_id, $wf->addon, $wf->id);
                                        break;
                                        
                            
                                    default:
                
                                        break;
                                }
                                if(str_contains($result, "Error")) {
                                    $wf->checked = $result;
                                    $order->workflowpause = "error";
                                    $order->save();
                                }  else {
                                    $wf->checked = $result;
                                    $order->workflowpause = "pause";
                                    $order->save();
                                }
                                if($result == true) {
                                    $used = true;
                                }
                            
                            
                        
                        $wf->save();
                    
    
            
                    }
                

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
            return true;
        } else {
            return null;
        }
    }

}
