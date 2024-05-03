<?php

namespace App\Http\Controllers;

use App\Http\Controller\newBroadcast;
use App\Http\Controllers\Broadcast as ControllersBroadcast;
use App\Mail\abholung;
use App\Mail\mail_template;
use App\Mail\technikerlabel;
use Illuminate\Support\Facades\File as SystemFile;
use App\Models\active_orders_person_data;
use App\Models\allowBarcodes;
use App\Models\archive_orders_person;
use App\Models\emailinbox;
use App\Models\entsorgung_extendtime;
use App\Models\seal;
use App\Models\hinweis;
use App\Models\mahnungen;
use App\Models\phone_history;
use App\Models\pickup;
use App\Models\scanhistory;
use App\Models\shelfe_count;
use App\Models\tracking_history;
use App\Models\unv_kunde;
use App\Models\upsErrorCodes;
use App\Models\used_shelfes;
use App\Models\überwachung;
use Illuminate\Http\Request;
use App\Models\shelfe;
use App\Models\order_id;
use App\Models\intern;
use App\Models\new_leads_car_data;
use App\Models\active_orders_car_data;
use App\Models\allowBarcode;
use App\Models\archive_lead_person_data;
use App\Models\attachment;
use App\Models\booking;
use App\Models\bpzfile;
use App\Models\component_name;
use App\Models\contact;
use App\Models\countrie;
use App\Models\device_data;
use App\Models\leads_archive_person;
use App\Models\leads_archive_car;
use App\Models\wareneingang;
use App\Models\device_orders;
use App\Models\new_leads_person_data;
use App\Models\status_histori;
use App\Models\statuse;
use App\Models\intern_history;
use App\Models\maindata;
use App\Models\email_template;
use App\Models\employee as employeeModel;
use App\Models\file;
use App\Models\file_attachment;
use App\Models\helpercode;
use App\Models\inshipping;
use App\Models\intern_admin;
use App\Models\inventar;
use App\Models\inventar_bestellung;
use App\Models\kundenkonto;
use App\Models\new_orders_person_declaration;
use App\Models\packtisch_problem;
use App\Models\permission;
use App\Models\primary_device;
use App\Models\rechnungen;
use App\Models\shelfes_archive;
use App\Models\shipping_order;
use App\Models\tagesabschluss;
use App\Models\tracking;
use App\Models\transportschaden;
use App\Models\user;
use App\Models\warenausgang;
use App\Models\warenausgang_archive;
use App\Models\warenausgang_history;
use Barryvdh\DomPDF\PDF;
use DateTime;
use Illuminate\Http\File as HttpFile;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D as BarcodeDNS1D;
use Pusher\Pusher;
use setasign\Fpdi\Fpdi;
use src\Milon\Barcode\DNS1D;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Uid\Uuid;

class packtisch_CONTROLLER extends Controller
{

    public $historie_site_counter = 5;

    public function new_device(Request $req, $process_id, $id = null) {
        $empty_shelfe   = $req->input("shelfe");
        $empty_shelfe   = shelfe::where("shelfe_id", $empty_shelfe)->first();
        $component_id   = $req->input("componentid");
        $component_type   = $req->input("componenttype");
        $component_count   = $req->input("componentcount");
        $device     = device_orders::where("component_number", $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count)->first();

        if($device == null) {

            $first_device = device_orders::where("process_id", $process_id)->first();

            $device_order                   = new device_orders();
            $device_order->process_id       = $process_id;
            $device_order->component_id     = $component_id;
            $device_order->component_type   = $component_type;
            $device_order->component_count  = $component_count;
            $device_order->opened           = $req->input("öffnung");
            $device_order->sticker          = $req->input("stickers");
            $device_order->component_number = $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count;
            if($first_device == null) {
                $device_order->primary_device = "true";
            }
            $device_order->save();
    
            $order                          = active_orders_person_data::where("process_id", $process_id)->first();
            if($order == null) {
            }

            if($order == null) {

                $this->moveto_orders($req, $process_id);
            }

            $status = statuse::where("id", 3736)->first();

            $his = new phone_history();
            $his->process_id = $process_id;
            $his->lead_name = "";
            $his->employee = auth()->user()->id;
            $his->status = $status->name;
            $his->message = "Gerät $device_order->component_number, Lager $empty_shelfe->shelfe_id";
            $his->device = $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count;
            $his->shelfe = $empty_shelfe->shelfe_id;
            $his->save();

            $dev = device_orders::where("component_number", $device_order->component_number)->first();
            $dev->ort = "Wareneingang (Neueinlagerung)";
            $dev->save();
        } else {
            $status = statuse::where("id", 4196)->first();

            $his = new phone_history();
            $his->process_id = $process_id;
            $his->lead_name = "";
            $his->employee = auth()->user()->id;
            $his->status = $status->name;
            $his->message = "Gerät $device->component_number, Lager $empty_shelfe->shelfe_id";
            $his->device = $device->component_number;
            $his->shelfe = $empty_shelfe->shelfe_id;
            $his->save();

            $dev = device_orders::where("component_number", $device->component_number)->first();
            $dev->ort = "Wareneingang (Wiedereinlagerung)";
            $dev->save();
        }

        $shipped    = inshipping::where("component_number", $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count)->first();
        if($shipped != null) {
            $shipped->delete();
        }

        $component_number = $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count;
        
       



        if($req->input("öffnung") == "on") {
            $opend = "Ja";
            $order = active_orders_person_data::where("process_id", $process_id)->first();
            $order->hinweis = "Gerät: " . $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count . " wurde bereits geöffnet";
            $order->save();
        } else {
            $opend = "Nein";
        }
        if($req->input("sticker") == "on") {
            $sticker = "Ja";
        } else {
            $sticker = "Nein";
        }
        $shelfe_id = $empty_shelfe->shelfe_id;


        $shelfe = $this->addToShelfe($shelfe_id, $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count);
        if($shelfe == "error") {
            return redirect()->back()->withErrors(["Lagerplatz konnte nicht hinzugefügt werden"]);
        }

        $wareneingang                   = new wareneingang();
        $wareneingang->process_id       = $process_id;
        $wareneingang->component_id     = $component_id;
        $wareneingang->component_type   = $component_type;
        $wareneingang->component_number = $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count;
        $wareneingang->component_count  = $component_count;
        $wareneingang->employee         = auth()->user()->id;
        $wareneingang->opened           = $req->input("öffnung");
        $wareneingang->sticker          = $req->input("stickers");
        $wareneingang->used_shelfe      = $empty_shelfe->shelfe_id;
        $wareneingang->auftragsfotos    = $req->input("a-fotos");
        $wareneingang->gerätefotos      = $req->input("g-fotos");
        $wareneingang->save();

        $this->packtischStatusÄndern($req, "packtisch", 917, $process_id, $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count, $empty_shelfe->shelfe_id, null, null, null, $opend, $sticker);

        $person = active_orders_person_data::where("process_id", $process_id)->first();

        $email      = email_template::where("id", 107)->first();

        $type = $req->input("type");
        if($type == "normal") {
            return redirect("crm/packtisch");
        }
        if($type == "original") {
            return $this->getNewComponentView($req, $process_id);
        }
        if($type == "austausch") {
            
            return $this->getNewComponentView($req, $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count, "on");
            
        }
       
    }

    public function new_device_view(Request $req) {

        
       
        $component_type             = $req->input("component");
        $componetn_number           = $req->input("component_number");
        $shelfe                     = $req->input("shelfe");
        $process_id                 = $req->input("process_number");

        $process_parts      = explode("-", $process_id);
        $order_id         = $process_parts[0];

        
        $no_barcode                 = $req->input("shopin_order");
        $allow = allowBarcodes::where("setting", "true")->first();
        if($allow == null) {
            $allow = allowBarcodes::where("setting", "false")->first();

        }
        if($no_barcode == "no_order_number") {
            
            $helpercode             = $this->createHelperCode();
            $shelfe                 = $this->getFreeShelfe();
            return view("forMitarbeiter/packtisch/no_barcode")->with("helpercode", $helpercode)->with("shelfe", $shelfe);
            
        } else {

            $order              = new_leads_person_data::where("process_id", $order_id)->first();
            if($order == null) {
                $order      = active_orders_person_data::where("process_id", $order_id)->first();
            }
            if(str_contains($process_id, "ORG")) {
                if($component_type != null) {
                    
                    $process_parts      = explode("-", $process_id);
                    $process_id         = $process_parts[0];
                    $component_id       = $process_parts[1];
                    $component_type     = $process_parts[2];
                    $component_count    = $process_parts[3];
        
                    
                    $order_component_id = device_orders::where("process_id", $process_id)->where("component_id", $component_id)->first();
                    if($order != null) {
                        if($order_component_id != null) {
                        $empty_shelfe   = $this->getFreeShelfe();
                        
                        $component      = $this->createATComponentId($process_id, $component_id);
                        $component_id   = $component[0];
                        $component_type = $component[1];
                        $component_count= $component[2];
                        $component_name = $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count;
                        
                       if($componetn_number != null) {
                        return view("forEmployees/packtisch/new-device")->with("shelfe", $empty_shelfe)->
                        with("component_name", $component_name)->
                        with("component_id", $component_id)->
                        with("component_type", $component_type)->
                        with("component_count", $component_count)->
                        with("process_id", $process_id)->
                        with("allow", $allow)->
                        with("order", $order)->
                        with("wiedereinlagern", "yes");
                       } else {
                        return view("forEmployees/packtisch/new-device")->with("shelfe", $empty_shelfe)->
                        with("component_name", $component_name)->
                        with("component_id", $component_id)->
                        with("component_type", $component_type)->
                        with("component_count", $component_count)->
                        with("process_id", $process_id)->
                        with("allow", $allow)->
                        with("order", $order)->
                        with("wiedereinlagern", "yes");
                       }
                    } else {
                            return redirect()->back()->withErrors(["Auftrag konnte nicht gefunden werden!"]);
                    }
                }
                } else {

                    $shelfe             = shelfe::where("component_number", $process_id)->first();
                    if($shelfe != null) {
                        return redirect()->back()->withErrors(["Das Gerät liegt bereits im Lager auf: ". $shelfe->shelfe_id]);
                    } else {
                        $empty_shelfe   = $this->getFreeShelfe();
                        
                        $component_name     = $process_id;
                        $process_parts      = explode("-", $process_id);
                        $process_id         = $process_parts[0];
                        $component_id       = $process_parts[1];
                        $component_type     = $process_parts[2];
                        $component_count    = $process_parts[3];

                        return view("forEmployees/packtisch/new-device")->with("shelfe", $empty_shelfe)->
                        with("component_name", $component_name)->
                        with("component_id", $component_id)->
                        with("component_type", $component_type)->
                        with("component_count", $component_count)->
                        with("process_id", $process_id)->
                        with("allow", $allow)->
                        with("order", $order)->
                        with("wiedereinlagern", "yes");
                    }
                }
            } else if(str_contains($process_id, "AT")) {
                if($component_type != null) {
                    $shelfe             = shelfe::where("component_number", $process_id)->first();
                    if($shelfe != null) {
                        return redirect()->back()->withErrors(["Das Gerät liegt bereits im Lager auf: ". $shelfe->shelfe_id]);
                    } else {
                        $empty_shelfe   = $this->getFreeShelfe();
                        
                        $component_name     = $process_id;
                        $process_parts      = explode("-", $process_id);
                        $process_id         = $process_parts[0];
                        $component_id       = $process_parts[1];
                        $component_type     = $process_parts[2];
                        $component_count    = $process_parts[3];

                        return view("forEmployees/packtisch/new-device")->with("shelfe", $empty_shelfe)->
                        with("component_name", $component_name)->
                        with("component_id", $component_id)->
                        with("component_type", $component_type)->
                        with("component_count", $component_count)->
                        with("process_id", $process_id)->
                        with("allow", $allow)->
                        with("order", $order)->
                        with("wiedereinlagern", "yes");
                    }
                } else {
                    return redirect()->back()->withErrors(["Muss vielleicht AT angeklickt werden?"]);
                }
            } else {
                
                if($component_type == null) { 
                   
                    if($order != null) {
                        $empty_shelfe   = $this->getFreeShelfe();
                        
                        
                        if($componetn_number != null) {
                            $component      = explode("-", $componetn_number);
                            $component_id   = $component[0];
                            $component_type = $component[1];
                            $component_count= $component[2];
                            $component_name = $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count;
    
                            return view("forEmployees/packtisch/new-device")->with("shelfe", $empty_shelfe)->
                            with("component_name", $component_name)->
                            with("component_id", $component_id)->
                            with("component_type", $component_type)->
                            with("component_count", $component_count)->
                            with("process_id", $process_id)->
                            with("allow", $allow)->
                            with("order", $order);
                       } else {
                        
                        $component      = $this->createORGComponentId($process_id);
                        $component_id   = $component[0];
                        $component_type = $component[1];
                        $component_count= $component[2];
                        $component_name = $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count;
                        
                        return view("forEmployees/packtisch/new-device")->with("shelfe", $empty_shelfe)->
                        with("component_name", $component_name)->
                        with("component_id", $component_id)->
                        with("component_type", $component_type)->
                        with("component_count", $component_count)->
                        with("process_id", $process_id)->
                        with("allow", $allow)->
                        with("order", $order)->
                        with("neu", "yes");
                       }
    
    
                    } else {
                        return redirect()->back()->withErrors(["Auftrag konnte nicht gefunden werden! (Kein Barcode nutzen?)"]);
                    }
                } else{
                    return redirect()->back()->withErrors(["Es muss erst ein ORG erstellt werden"]);
                }
                if($component_type == "3") {
                    $shelfe   = shelfe::where("shelfe_id", $shelfe)->first();
                    
                    $component      = explode("-", $componetn_number);
                    $component_id   = $component[0];
                    $component_type = $component[1];
                    $component_count= $component[2];
                    $component_countt= $component[3];
                    $component_name = $component_id . "-" . $component_type . "-" . $component_count . "-". $component_countt;
                    return view("forEmployees/packtisch/new-device")->with("shelfe", $shelfe)->
                            with("component_name", $component_name)->
                            with("component_id", $component_id)->
                            with("component_type", $component_type)->
                            with("component_count", $component_count)->
                            with("process_id", $process_id)->
                            with("allow", $allow)->
                            with("order", $order);
                }
    
               
                }
        }

        

    }

    function createORGComponentId($process_id) {
        $order_from_db          = device_orders::where("process_id", $process_id)->where("component_type", "ORG")->get();
        if($order_from_db->isEmpty())
        {
            $first_number       = rand(1,9);
            $second_number      = rand(1,9);

            $component_id       = "". $first_number. $second_number;
            $component_type     = "ORG";
            $component_count    = "1";
            

            return [$component_id, $component_type, $component_count];
            
        } else
        {
            $first_number       = rand(1,9);
            $second_number      = rand(1,9);
          

            $component_id       = "". $first_number. $second_number;
            $component_type     = "ORG";
            $component_count    = $order_from_db->count() + 1;
            

            return [$component_id, $component_type, $component_count];
        }
    }

    public function createATComponentId($process_id, $component_id_org) {
        $order_from_db          = device_orders::where("component_id", $component_id_org)->where("component_type", "AT")->get();
        if($order_from_db->isEmpty())
        {
            $first_number       = rand(1,9);
            $second_number      = rand(1,9);
            $third_number       = rand(1,9);
            $fourth_number      = rand(1,9);
            $fifth_number       = rand(1,9);

            $component_id       = $component_id_org;
            $component_type     = "AT";
            $component_count    = "1";
            

            return [$component_id, $component_type, $component_count];
            
        } else
        {
            $first_number       = rand(1,9);
            $second_number      = rand(1,9);
            $third_number       = rand(1,9);
            $fourth_number      = rand(1,9);
            $fifth_number       = rand(1,9);

            $component_id       = $component_id_org;
            $component_type     = "AT";
            $component_count    = $order_from_db->count() + 1;
            

            return [$component_id, $component_type, $component_count];
        }
    }
    public function createHelperCode() {
       
            $first_number       = rand(1,9);
            $second_number      = rand(1,9);
            $third_number       = rand(1,9);
            $fourth_number      = rand(1,9);

            $helper_code       = $first_number.$second_number.$third_number.$fourth_number;


            return $helper_code;
        
    }

    public function moveto_orders($req, $id) {
        
        $lead_person            = new_leads_person_data::where("process_id", $id)->first();
        $active_order_person    = new active_orders_person_data();
        
        $active_order_person->send_back_company_name                = $lead_person->send_back_company_name;
        $active_order_person->send_back_gender                      = $lead_person->send_back_salutation;
        $active_order_person->send_back_firstname                   = $lead_person->send_back_firstname;
        $active_order_person->send_back_lastname                    = $lead_person->send_back_lastname;
        $active_order_person->send_back_zipcode                     = $lead_person->send_back_zipcode;
        $active_order_person->send_back_street                      = $lead_person->send_back_street;
        $active_order_person->send_back_street_number               = $lead_person->send_back_street_number;
        $active_order_person->send_back_city                        = $lead_person->send_back_city;
        $active_order_person->send_back_country                     = $lead_person->send_back_country;
        $active_order_person->process_id                            = $lead_person->process_id;
        $active_order_person->gender                                = $lead_person->gender;
        $active_order_person->employee                              = $lead_person->employee;
        $active_order_person->company_name                          = $lead_person->company_name;
        $active_order_person->firstname                             = $lead_person->firstname;
        $active_order_person->lastname                              = $lead_person->lastname;
        $active_order_person->email                                 = $lead_person->email;
        $active_order_person->phone_number                          = $lead_person->phone_number;
        $active_order_person->mobile_number                         = $lead_person->mobile_number;
        $active_order_person->home_street                           = $lead_person->home_street;
        $active_order_person->home_street_number                    = $lead_person->home_street_number;
        $active_order_person->home_zipcode                          = $lead_person->home_zipcode;
        $active_order_person->home_city                             = $lead_person->home_city;
        $active_order_person->home_country                          = $lead_person->home_country;
        $active_order_person->pricemwst                             = $lead_person->pricemwst;
        $active_order_person->shipping_type                         = $lead_person->shipping_type;
        $active_order_person->payment_type                          = $lead_person->payment_type;
        $active_order_person->submit_type                           = $lead_person->submit_type;
        $active_order_person->zuteilung                             = $lead_person->zuteilung;
        $active_order_person->last_payment                          = $lead_person->last_payment;
        $active_order_person->kunden_id                            = $lead_person->kunden_id;

        $active_order_person->save();

       

        $lead_person->delete();

        $lead_car               = new_leads_car_data::where("process_id", $id)->first();
        #NEW CAR
        $new_orders_car_declaration                             = new active_orders_car_data();
        $new_orders_car_declaration->process_id                 = $lead_car->process_id;
        $new_orders_car_declaration->car_company                = $lead_car->car_company;
        $new_orders_car_declaration->car_model                  = $lead_car->car_model;
        $new_orders_car_declaration->production_year            = $lead_car->production_year;
        $new_orders_car_declaration->car_identification_number  = $lead_car->car_identification_number;
        $new_orders_car_declaration->car_power                  = $lead_car->car_power;
        $new_orders_car_declaration->mileage                    = $lead_car->mileage;
        $new_orders_car_declaration->transmission               = $lead_car->transmission;
        $new_orders_car_declaration->fuel_type                  = $lead_car->fuel_type;
        $new_orders_car_declaration->broken_component           = $lead_car->broken_component;
        $new_orders_car_declaration->device_manufacturer        = $lead_car->device_manufacturer;
        $new_orders_car_declaration->from_car                   = $lead_car->from_car;
        $new_orders_car_declaration->error_message              = $lead_car->error_message;
        $new_orders_car_declaration->device_partnumber          = $lead_car->device_partnumber;
        $new_orders_car_declaration->component_company          = $lead_car->component_company;
        $new_orders_car_declaration->component_number           = $lead_car->component_number;
        $new_orders_car_declaration->error_message_cache        = $lead_car->car_cache;

        $new_orders_car_declaration->save();

        $lead_car->delete();
        return redirect("/crm/neue-auftraege");
    }

    public function changeStatus($req, $status_id , $order_id, $changed_employee, $from_order) {

        $order_id                                   = order_id::where("process_id", $order_id)->first();

        if($order_id->current_status != null) {
            $shelfes = shelfe::where("process_id", $order_id->process_id)->get();
            foreach($shelfes as $shelfe) {
                $shelfe->last_status = $order_id->current_status;
                $shelfe->update();
            }
        }

        if($from_order == true) {
            $lead                                   = active_orders_person_data::where("process_id", $order_id->process_id)->first();

        } else {
            $lead                                   = new_leads_person_data::where("process_id", $order_id->process_id)->first();
        }
        $order_id                               = order_id::where("process_id", $order_id->process_id)->first();
        $order_id->current_status               = $status_id;
        $order_id->save();
        $new_status_history                     = new status_histori();
        $new_status_history->process_id         = $order_id->process_id;
        
        

        if($order_id->current_status == null) {
            $new_status_history->last_status    = $status_id;
        } else {
            $new_status_history->last_status    = $order_id->current_status;
        }
        $new_status_history->changed_employee   = $changed_employee;

        if($req->has("email_sender")) {
            if($req->input("no_email") == null) {
                $status                             = statuse::where("id", $req->input("status_id"))->first();
                $new_status_history->email_template = $status->email_template;
                $email_template                     = email_template::where("id", $status->email_template)->first();
                $new_status_history->email_message  = $email_template->subject;
            }
        }

        $new_status_history->save();
        
    }

    public function packtisch_request(Request $req, $id) {
        
        $type               = $req->input("auftrag");
        $device             = $req->input("device");
        $info               = $req->input("infofoto");
        
        if($type == "Fotoauftrag") {
            $fin_devi        = array();
            foreach($req->except('_token') as $key => $in) {
                if(str_contains($key, "fcompo-")) {
                    array_push($fin_devi, $in);
                }
            }
            if($fin_devi[0] != null) {
                
               foreach($fin_devi as $dev) {
                if($dev != null) {
                    $process_parts              = explode("-", $dev);
                    $process_id                 = $process_parts[0];
                    $component_id               = $process_parts[1];
                    $component_type             = $process_parts[2];
                    $component_count            = $process_parts[3];
    
                    $intern                     = new intern();
                    $intern->process_id         = $process_id;
                    $intern->component_id       = $component_id;
                    $intern->component_type     = $component_type;
                    $intern->component_count    = $component_count;
                    $intern->component_number   = $dev;
                    $intern->auftrag_id         = $type;
                    $intern->info               = $info;
                    $intern->locked             = "no";
                    $intern->save();
                }
            
               }
               return redirect("/crm/change/order/". $id ."/auftragshistory");
            } else {
                return redirect("/crm/change/order/". $id ."/auftragshistory");
            }
        }
        
        if($type == "Neuer Versandauftrag - Techniker") {
            $this->shipping_order_to_table($req, $id);
            return redirect("/crm/change/order/". $id ."/auftragshistory");

        } else if($type == "Neuer Versandauftrag - Kunde") {
            $this->shipping_order_to_table_kunde($req, $id);
            return redirect("/crm/change/order/". $id ."/auftragshistory");
        }
        if($type == "Umlagerungsauftrag-Archive") {
        }

        if($type == "Umlagerungsauftrag") {
            $this->umlagerungsauftrag($req, $id);
            return redirect("/crm/change/order/". $id ."/auftragshistory");

        }

        
        return redirect("/crm/change/order/". $id ."/auftragshistory");

    }

    public function bearbeitenIntern(Request $req, $id) {
        $intern = intern::where("id", $id)->first();

        $intern->info = $req->input("info");
        $intern->save();

        return redirect()->back();
    }

    //BESPRECHUNG INTERN (In Historie eintragen mit Status das gelöscht)
    public function deleteIntern(Request $req, $id) {
        $intern = intern::where("id", $id)->first();

        $intern->delete();

        return redirect("crm/packtisch");
    }

    public function umlagerungsauftrag(Request $req, $id) {
        $fin_devi        = array();
        $shelfe_ar          = array();
        
        foreach($req->except('_token') as $key => $in) {
            if(str_contains($key, "compo-")) {
                
                $inpt               = explode("+", $in);
                $shelfe             = $inpt[0];
                $dev   = $inpt[1];

                $dev = device_orders::where("component_number", $dev)->first();
                    $dev->ort = "Intern (gelöscht)";
                    $dev->save();

                if($shelfe != "archiv") {
                    $current_shelfe             = shelfe::where("component_number", $dev)->first();
                    $process_parts              = explode("-", $dev);
                    $process_id                 = $process_parts[0];
                    $component_id               = $process_parts[1];
                    $component_type             = $process_parts[2];
                    $component_count            = $process_parts[3];
    
                    $intern                     = new intern();
                    $intern->process_id         = $process_id;
                    $intern->component_id       = $component_id;
                    $intern->component_type     = $component_type;
                    $intern->component_count    = $component_count;
                    $intern->component_number   = $dev;
                    $intern->auftrag_id         = "Umlagerungsauftrag";
                    $intern->auftrag_info       = $current_shelfe->shelfe_id;
                    $intern->info               = $shelfe;
                    $intern->locked             = "no";
                    $intern->save();
                } else {
                    $current_shelfe             = shelfe::where("component_number", $dev)->first();
                    $process_parts              = explode("-", $dev);
                    $process_id                 = $process_parts[0];
                    $component_id               = $process_parts[1];
                    $component_type             = $process_parts[2];
                    $component_count            = $process_parts[3];
    
                    $intern                     = new intern();
                    $intern->process_id         = $process_id;
                    $intern->component_id       = $component_id;
                    $intern->component_type     = $component_type;
                    $intern->component_count    = $component_count;
                    $intern->component_number   = $dev;
                    $intern->auftrag_id         = "Umlagerungsauftrag-Archive";
                    $intern->auftrag_info       = $current_shelfe->shelfe_id;
                    $intern->info               = $shelfe;
                    $intern->locked             = "no";
                    $intern->save();
                }
            }
        
       
           
        }

        

        return redirect("/crm/change/order/". $id ."/auftragshistory");
    }

    public function einlagerungsAuftrag(Request $req, $dev) {

        $shelfe        = $req->input("shelfe");

        $current_shelfe             = shelfe::where("shelfe_id", $shelfe)->first();
        $process_parts              = explode("-", $dev);
        $process_id                 = $process_parts[0];
        $component_id               = $process_parts[1];
        $component_type             = $process_parts[2];
        $component_count            = $process_parts[3];

        $intern                     = new intern();
        $intern->process_id         = $process_id;
        $intern->component_id       = $component_id;
        $intern->component_type     = $component_type;
        $intern->component_count    = $component_count;
        $intern->component_number   = $dev;
        $intern->auftrag_id         = "Einlagerungsauftrag";
        $intern->auftrag_info       = $current_shelfe->shelfe_id;
        $intern->info               = "Gerät war vorher nicht im Lager";
        $intern->save();
        
        return redirect()->back();

    }

    public function packtisch_view(Request $req) {
        $interns        = intern::all();
        $shelfes        = shelfe::all();
        $warensausgang  = warenausgang::all();
        $helpercodes    = helpercode::all();
        
       
        return view("forMitarbeiter/packtisch/packtisch_main")->
                with("interns", $interns)->
                with("shelfes", $shelfes)->
                with("warenausgang", $warensausgang)->
                with("helpercodes", $helpercodes);
    }
    
    public function auftrag_pdf(Request $req, $id, $process_id, $gerätedaten = null, $get = null) {
     
        if(strlen($id) < 5) {
            
            if(file_exists("files/aufträge/users/packtisch/". $id . ".pdf")) {

                if(file_exists("files/aufträge/helpercodes/". $id . ".pdf")) {
                    Storage::move("files/aufträge/helpercodes/". $id . ".pdf", "files/aufträge/helpercodes/". $id . "-old.pdf");
                    return '<embed src="'. url("/") .'/files/aufträge/helpercodes/'. $id .'.pdf" height="1000" width="1000" type="application/pdf">';
                } else {
                    #Storage::move("files/aufträge/users/packtisch/". $id . ".pdf",  $id . "_eingelagert_". Date("d.m.Y") . "_". Date("H:i") .".pdf");
                    Storage::move("files/aufträge/users/packtisch/". $id . ".pdf",  $id . "_eingelagert_.pdf");
                    return '<embed src="'. url("/") .'/files/aufträge/'.  $id . "_eingelagert_.pdf" .' height="1000" width="1000" type="application/pdf">';
                }
            } else {
                if(file_exists("files/aufträge/helpercodes/". $id . ".pdf")) {
                    return '<embed src="'. url("/") .'/files/aufträge/helpercodes/'. $id .'.pdf" height="1000" width="1000" type="application/pdf">';
                } else {
                    if($gerätedaten != null) {
                        return redirect()->back()->withErrors(["Keine Gerätebilder gefunden."]);
                    } else {
                        return "Keine Datei gefunden";
                    }
                }
            }

        } else {
           
            if($get == null) {
                if(file_exists("files/aufträge/users/packtisch/". $process_id . ".pdf")) {
                    $date = date("_d_m_Y_H_i");
                    $filen = $id . $date. "_eingelagert_.pdf";
                   
                    
                   
                    if($id == "warenausgang") {

        
                       
            
                        $file           = new file();
                        $file->process_id       = $process_id;
                        $file->employee         = $req->session()->get("username"); #EmployeeChange
                        $file->filename         = "warenausgang.pdf";
                        $file->description      = "Warenausgang";
                        $file->type             = "Auftragsdokumente";
                        $file->save();
                        
                        Storage::move("files/aufträge/users/packtisch/". $process_id . ".pdf", "files/aufträge/". $process_id . "/warenausgang.pdf");
                        return view("pdf_img")->with("component_name", "warenausgang")->with("process_id", $process_id);
                        
                    } else {

                        if(file_exists("files/aufträge/". $process_id . "/".  $id . "_aktuell_.pdf")) {
                        
                            Storage::move("files/aufträge/". $process_id . "/". $id . "_aktuell_.pdf", "files/aufträge/".$process_id. "/". $filen);
                        }

                        $process_parts    = explode("-", $id);
                    $process_id         = $process_parts[0];
                    $component_id       = $process_parts[1];
                    $component_type     = $process_parts[2];
                    $component_count    = $process_parts[3];
    
                   
        
                    $file           = new file();
                    $file->process_id       = $process_id;
                    $file->component_id     = $component_id;
                    $file->component_type   = $component_type;
                    $file->component_count  = $component_count;
                    $file->component_number = $id;
                    $file->employee         = $req->session()->get("username"); #EmployeeChange
                    $file->filename         = $filen;
                    $file->description      = "Auftragsbilder";
                    $file->type             = "Auftragsdokumente";
                    $file->save();
                       
                       
                        Storage::move("files/aufträge/users/packtisch/". $process_id . ".pdf", "files/aufträge/". $process_id . "/". $id. "_aktuell_.pdf");
                        return view("pdf_img")->with("component_name", $id)->with("process_id", $process_id);
                    }
    
                    
                    
                } 
            }

                if($id == "warenausgang") {
                    if(file_exists("files/aufträge/". $process_id . "/warenausgang.pdf")) {

                            return view("pdf_img")->with("component_name", $id)->with("process_id", $process_id);
    
                        
                    } else {
                        
                        return "Keine Datei gefunden";
                        
                    }
                } else {
                    if(file_exists("files/aufträge/". $process_id . "/". $id . "_aktuell_.pdf")) {
                        if($gerätedaten != null) {
                            return redirect()->back()->withErrors(["Keine Gerätebilder gefunden."]);
                        } else {
                            return view("pdf_img")->with("component_name", $id)->with("process_id", $process_id);
    
                        }
                    } else {
                        if($gerätedaten != null) {
                            return redirect()->back()->withErrors(["Keine Gerätebilder gefunden."]);
                        } else {
                            if(file_exists("files/aufträge/". $process_id . "/warenausgang.pdf")) {
                                return view("pdf_img")->with("component_name", "warenausgang")->with("process_id", $process_id);
    
                            }
                        }
                    }
                }
            
        }

        
    }

    public function intern_auftrag_view(Request $req, $id) {

        $intern         = intern::where("component_number", $id)->first();
        $shelfe          = shelfe::where("component_number", $id)->first();

        if($req->input("auftrag") == "Fotoauftrag") {
            return view("forMitarbeiter/packtisch/fotoauftrag")->
            with("intern", $intern)->
            with("shelfe", $shelfe);
        } else if($req->input("auftrag") == "Umlagerungsauftrag") {
            return view("forMitarbeiter/packtisch/umlagerungsauftrag")->
            with("intern", $intern)->
            with("shelfe", $shelfe);
        }
            
        
    }

    public function helpercode_auftrag_view(Request $req, $helpercode, $shelfe) {

            $shelfe = shelfe::where("shelfe_id", $shelfe)->first();

            return view("forEmployees/packtisch/kein-barcode")->
            with("barcode", $helpercode)->
            with("shelfe", $shelfe);
        
    }
            

    public function umlagerungsauftrag_finish(Request $req, $component_number) {
        $intern                             = intern::where("component_number", $component_number)->first();

        $shelfe = shelfe::where("component_number", $component_number)->first();

        $process_parts              = explode("-", $component_number);
        $process_id                 = $process_parts[0];
        $component_id               = $process_parts[1];
        $component_type             = $process_parts[2];
        $component_count            = $process_parts[3];

        $intern_archive                     = new intern_history();
        $intern_archive->process_id         = $process_id;
        $intern_archive->component_id       = $component_id;
        $intern_archive->component_type     = $component_type;
        $intern_archive->component_number   = $component_number;
        $intern_archive->auftrag_info       = $intern->auftrag_info;
        $intern_archive->shelfeid           = $intern->info;
        $intern_archive->employee           = auth()->user()->id;
        $intern_archive->save();

        $dev = device_orders::where("component_number", $component_number)->first();
                    $dev->ort = "Intern (Umlagerungsauftrag, abgeschlossen)";
                    $dev->save();

        DB::table('shelfes')
        ->where('shelfe_id', $intern->info)
        ->update(['process_id' => $process_id, 'component_id' => $component_id, 'component_number' => $process_id. "-" .$component_id. "-" .$component_type. "-" .$component_count]);

        DB::table('shelfes')
        ->where('shelfe_id', $shelfe->shelfe_id)
        ->update(['process_id' => "0", 'component_id' => "0", 'component_number' => "0"]);


        $this->packtischStatusÄndern($req, "packtisch", 786, $process_id, $process_id . "-" . $component_id . "-" . $component_type . "-" . $component_count);


        $intern->delete();

        return redirect("/crm/packtisch");
        
    }

    public function complete_foto(Request $req, $id) {

        $intern             = intern::where("component_number", $id)->first();
        $shelfe             = used_shelfes::where("component_number");

        $intern_history                     = new intern_history();
        $intern_history->process_id         = $intern->process_id;
        $intern_history->component_id       = $intern->component_id;
        $intern_history->component_type     = $intern->component_type;
        $intern_history->component_count    = $intern->component_count;
        $intern_history->component_number   = $intern->component_number;
        $intern_history->employee           = auth()->user()->id;
        $intern_history->shelfeid           = $shelfe->shelfe_id;
        $intern_history->auftrag_id         = $intern->auftrag_id;
        $intern_history->auftrag_info       = $intern->info;
        $intern_history->save();
        $intern->delete();
        $this->packtischStatusÄndern($req, "packtisch", 543, $intern->process_id, $intern->process_id . "-" . $intern->component_id . "-" . $intern->component_type . "-" . $intern->component_count);


        return redirect("/crm/packtisch");
    }

    public function versenden_view(Request $req) {

        $orders         = active_orders_person_data::all();
        return view("forMitarbeiter/versenden_view")->with("orders", $orders);
    }

    public function shipping_device(Request $req) {
        $process_id     = $req->input("order_id");

        $orders         = active_orders_person_data::all();
        $devices        = device_orders::where("process_id", $process_id)->get();

        return view("forMitarbeiter/versenden_view")->with("orders", $orders)->with("devices", $devices);
    }

    public function device_cart_add(Request $req) {
        $process_id     = $req->input("order_id");
        $counter = 0;
        $fin_devi        = array();
        foreach($req->except('_token') as $key => $in) {
            if(str_contains($key, "comp")) {
                array_push($fin_devi, $in);
            }
        }
        
        $orders         = active_orders_person_data::all();
        $devices        = device_orders::where("process_id", $process_id)->get();

        return view("forMitarbeiter/versenden_view")->with("orders", $orders)->with("devices", $devices)->with("fin_devi", $fin_devi);


    }

    public function shipping_new(Request $req) {

    
        foreach($req->all() as $key => $value) {
            $$key       = $value;
        }
        $maindata           = maindata::where("company_id", "1")->first();

        $row_country_from   = countrie::where("id", $req->input("from_country"))->first();
        $row_country_to   = countrie::where("id", $req->input("to_country"))->first();

        $saturday_delivery = array();

        $carriers_services = array(
			'11' => 'UPS Standard', 
			'65' => 'UPS Saver'
		);
        
        if(!isset($radio_saturday)) {
            $radio_saturday = 0;
        }
        if(!isset($radio_payment)) {
            $radio_payment = 0;
        }

		if($carriers_service == "65" && $radio_saturday == 1){
			$saturday_delivery['SaturdayDeliveryIndicator'] = array('SATURDAY_DELIVERY');
		}


		if($radio_payment == 1){
			$saturday_delivery['COD'] = array(
				'CODFundsCode' => '1', 
				'CODAmount' => array(
					'CurrencyCode' => 'EUR', 
					'MonetaryValue' => '' . $amount
				)
			);
		}

		$data = array(
			'ShipmentRequest' => array(
				'Shipment' => array(
					'Description' => $description, 
					'ShipmentServiceOptions' => $saturday_delivery, 
					'Shipper' => array(
						'Name' => $from_firstname . ' ' . $from_lastname, 
						'AttentionName' => '' . ($from_companyname != "" ? $from_companyname : $maindata['company']), 
						'TaxIdentificationNumber' => '456999', 
						'ShipperNumber' => $maindata['ups_customer_number'], 
						'Address' => array(
							'AddressLine' => $from_street . ' ' . $from_streetno, 
							'City' => $from_city, 
							'StateProvinceCode' => '', 
							'PostalCode' => $from_zipcode, 
							'CountryCode' => $row_country_from['code']
						)
					), 
					'ShipTo' => array(
						'Name' => $to_firstname . ' ' . $to_lastname, 
						'AttentionName' => $to_companyname, 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => $to_street . ' ' . $to_streetno, 
							'City' => $to_city, 
							'StateProvinceCode' => '', 
							'PostalCode' => $to_zipcode, 
							'CountryCode' => $row_country_to['code']
						)
					), 
					'ShipFrom' => array(
						'Name' => $from_firstname . ' ' . $from_lastname, 
						'AttentionName' => $from_companyname, 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => $from_street . ' ' . $from_streetno, 
							'City' => $from_city, 
							'StateProvinceCode' => '', 
							'PostalCode' => $from_zipcode, 
							'CountryCode' => $row_country_from['code']
						)
					), 
					'PaymentInformation' => array(
						'ShipmentCharge' => array(
							'Type' => '01', 
							'BillShipper' => array(
								'AccountNumber' => $maindata['ups_customer_number']
							)
						)
					), 
					'Service' => array(
						'Code' => $carriers_service, 
						'Description' => $carriers_services[$carriers_service]
					), 
					'Package' => array(
						array(
							'Description' => 'GZA Motors - Sendung', 
							'ReferenceNumber' => array(
								'Value' => $description, 
							),
							'Packaging' => array(
								'Code' => '02'
							), 
							'Dimensions' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'CM', 
									'Description' => 'Zentimeter'
								), 
								'Length' => '' . $length, 
								'Width' => '' . $width, 
								'Height' => '' . $height 
							), 
							'PackageWeight' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'KGS'
								), 
								'Weight' => '' . $weight
							), 
							'PackageServiceOptions' => ''
						)
	// ...
					), 
					'ItemizedChargesRequestedIndicator' => '', 
					'RatingMethodRequestedIndicator' => '', 
					'TaxInformationIndicator' => '', 
					'ShipmentRatingOptions' => array(
						'NegotiatedRatesIndicator' => ''
					)
				), 
				'LabelSpecification' => array(
					'LabelImageFormat' => array(
						'Code' => 'GIF'
					)
				)
			)
		);

		$from_phonenumber1 = $from_mobilnumber != "" ? $from_mobilnumber : $from_phonenumber;

		if($from_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['Shipper']['Phone'] = array('Number' => $from_phonenumber1);
			$data['ShipmentRequest']['Shipment']['ShipFrom']['Phone'] = array('Number' => $from_phonenumber1);
		}

		$to_phonenumber1 = $to_mobilnumber != "" ? $to_mobilnumber : $to_phonenumber;

		if($to_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['ShipTo']['Phone'] = array('Number' => $to_phonenumber1);
		}

		$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

		$ch = curl_init($maindata['ups_url'] . '/ship/v1/shipments?additionaladdressvalidation=city');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'AccessLicenseNumber: ' . $maindata['ups_access_license_number'],
				'Password: ' . $maindata['ups_password'],
				'Content-Type: application/json',
				'transId: ' . "lucas" . date("h:m:s"),
				'transactionSrc: ' . "https://crm-v2.ordergo.de",
				'Username: ' . $maindata['ups_username'],
				'Accept: application/json',
				'Content-Length: ' . strlen($data_string)
			)
		);

		$result = curl_exec($ch);

		$response = json_decode($result);

		sleep($maindata['sleep_shipping_label']);

		if(!isset($response->response->errors[0])){

			$data = array(
				'LabelRecoveryRequest' => array(
					'LabelSpecification' => array(
						'HTTPUserAgent' => strip_tags($_SERVER['HTTP_USER_AGENT']), 
						'LabelImageFormat' => array(
							'Code' => 'GIF'
						), 
		/*					'LabelStockSize' => array(
							'Height' => '6', 
							'Width' => '4'
						)*/
					), 
					'Translate' => array(
						'LanguageCode' => 'deu', 
						'DialectCode' => '97', 
						'Code' => '01'
					), 
					'LabelDelivery' => array(
						'LabelLinkIndicator' => '', 
						'ResendEMailIndicator' => '', 
						'EMailMessage' => array(
							'EMailAddress' => $from_email
						)
					), 
					'TrackingNumber' => $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber . ''
				)
			);

			$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

			$ch = curl_init($maindata['ups_url'] . '/ship/v1/shipments/labels');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'AccessLicenseNumber: ' . $maindata['ups_access_license_number'],
					'Password: ' . $maindata['ups_password'],
					'Content-Type: application/json',
					'Username: ' . $maindata['ups_username'],
					'Accept: application/json',
					'Content-Length: ' . strlen($data_string)
				)
			);

			$result = curl_exec($ch);

			$response_label = json_decode($result);

        }
    }

    public function instantVersand(Request $req) {
        foreach($req->all() as $key => $value) {
            $$key       = $value;
        }
        $maindata           = maindata::where("company_id", "1")->first();
        $row_country_from   = countrie::where("name", $req->input("ab_country"))->first();
        $row_country_to   = countrie::where("id", $req->input("country"))->first();

        $saturday_delivery = array();

        $carriers_services = array(
			'11' => 'UPS Standard', 
			'65' => 'UPS Saver'
		);

        if($shippingtype == "Standard") {
            $service = "11";
        }
        if($shippingtype == "Express") {
            $service = "65";
            
        }
        if($shippingtype == "Samstag") {
            $service = "65";
        }
		if($shippingtype == "Samstag"){
            if($nachnahme == "yes") {
                $cod = array(
                    'COD' => array(
                        'description' => "test",
                        'CODFundsCode' => '1',
                        'CODAmount' => array(
                            'CurrencyCode' => "EUR",
                            'MonetaryValue' => $nachnahmebetrag,
                        )
                        ),
                    );
                
            } else {
                $cod = array(
                    "SaturdayDeliveryIndicator" => "true",
                    );
            }
		} else {
            if($nachnahme == "yes") { 
                $cod = array(
                    'COD' => array(
                        'description' => "test",
                        'CODFundsCode' => '1',
                        'CODAmount' => array(
                            'CurrencyCode' => "EUR",
                            'MonetaryValue' => $nachnahmebetrag,
                        )
                        ),
                    );
                } else {
                    $cod = array();
                }
        }
        



        $ab_companyname = "";
        $companyname = "";
        $ab_mobil = "";
        $ab_phone = "";
        $ab_email = "";
$data = array(
            "ShipmentRequest" => array(
            "Request" => array(
                "SubVersion" => "1801",
                "RequestOption" => "nonvalidate",
                "TransactionReference" => array(
                    "CustomerContext" => ""
                )
                ),
                "Shipment" => array(
                    "Description" => "",
                    'ShipmentServiceOptions' => $cod,
                    "Shipper" => array(
                        "Name" => $ab_firstname . " " . $ab_lastname,
                        "AttentionName" => $ab_firstname . " " . $ab_lastname,
                        "TaxIdentificationNumber" => "456999",
                        "Phone" => array(
                            "Number" => $ab_phone,
                            "Extension" => " "
                        ),
                        "ShipperNumber" => "A285F8",
                        "FaxNumber" => "",
                        "Address" => array(
                            "AddressLine" => $ab_street . " " . $ab_streetno,
                            "City" => $ab_city,
                            "StateProvinceCode" => $row_country_from['code'],
                            "PostalCode" => $ab_zipcode,
                            "CountryCode" => $row_country_from['code']
                        )
                        ),

                        
                        "ShipTo" => array(
                            "Name" => $firstname . " " . $lastname,
                            "AttentionName" => $firstname .  " " . $lastname,
                            "Phone" => array(
                                "Number" => $phone
                            ),
                            "Address" => array(
                                "AddressLine" => $street . " " . $streetno,
                                "City" => $city,
                                "StateProvinceCode" => $row_country_to['code'],
                                "PostalCode" => $zipcode,
                                "CountryCode" => $row_country_to['code']
                            ),
                            "Residential" => " "
                        ),
                        "ShipFrom" => array(
                            "Name" => "Gazi Ahmad",
                            "AttentionName" => "GZAMotors",
                            "Phone" => array(
                                "Number" => "1234567890"
                            ),
                            "FaxNumber" => "1234567890",
                            "Address" => array(
                                "AddressLine" => "Strausberger Platz. 13",
                                "City" => "Berlin",
                                "StateProvinceCode" => "DE",
                                "PostalCode" => "10243",
                                "CountryCode" => "DE"
                            )
                            ),
                        
                            "PaymentInformation" => array(
                                "ShipmentCharge" => array(
                                    "Type" => "01",
                                    "BillShipper" => array(
                                        "AccountNumber" => "A285F8"
                                    )
                                )
                                    ),
                                    "Service" => array(
                                        "Code" => $service,
                                        "Description" => "UPS Standard"
                                    ),
                                    "Package" => array(
                                        "Description" => " ",
                                        "Packaging" => array(
                                            "Code" => "02",
                                            "Description" => "Steuergeräte"
                                        ),
                                        "Dimensions" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "CM",
                                                "Description" => "Zentimeter"
                                            ),
                                            "Length" => "30",
                                            "Width" => "30",
                                            "Height" => "20"
                                        ),
                                        "PackageWeight" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "KGS",
                                                "Description" => "Kilogramm"
                                            ),
                                            "Weight" => "5"
                                        )
                                        )),
                                        "LabelSpecification" => array(
                                            "LabelImageFormat" => array(
                                                "Code" => "GIF",
                                                "Description" => "GIF"
                                            ),
                                            "HTTPUserAgent" => "Mozilla/4.5"
                                        )
                                    )
                                        );

        /*array(
			'ShipmentRequest' => array(
				'Shipment' => array(
					'Description' => "awd", 
					'ShipmentServiceOptions' => $saturday_delivery, 
					'Shipper' => array(
						'Name' => "Gazi" . ' ' . "Ahmad", 
						'AttentionName' => '' . ("GZAMOTORS" != "" ? "GZAMOTORS" : $maindata['company']), 
						'TaxIdentificationNumber' => '456999', 
						'ShipperNumber' => $maindata['ups_customer_number'], 
						'Address' => array(
							'AddressLine' => "Straußbergerplatz" . ' ' . "12", 
							'City' => "Berlin", 
							'StateProvinceCode' => '', 
							'PostalCode' => "10243", 
							'CountryCode' => $row_country_from['code']
						)
					), 
					'ShipTo' => array(
						'Name' => $to_firstname . ' ' . $to_lastname, 
						'AttentionName' => $to_companyname, 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => $to_street . ' ' . $to_streetno, 
							'City' => $to_city, 
							'StateProvinceCode' => '', 
							'PostalCode' => $to_zipcode, 
							'CountryCode' => $row_country_to['code']
						)
					), 
					'ShipFrom' => array(
						'Name' => "Gazi" . ' ' . "Ahmad", 
						'AttentionName' => "GZAMOTORS", 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => "Straußbergerplatz" . ' ' . "12", 
							'City' => "Berlin", 
							'StateProvinceCode' => '', 
							'PostalCode' => "10243", 
							'CountryCode' => $row_country_from['code']
						)
					), 
					'PaymentInformation' => array(
						'ShipmentCharge' => array(
							'Type' => '01', 
							'BillShipper' => array(
								'AccountNumber' => $maindata['ups_customer_number']
							)
						)
					), 
					'Service' => array(
						'Code' => $carriers_service, 
						'Description' => $carriers_services[$carriers_service]
					), 
					'Package' => array(
						array(
							'Description' => 'GZA Motors - Sendung', 
							'ReferenceNumber' => array(
								'Value' => "awd", 
							),
							'Packaging' => array(
								'Code' => '02'
							), 
							'Dimensions' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'CM', 
									'Description' => 'Zentimeter'
								), 
								'Length' => '' . $length, 
								'Width' => '' . $width, 
								'Height' => '' . $height 
							), 
							'PackageWeight' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'KGS'
								), 
								'Weight' => '' . $weight
							), 
							'PackageServiceOptions' => ''
						)
	// ...
					), 
					'ItemizedChargesRequestedIndicator' => '', 
					'RatingMethodRequestedIndicator' => '', 
					'TaxInformationIndicator' => '', 
					'ShipmentRatingOptions' => array(
						'NegotiatedRatesIndicator' => ''
					)
				), 
				'LabelSpecification' => array(
					'LabelImageFormat' => array(
						'Code' => 'GIF'
					)
				)
			)
		);*/
        
        $from_mobilnumber       = $maindata["mobilnumber"];
        $from_phonenumber       = $maindata["phonenumber"];
        $from_email             = $maindata["email"];


		



        
		$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

        
		$headers = array();
        $headers[] = "Authorization: Bearer ". $this->Auth()->access_token;
        $headers[] = 'Accept: application/json';
        $headers[] = "grant_type=client_credentials";
        $headers[] = "x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $ch = curl_init('https://onlinetools.ups.com/api/shipments/v1/ship');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);
		sleep($maindata['sleep_shipping_label']);

		if(!isset($response->response->errors[0])){

			$data = array(
				'LabelRecoveryRequest' => array(
					'LabelSpecification' => array(
						'HTTPUserAgent' => strip_tags($_SERVER['HTTP_USER_AGENT']), 
						'LabelImageFormat' => array(
							'Code' => 'PNG'
						), 
		/*					'LabelStockSize' => array(
							'Height' => '6', 
							'Width' => '4'
						)*/
					), 
					'Translate' => array(
						'LanguageCode' => 'deu', 
						'DialectCode' => '97', 
						'Code' => '01'
					), 
					'LabelDelivery' => array(
						'LabelLinkIndicator' => '', 
						'ResendEMailIndicator' => '', 
						'EMailMessage' => array(
							'EMailAddress' => $ab_email
						)
					), 
					'TrackingNumber' => $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber . ''
				)
			);

			$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

			$ch = curl_init($maindata['ups_url'] . '/ship/v1/shipments/labels');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'AccessLicenseNumber: ' . $maindata['ups_access_license_number'],
					'Password: ' . $maindata['ups_password'],
					'Content-Type: application/json',
					'Username: ' . $maindata['ups_username'],
					'Accept: application/json',
					'Content-Length: ' . strlen($data_string)
				)
			);

			$result = curl_exec($ch);

			$response_label = json_decode($result);
            $data = 'data:image/png;base64,'. $response_label->LabelRecoveryResponse->LabelResults->LabelImage->GraphicImage;

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            
            file_put_contents(public_path("/").'/temp/'. "customlabel" . ".png", $data);
            
            // set the source file
            $pdf = new Fpdi(); 

            $pdf->setSourceFile(public_path("/"). "/blank.pdf");

            $pdf->AddPage();
            $tplId = $pdf->importPage(1);
            $pdf->useTemplate($tplId); 
            $source = imagecreatefrompng(public_path("/").'/temp/customlabel.png');
            // Rotate
            $rotate = imagerotate($source, 270, 0);
            //and save it on your server...
            imagepng($rotate, public_path("/")."/temp/customlabel.png");
            $pdf->Image(public_path("/")."/temp/customlabel.png", 0, 0, 210, 345);


            dd($pdf->Output());

            return redirect()->back();
        }
    }

    public function warenausgangVerpackenKunde(Request $req, $id) {

        $ausgangg    = warenausgang::where("process_id", $id)->get();

        foreach ($ausgangg as $device) {

            $inshipping     = new inshipping();
                $inshipping->process_id         = $device->process_id;
                $inshipping->component_number   = $device->component_number;
                $inshipping->label_id           = "";
                $inshipping->type               = "Kunde";
                $inshipping->firstname          = $device->firstname;
                $inshipping->lastname           = $device->lastname;
                $inshipping->save();

                
                $ausgang                        = new warenausgang_history();
                $ausgang->gummi                 = $device->gummi;
                $ausgang->protection            = $device->protection;
                $ausgang->seal                  = $device->seal;
                $ausgang->bpz1                  = $device->bpz1 ;
                $ausgang->bpz2                  = $device->bpz2;
                $ausgang->shipping_type         = $device->shipping_type;
                $ausgang->payment_type          = $device->payment_type;
                $ausgang->carriers_service      = $device->carriers_service;
                $ausgang->companyname           = $device->companyname;
                $ausgang->shortcut              = $device->shortcut;
                $ausgang->firstname             = $device->firstname;
                $ausgang->lastname              = $device->lastname;
                $ausgang->street                = $device->street;
                $ausgang->streetno              = $device->streetno;
                $ausgang->zipcode               = $device->zipcode;
                $ausgang->city                  = $device->city ;
                $ausgang->country               = $device->country;
                $ausgang->email                 = $device->email;
                $ausgang->mobilnumber           = $device->mobilnumber;
                $ausgang->phonenumber           = $device->phonenumber;
                $ausgang->amount                = $device->amount      ;
                $ausgang->length                = $device->length;
                $ausgang->weight                = $device->weight;
                $ausgang->height                = $device->height;
                $ausgang->width                 = $device->width   ;
                $ausgang->ex_space              = $device->ex_space;
                $ausgang->process_id            = $device->process_id;
                $ausgang->component_id          = $device->component_id;
                $ausgang->component_type        = $device->component_type;
                $ausgang->component_count       = $device->component_count;
                $ausgang->component_number      = $device->component_number;
                $ausgang->employee              = auth()->user()->id;
                $ausgang->label                 = "";

                $ausgang->save();
            $device->delete();

                DB::table('shelfes')
                ->where('component_number', $device->component_number)
                ->update(['process_id' =>"0", 'component_id' => "0", 'component_number' =>"0"]);
                $this->packtischStatusÄndern($req, "packtisch", 705, $device->process_id, $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count);

            
        }
        return redirect("crm/packtisch");

    }

    public function warenausgang_entsorgung_shipping(Request $req) {
        $maindata               = maindata::where("company_id", "1")->first();
        
        $shipping_data          = warenausgang::where("ex_space", "Entsorgung")->first();

        $row_country_from       = countrie::where("id", "1")->first();
        
        $row_country_to         = countrie::where("id", $shipping_data->country)->first();
        $carriers_service       = $shipping_data->carriers_service;
        $to_companyname         = $shipping_data->companyname;
        $to_firstname           = $shipping_data->firstname;
        $to_lastname            = $shipping_data->lastname;
        $to_street              = $shipping_data->street;
        $to_streetno            = $shipping_data->streetno;
        $to_zipcode             = $shipping_data->zipcode;
        $to_city                = $shipping_data->city;
        $to_mobilnumber         = $shipping_data->mobilnumber;
        $to_phonenumber         = $shipping_data->phonenumber;
        $length                 = $shipping_data->length;
        $width                  = $shipping_data->width;
        $height                 = $shipping_data->height;
        $weight                 = $shipping_data->weight;
        $nachnahme              = $shipping_data->nachnahme;


        

        $saturday_delivery = array();

        $carriers_services = array(
			'11' => 'UPS Standard', 
			'65' => 'UPS Saver'
		);
        
        if(!isset($radio_saturday)) {
            $radio_saturday = 0;
        }
        if(!isset($radio_payment)) {
            $radio_payment = 0;
        }

		if($carriers_service == "65" && $radio_saturday == 1){
			$saturday_delivery['SaturdayDeliveryIndicator'] = array('SATURDAY_DELIVERY');
		}


		if($radio_payment == 1){
			$saturday_delivery['COD'] = array(
				'CODFundsCode' => '1', 
				'CODAmount' => array(
					'CurrencyCode' => 'EUR', 
					'MonetaryValue' => '' . $amount
				)
			);
		}
    
        if(!isset($nachnahme) || $nachnahme == null || $nachnahme != "on") {
            $cod = array('COD' => array(
                
            )
            );
        } else {

            $booking     = booking::where("process_id", "12345")->latest()->first();
            
            if($booking == null) {
                return redirect()->back()->withErrors(["Keine Offene Summe gefunden, Nachnahme hat somit kein Geldwert"]);
            }
            $cod = array('COD' => array(
                'description' => "test",
                'CODFundsCode' => '1',
                'CODAmount' => array(
                    'CurrencyCode' => "EUR",
                    'MonetaryValue' => $booking->open_sum,
                )
            )
            );
        }
       
		$data = array(
            "ShipmentRequest" => array(
            "Request" => array(
                "SubVersion" => "1801",
                "RequestOption" => "nonvalidate",
                "TransactionReference" => array(
                    "CustomerContext" => ""
                )
                ),
                "Shipment" => array(
                    "Description" => "GZAMotors",
                    'ShipmentServiceOptions' => $cod, 
                    "Shipper" => array(
                        "Name" => "Gazi Ahmad",
                        "AttentionName" => "GZAMotors",
                        "TaxIdentificationNumber" => "456999",
                        "Phone" => array(
                            "Number" => "1115554758",
                            "Extension" => " "
                        ),
                        "ShipperNumber" => "A285F8",
                        "FaxNumber" => "8002222222",
                        "Address" => array(
                            "AddressLine" => "Strausberger Platz. 13",
                            "City" => "Berlin",
                            "StateProvinceCode" => "DE",
                            "PostalCode" => "10243",
                            "CountryCode" => "DE"
                        )
                        ),

                        
                        "ShipTo" => array(
                            "Name" => $to_firstname . $to_lastname,
                            "AttentionName" => $to_companyname,
                            "Phone" => array(
                                "Number" => "9225377171"
                            ),
                            "Address" => array(
                                "AddressLine" => $to_street . " " . $to_streetno,
                                "City" => $to_city,
                                "StateProvinceCode" => $row_country_to['code'],
                                "PostalCode" => $to_zipcode,
                                "CountryCode" => $row_country_to['code']
                            ),
                            "Residential" => " "
                        ),
                        "ShipFrom" => array(
                            "Name" => "Gazi Ahmad",
                            "AttentionName" => "GZAMotors",
                            "Phone" => array(
                                "Number" => "1234567890"
                            ),
                            "FaxNumber" => "1234567890",
                            "Address" => array(
                                "AddressLine" => "Strausberger Platz. 13",
                                "City" => "Berlin",
                                "StateProvinceCode" => "DE",
                                "PostalCode" => "10243",
                                "CountryCode" => "DE"
                            )
                            ),
                        
                            "PaymentInformation" => array(
                                "ShipmentCharge" => array(
                                    "Type" => "01",
                                    "BillShipper" => array(
                                        "AccountNumber" => "A285F8"
                                    )
                                )
                                    ),
                                    "Service" => array(
                                        "Code" => "11",
                                        "Description" => "UPS Standard"
                                    ),
                                    "Package" => array(
                                        "Description" => " ",
                                        "Packaging" => array(
                                            "Code" => "02",
                                            "Description" => "Steuergeräte"
                                        ),
                                        "Dimensions" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "CM",
                                                "Description" => "Zentimeter"
                                            ),
                                            "Length" => $length,
                                            "Width" => $width,
                                            "Height" => $height
                                        ),
                                        "PackageWeight" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "KGS",
                                                "Description" => "Kilogramm"
                                            ),
                                            "Weight" => "5"
                                        )
                                        )),
                                        "LabelSpecification" => array(
                                            "LabelImageFormat" => array(
                                                "Code" => "GIF",
                                                "Description" => "GIF"
                                            ),
                                            "HTTPUserAgent" => "Mozilla/4.5"
                                        )
                                    )
                                        );


        
        $from_mobilnumber       = $maindata["mobilnumber"];
        $from_phonenumber       = $maindata["phonenumber"];
        $from_email             = $maindata["email"];

		$from_phonenumber1 = $from_mobilnumber != "" ? $from_mobilnumber : $from_phonenumber;

		if($from_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['Shipper']['Phone'] = array('Number' => $from_phonenumber1);
			$data['ShipmentRequest']['Shipment']['ShipFrom']['Phone'] = array('Number' => $from_phonenumber1);
		}

		$to_phonenumber1 = $to_mobilnumber != "" ? $to_mobilnumber : $to_phonenumber;

		if($to_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['ShipTo']['Phone'] = array('Number' => $to_phonenumber1);
		}



        
		$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);



        #Adress Validation
        $APIUrl = 'https://addressvalidation.googleapis.com/v1:validateAddress?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg';

        $Params = array('XAVRequest' => array(
            "AddressKeyFormat" => array(
                "ConsigneeName" => "RITZ CAMERA CENTERS-1749",
                "BuildingName" => "Innoplex",
                "AddressLine" => [
                    "26601 ALISO CREEK ROAD",
                    "STE D",
                    "ALISO VIEJO TOWN CENTER"
                ],
                "CountryCode" => "US",
                "Region" => "ROSWELL,GA,30076-1521",
                "Urbanization" => "porto arundal",
                "PostcodeExtendedLow" => "1521",
                "PostcodePrimaryLow" => "92656",
                "PoliticalDivision1" => "CA",
                "PoliticalDivision2" => "ALISO VIEJO",

            )
        ));

        $headers = array();
        $headers[] = "Authorization: Bearer ". $this->Auth()->access_token;
        $headers[] = 'Accept: application/json';
        $headers[] = "grant_type=client_credentials";
        $headers[] = "x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $ch = curl_init('https://onlinetools.ups.com/api/addressvalidation/v1/1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{ 
            "XAVRequest": {
            "AddressKeyFormat": {
            "AddressLine": [
            "Lea-Grundig-Straße",
            "2",
            ],
            "Region": "Berlin",
            "PoliticalDivision1": "DE",
            "PostcodePrimaryLow": "12679",
            "CountryCode": "US"
            }
            } }
           ');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


		$result = curl_exec($ch);

		$response = json_decode($result);


		$headers = array();
        $headers[] = "Authorization: Bearer ". $this->Auth()->access_token;
        $headers[] = 'Accept: application/json';
        $headers[] = "grant_type=client_credentials";
        $headers[] = "x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $ch = curl_init('https://onlinetools.ups.com/api/shipments/v1/ship');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);
		sleep($maindata['sleep_shipping_label']);
		if(!isset($response->response->errors[0])){
		
            $data = 'data:image/png;base64,'. $response->ShipmentResponse->ShipmentResults->PackageResults->ShippingLabel->GraphicImage;

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            
            file_put_contents(public_path("/").'/temp/'. "entsorgung" . ".png", $data);
 
            $devices        = warenausgang::where("ex_space", "Entsorgung")->get();

            foreach($devices as $device) {
                $inshipping     = new inshipping();
                $inshipping->process_id         = $device->process_id;
                $inshipping->component_number   = $device->component_number;
                $inshipping->label_id           = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber;
                $inshipping->type               = "Kunde";
                $inshipping->firstname          = $device->firstname;
                $inshipping->lastname           = $device->lastname;
                $inshipping->save();

                
                $ausgang                        = new warenausgang_history();
                $ausgang->gummi                 = $device->gummi;
                $ausgang->protection            = $device->protection;
                $ausgang->seal                  = $device->seal;
                $ausgang->bpz1                  = $device->bpz1 ;
                $ausgang->bpz2                  = $device->bpz2;
                $ausgang->shipping_type         = $device->shipping_type;
                $ausgang->payment_type          = $device->payment_type;
                $ausgang->carriers_service      = $device->carriers_service;
                $ausgang->companyname           = $device->companyname;
                $ausgang->shortcut              = $device->shortcut;
                $ausgang->firstname             = $device->firstname;
                $ausgang->lastname              = $device->lastname;
                $ausgang->street                = $device->street;
                $ausgang->streetno              = $device->streetno;
                $ausgang->zipcode               = $device->zipcode;
                $ausgang->city                  = $device->city ;
                $ausgang->country               = $device->country;
                $ausgang->email                 = $device->email;
                $ausgang->mobilnumber           = $device->mobilnumber;
                $ausgang->phonenumber           = $device->phonenumber;
                $ausgang->amount                = $device->amount      ;
                $ausgang->length                = $device->length;
                $ausgang->weight                = $device->weight;
                $ausgang->height                = $device->height;
                $ausgang->width                 = $device->width   ;
                $ausgang->ex_space              = $device->ex_space;
                $ausgang->process_id            = $device->process_id;
                $ausgang->component_id          = $device->component_id;
                $ausgang->component_type        = $device->component_type;
                $ausgang->component_count       = $device->component_count;
                $ausgang->component_number      = $device->component_number;
                $ausgang->employee              = auth()->user()->id;
                $ausgang->label                 = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber;

                $ausgang->save();

                $sh = shelfe::where("component_number", $device->component_number)->first();

            if($device->exspace == "Entsorgung") {
                $this->packtischStatusÄndern($req, "packtisch", 517, $device->process_id, $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count, $sh->shelfe_id, $device->bpz1, $device->bpz2, $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);
            
                $order = order_id::where("process_id", $device->process_id)->first();
                
                DB::table('shelfes')
                ->where('component_number', $device->component_number)
                ->update(['process_id' =>"0", 'component_id' => "0", 'component_number' =>"0", "last_device" => $device->component_number, "last_status" => $order->current_status]);
            } else {
                $this->packtischStatusÄndern($req, "packtisch", 729, $device->process_id, $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count, $sh->shelfe_id, $device->bpz1, $device->bpz2, $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);
            
                DB::table('shelfes')
                ->where('component_number', $device->component_number)
                ->update(['process_id' =>"0", 'component_id' => "0", 'component_number' =>"0"]);
            
            }

            }            

            
            $shipping_data->delete();
            return view("forEmployees/packtisch/versand-erfolg")->with("process_id", "entsorgung")->with("number", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);

        } else {
        }

    }

    public function warenausgang_shipping(Request $req, $id) {
        $maindata               = maindata::where("company_id", "1")->first();
        $shipping_data          = warenausgang::where("process_id", $id)->first();

        $firstdate      = date("Y-m-d H:i:s", strtotime('+2 days'));
        $seconddate     = date('Y-m-d H:i:s', strtotime('-'. date('h') .' hours'));

        if($shipping_data->shortcut != "") {
            $label = warenausgang_history::whereBetween("created_at", [$seconddate, $firstdate])->where("shortcut", $shipping_data->shortcut)->first();
            if($label != null) {
                return view("forEmployees.packtisch.versenden-labelcheck")->with("label", $label->label)->with("ausgang", $label);
            }
        }

        $row_country_from       = countrie::where("id", "1")->first();
        
        $row_country_to         = countrie::where("name", $shipping_data->country)->first();
        $carriers_service       = $shipping_data->carriers_service;
        $to_companyname         = $shipping_data->companyname;
        $to_firstname           = $shipping_data->firstname;
        $to_lastname            = $shipping_data->lastname;
        $to_street              = $shipping_data->street;
        $to_streetno            = $shipping_data->streetno;
        $to_zipcode             = $shipping_data->zipcode;
        $to_city                = $shipping_data->city;
        $to_mobilnumber         = $shipping_data->mobilnumber;
        $to_phonenumber         = $shipping_data->phonenumber;
        $length                 = $shipping_data->length;
        $width                  = $shipping_data->width;
        $height                 = $shipping_data->height;
        $weight                 = $shipping_data->weight;
        $nachnahme              = $shipping_data->nachnahme;

        if($carriers_service == "standard") {
            $carriers_service = "11";
        } else {
            $carriers_service = "65";
        }

       
        if(!isset($radio_saturday)) {
            $radio_saturday = 0;
        }
        if(!isset($radio_payment)) {
            $radio_payment = 0;
        }

		if($carriers_service == "65" && $radio_saturday == 1){
			$saturday_delivery['SaturdayDeliveryIndicator'] = array('SATURDAY_DELIVERY');
		}


		if($radio_payment == 1){
			$saturday_delivery['COD'] = array(
				'CODFundsCode' => '1', 
				'CODAmount' => array(
					'CurrencyCode' => 'EUR', 
					'MonetaryValue' => '' . $amount
				)
			);
		}
        $person = active_orders_person_data::where("process_id", $shipping_data->process_id)->first();
        if(!isset($nachnahme) || $nachnahme == null || $nachnahme != "on") {
            if($person->shipping_type == "samstagszustellung") {
                $cod = array('SaturdayDeliveryIndicator' => "true",
                    );
            } else {
                $cod = array('COD' => array(
                
                    )
                    );
            }

            
        } else {

            $booking     = booking::where("process_id", $id)->latest()->first();
            
            if($booking == null) {
                return redirect()->back()->withErrors(["Keine Offene Summe gefunden, Nachnahme hat somit kein Geldwert"]);
            }
            if($person->shipping_type == "samstagszustellung") {
                $cod = array(
                    'COD' => array(
                        'description' => "test",
                        'CODFundsCode' => '1',
                        'CODAmount' => array(
                            'CurrencyCode' => "EUR",
                            'MonetaryValue' => $booking->open_sum,
                        )
                        ),
                    "SaturdayDeliveryIndicator" => "true",
                    );
            } else {
                $cod = array(
                    'COD' => array(
                        'description' => "test",
                        'CODFundsCode' => '1',
                        'CODAmount' => array(
                            'CurrencyCode' => "EUR",
                            'MonetaryValue' => $booking->open_sum,
                        )
                    )
                    );
            }
            
        }
       
		$data = array(
            "ShipmentRequest" => array(
            "Request" => array(
                "SubVersion" => "1801",
                "RequestOption" => "nonvalidate",
                "TransactionReference" => array(
                    "CustomerContext" => ""
                )
                ),
                "Shipment" => array(
                    "Description" => "GZAMotors",
                    'ShipmentServiceOptions' => $cod,
                    "Shipper" => array(
                        "Name" => "Gazi Ahmad",
                        "AttentionName" => "GZAMotors",
                        "TaxIdentificationNumber" => "456999",
                        "Phone" => array(
                            "Number" => "1115554758",
                            "Extension" => " "
                        ),
                        "ShipperNumber" => "A285F8",
                        "FaxNumber" => "8002222222",
                        "Address" => array(
                            "AddressLine" => "Strausberger Platz. 13",
                            "City" => "Berlin",
                            "StateProvinceCode" => "DE",
                            "PostalCode" => "10243",
                            "CountryCode" => "DE"
                        )
                        ),

                        
                        "ShipTo" => array(
                            "Name" => $to_firstname . $to_lastname,
                            "AttentionName" => $to_companyname,
                            "Phone" => array(
                                "Number" => "9225377171"
                            ),
                            "Address" => array(
                                "AddressLine" => $to_street . " " . $to_streetno,
                                "City" => $to_city,
                                "StateProvinceCode" => $row_country_to['code'],
                                "PostalCode" => $to_zipcode,
                                "CountryCode" => $row_country_to['code']
                            ),
                            "Residential" => " "
                        ),
                        "ShipFrom" => array(
                            "Name" => "Gazi Ahmad",
                            "AttentionName" => "GZAMotors",
                            "Phone" => array(
                                "Number" => "1234567890"
                            ),
                            "FaxNumber" => "1234567890",
                            "Address" => array(
                                "AddressLine" => "Strausberger Platz. 13",
                                "City" => "Berlin",
                                "StateProvinceCode" => "DE",
                                "PostalCode" => "10243",
                                "CountryCode" => "DE"
                            )
                            ),
                        
                            "PaymentInformation" => array(
                                "ShipmentCharge" => array(
                                    "Type" => "01",
                                    "BillShipper" => array(
                                        "AccountNumber" => "A285F8"
                                    )
                                )
                                    ),
                                    "Service" => array(
                                        "Code" => $carriers_service,
                                        "Description" => "UPS Standard"
                                    ),
                                    "Package" => array(
                                        "Description" => " ",
                                        "Packaging" => array(
                                            "Code" => "02",
                                            "Description" => "Steuergeräte"
                                        ),
                                        "Dimensions" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "CM",
                                                "Description" => "Zentimeter"
                                            ),
                                            "Length" => $length,
                                            "Width" => $width,
                                            "Height" => $height
                                        ),
                                        "PackageWeight" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "KGS",
                                                "Description" => "Kilogramm"
                                            ),
                                            "Weight" => $weight
                                        )
                                        )),
                                        "LabelSpecification" => array(
                                            "LabelImageFormat" => array(
                                                "Code" => "GIF",
                                                "Description" => "GIF"
                                            ),
                                            "HTTPUserAgent" => "Mozilla/4.5"
                                        )
                                    )
                                        );

        /*array(
			'ShipmentRequest' => array(
				'Shipment' => array(
					'Description' => "awd", 
					'ShipmentServiceOptions' => $saturday_delivery, 
					'Shipper' => array(
						'Name' => "Gazi" . ' ' . "Ahmad", 
						'AttentionName' => '' . ("GZAMOTORS" != "" ? "GZAMOTORS" : $maindata['company']), 
						'TaxIdentificationNumber' => '456999', 
						'ShipperNumber' => $maindata['ups_customer_number'], 
						'Address' => array(
							'AddressLine' => "Straußbergerplatz" . ' ' . "12", 
							'City' => "Berlin", 
							'StateProvinceCode' => '', 
							'PostalCode' => "10243", 
							'CountryCode' => $row_country_from['code']
						)
					), 
					'ShipTo' => array(
						'Name' => $to_firstname . ' ' . $to_lastname, 
						'AttentionName' => $to_companyname, 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => $to_street . ' ' . $to_streetno, 
							'City' => $to_city, 
							'StateProvinceCode' => '', 
							'PostalCode' => $to_zipcode, 
							'CountryCode' => $row_country_to['code']
						)
					), 
					'ShipFrom' => array(
						'Name' => "Gazi" . ' ' . "Ahmad", 
						'AttentionName' => "GZAMOTORS", 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => "Straußbergerplatz" . ' ' . "12", 
							'City' => "Berlin", 
							'StateProvinceCode' => '', 
							'PostalCode' => "10243", 
							'CountryCode' => $row_country_from['code']
						)
					), 
					'PaymentInformation' => array(
						'ShipmentCharge' => array(
							'Type' => '01', 
							'BillShipper' => array(
								'AccountNumber' => $maindata['ups_customer_number']
							)
						)
					), 
					'Service' => array(
						'Code' => $carriers_service, 
						'Description' => $carriers_services[$carriers_service]
					), 
					'Package' => array(
						array(
							'Description' => 'GZA Motors - Sendung', 
							'ReferenceNumber' => array(
								'Value' => "awd", 
							),
							'Packaging' => array(
								'Code' => '02'
							), 
							'Dimensions' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'CM', 
									'Description' => 'Zentimeter'
								), 
								'Length' => '' . $length, 
								'Width' => '' . $width, 
								'Height' => '' . $height 
							), 
							'PackageWeight' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'KGS'
								), 
								'Weight' => '' . $weight
							), 
							'PackageServiceOptions' => ''
						)
	// ...
					), 
					'ItemizedChargesRequestedIndicator' => '', 
					'RatingMethodRequestedIndicator' => '', 
					'TaxInformationIndicator' => '', 
					'ShipmentRatingOptions' => array(
						'NegotiatedRatesIndicator' => ''
					)
				), 
				'LabelSpecification' => array(
					'LabelImageFormat' => array(
						'Code' => 'GIF'
					)
				)
			)
		);*/
        
        $from_mobilnumber       = $maindata["mobilnumber"];
        $from_phonenumber       = $maindata["phonenumber"];
        $from_email             = $maindata["email"];

		$from_phonenumber1 = $from_mobilnumber != "" ? $from_mobilnumber : $from_phonenumber;

		if($from_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['Shipper']['Phone'] = array('Number' => $from_phonenumber1);
			$data['ShipmentRequest']['Shipment']['ShipFrom']['Phone'] = array('Number' => $from_phonenumber1);
		}

		$to_phonenumber1 = $to_mobilnumber != "" ? $to_mobilnumber : $to_phonenumber;

		if($to_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['ShipTo']['Phone'] = array('Number' => $to_phonenumber1);
		}



        
		$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);



        #Adress Validation
        $APIUrl = 'https://addressvalidation.googleapis.com/v1:validateAddress?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg';

        $Params = '{  "address": {    "regionCode": "'.$row_country_to->code.'",    "locality": "'.$row_country_to->city.'",    "postalCode": "'.$row_country_to->zipcode.'",    "addressLines": ["'.$row_country_to->street. ' ' . $row_country_to->streetno .'"]  },  "enableUspsCass": false}';

		$Params = json_decode($Params);

        $Params = json_encode($Params);


        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $ch = curl_init($APIUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $Params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);

        
		$headers = array();
        $headers[] = "Authorization: Bearer ". $this->Auth()->access_token;
        $headers[] = 'Accept: application/json';
        $headers[] = "grant_type=client_credentials";
        $headers[] = "x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $ch = curl_init('https://onlinetools.ups.com/api/shipments/v1/ship');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);
		sleep($maindata['sleep_shipping_label']);
		if(!isset($response->response->errors[0])){
		
            $data = 'data:image/png;base64,'. $response->ShipmentResponse->ShipmentResults->PackageResults->ShippingLabel->GraphicImage;

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            file_put_contents(public_path("/").'/temp/'. $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber . ".png", $data);
            $devices        = warenausgang::where("process_id", $id)->get();

            foreach($devices as $device) {

                if(isset($device->fotoauftrag)) {
                    if(!file_exists('files/aufträge/'. $device->process_id ."/". $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf")) {
                       $file = file::where("filename", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf")->first();
                       if($file == null) {
                        Storage::move('files/aufträge/'. $device->process_id ."/warenausgang.pdf", 'files/aufträge/'. $device->process_id ."/". $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf");
                        $file = file::where("process_id", $device->process_id)->where("filename", "warenausgang.pdf")->first();
                        if($file != null) {
                            $file->filename = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf";
                            $file->update();
                        }
                       }
                    }
                   
                }

                $inshipping     = new inshipping();
                $inshipping->process_id         = $device->process_id;
                $inshipping->component_number   = $device->component_number;
                $inshipping->label_id           = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber;
                $inshipping->type               = "Kunde";
                $inshipping->firstname          = $device->firstname;
                $inshipping->lastname           = $device->lastname;
                $inshipping->save();

                
                $ausgang                        = new warenausgang_history();
                $ausgang->gummi                 = $device->gummi;
                $ausgang->protection            = $device->protection;
                $ausgang->seal                  = $device->seal;
                $ausgang->bpz1                  = $device->bpz1 ;
                $ausgang->bpz2                  = $device->bpz2;
                $ausgang->shipping_type         = $device->shipping_type;
                $ausgang->employee              = auth()->user()->id;
                $ausgang->payment_type          = $device->payment_type;
                $ausgang->carriers_service      = $device->carriers_service;
                $ausgang->companyname           = $device->companyname;
                $ausgang->shortcut              = $device->shortcut;
                $ausgang->firstname             = $device->firstname;
                $ausgang->lastname              = $device->lastname;
                $ausgang->street                = $device->street;
                $ausgang->streetno              = $device->streetno;
                $ausgang->zipcode               = $device->zipcode;
                $ausgang->city                  = $device->city ;
                $ausgang->country               = $device->country;
                $ausgang->email                 = $device->email;
                $ausgang->mobilnumber           = $device->mobilnumber;
                $ausgang->phonenumber           = $device->phonenumber;
                $ausgang->amount                = $device->amount      ;
                $ausgang->length                = $device->length;
                $ausgang->weight                = $device->weight;
                $ausgang->height                = $device->height;
                $ausgang->width                 = $device->width   ;
                $ausgang->ex_space              = $device->ex_space;
                $ausgang->process_id            = $device->process_id;
                $ausgang->component_id          = $device->component_id;
                $ausgang->component_type        = $device->component_type;
                $ausgang->component_count       = $device->component_count;
                $ausgang->component_number      = $device->component_number;
                $ausgang->label                 = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber;

                $ausgang->save();

                $sh = used_shelfes::where("component_number", $device->component_number)->first();

            if($device->exspace == "Entsorgung") {
                $this->packtischStatusÄndern($req, "packtisch", 517, $device->process_id, $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count, $sh->shelfe_id, $device->bpz1, $device->bpz2, $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);
            
                $order = order_id::where("process_id", $device->process_id)->first();
                
                $this->deleteShelfeDevice($sh->shelfe_id, $device->component_number);
            } else {
                $this->packtischStatusÄndern($req, "packtisch", 729, $device->process_id, $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count, $sh->shelfe_id, $device->bpz1, $device->bpz2, $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);
            
                $this->deleteShelfeDevice($sh->shelfe_id, $device->component_number);
            
            }

            }            

            

            $file = file::where("filename", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf")->where("description", "Erstvergleich")->first();
            if($file != null) {
                $file->delete();
            }
            return view("forEmployees/packtisch/versand-erfolg")->with("process_id", $id)->with("number", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);

        } else {
            $error = upsErrorCodes::where("code", $response->response->errors[0]->code)->first();
            $translator = new googleAPI();
            $translateted = $translator->translate("DE", $error->description, "EN");

            return redirect()->back()->withErrors([$translateted]);
        }

    }

    public function completeExternAusgang(Request $req, $id = "qqq") {
        $maindata               = maindata::where("company_id", "1")->first();
        
        $shipping_data          = warenausgang::where("ex_space", "Extern")->first();

        $row_country_from       = countrie::where("id", "1")->first();
        
        $row_country_to         = countrie::where("name", $shipping_data->country)->first();
        $carriers_service       = $shipping_data->carriers_service;
        $to_companyname         = $shipping_data->companyname;
        $to_firstname           = $shipping_data->firstname;
        $to_lastname            = $shipping_data->lastname;
        $to_street              = $shipping_data->street;
        $to_streetno            = $shipping_data->streetno;
        $to_zipcode             = $shipping_data->zipcode;
        $to_city                = $shipping_data->city;
        $to_mobilnumber         = $shipping_data->mobilnumber;
        $to_phonenumber         = $shipping_data->phonenumber;
        $length                 = $shipping_data->length;
        $width                  = $shipping_data->width;
        $height                 = $shipping_data->height;
        $weight                 = $shipping_data->weight;
        $nachnahme              = $shipping_data->nachnahme;

        if($carriers_service == "standard") {
            $carriers_service = "11";
        } else {
            $carriers_service = "65";
        }

       
        if(!isset($radio_saturday)) {
            $radio_saturday = 0;
        }
        if(!isset($radio_payment)) {
            $radio_payment = 0;
        }

		if($carriers_service == "65" && $radio_saturday == 1){
			$saturday_delivery['SaturdayDeliveryIndicator'] = array('SATURDAY_DELIVERY');
		}


		if($radio_payment == 1){
			$saturday_delivery['COD'] = array(
				'CODFundsCode' => '1', 
				'CODAmount' => array(
					'CurrencyCode' => 'EUR', 
					'MonetaryValue' => '' . $amount
				)
			);
		}
        $person = active_orders_person_data::where("process_id", $shipping_data->process_id)->first();
        if(!isset($nachnahme) || $nachnahme == null || $nachnahme != "on") {
            if($person->shipping_type == "samstagszustellung") {
                $cod = array('SaturdayDeliveryIndicator' => "true",
                    );
            } else {
                $cod = array('COD' => array(
                
                    )
                    );
            }

            
        } else {

            $booking     = booking::where("process_id", $id)->latest()->first();
            
            if($booking == null) {
                return redirect()->back()->withErrors(["Keine Offene Summe gefunden, Nachnahme hat somit kein Geldwert"]);
            }
            if($person->shipping_type == "samstagszustellung") {
                $cod = array(
                    'COD' => array(
                        'description' => "test",
                        'CODFundsCode' => '1',
                        'CODAmount' => array(
                            'CurrencyCode' => "EUR",
                            'MonetaryValue' => $booking->open_sum,
                        )
                        ),
                    "SaturdayDeliveryIndicator" => "true",
                    );
            } else {
                $cod = array(
                    'COD' => array(
                        'description' => "test",
                        'CODFundsCode' => '1',
                        'CODAmount' => array(
                            'CurrencyCode' => "EUR",
                            'MonetaryValue' => $booking->open_sum,
                        )
                    )
                    );
            }
            
        }
       
		$data = array(
            "ShipmentRequest" => array(
            "Request" => array(
                "SubVersion" => "1801",
                "RequestOption" => "nonvalidate",
                "TransactionReference" => array(
                    "CustomerContext" => ""
                )
                ),
                "Shipment" => array(
                    "Description" => "GZAMotors",
                    'ShipmentServiceOptions' => $cod,
                    "Shipper" => array(
                        "Name" => "Gazi Ahmad",
                        "AttentionName" => "GZAMotors",
                        "TaxIdentificationNumber" => "456999",
                        "Phone" => array(
                            "Number" => "1115554758",
                            "Extension" => " "
                        ),
                        "ShipperNumber" => "A285F8",
                        "FaxNumber" => "8002222222",
                        "Address" => array(
                            "AddressLine" => "Strausberger Platz. 13",
                            "City" => "Berlin",
                            "StateProvinceCode" => "DE",
                            "PostalCode" => "10243",
                            "CountryCode" => "DE"
                        )
                        ),

                        
                        "ShipTo" => array(
                            "Name" => $to_firstname . $to_lastname,
                            "AttentionName" => $to_companyname,
                            "Phone" => array(
                                "Number" => "9225377171"
                            ),
                            "Address" => array(
                                "AddressLine" => $to_street . " " . $to_streetno,
                                "City" => $to_city,
                                "StateProvinceCode" => $row_country_to['code'],
                                "PostalCode" => $to_zipcode,
                                "CountryCode" => $row_country_to['code']
                            ),
                            "Residential" => " "
                        ),
                        "ShipFrom" => array(
                            "Name" => "Gazi Ahmad",
                            "AttentionName" => "GZAMotors",
                            "Phone" => array(
                                "Number" => "1234567890"
                            ),
                            "FaxNumber" => "1234567890",
                            "Address" => array(
                                "AddressLine" => "Strausberger Platz. 13",
                                "City" => "Berlin",
                                "StateProvinceCode" => "DE",
                                "PostalCode" => "10243",
                                "CountryCode" => "DE"
                            )
                            ),
                        
                            "PaymentInformation" => array(
                                "ShipmentCharge" => array(
                                    "Type" => "01",
                                    "BillShipper" => array(
                                        "AccountNumber" => "A285F8"
                                    )
                                )
                                    ),
                                    "Service" => array(
                                        "Code" => $carriers_service,
                                        "Description" => "UPS Standard"
                                    ),
                                    "Package" => array(
                                        "Description" => " ",
                                        "Packaging" => array(
                                            "Code" => "02",
                                            "Description" => "Steuergeräte"
                                        ),
                                        "Dimensions" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "CM",
                                                "Description" => "Zentimeter"
                                            ),
                                            "Length" => $length,
                                            "Width" => $width,
                                            "Height" => $height
                                        ),
                                        "PackageWeight" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "KGS",
                                                "Description" => "Kilogramm"
                                            ),
                                            "Weight" => $weight
                                        )
                                        )),
                                        "LabelSpecification" => array(
                                            "LabelImageFormat" => array(
                                                "Code" => "GIF",
                                                "Description" => "GIF"
                                            ),
                                            "HTTPUserAgent" => "Mozilla/4.5"
                                        )
                                    )
                                        );

        /*array(
			'ShipmentRequest' => array(
				'Shipment' => array(
					'Description' => "awd", 
					'ShipmentServiceOptions' => $saturday_delivery, 
					'Shipper' => array(
						'Name' => "Gazi" . ' ' . "Ahmad", 
						'AttentionName' => '' . ("GZAMOTORS" != "" ? "GZAMOTORS" : $maindata['company']), 
						'TaxIdentificationNumber' => '456999', 
						'ShipperNumber' => $maindata['ups_customer_number'], 
						'Address' => array(
							'AddressLine' => "Straußbergerplatz" . ' ' . "12", 
							'City' => "Berlin", 
							'StateProvinceCode' => '', 
							'PostalCode' => "10243", 
							'CountryCode' => $row_country_from['code']
						)
					), 
					'ShipTo' => array(
						'Name' => $to_firstname . ' ' . $to_lastname, 
						'AttentionName' => $to_companyname, 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => $to_street . ' ' . $to_streetno, 
							'City' => $to_city, 
							'StateProvinceCode' => '', 
							'PostalCode' => $to_zipcode, 
							'CountryCode' => $row_country_to['code']
						)
					), 
					'ShipFrom' => array(
						'Name' => "Gazi" . ' ' . "Ahmad", 
						'AttentionName' => "GZAMOTORS", 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => "Straußbergerplatz" . ' ' . "12", 
							'City' => "Berlin", 
							'StateProvinceCode' => '', 
							'PostalCode' => "10243", 
							'CountryCode' => $row_country_from['code']
						)
					), 
					'PaymentInformation' => array(
						'ShipmentCharge' => array(
							'Type' => '01', 
							'BillShipper' => array(
								'AccountNumber' => $maindata['ups_customer_number']
							)
						)
					), 
					'Service' => array(
						'Code' => $carriers_service, 
						'Description' => $carriers_services[$carriers_service]
					), 
					'Package' => array(
						array(
							'Description' => 'GZA Motors - Sendung', 
							'ReferenceNumber' => array(
								'Value' => "awd", 
							),
							'Packaging' => array(
								'Code' => '02'
							), 
							'Dimensions' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'CM', 
									'Description' => 'Zentimeter'
								), 
								'Length' => '' . $length, 
								'Width' => '' . $width, 
								'Height' => '' . $height 
							), 
							'PackageWeight' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'KGS'
								), 
								'Weight' => '' . $weight
							), 
							'PackageServiceOptions' => ''
						)
	// ...
					), 
					'ItemizedChargesRequestedIndicator' => '', 
					'RatingMethodRequestedIndicator' => '', 
					'TaxInformationIndicator' => '', 
					'ShipmentRatingOptions' => array(
						'NegotiatedRatesIndicator' => ''
					)
				), 
				'LabelSpecification' => array(
					'LabelImageFormat' => array(
						'Code' => 'GIF'
					)
				)
			)
		);*/
        
        $from_mobilnumber       = $maindata["mobilnumber"];
        $from_phonenumber       = $maindata["phonenumber"];
        $from_email             = $maindata["email"];

		$from_phonenumber1 = $from_mobilnumber != "" ? $from_mobilnumber : $from_phonenumber;

		if($from_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['Shipper']['Phone'] = array('Number' => $from_phonenumber1);
			$data['ShipmentRequest']['Shipment']['ShipFrom']['Phone'] = array('Number' => $from_phonenumber1);
		}

		$to_phonenumber1 = $to_mobilnumber != "" ? $to_mobilnumber : $to_phonenumber;

		if($to_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['ShipTo']['Phone'] = array('Number' => $to_phonenumber1);
		}



        
		$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);



        #Adress Validation
        $APIUrl = 'https://addressvalidation.googleapis.com/v1:validateAddress?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg';

        $Params = array('XAVRequest' => array(
            "AddressKeyFormat" => array(
                "ConsigneeName" => "RITZ CAMERA CENTERS-1749",
                "BuildingName" => "Innoplex",
                "AddressLine" => [
                    "26601 ALISO CREEK ROAD",
                    "STE D",
                    "ALISO VIEJO TOWN CENTER"
                ],
                "CountryCode" => "US",
                "Region" => "ROSWELL,GA,30076-1521",
                "Urbanization" => "porto arundal",
                "PostcodeExtendedLow" => "1521",
                "PostcodePrimaryLow" => "92656",
                "PoliticalDivision1" => "CA",
                "PoliticalDivision2" => "ALISO VIEJO",

            )
        ));

        $headers = array();
        $headers[] = "Authorization: Bearer ". $this->Auth()->access_token;
        $headers[] = 'Accept: application/json';
        $headers[] = "grant_type=client_credentials";
        $headers[] = "x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $ch = curl_init('https://onlinetools.ups.com/api/addressvalidation/v1/1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{ 
            "XAVRequest": {
            "AddressKeyFormat": {
            "AddressLine": [
            "Lea-Grundig-Straße",
            "2",
            ],
            "Region": "Berlin",
            "PoliticalDivision1": "DE",
            "PostcodePrimaryLow": "12679",
            "CountryCode": "US"
            }
            } }
           ');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


		$result = curl_exec($ch);

		$response = json_decode($result);
        dd($response);

		$headers = array();
        $headers[] = "Authorization: Bearer ". $this->Auth()->access_token;
        $headers[] = 'Accept: application/json';
        $headers[] = "grant_type=client_credentials";
        $headers[] = "x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $ch = curl_init('https://onlinetools.ups.com/api/shipments/v1/ship');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);
		sleep($maindata['sleep_shipping_label']);
		if(!isset($response->response->errors[0])){
		
            $data = 'data:image/png;base64,'. $response->ShipmentResponse->ShipmentResults->PackageResults->ShippingLabel->GraphicImage;

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            file_put_contents(public_path("/").'/temp/'. $id . ".png", $data);
            $devices        = warenausgang::where("ex_space", "extern")->get();

            foreach($devices as $device) {

                if(isset($device->fotoauftrag)) {
                    if(!file_exists('files/aufträge/'. $device->process_id ."/". $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf")) {
                       $file = file::where("filename", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf")->first();
                       if($file == null) {
                        Storage::move('files/aufträge/'. $device->process_id ."/warenausgang.pdf", 'files/aufträge/'. $device->process_id ."/". $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf");
                        $file = file::where("process_id", $device->process_id)->where("filename", "warenausgang.pdf")->first();
                        if($file != null) {
                            $file->filename = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf";
                            $file->update();
                        }
                       }
                    }
                   
                }

                $inshipping     = new inshipping();
                $inshipping->process_id         = $device->process_id;
                $inshipping->component_number   = $device->component_number;
                $inshipping->label_id           = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber;
                $inshipping->type               = "Kunde";
                $inshipping->firstname          = $device->firstname;
                $inshipping->lastname           = $device->lastname;
                $inshipping->save();

                
                $ausgang                        = new warenausgang_history();
                $ausgang->gummi                 = $device->gummi;
                $ausgang->protection            = $device->protection;
                $ausgang->seal                  = $device->seal;
                $ausgang->bpz1                  = $device->bpz1 ;
                $ausgang->bpz2                  = $device->bpz2;
                $ausgang->employee              = auth()->user()->id;
                $ausgang->shipping_type         = $device->shipping_type;
                $ausgang->payment_type          = $device->payment_type;
                $ausgang->carriers_service      = $device->carriers_service;
                $ausgang->companyname           = $device->companyname;
                $ausgang->shortcut              = $device->shortcut;
                $ausgang->firstname             = $device->firstname;
                $ausgang->lastname              = $device->lastname;
                $ausgang->street                = $device->street;
                $ausgang->streetno              = $device->streetno;
                $ausgang->zipcode               = $device->zipcode;
                $ausgang->city                  = $device->city ;
                $ausgang->country               = $device->country;
                $ausgang->email                 = $device->email;
                $ausgang->mobilnumber           = $device->mobilnumber;
                $ausgang->phonenumber           = $device->phonenumber;
                $ausgang->amount                = $device->amount      ;
                $ausgang->length                = $device->length;
                $ausgang->weight                = $device->weight;
                $ausgang->height                = $device->height;
                $ausgang->width                 = $device->width   ;
                $ausgang->ex_space              = $device->ex_space;
                $ausgang->process_id            = $device->process_id;
                $ausgang->component_id          = $device->component_id;
                $ausgang->component_type        = $device->component_type;
                $ausgang->component_count       = $device->component_count;
                $ausgang->component_number      = $device->component_number;
                $ausgang->label                 = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber;

                $ausgang->save();

                $sh = used_shelfes::where("component_number", $device->component_number)->first();

            if($device->exspace == "Entsorgung") {
                $this->packtischStatusÄndern($req, "packtisch", 517, $device->process_id, $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count, $sh->shelfe_id, $device->bpz1, $device->bpz2, $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);
            
                $order = order_id::where("process_id", $device->process_id)->first();
                
                $this->deleteShelfeDevice($sh->shelfe_id, $device->component_number);
            } else {
                $this->packtischStatusÄndern($req, "packtisch", 729, $device->process_id, $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count, $sh->shelfe_id, $device->bpz1, $device->bpz2, $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);
            
                $this->deleteShelfeDevice($sh->shelfe_id, $device->component_number);
            
            }

            }            

            
            $shipping_data->delete();

            $file = file::where("filename", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf")->where("description", "Erstvergleich")->first();
            if($file != null) {
                $file->delete();
            }
            return view("forEmployees/packtisch/versand-erfolg")->with("process_id", $id)->with("number", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);

        } else {
        }

    }

    public function warenausgang_shipping_tec(Request $req, $id) {

            

        $maindata               = maindata::where("company_id", "1")->first();
        
        $shipping_data          = warenausgang::where("shortcut", $id)->first();

        $row_country_from       = countrie::where("id", "1")->first();
        
        $row_country_to         = countrie::where("name", $shipping_data->country)->first();
        if($row_country_to == null) {
            $row_country_to         = countrie::where("id", $shipping_data->country)->first();
        }
        $carriers_service       = $shipping_data->carriers_service;
        $to_companyname         = $shipping_data->companyname;
        $to_firstname           = $shipping_data->firstname;
        $to_lastname            = $shipping_data->lastname;
        $to_street              = $shipping_data->street;
        $to_streetno            = $shipping_data->streetno;
        $to_zipcode             = $shipping_data->zipcode;
        $to_city                = $shipping_data->city;
        $to_mobilnumber         = $shipping_data->mobilnumber;
        $to_phonenumber         = $shipping_data->phonenumber;
        $length                 = $shipping_data->length;
        $width                  = $shipping_data->width;
        $height                 = $shipping_data->height;
        $weight                 = $shipping_data->weight;
        $nachnahme              = $shipping_data->nachnahme;
        $type                   = $shipping_data->shipping_type;

        if($carriers_service == "standard" || $carriers_service == "Standard" || $carriers_service == "UPS Versand") {
            $carriers_service = "11";
        } else {
            $carriers_service = "65";
        }

       
        if(!isset($radio_saturday)) {
            $radio_saturday = 0;
        }
        if(!isset($radio_payment)) {
            $radio_payment = 0;
        }

        if($type == "Samstag") {
            $radio_payment = 1;
        }
        

		if($carriers_service == "65" && $radio_saturday == 1){
			$saturday_delivery['SaturdayDeliveryIndicator'] = array('SATURDAY_DELIVERY');
		}




		if($radio_payment == 1){
			$saturday_delivery['COD'] = array(
				'CODFundsCode' => '1', 
				'CODAmount' => array(
					'CurrencyCode' => 'EUR', 
					'MonetaryValue' => '' . $amount
				)
			);
		}
        $person = active_orders_person_data::where("process_id", $shipping_data->process_id)->first();
        if(!isset($nachnahme) || $nachnahme == null || $nachnahme != "on") {
            if($type == "Samstag") {
                $cod = array('SaturdayDeliveryIndicator' => "true",
                    );
            } else {
                $cod = array('COD' => array(
                
                    )
                    );
            }

            
        } else {

            $booking     = booking::where("process_id", $id)->latest()->first();
            
            if($booking == null) {
                return redirect()->back()->withErrors(["Keine Offene Summe gefunden, Nachnahme hat somit kein Geldwert"]);
            }
            if($person->shipping_type == "samstagszustellung") {
                $cod = array(
                    'COD' => array(
                        'description' => "test",
                        'CODFundsCode' => '1',
                        'CODAmount' => array(
                            'CurrencyCode' => "EUR",
                            'MonetaryValue' => $booking->open_sum,
                        )
                        ),
                    "SaturdayDeliveryIndicator" => "true",
                    );
            } else {
                $cod = array(
                    'COD' => array(
                        'description' => "test",
                        'CODFundsCode' => '1',
                        'CODAmount' => array(
                            'CurrencyCode' => "EUR",
                            'MonetaryValue' => $booking->open_sum,
                        )
                    )
                    );
            }
            
        }
       
		$data = array(
            "ShipmentRequest" => array(
            "Request" => array(
                "SubVersion" => "1801",
                "RequestOption" => "nonvalidate",
                "TransactionReference" => array(
                    "CustomerContext" => ""
                )
                ),
                "Shipment" => array(
                    "Description" => "GZAMotors",
                    'ShipmentServiceOptions' => $cod,
                    "Shipper" => array(
                        "Name" => "Gazi Ahmad",
                        "AttentionName" => "GZAMotors",
                        "TaxIdentificationNumber" => "456999",
                        "Phone" => array(
                            "Number" => "1115554758",
                            "Extension" => " "
                        ),
                        "ShipperNumber" => "A285F8",
                        "FaxNumber" => "8002222222",
                        "Address" => array(
                            "AddressLine" => "Strausberger Platz. 13",
                            "City" => "Berlin",
                            "StateProvinceCode" => "DE",
                            "PostalCode" => "10243",
                            "CountryCode" => "DE"
                        )
                        ),

                        
                        "ShipTo" => array(
                            "Name" => $to_firstname . $to_lastname,
                            "AttentionName" => $to_companyname,
                            "Phone" => array(
                                "Number" => "9225377171"
                            ),
                            "Address" => array(
                                "AddressLine" => $to_street . " " . $to_streetno,
                                "City" => $to_city,
                                "StateProvinceCode" => $row_country_to['code'],
                                "PostalCode" => $to_zipcode,
                                "CountryCode" => $row_country_to['code']
                            ),
                            "Residential" => " "
                        ),
                        "ShipFrom" => array(
                            "Name" => "Gazi Ahmad",
                            "AttentionName" => "GZAMotors",
                            "Phone" => array(
                                "Number" => "1234567890"
                            ),
                            "FaxNumber" => "1234567890",
                            "Address" => array(
                                "AddressLine" => "Strausberger Platz. 13",
                                "City" => "Berlin",
                                "StateProvinceCode" => "DE",
                                "PostalCode" => "10243",
                                "CountryCode" => "DE"
                            )
                            ),
                        
                            "PaymentInformation" => array(
                                "ShipmentCharge" => array(
                                    "Type" => "01",
                                    "BillShipper" => array(
                                        "AccountNumber" => "A285F8"
                                    )
                                )
                                    ),
                                    "Service" => array(
                                        "Code" => $carriers_service,
                                        "Description" => "UPS Standard"
                                    ),
                                    "Package" => array(
                                        "Description" => " ",
                                        "Packaging" => array(
                                            "Code" => "02",
                                            "Description" => "Steuergeräte"
                                        ),
                                        "Dimensions" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "CM",
                                                "Description" => "Zentimeter"
                                            ),
                                            "Length" => "15",
                                            "Width" => "10",
                                            "Height" => "5"
                                        ),
                                        "PackageWeight" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "KGS",
                                                "Description" => "Kilogramm"
                                            ),
                                            "Weight" => "5.0"
                                        )
                                        )),
                                        "LabelSpecification" => array(
                                            "LabelImageFormat" => array(
                                                "Code" => "GIF",
                                                "Description" => "GIF"
                                            ),
                                            "HTTPUserAgent" => "Mozilla/4.5"
                                        )
                                    )
                                        );


        
        $from_mobilnumber       = $maindata["mobilnumber"];
        $from_phonenumber       = $maindata["phonenumber"];
        $from_email             = $maindata["email"];

		$from_phonenumber1 = $from_mobilnumber != "" ? $from_mobilnumber : $from_phonenumber;

		if($from_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['Shipper']['Phone'] = array('Number' => $from_phonenumber1);
			$data['ShipmentRequest']['Shipment']['ShipFrom']['Phone'] = array('Number' => $from_phonenumber1);
		}

		$to_phonenumber1 = $to_mobilnumber != "" ? $to_mobilnumber : $to_phonenumber;

		if($to_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['ShipTo']['Phone'] = array('Number' => $to_phonenumber1);
		}



        
		$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);



        #Adress Validation
        $APIUrl = 'https://addressvalidation.googleapis.com/v1:validateAddress?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg';

        $Params = '{  "address": {    "regionCode": "'.$row_country_to->code.'",    "locality": "'.$row_country_to->city.'",    "postalCode": "'.$row_country_to->zipcode.'",    "addressLines": ["'.$row_country_to->street. ' ' . $row_country_to->streetno .'"]  },  "enableUspsCass": false}';

		$Params = json_decode($Params);

        $Params = json_encode($Params);


        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $ch = curl_init($APIUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $Params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);

        
		$headers = array();
        $headers[] = "Authorization: Bearer ". $this->Auth()->access_token;
        $headers[] = 'Accept: application/json';
        $headers[] = "grant_type=client_credentials";
        $headers[] = "x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $ch = curl_init('https://onlinetools.ups.com/api/shipments/v1/ship');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);
		sleep($maindata['sleep_shipping_label']);
		if(!isset($response->response->errors[0])){
		
            $data = 'data:image/png;base64,'. $response->ShipmentResponse->ShipmentResults->PackageResults->ShippingLabel->GraphicImage;

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            file_put_contents(public_path("/").'/temp/'. $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber . ".png", $data);
            $devices        = warenausgang::where("shortcut", $id)->get();

            foreach($devices as $device) {

                if(isset($device->fotoauftrag)) {
                    if(!file_exists('files/aufträge/'. $device->process_id ."/". $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf")) {
                       $file = file::where("filename", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf")->first();
                       if($file == null) {
                        Storage::move('files/aufträge/'. $device->process_id ."/warenausgang.pdf", 'files/aufträge/'. $device->process_id ."/". $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf");
                        $file = file::where("process_id", $device->process_id)->where("filename", "warenausgang.pdf")->first();
                        if($file != null) {
                            $file->filename = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf";
                            $file->update();
                        }
                       }
                    }
                   
                }

                $inshipping     = new inshipping();
                $inshipping->process_id         = $device->process_id;
                $inshipping->component_number   = $device->component_number;
                $inshipping->label_id           = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber;
                $inshipping->type               = "Kunde";
                $inshipping->firstname          = $device->firstname;
                $inshipping->lastname           = $device->lastname;
                $inshipping->save();

                
                $ausgang                        = new warenausgang_history();
                $ausgang->gummi                 = $device->gummi;
                $ausgang->protection            = $device->protection;
                $ausgang->seal                  = $device->seal;
                $ausgang->employee              = auth()->user()->id;
                $ausgang->bpz1                  = $device->bpz1 ;
                $ausgang->bpz2                  = $device->bpz2;
                $ausgang->shipping_type         = $device->shipping_type;
                $ausgang->payment_type          = $device->payment_type;
                $ausgang->carriers_service      = $device->carriers_service;
                $ausgang->companyname           = $device->companyname;
                $ausgang->shortcut              = $device->shortcut;
                $ausgang->firstname             = $device->firstname;
                $ausgang->lastname              = $device->lastname;
                $ausgang->street                = $device->street;
                $ausgang->streetno              = $device->streetno;
                $ausgang->zipcode               = $device->zipcode;
                $ausgang->city                  = $device->city ;
                $ausgang->country               = $device->country;
                $ausgang->email                 = $device->email;
                $ausgang->mobilnumber           = $device->mobilnumber;
                $ausgang->phonenumber           = $device->phonenumber;
                $ausgang->amount                = $device->amount      ;
                $ausgang->length                = $device->length;
                $ausgang->weight                = $device->weight;
                $ausgang->height                = $device->height;
                $ausgang->width                 = $device->width   ;
                $ausgang->ex_space              = $device->ex_space;
                $ausgang->process_id            = $device->process_id;
                $ausgang->component_id          = $device->component_id;
                $ausgang->component_type        = $device->component_type;
                $ausgang->component_count       = $device->component_count;
                $ausgang->component_number      = $device->component_number;
                $ausgang->fotoauftrag           = $device->fotoauftrag;
                $ausgang->file_id               = $device->file_id;
                $ausgang->label                 = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber;

                $ausgang->save();

                $dev = device_orders::where("component_number", $device->component_number)->first();
                $dev->ort = "Warenausgang (Techniker, versendet)";
                $dev->save();

                $sh = used_shelfes::where("component_number", $device->component_number)->first();

            if($device->exspace == "Entsorgung") {
                $this->packtischStatusÄndern($req, "packtisch", 517, $device->process_id, $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count, $sh->shelfe_id, $device->bpz1, $device->bpz2, $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);
            
                $order = order_id::where("process_id", $device->process_id)->first();
                
                $this->deleteShelfeDevice($sh->shelfe_id, $device->component_number);
            } else {
                $this->packtischStatusÄndern($req, "packtisch", 729, $device->process_id, $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count, $sh->shelfe_id, $device->bpz1, $device->bpz2, $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);
            
                $this->deleteShelfeDevice($sh->shelfe_id, $device->component_number);
            
            }
                $device->delete();

            }            

            
            $shipping_data->delete();

            $file = file::where("filename", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf")->where("description", "Erstvergleich")->first();
            if($file != null) {
                $file->delete();
            }
            return view("forEmployees/packtisch/versand-erfolg")->with("process_id", $devices[0]->process_id)->with("number", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);

        } else {
            $error = upsErrorCodes::where("code", $response->response->errors[0]->code)->first();

            if($error != null) {
                $translator = new googleAPI();
                $translateted = $translator->translate("DE", $error->description, "EN");
            } else {
                $translator = new googleAPI();
                $translateted = $translator->translate("DE", $response->response->errors[0]->message, "EN");
            }

            return redirect()->back()->withErrors([$translateted]);
        }

    }

    public function toPacktischExternVersand(Request $req) {
        foreach($req->all() as $key => $item) {
            if(str_contains($key, "dev") && str_contains($key, "-")) {
                $parts          = explode("-", $item);

                $ausgang        = new warenausgang();
                $ausgang->process_id = $parts[0];
                $ausgang->component_id = $parts[1];
                $ausgang->component_type = $parts[2];
                $ausgang->component_count = $parts[3];
                $ausgang->component_number = $item;
                $ausgang->ex_space = "Extern";

                $ausgang->ab_companyname = $req->input("ab_companyname");
                $ausgang->ab_firstname = $req->input("ab_firstname");
                $ausgang->ab_lastname = $req->input("ab_lastname");
                $ausgang->ab_street = $req->input("ab_street");
                $ausgang->ab_streetno = $req->input("ab_streetno");
                $ausgang->ab_city = $req->input("ab_city");
                $ausgang->ab_country = $req->input("ab_country");
                $ausgang->ab_email = $req->input("ab_email");
                $ausgang->ab_phone = $req->input("ab_phone");
                $ausgang->ab_mobil = $req->input("ab_mobil");


                $ausgang->shortcut = $req->input("contact");
                $ausgang->carriers_service = $req->input("shippingtype");
                $ausgang->firstname = $req->input("firstname");
                $ausgang->lastname = $req->input("lastname");
                $ausgang->gender = $req->input("gender");
                $ausgang->street = $req->input("street");
                $ausgang->streetno = $req->input("streetno");
                $ausgang->zipcode = $req->input("zipcode");
                $ausgang->city = $req->input("city");
                $ausgang->mobilnumber = $req->input("mobil");
                $ausgang->phonenumber = $req->input("phone");
                $ausgang->amount = $req->input("nachnahmebetrag");
                $ausgang->length = "30";
                $ausgang->height = "10";
                $ausgang->width = "20";
                $ausgang->weight = "5.0";
                $ausgang->country = $req->input("country");
                $ausgang->nachnahme = $req->input("nachnahme");
                $ausgang->info = $req->input("extcomment");

                $files = "";
                foreach($req->all() as $key => $item) {
                    if(str_contains("file-", $key)) {
                        $files += "," . $item->filename;
                    }
                }
                $ausgang->upload_file = $files;

                $ausgang->save();

            }
        }
        return redirect("/crm/versenden");
        }

    public function shipping_order_to_table(Request $req, $id) {
        $proc_id = $id;
        foreach($req->all() as $key => $value) {
            $$key       = $value;
        }
        $fin_devi        = array();
        foreach($req->except('_token') as $key => $in) {
            if(str_contains($key, "compon-")) {
                array_push($fin_devi, $in);
            }
        }
        foreach($fin_devi as $dev) {
            $de                             = device_orders::where("component_number", $dev)->first();
            $intern                         = intern_admin::where("process_id", $proc_id)->first();
            if($intern != null) {
                if($intern->result == "Überholung") {
                    $action = "Überholung";
                } else if($intern->result == "Ablehnung") {
                    $action = "Ablehnung";
                } else if($intern->result == "Prüfung") {
                    $action = "Prüfung";
                } else if($intern->result == "Gutschrift") {
                    $action = "Gutschrift";
                } else if($intern->result == "Austausch") {
                    $action = "Austausch";
                }

                $component               = component_name::where("id", $de->component)->first();
                if($component != null) {
                    $files                   = bpzfile::where("component_name", $component->component_name)->where("action", $action)->first();
                } else {
                    $files = null;
                }
            } else {
            }
            $tec        = contact::where("street", $street)->first();
            if($dev != null) {
                $dev_exp                    = explode("-", $dev);
                $order                      = new warenausgang();

                $order->carriers_service    = $carriers_service;
                $order->companyname         = $companyname;
                $order->shortcut            = $tec->shortcut;
                $order->firstname           = $firstname;
                $order->lastname            = $lastname;
                $order->street              = $street;
                $order->streetno            = $streetno;
                $order->zipcode             = $zipcode;
                $order->city                = $city;
                $order->country             = $country;
                $order->email               = $email;
                $order->mobilnumber         = $mobilnumber;
                $order->phonenumber         = $phonenumber;
                $order->amount              = $amount;
                $order->length              = $length;
                $order->weight              = $weight;
                $order->height              = $height;
                $order->width               = $width;
                $order->ex_space            = $type;
                $order->process_id          = $process_id;
                $order->component_id        = $dev_exp[1];
                $order->component_type      = $dev_exp[2];
                $order->component_count     = $dev_exp[3];
                $order->component_number    = $dev;
                 if(!isset($gummi)) {
                    $gummi = "";
                }
                $order->gummi               = $gummi;
                if(!isset($spannungsschutz)) {
                    $ean = "";
                    $order->protection          = $ean;
                } else {
                    $order->protection          = $spannungsschutz;
                }
                if(!isset($vp_si)) {
                    $vp_si = "";
                    $order->seal                = $vp_si;
                } else {
                    $order->seal                = $vp_si;
                }
                if($kfile1 == "0") {
                    if(!isset($files)) {
                        $kfile1             = null;
                    } else {
                        $kfile1             = $files->Datei_1;
                    }
                }
                $order->bpz1                = $kfile1;
                if($kfile2 == "0") {
                    if(!isset($files)) {
                        $kfile1             = null;
                    } else {
                        $kfile2                  = $files->Datei_2;
                    }
                }
                $order->bpz2                = $kfile2;
                if($info != null) {
                    $order->info                = "Bitte umbedingt fremde Kleber vom alten Techniker überkleben & " . $info;
                } else {
                    $order->info                = "Bitte umbedingt fremde Kleber vom alten Techniker überkleben";
                }
                if($req->file("kshipping-file") != null) {
                    $path = $req->file("kshipping-file")->storeAs("/files/warenausgang/". $id. "/" ,  "ex_file.pdf");
                    $order->upload_file = $dev. "." . $req->file("kshipping-file")->getClientOriginalExtension();
                }
                $res = $order->save();
            }
        }
            return redirect("/crm/change/order/". $id ."/auftragshistory");

    }

    public function shipping_order_to_table_kunde(Request $req, $id) {

       

        $counti = ["Belgien",
        "Bulgarien",
        "Dänemark",
        "Deutschland",
        "Estland",
        "Finnland",
        "Frankreich",
        "Griechenland",
        "Irland",
        "Italien",
        "Kroatien",
        "Lettland",
        "Litauen",
        "Luxemburg",
        "Malta",
        "Niederlande",
        "Österreich",
        "Polen",
        "Portugal",
        "Rumänien",
        "Schweden",
        "Slowakei",
        "Slowenien",
        "Spanien",
        "Tschechien",
        "Ungarn",
        "Vereinigtes Königreich",
        "Zypern"];

        $proc_id = $id;
        foreach($req->all() as $key => $value) {
            $$key       = $value;
        }
        $fin_devi        = array();
        foreach($req->except('_token') as $key => $in) {
            if(str_contains($key, "kcompon-")) {
                array_push($fin_devi, $in);
            }
        }
        
        if(!isset($nachnahme)) {
            $nachnahme = "off";
        } else {
            $booking     = booking::where("process_id", $id)->latest()->first();
            
            if($booking == null) {
                return redirect()->back()->withErrors(["Keine Offene Summe gefunden, Nachnahme hat somit kein Geldwert"]);
            }
        }

        $country = countrie::where("name", $req->input("kcountry"))->first();

        $google = new googleAPI();
        $response = $google->verifyAdress($country->code, $kcity, $kzipcode, $kstreet, $kstreetno);
        if($response != "ok") {
            if($response[0] != "CORRECTED") {
                $req->session()->flash('verify-street', $kstreet . " " . $kstreetno);
                $req->session()->flash('verify-zipcode-city', $kzipcode . ", " . $kcity);
                $req->session()->flash('verify-country', $country->name);

                $handle = curl_init("https://maps.googleapis.com/maps/api/place/queryautocomplete/json?input=". $kstreet ."%20". $kstreetno ."&key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg");
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($handle);
                $responseDecoded = json_decode($response, true);
                curl_close($handle);
                if(!isset($responseDecoded["status"])) {
                    $req->session()->flash('new-street', "NOT_FOUND");
                } else {
                    $req->session()->flash('verify-street', $kstreet . " " . $kstreetno);
                    $req->session()->flash('verify-zipcode', $kzipcode . ", " . $kcity);
                    $req->session()->flash('verify-country', $country->name);

                    $req->session()->flash('new-street', $kstreet . " " . $kstreetno);
                    $req->session()->flash('new-zipcode', $kzipcode . ", " . $kcity);
                    $req->session()->flash('new-country', $country->name);
                }
            } else {
                $req->session()->flash('verify-street', $kstreet . " " . $kstreetno);
                $req->session()->flash('verify-zipcode-city', $kzipcode . ", " . $kcity);
                $req->session()->flash('verify-country', $country->name);

                $req->session()->flash('new-street', $response[1][0]->componentName->text . " " . $response[1][1]->componentName->text);
                $req->session()->flash('new-zipcode-city', $response[1][2]->componentName->text . ", " . $response[1][3]->componentName->text);
                $req->session()->flash('new-country', $response[1][4]->componentName->text);
            }

            return redirect()->back()->withErrors(["Address not Found"]);
        }
       
        $packid = random_int(1000, 9999);

        foreach($fin_devi as $dev) {
            $de                             = device_orders::where("component_number", $dev)->first();
            $intern                         = intern_admin::where("process_id", $proc_id)->first();
            if($intern != null) {
                if($intern->result == "Überholung") {
                    $action = "Überholung";
                } else if($intern->result == "Ablehnung") {
                    $action = "Ablehnung";
                } else if($intern->result == "Prüfung") {
                    $action = "Prüfung";
                } else if($intern->result == "Gutschrift") {
                    $action = "Gutschrift";
                } else if($intern->result == "Austausch") {
                    $action = "Austausch";
                }

                $component               = component_name::where("id", $de->component)->first();
                if($component != null) {
                    $files                   = bpzfile::where("component_name", $component->component_name)->where("action", $action)->first();
                } else {
                    $files = null;
                }
            } else {
            }
            if($dev != null) {

                $person = active_orders_person_data::where("process_id", $process_id)->first();
                
               
                $dev_exp                    = explode("-", $dev);
                $order                      = new warenausgang();

                if(!isset($nachnahme)) {
                    $nachnahme = "off";
                }

                $order->carriers_service    = $person->shipping_type;
                $order->companyname         = $kcompanyname;
                $order->firstname           = $kfirstname;
                $order->lastname            = $klastname;
                $order->street              = $kstreet;
                $order->streetno            = $kstreetno;
                $order->zipcode             = $kzipcode;
                $order->city                = $kcity;
                $order->country             = $kcountry;
                $order->email               = $kemail;
                $order->mobilnumber         = $kmobilnumber;
                $order->phonenumber         = $kphonenumber;
                $order->amount              = $amount;
                $order->length              = $length;
                $order->weight              = $weight;
                $order->height              = $height;
                $order->packid              = $packid;
                $order->width               = $width;
                $order->ex_space            = $ktype;
                $order->process_id          = $process_id;
                if(isset($fotoauftrag)) {
                    $order->fotoauftrag     = $fotoauftrag;
                }
                $order->nachnahme = $nachnahme;
                $order->component_id        = $dev_exp[1];
                $order->component_type      = $dev_exp[2];
                $order->component_count     = $dev_exp[3];
                $order->component_number    = $dev;
                if(!isset($gummi)) {
                    $gummi = "";
                }
                $order->gummi               = $gummi;
                if(!isset($spannungsschutz)) {
                    $ean = "";
                    $order->protection          = $ean;
                } else {
                    $order->protection          = $spannungsschutz;
                }
                if(!isset($vp_si)) {
                    $vp_si = "";
                    $order->seal                = $vp_si;
                } else {
                    $order->seal                = $vp_si;
                }
                if($file1 == "0") {
                    if(!isset($files)) {
                        $file1             = null;
                    } else {
                        $file1             = $files->Datei_1;
                    }
                } else {
                    
                    $file1 = attachment::where("name", $file1)->first();
                    if($file1 != null) {
                        $order->bpz1                = $file1->barcode;
                    }

                }
                if($file2 == "0") {
                    if(!isset($files)) {
                        $kfile1             = null;
                    } else {
                        $kfile2                  = $files->Datei_2;
                    }
                } else{
                    $file2 = attachment::where("name", $file2)->first();
                    if($file2 != null) {
                        $order->bpz2                = $file2->barcode;
                    }
                }
                $c = countrie::where("name", $kcountry)->first();
                if(!in_array($c->name, $counti)) {
                    if($kinfo == null) {
                        $kinfo = 'Dritt Land Rechnungen Internationale Sendungen REMINDER “Achtung Internationale Sendung, Kunden Rechnung muss 2-Fach an das Paket von Außen geklebt werden';

                    } else {
                        $kinfo += 'Dritt Land Rechnungen Internationale Sendungen REMINDER “Achtung Internationale Sendung, Kunden Rechnung muss 2-Fach an das Paket von Außen geklebt werden';

                    }
                }

                if($kinfo != null) {
                    $order->info                = $kinfo;
                } else {
                    $order->info                = "";
                }
                if(!isset($to_adress)) {
                    $to_adress = "";
                }
                $order->shortcut            = $to_adress;

                if($req->file("shipping-file") != null) {
                    $path = $req->file("shipping-file")->storeAs("/files/warenausgang/". $id. "/" ,  "ex_file.pdf");
                    $order->upload_file = $dev. "." . $req->file("shipping-file")->getClientOriginalExtension();
                }

                $order->save();

                $this->packtischStatusÄndern($req, "packtisch", "930", $order->process_id, $order->component_number, null, $order->bpz1, $order->bpz2);
            }
        }

        
       
            return redirect("/crm/change/order/". $id ."/auftragshistory");

    }

    public function warenausgang_view(Request $req, $id) {
        $warensausgang      = warenausgang::where("process_id", $id)->get();
        $attch              = attachment::all();
        $files              = array();
        $process_id         = $id;
        
        return view("forMitarbeiter/packtisch/versand_view")->with("warenausgang", $warensausgang)->with("attch", $attch)->with("process_id", $process_id);
    }

    public function global_search(Request $req) {
        if($req->input("global_keyword") != null) {
            $key        = $req->input("global_keyword");

            $query = active_orders_person_data::query();
            $columns = ['process_id', 'firstname', 'lastname', "phone_number", "mobile_number", "email", "home_street", "send_back_street", "home_city", "home_country", "kunden_id"];
            foreach($columns as $column){
                if($column == "kunden_id") {
                    $query->orWhere($column, 'LIKE', "%" . str_replace("K", "", $key) . "%");
                } else {
                    $query->orWhere($column, 'LIKE', "%" . $key . "%" );
                }
            }
            $active_orders = $query->get();

            $query3 = rechnungen::query();
            $columns = ['kundenid', 'rechnungsnummer', 'bezeichnung'];
            foreach($columns as $column){
                $query3->orWhere($column, 'LIKE', $key);
                if($column == "kundenid") {
                    $query3->orWhere($column, 'LIKE', "%" . str_replace("K", "", $key) . "%" );
                } else {
                    $query3->orWhere($column, 'LIKE', "%" . $key. "%" );
                }
            }
            $rechnungen = $query3->get();
            
            $query2 = new_leads_person_data::query();
            $columns = ['process_id', 'firstname', 'lastname', "phone_number", "mobile_number", "email", "home_street", "send_back_street", "home_city", "home_country", "kunden_id"];
            foreach($columns as $column){
                if($column == "kunden_id") {
                    $query2->orWhere($column, 'LIKE', str_replace("K", "", $key));
                } else {
                    $query2->orWhere($column, 'LIKE', $key);
                }
            }
            $leads = $query2->get();

            $employees          = employeeModel::all();

            $statuses = statuse::all();
            $statusHistory = status_histori::all();

            $active_orders = $active_orders->merge($leads);
            $active_orders = $active_orders->merge($rechnungen);

            
            return view("forEmployees/global-search")
                    ->with("statuses", $statuses)
                    ->with("rechnungen", $rechnungen)
                    ->with("orders", $active_orders)
                    ->with("employees", $employees)
                    ->with("search_option", $key)
                    ->with("statusHistory", $statusHistory);
        } else {
            return redirect()->back();
        }
    }

    public function filterGlobaleSuche(Request $req) {
        
        $count          = $req->input("count");
        $sort           = $req->input("direction");
        $type           = $req->input("field");
        $status         = $req->input("status");
        $buchhaltung    = $req->input("buchhaltung");
        if($buchhaltung != null) {

            if(str_contains($buchhaltung, "mahnstufe")) {
                $mahnstufe = explode("-", $buchhaltung)[1];
                $mahnungen = mahnungen::where("mahnstufe",$mahnstufe)->where("process_id", null)->get();
                $person = collect();
                $usedRechnunge = array();
                foreach ($mahnungen as $mahnung) {
                    $rechnung = rechnungen::where("rechnungsnummer", $mahnung->rechnungsnummer)->first();
                    if($rechnung != null) {
                        $kundenkonto = kundenkonto::where("kundenid", $rechnung->kundenid)->first();
                        if($kundenkonto != null) {
                            $p = active_orders_person_data::where("process_id", $kundenkonto->process_id)->with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->first();
                            $person->push($p);
                        }
                    }
                    
                }
            }

            if($buchhaltung == "mahnsperre") {
                $mahnungen = mahnungen::where("process_id","sperre")->get();
                $person = collect();

                foreach ($mahnungen as $mahnung) {
                    $rechnung = rechnungen::where("rechnungsnummer", $mahnung->rechnungsnummer)->first();
                    if($rechnung != null) {
                        $kundenkonto = kundenkonto::where("kundenid", $rechnung->kundenid)->first();
                        if($kundenkonto != null) {
                            $p = active_orders_person_data::where("process_id", $kundenkonto->process_id)->with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->first();
                            $person->push($p);
                        }
                    }
                   
                }
            }

            if($buchhaltung == "keine-rechnungen") {
                $kundenkonten = kundenkonto::all();
                $person = collect();

                foreach($kundenkonten as $konto) {
                    $rechnung = rechnungen::where("kundenid", $konto->kundenid)->first();
                    if($rechnung == null) {
                        $p = active_orders_person_data::where("process_id", $konto->process_id)->with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->first();
                        if($p != null) {
                            $person->push($p);
                        }
                    }
                }
            }

            if($buchhaltung == "gutschriften") {
                $rechnungen = rechnungen::where("kundenid", $konto->kundenid)->get();
                $person = collect();

                foreach($kundenkonten as $konto) {
                    $rechnung = rechnungen::where("kundenid", $konto->kundenid)->first();
                    if($rechnung == null) {
                        $p = active_orders_person_data::where("process_id", $konto->process_id)->with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->first();
                        if($p != null) {
                            $person->push($p);
                        }
                    }
                }
            }

            $users = user::all();
            $email = emailinbox::where("read_at", null)->get();
            $allStats = statuse::all();

            
            if($status != "all") {
                $statuses = statuse::where("id", $status)->get();
            } else {
                $statuses = statuse::all();
            }

     
    }


}

    public function changeLagerplatsübersichtView(Request $req, $id) {

        $lagerplatz         = used_shelfes::where("component_number", $id)->first();

        if($lagerplatz != null && $lagerplatz->process_id != "0") {
            $shelfes        = used_shelfes::all();
            return view("forMitarbeiter/packtisch/lagerplatz_comp")->with("lagerplatz", $lagerplatz)->with("shelfes", $shelfes);

        }

    }

    public function addHelperBarcode(Request $req, $helpercode, $shelfe) {

        $db         = helpercode::where("helper_code", $helpercode)->first();
        if($db != null) {
            $this->addHelperBarcode($req, $this->createHelperCode(), $shelfe);
        } else {
            $code                   = new helpercode();
            $code->process_id       = "not found";
            $code->helper_code      = $helpercode;
            $code->save();

            DB::table('shelfes')
            ->where('shelfe_id', $shelfe)
            ->update(['process_id' =>$helpercode, 'component_id' => "not defined", 'component_number' =>"not defined"]);

            return redirect("crm/neue-packtische");
        }

    }

    public function getBarcode(Request $req, $barcode) {
        return view("helper/barcode")->with("barcode", $barcode);

    }

    public function packtischView(Request $req, $args = null) {

        
        $firstdate      = date("Y-m-d H:i:s", strtotime('+2 days'));
        $seconddate     = date('Y-m-d H:00:00', strtotime('-'. date('H') .' hours'));
        $intern         = intern::where("locked", null)->get();
        $ausgang        = warenausgang::where("locked", "!=", "yes")->orWhere("locked", null)->where("einlagerungid", null)->with("file")->get();
        $intern_history = intern_history::whereBetween('created_at', [$seconddate , $firstdate])->get();
        $ausgang_archive= warenausgang_history::whereBetween('created_at', [$seconddate , $firstdate])->with("shelfe")->get();
        $wareneingang   = wareneingang::whereBetween('created_at', [$seconddate, $firstdate])->with("shelfe")->get(); 
        $contacts       = contact::all();    
        $hinweise       = hinweis::where("area", "Packtisch")->get();
        $employees      = User::all();
  

        return view("forEmployees/packtisch/main")
                ->with('contacts', $contacts)
                ->with("wareneingang", $wareneingang)
                ->with("warenausgang_history", $ausgang_archive)
                ->with("interns", $intern)
                ->with("ausgang", $ausgang)
                ->with("intern_history", $intern_history)
                ->with("hinweise", $hinweise)
                ->witH("employees", $employees)
                ->with("args", $args);
    }

    public function getInternEinlagerungsauftrag(Request $req, $id) {

        $intern = intern::where("id", $id)->first();
        $shelfe = $this->getFreeShelfe();

        return view("forEmployees.packtisch.einlagerungsauftrag")->with("intern", $intern)->with("shelfe", $shelfe);

    }

    public function getSliderTrackinghistory(Request $req, $id) {
         
        $firstdate      = date("Y-m-d H:i:s", strtotime('+2 days'));
        $seconddate     = date('Y-m-d H:i:s', strtotime('-'. date('h') .' hours'));
        $intern         = intern::where("locked", "!=", "yes")->get();
        $ausgang        = warenausgang::where("locked", "!=", "yes")->orWhere("locked", null)->get();
        $intern_history = intern_history::whereBetween('created_at', [$seconddate , $firstdate])->get();
        $ausgang_archive= warenausgang_history::whereBetween('created_at', [$seconddate , $firstdate])->with("shelfe")->get();
        $wareneingang   = wareneingang::whereBetween('created_at', [$seconddate, $firstdate])->with("shelfe")->get(); 

        $wt = warenausgang_history::where("id", $id)->first();
        $trackinghistory = tracking_history::where("label", $wt->label)->get();
        
        $versandartikel = warenausgang_history::where("label", $wt->label)->get();

        $contacts       = contact::all();    
        $ups = new UPS();
       
        return view("forEmployees/packtisch/main")->with("versandartikel", $versandartikel)->with("wt", $wt)->with("trackinghistory", $trackinghistory)->with('contacts', $contacts)->with("wareneingang", $wareneingang)->with("warenausgang_history", $ausgang_archive)->with("interns", $intern)->with("ausgang", $ausgang)->with("intern_history", $intern_history);


    }

    public function fotoauftragView(Request $req, $id) {
        $intern         = intern::where("component_number", $id)->first();
        $auftrag        = device_orders::where("component_number", $id)->first();
        $shelfe         = shelfe::where("component_number", $id)->first();

        return view("forEmployees/packtisch/fotoauftrag")->with("id", $id)->with("auftrag", $auftrag)->with("shelfe", $shelfe)->with("intern", $intern);

    }

    public function umlagerungsauftragView(Request $req, $id) {
        $auftrag        = device_orders::where("component_number", $id)->first();
        $shelfe         = shelfe::where("component_number", $id)->first();
        $intern         = intern::where("component_number", $id)->first();
        $newshelfe      = shelfe::where("shelfe_id", $intern->info)->first();

        return view("forEmployees/packtisch/umlagerungsauftrag")->with("id", $id)->with("auftrag", $auftrag)->with("shelfe", $shelfe)->with("shelfenew", $newshelfe)->with("intern", $intern);
    }

    public function technikerAusgangView(Request $req, $tec) {

        $ausgang        = warenausgang::where("shortcut", $tec)->with("shelfe")->get();

        return view("forEmployees/packtisch/ausgang-techniker")->with("warenausgang", $ausgang)->with("shortcut", $tec);

    }

    public function kundenAusgangView(Request $req, $id) {

        $ausgang        = warenausgang::where("process_id", $id)->with("shelfe")->get();
        $attch          = attachment::all();
        $files          = array();
        foreach($ausgang as $aus) {
            if($aus->upload_file != null) {
                if(file_exists("files/warenausgang/". $aus->process_id . "/". $aus->upload_file)) {
                    array_push($files, $aus->upload_file);
                }
            }
            
        }
        return view("forEmployees/packtisch/ausgang-kunde")->with("warenausgang", $ausgang)->with("id", $id)->with("attach", $attch)->with("files", $files);

    }

    public function externAusgangView(Request $req) {
        
        $ausgang        = warenausgang::where("ex_space", "extern")->with("shelfe")->get();
        $attch          = attachment::all();
        $files          = array();
        foreach($ausgang as $aus) {
            if($aus->upload_file != null) {
                if(file_exists("files/warenausgang/". $aus->process_id . "/". $aus->upload_file)) {
                    array_push($files, $aus->upload_file);
                }
            }
            
        }
        return view("forEmployees/packtisch/ausgang-extern")->with("warenausgang", $ausgang)->with("id", "extern")->with("attach", $attch)->with("files", $files);
    }

    public function entsorgungAusgangView(Request $req) {

        $ausgang        = warenausgang::where("ex_space", "Entsorgung")->with("shelfe")->get();

        return view("forEmployees/packtisch/ausgang-entsorgung")->with("warenausgang", $ausgang);

    }

    public function keinBarcodeView(Request $req) {

        $barcode        = $this->createHelperCode();
        $shelfe         = $this->getFreeShelfe();
        return view("forEmployees/packtisch/kein-barcode")->with("barcode", $barcode)->with("shelfe", $shelfe);

    }

    public function keinBarcode(Request $req, $id, $shelfe) {
        $code       = new helpercode();
        $code->process_id       = "not found";
        $code->helper_code      = $id;
        $code->save();

        DB::table('shelfes')
        ->where('shelfe_id', $shelfe)
        ->update(['process_id' => "not defined", 'component_id' => "not defined", 'component_number' => $id]);

        return redirect("/crm/packtisch");

    }
    public function newDeviceViewRefresh(Request $req, $code, $shelfe) {
        $empty_shelfe   = shelfe::where("shelfe_id", $shelfe)->first();
        $parts          = explode("-", $code);
        $user           = active_orders_person_data::where("process_id", $parts[0])->first();
        $allow = allowBarcodes::where("setting", "true")->first();
        if($allow == null) {
            $allow = allowBarcodes::where("setting", "false")->first();
        }
        if($user == null) {
            $user           = new_leads_person_data::where("process_id", $parts[0])->first();
        }

        if(file_exists(public_path(). "/files/aufträge/". $parts[0]. "/". $code. ".PDF") || file_exists(public_path().  "/files/aufträge/users/packtisch/". $parts[0]. ".PDF")) {
            $file = true;
        } else {
            $file = false;
        }
        $process_parts      = explode("-", $code);
                    $process_id         = $process_parts[0];
                    $component_id       = $process_parts[1];
                    $component_type     = $process_parts[2];
                    $component_count    = $process_parts[3];
        return view("forEmployees/packtisch/new-device")->with("shelfe", $empty_shelfe)->
                        with("component_name", $code)->
                        with("component_id", $component_id)->
                        with("component_type", $component_type)->
                        with("component_count", $component_count)->
                        with("process_id", $process_id)->
                        with("order", $user)->
                        with("file", $file)->
                        with("allow", $allow);
    }

    public function fotoauftragRefresh(Request $req, $id, $shelfe) {
        $intern         = intern::where("component_number", $id)->first();
        $auftrag        = device_orders::where("component_number", $id)->first();
        $shelfe         = shelfe::where("component_number", $id)->first();

        return view("forEmployees/packtisch/fotoauftrag")->with("id", $id)->with("auftrag", $auftrag)->with("shelfe", $shelfe)->with("intern", $intern);
    }

    public function pickup(Request $req) {
        #https://wwwcie.ups.com/webservices/Pickup/PickupCreationRequest
        $maindata               = maindata::where("company_id", "1")->first();

        $data = array(
            "PickupRateRequest" => array(
                "PickupAddress" => array(
                    "AddressLine" => "315 Saddle Bridge Drive",
                    "City" => "Allendale",
                    "StateProvince" => "NJ",
                    "PostalCode" => "07401",
                    "CountryCode" => "US",
                    "ResidentialIndicator" => "Y"
                ),
                "AlternateAddressIndicator" => "N",
                "ServiceDateOption" =>"02",
                "PickupDateInfo" => array(
                    "CloseTime" => "2000",
                    "ReadyTime" => "900",
                    "PickupDate" => "20160405"
                )
            )
                );
            $data_string = json_encode($data, JSON_UNESCAPED_UNICODE);
            

            $headers = array();
            $headers[] = "Authorization: Bearer ". $this->Auth();
            $headers[] = 'Accept: application/json';
            $headers[] = "grant_type=grant_type=client_credentials";
            $headers[] = "X-Merchant-Id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX";
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';

            $ch = curl_init('https://wwwcie.ups.com/api/shipments/v1/pickup/both');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
            $result = curl_exec($ch);
            $response = json_decode($result);
    }

    public function Auth() {
        #https://wwwcie.ups.com/webservices/Pickup/PickupCreationRequest
        $maindata               = maindata::where("company_id", "1")->first();

        $data       = array();
        $data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

         
        $clientID = base64_encode("WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX:hUt8JugAfbixJ0iFL5g5LOM26bogHxelFoyjxas4AwvcfKxCV2Vm0eCJM5vlRP2s");
        
        $headers = array();
        $headers[] = "Authorization: Basic V3dXclkyQmNNY1dBS3hmWE80WkFDb254VEQzNGxzbWk4eGRIZ3k4VEFFZ1NJTlJYOmhVdDhKdWdBZmJpeEowaUZMNWc1TE9NMjZib2dIeGVsRm95anhhczRBd3ZjZkt4Q1YyVm0wZUNKTTV2bFJQMnM=";
        $headers[] = 'Accept: application/json';
        $headers[] = "grant_type=client_credentials";
        $headers[] = "x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $ch = curl_init('https://onlinetools.ups.com/security/v1/oauth/token');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		$response = json_decode($result);
        return $response;
    }

    public function packtischHistorie(Request $req) {
        
        $intern             = intern_history::latest()->limit($this->historie_site_counter)->get()->sortByDesc("created_at");
        $internCount        = intern_history::count();

        $warenausgang       = warenausgang_history::latest()->limit($this->historie_site_counter)->get()->sortByDesc("created_at");
        $warenausgangCount  = warenausgang_history::count();

        $wareneingang       = wareneingang::with("shelfe")->latest()->limit($this->historie_site_counter)->get()->sortByDesc("created_at");
        $wareneingangCount  = wareneingang::count();

        $db_trackings = tracking_history::all();

        $users          = user::all();
        $contacts       = contact::all();

        return view("forEmployees/packtisch/historie")
                ->with("trackings", $db_trackings->sortByDesc("created_at"))
                ->with("intern", $intern)
                ->with("internCount", $internCount)
                ->with("warenausgang", $warenausgang)
                ->with("warenausgangCount", $warenausgangCount)
                ->with("wareneingang", $wareneingang)
                ->with("wareneingangCount", $wareneingangCount)
                ->with("users", $users)
                ->with("contacts", $contacts);

    }

    public function packtischHistorieAllTracking(Request $req, $id) {
        $warenausgang       = warenausgang_history::all()->sortByDesc("created_at");
        $shelfes            = used_shelfes::all();
        $db_trackings       = tracking_history::all();
        $trackinghistory    = tracking_history::where("label", $id)->get();
        $wt                 = warenausgang_history::where("label", $id)->first();
        $versandartikel     = warenausgang_history::where("label", $id)->get();
        $users              = User::all();
        if($wt->file_id != null) {
            $files              = file::where("warenausgang_id", $wt->file_id)->get();
        } else {
            $files              = file::where("warenausgang_id", "noid")->get();
        }

        $siegel = collect();
        foreach($versandartikel as $v){
            $s = seal::where("component_number", $v->component_number)->first();
            if($s != null) {
                $siegel->push($s);
            }
        } 

        return view("includes.packtisch.historie")
                    ->with("users", $users)
                    ->with("wt", $wt)
                    ->with("versandartikel", $versandartikel)
                    ->with("trackinghistory", $trackinghistory)
                    ->with("trackings", $db_trackings->sortByDesc("created_at"))
                    ->with("warenausgang", $warenausgang)
                    ->with("siegel", $siegel)
                    ->with("shelfes", $shelfes)
                    ->with("files", $files);
    }

    public function getVersandInfosModal(Request $req, $id) {
        $intern         = intern_history::all()->sortByDesc("created_at");
        $warenausgang   = warenausgang_history::all()->sortByDesc("created_at");

        $wareneingang   = wareneingang::all()->sortByDesc("created_at");
        $shelfes        = used_shelfes::all();
        $db_trackings = tracking_history::all();
        $trackinghistory = tracking_history::where("label", $id)->get();
        $wt = warenausgang_history::where("label", $id)->first();
        $versandartikel = warenausgang_history::where("label", $id)->get();

        $users = user::all();

        return view("includes.packtisch.versand-verlauf")->with("users", $users)->with("wt", $wt)->with("versandartikel", $versandartikel)->with("trackinghistory", $trackinghistory)->with("trackings", $db_trackings->sortByDesc("created_at"))->with("intern", $intern)->with("warenausgang", $warenausgang)->with("wareneingang", $wareneingang)->with("shelfes", $shelfes);

    }

    public function getShippingHistoryTracking(Request $req, $id, $label) {

        $ups = new UPS();
        $trackings = $ups->getTracking($label);
        if($trackings[0]->status->statusCode == 007) {
            $statuses  = status_histori::where("process_id", $id)->where("last_status", "581")->first();
            if($statuses != null) {
                $trackings[0]->status->description = "Warenausgang rückgängig gemacht";
                $trackings[0]->date = $statuses->created_at->format("Ymd");
                $trackings[0]->time = $statuses->created_at->format("His");

            }
        }

        if($trackings == "error") {
            $ausgang  = warenausgang_history::where("label", $label)->where("process_id", $id)->first();

            $trackings = DB::table("tracking_history")->where("process_id", $id)->where("label", $label)->get();
    
            return [$ausgang, null, $trackings];

        } else {
            $ausgang  = warenausgang_history::where("label", $label)->where("process_id", $id)->first();
            if($ausgang == null) {
                return redirect("crm/packtisch/historie");
            }
        $db_trackings = tracking_history::all();

        return [$ausgang, $trackings, $db_trackings];
        }
    }

    public function refreshShippingStatus(Request $req) {

        $db_trackings = tracking_history::all();

        foreach($db_trackings as $tracking) {

            if($tracking->status != "Stornierte Info erhalten " && $tracking->status != "") {
                $check = tracking_history::where("label", $tracking->label)->latest()->first();

                $ups = new UPS();
                $ups_trackings = $ups->getTracking($tracking->label);

                if(isset($ups_trackings[0]->status->description)) {
                    if($ups_trackings[0]->status->description != $check->status) {
                        $db = new tracking_history();
                    $db->process_id = $check->process_id;
                    $db->label = $check->label;
                    $db->status = $ups_trackings[0]->status->description;
                    $db->date = $check->date;
                    $db->save();
                    
                }
                }
            }
        }

        $shippings = warenausgang_history::all();

        foreach($shippings as $shipping) {

            $tracking = tracking_history::where("label", $shipping->label)->latest()->first();

            if($tracking != null) {
                $shippings->where("label", $shipping->label)->first()->status = $tracking->status;
            }

        }

        return $shippings;
        
    }

    public function warenausgangLabelLöschen(Request $req, $id) {

        $headers = array();
        $headers[] = "Authorization: Bearer ". $this->Auth()->access_token;
        $headers[] = 'Accept: application/json';
        $headers[] = "grant_type=client_credentials";
        $headers[] = "x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';

        $ch = curl_init('https://onlinetools.ups.com/api/shipments/v1/void/cancel/'. $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);

        $ausgang = warenausgang_history::where("label", $id)->get();

        $process_ids = array();
        foreach($ausgang as $as) {

            if(!in_array($as->process_id, $process_ids)) {
                $this->packtischStatusÄndern($req, "packtisch", 520, $as->process_id, $as->component_number);
                array_push($process_ids, $as->process_id);
                $db = new tracking_history();
                $db->process_id = $as->process_id;
                $db->label = $as->label;
                $db->status = "Stornierte Info erhalten ";
                $db->date = date("Ymd");
                $db->save();
            }
        }

        return $this->packtischHistorieAllTracking($req, $id);

    }

    public function lagerplatzÜbersicht(Request $req) {

        $shelfes            = shelfe::all();
        $shelfes_archive    =  shelfes_archive::all();
        $devices            = device_orders::all();
        $statuses           = statuse::all();
        $extendtime = entsorgung_extendtime::all();
        $contacts = contact::all();
        $countries = countrie::all();
        $usedShelfes = used_shelfes::with("entsorgung")->get();
        $statushistory = status_histori::all();

        return view("forEmployees/packtisch/lagerplatzübersicht")->with("statushistory", $statushistory)->with("allShelfes", $shelfes)->with("usedShelfes", $usedShelfes)->with("contacts", $contacts)->with("countries", $countries)->with("extendtime", $extendtime)->with("shelfes", $shelfes)->with("shelfes_archive", $shelfes_archive)->with("devices", $devices)->with("statuses", $statuses);

    }

    public function warenausgangSperren(Request $req) {

        $user = User::where("id", auth()->user()->id)->first();
        $user->warenausgangsperre = "true";
        $user->save();

        $überwachung = new überwachung();
        $überwachung->employee = auth()->user()->id;
        $überwachung->type = "Packtisch";
        $überwachung->text = "Der Nutzer hat den Warenausgang gesperrt";
        $überwachung->save();

        $ausgänge = warenausgang::all();
        foreach($ausgänge as $as) {
            $as->sperre_von = auth()->user()->id;
            $as->save();
        }


        return redirect()->back();
    }

    public function warenausgangEntsperren(Request $req) {

        $user = User::where("id", auth()->user()->id)->first();
        $user->warenausgangsperre = "false";
        $user->save();

        $ausgänge = warenausgang::all();
        foreach($ausgänge as $as) {
            $as->sperre_von = null;
            $as->save();
        }


        return redirect()->back();
    }

    public function packtischProblemMelden(Request $req, $id, $device) {
        
        $text = $req->input("text");

        $problem = new packtisch_problem();
        $problem->process_id = $id;
        $problem->text = $text;
        $problem->save();

        $status = statuse::where("id", "193")->first();


        $stat = new status_histori();
        $stat->process_id = $id;
        $stat->last_status = $status->id;
        $stat->changed_employee = auth()->user()->id;
        $stat->save();

        $phone = new phone_history();
        $phone->process_id = $id;
        $phone->lead_name = "";
        $phone->employee = auth()->user()->id;
        $phone->status = $status->name;
        $phone->message = $text;
        
        $phone->save();

        return $this->packtischView($req, ["Erfolg", "Erfolgreich gemeldet", "Die Bearbeitung des Auftrages $id wurde erfolgreich übermittelt. Bitte auf Rückmeldung warten"]);
    }

    public function inventurBeauftragen(Request $req) {

        $intern = new intern();
        $intern->process_id = "Globaler Auftrag";
        $intern->component_id = "";
        $intern->component_type = "";
        $intern->component_number = "";
        $intern->auftrag_id = "Inventur";
        $intern->save();

        return redirect()->back()->withErrors(["inventur-beauftragt"]);
        

    }

    public function inventurView(Request $req) {
        $shelfes            = shelfe::all();
        $devices            = device_orders::all();
        
        return view("forEmployees/packtisch/inventur")->with("shelfes", $shelfes)->with("devices", $devices);
    }

    public function inventurAbschließen(Request $req) {


        foreach($req->except("_token") as $key => $item) {
            $parts = explode(":", $item);
            $shelfe     = shelfe::where("shelfe_id", $parts[1])->first();
            $device     = device_orders::where("component_number", $parts[0])->first();
            $oldshelfe      = shelfe::where("component_number", $parts[1])->first();
            if($device != null && $shelfe != null && $shelfe->shelfe_id == $parts[1] && $shelfe->component_number == $parts[0]) {
                $process_parts              = explode("-", $parts[0]);

                $gerät          = device_orders::where("component_number", $parts[0])->where("component_id", $process_parts[1])->first();
                $gerät->status  = "OK, richtig!";
                $gerät->update();
                DB::table('shelfes')
                ->where('shelfe_id', $parts[1])
                ->update(["status" => "OK, richtig!", "should_shelfe_id" => $parts[1], "should_device_number" => $parts[0]]);
            } else  if($device == null && $shelfe->component_number == $parts[0]) {
                if(strlen($parts[0]) != 4) {
                    $process_parts              = explode("-", $parts[0]);
                    $person                     = active_orders_person_data::where("process_id", $process_parts[0])->first();
                    if($person != null) {
                        $newdevice                      = new device_orders();
                        $newdevice->process_id          = $process_parts[0];
                        $newdevice->component_id        = $process_parts[1];
                        $newdevice->component_type      = $process_parts[2];
                        $newdevice->component_count     = $process_parts[3];
                        $newdevice->component_number    = $parts[0];
                        $newdevice->save();
                        DB::table('shelfes')
                        ->where('shelfe_id', $parts[1])
                        ->update(["status" => "Autokorrektur, Gerät hinzugefügt", "should_shelfe_id" => $parts[1], "should_device_number" => $parts[0]]);
                    } else {
                        DB::table('shelfes')
                        ->where('shelfe_id', $parts[1])
                        ->update(["status" => "Manuell: Fehler, Gerät nicht im Lager und System", "should_shelfe_id" => $parts[1], "should_device_number" => $parts[0]]);
                    }
                } else {
                    
                    DB::table('shelfes')
                    ->where('shelfe_id', $parts[1])
                    ->update(["status" => "Manuell: Zuweisen, Gerät nicht im System", "should_shelfe_id" => $parts[1], "should_device_number" => $parts[0]]);
                }

            } else if($device != null && $shelfe->component_number != $parts[0] && $oldshelfe != null) {

                DB::table('shelfes')
                ->where('shelfe_id', $oldshelfe->shelfe_id)
                ->update(['process_id' => "0", 'component_id' => "0", 'component_number' => "0"]);  

                

                DB::table('shelfes')
                ->where('shelfe_id', $parts[1])
                ->update(["status" => "Autokorrektur, Lagerplatz", "should_shelfe_id" => $parts[1], "should_device_number" => $parts[0]]);
            } else  if($oldshelfe == null && $device != null) {
                $process_parts              = explode("-", $parts[0]);

                DB::table('shelfes')
                ->where('shelfe_id', $parts[1])
                ->update(["status" => "Manuell: Fehler, Gerät nicht im Lager", "should_shelfe_id" => $parts[1], "should_device_number" => $parts[0]]);

                $gerät          = device_orders::where("component_number", $parts[0])->where("component_id", $process_parts[1])->first();
                $gerät->status  = "Manuell: Fehler, Gerät nicht im Lager";
                $gerät->update();
            } else if($device == null && $oldshelfe == null) {
                DB::table('shelfes')
                ->where('shelfe_id', $parts[1])
                ->update(["status" => "Manuell: Zuweisen, Gerät nicht im System", "should_shelfe_id" => $parts[1], "should_device_number" => $parts[0]]);
            }

            $this->packtischStatusÄndern($req, "packtisch", 689, $device->process_id, $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count);

            

            #MUSS NOCH AUSGEBAUT WERDEN OKE
           
            

           
            

        }

    }

    public function lagerplatzBearbeiten_nichtImLager(Request $req, $id) {

        $device     = device_orders::where("component_number", $id)->first();
        $shelfe     = shelfe::where("component_number", $id)->first();
        $shelfes    = shelfe::all();

        return view("forEmployees/packtisch/lagerplatz-bearbeiten_nichtImLager")->with("device", $device)->with("shelfe", $shelfe)->with("shelfes", $shelfes);
    }

    public function einlagerungsAuftragView(Request $req, $id) {

        $intern = intern::where("component_number", $id)->first();
        
        return view("forEmployees/packtisch/einlagerungsauftrag")->with("intern", $intern);
    }

    public function umlagerungsauftragArchiveView(Request $req, $id) {
        
        $process_id     = explode("-", $id)[0];
        $shelfe         = shelfe::where("component_number", $id)->first();
        return view("forEmployees/packtisch/umlagerungsauftrag-archive")->with("id", $id)->with("process_id", $process_id)->with("shelfe", $shelfe);
    }

    public function umlagerungsauftragArchive(Request $req, $id) {
        $shelfe     = $req->input("shelfe");
        $parts      = explode("-", $id);
        $shelfe     = shelfes_archive::where("shelfe_id", $shelfe)->first();
        if($shelfe != null) {
            DB::table('shelfes')
            ->where('component_number', $id)
            ->update(['process_id' => "0", 'component_id' =>"0", 'component_number' => "0"]);

            DB::table('shelfes_archive')
            ->where('shelfe_id', $req->input("shelfe"))
            ->update(['process_id' => $parts[0], 'component_id' => $parts[1], 'component_number' => $id]);

            $intern                 = intern::where("component_number", $id)->first();
            $intern_history         = new intern_history();
            $intern_history->process_id         = $parts[0];
            $intern_history->component_id       = $parts[1];
            $intern_history->component_type     = $parts[2];
            $intern_history->component_count    = $parts[3];
            $intern_history->employee           = auth()->user()->id;
            $intern_history->component_number   = $id;
            if($intern->auftrag_id != null) {
                $intern_history->auftrag_id         = $intern->auftrag_id;
            }
            if($intern->auftrag_info != null) {
                $intern_history->auftrag_info       = $intern->auftrag_info;
            }
            $intern_history->save();
            $intern->delete();
            return redirect("/crm/packtisch");
        } else {
            return redirect()->back()->withErrors(["Der gewünschte Lagerplatz existiert nicht"]);
        }
    }

    public function beschriftungsauftragView(Request $req, $id) {
        $intern         = intern::where("component_number", $id)->first();
        $shelfe         = shelfe::where("component_number", $intern->component_number)->first();
        return view("forEmployees/packtisch/beschriftungsauftrag")->with("intern", $intern)->with("shelfe", $shelfe);
    }

    public function beschriftungsauftragErledigt(Request $req, $id) {

        $intern         = intern::where("component_number", $id)->first();

        $this->packtischStatusÄndern($req, "packtisch", 861, $intern->process_id, $intern->process_id . "-" . $intern->component_id . "-" . $intern->component_type . "-" . $intern->component_count);
        
        $parts = explode("-", $intern->helpercode);

        $first_device = device_orders::where("process_id", $parts[0])->first();
       
        $device_order                   = new device_orders();
        $device_order->process_id       = $parts[0];
        $device_order->component_id     = $parts[1];
        $device_order->component_type   = $parts[2];
        $device_order->component_count  = $parts[3];
        $device_order->component_number = $intern->helpercode;
        if($first_device == null) {
            $device_order->primary_device = "true";
        }
        
        dd($device_order);
        $device_order->save();

        $shelfe = used_shelfes::where("component_number", $intern->component_number)->first();
        if($shelfe != null) {
            $shelfe->component_number = $intern->helpercode;
            $shelfe->save();
        }

        $device = device_orders::where("component_number", $intern->component_number)->first();
        $device->delete();

        $his                    = new intern_history();
        $his->process_id        = $intern->process_id;
        $his->component_id      = $intern->component_id;
        $his->component_type    = $intern->component_type;
        $his->component_count   = $intern->component_count;
        $his->component_number  = $id;
        $his->employee          = auth()->user()->id;
        $his->auftrag_id        = $intern->auftrag_id;
        $his->shelfeid          = $shelfe->shelfe_id;
        $his->auftrag_info      = $intern->info;
        $his->save();
        $intern->delete();


        return redirect("/crm/packtisch");
    }

    public function lagerplatzBearbeiten(Request $req, $id) {

        $shelfe     = shelfe::where("component_number", $id)->first();
        $shelfes    = shelfe::where("process_id", "0")->get();
        $extendtime = entsorgung_extendtime::where("component_number", $id)->first();
        return view("forEmployees/packtisch/lagerplatz")->with("shelfe", $shelfe)->with("shelfes", $shelfes)->with("extendtime", $extendtime);
    }

    public function entsorgungBeauftragen(Request $req) {
        $devices        = device_orders::where("component_type", "ORG")->get();
        $shelfes        = shelfe::all();

        $devicelist     = array();
        foreach($devices as $device) {
                
            $shelfe = used_shelfes::where("component_number", $device->component_number)->with("entsorgung")->first();
            if($shelfe != null) {

                $createDate = $shelfe->created_at;
                $nowDate = new DateTime();

                if($shelfe->entsorgung != null) {
                    if(2 - $createDate->diff($nowDate)->d + $shelfe->entsorgung->days <= 0) {
                        array_push($devicelist, $device);
                    }
                } else {
                    if(90 - $createDate->diff($nowDate)->d <= 0) {
                        array_push($devicelist, $device);
                    }
                }
            }
           
        }


        $phones = phone_history::where("status", "Entsorgung")->get();
        foreach($phones as $phone) {
            $device = explode(" ", $phone->message)[1];
            $shelfe = used_shelfes::where("component_number", $device)->first();
            
            if($shelfe != null) {

                $device = device_orders::where("component_number", $device)->first();

                if(!in_array($device, $devicelist)) {
                    array_push($devicelist, $device);
                }
            }
        }

        foreach($devicelist as $dev) {

            $warenausgang = warenausgang::where("component_number", $dev->component_number)->first();
            if($warenausgang == null) {
                $ausgang                    = new warenausgang();
                $ausgang->process_id        = $dev->process_id;
                $ausgang->component_id      = $dev->component_id;
                $ausgang->component_number  = $dev->process_id. "-". $dev->component_id. "-". $dev->component_type. "-". $dev->component_count;
                $ausgang->component_count   = $dev->component_count;
                $ausgang->component_type    = $dev->component_type;
                $ausgang->ex_space          = "Entsorgung";
                $ausgang->companyname       = $req->input("companyname");
                $ausgang->firstname         = $req->input("firstname");
                $ausgang->lastname          = $req->input("lastname");
                $ausgang->street            = $req->input("street");
                $ausgang->streetno          = $req->input("streetno");
                $ausgang->zipcode           = $req->input("zipcode");
                $ausgang->city              = $req->input("city");
                $ausgang->country           = $req->input("country");
                $ausgang->mobilnumber       = $req->input("mobilnumber");
                $ausgang->info              = $req->input("extcomment");
                $ausgang->amount            = "0,00";
                $ausgang->length            = "20";
                $ausgang->width             = "20";
                $ausgang->height            = "30";
                $ausgang->weight            = $req->input("weight");
                $ausgang->email             = $req->input("email");
                $ausgang->carriers_service  = $req->input("shippingtype");
                $ausgang->shipping_type     = $req->input("shippingtype");
                $ausgang->save();
            
            }
        }
        
        if(empty($devicelist)) {
            return redirect()->back()->withErrors(["Es stehen keine Geräte auf der Entsorgungliste"]);
        } else {
            return redirect()->back()->withErrors(["entsorgung-beauftragt"]);
        }
    }

    public function entsorgungsauftragView(Request $req) {
        $devices        = device_orders::where("component_type", "ORG")->get();
        $archives = archive_orders_person::all();
        $shelfes        = shelfe::all();

        $devicelist     = array();
        foreach($devices as $device) {
           foreach ($archives as $arc) {
            if($arc->process_id == $device->process_id) {
                $extendtime = entsorgung_extendtime::where("component_number", $device->component_number)->first();
                if($extendtime != null) {
                    $seconddate         = date($device->created_at->format("Y-m-d"), strtotime('+'. $extendtime->days .' days', time()));
                } else {
                    $seconddate         = date($device->created_at->format("Y-m-d"), strtotime('+90 days', time()));
                }
                $sd     = date_create($seconddate);
                $firstdate          = date("Y-m-d");
                $fd = date_create($firstdate);
                $diff = date_diff($fd, $sd);
                if($diff->d >= 1) {
                    array_push($devicelist, $device);
                }
            }
           }
        }
        return view("forEmployees/packtisch/entsorgungsauftrag")->with("devices", $devicelist)->with("shelfes", $shelfes);
    }

    public function entsorgungAbschließen(Request $req) {
        $devices        = device_orders::where("component_type", "ORG")->get();

        foreach($devices as $device) {
            $datetime_1 = new DateTime($device->created_at);
            $datetime_2 = date("d.m.Y"); 

            $start_datetime = $datetime_1->modify("+90 days"); 
            $diff = $start_datetime->diff(new DateTime()); 

            if($diff->d >= 0 && $diff->m >= 0) {
                DB::table('shelfes')
                    ->where('component_number', $device->process_id."-".$device->component_id."-".$device->component_type."-".$device->component_count)
                    ->update(['process_id' => "0", 'component_id' =>"0", 'component_number' => "0"]);
                
                DB::table('shelfes_archive')
                    ->where('process_id', "0")
                    ->update(['process_id' => $device->process_id, 'component_id' => $device->component_id, 'component_number' => $device->process_id."-".$device->component_id."-".$device->component_type."-".$device->component_count]);
    
            }
        }

        
        
        $intern         = intern::where("auftrag_id", "Entsorgungsauftrag")->first();
        $intern->delete();
        
    }

    public function sendHelperCode(Request $req, $id) {
        $code       = helpercode::where("helper_code", $id)->first();
        $countries  = countrie::all();

        return view("forEmployees/packtisch/hilfscode-versenden")->with("barcode", $code)->with("countries", $countries);
    }

    public function helpercodeToPacktisch(Request $req, $id) {
        $proc_id = $id;
        foreach($req->all() as $key => $value) {
            $$key       = $value;
        }
            $dev                             = helpercode::where("helper_code", $id)->first();           
            $tec        = contact::where("street", $street)->first();
            if($dev != null) {
                $order                      = new warenausgang();

                $order->carriers_service    = $carriers_service;
                $order->companyname         = $companyname;
                if($tec != null) {
                    $order->shortcut            = $tec->shortcut;
                }
                $order->firstname           = $firstname;
                $order->lastname            = $lastname;
                $order->street              = $street;
                $order->streetno            = $streetno;
                $order->zipcode             = $zipcode;
                $order->city                = $city;
                $order->country             = $home_country;
                $order->email               = $email;
                $order->mobilnumber         = $mobilnumber;
                $order->phonenumber         = $phonenumber;
                $order->amount              = $amount;
                $order->length              = $length;
                $order->weight              = $weight;
                $order->height              = $height;
                $order->width               = $width;
                $order->ex_space            = "Direkt Versand";
                $order->shipping_type       = $type;
                $order->payment_type        = $payment_type;
                $order->process_id          = $proc_id;
                $order->component_id        = $id;
                $order->component_type      = $id;
                $order->component_count     = $id;
                $order->component_number    = $id;
                if(!isset($gummi)) {
                    $gummi = "";
                }
                $order->gummi               = $gummi;
                if(!isset($spannungsschutz)) {
                    $ean = "";
                    $order->protection          = $ean;
                } else {
                    $order->protection          = $spannungsschutz;
                }
                if(!isset($vp_si)) {
                    $vp_si = "";
                    $order->seal                = $vp_si;
                } else {
                    $order->seal                = $vp_si;
                }
                
                $order->bpz1                = $kfile1;
                if($kfile2 == "0" && $device != null) {
                    $file2                  = $files->Datei_2;
                }
                $order->bpz2                = $kfile2;
                
            
                $order->save();
            }
        
            return redirect()->back();

    }

    public function externVersandSelectDevice(Request $req, $device, $id, $selectedDevices = null, $contact = null) {
        $persons    = new_leads_person_data::all();
        $persons    = $persons->merge(active_orders_person_data::all());
        $countries  = countrie::all();
        $contacts   = contact::all();
        $device     = device_orders::where("component_number", $device)->first();
        $selectedDevices = explode("!", $selectedDevices);
        array_push($selectedDevices, $device->process_id . "-". $device->component_id. "-". $device->component_type . "-". $device->component_count);
        $devices = device_orders::where("process_id", $device->process_id)->get();
        if($contact != null) {
            $versandContact = contact::where("id", $contact)->first();
            return view("forEmployees/packtisch/versenden")->with("devices", $devices)->with("selectedDevices", $selectedDevices)->with("persons", $persons)->with("countries", $countries)->with("contacts", $contacts)->with("versandContact", $versandContact);
        } else {
            return view("forEmployees/packtisch/versenden")->with("devices", $devices)->with("selectedDevices", $selectedDevices)->with("persons", $persons)->with("countries", $countries)->with("contacts", $contacts)->with("selectedDevices", $selectedDevices);

        }

  
    }

    public function getContactExternVersand(Request $req, $id, $devices = null, $selectedDevices = null) {

        $persons    = new_leads_person_data::all();
        $persons    = $persons->merge(active_orders_person_data::all());
        $countries  = countrie::all();
        $contacts   = contact::all();
        $versandContact = contact::where("id", $id)->first();
        $getDev = $devices;
        if($devices != null) {
            $devices = device_orders::where("process_id", $devices)->get();
        } 

        if($getDev != null) {
            $selectedDevices = $getDev;
            $testDevices = explode("!", str_replace(" ", "", $getDev));
            $testDevice = device_orders::where("process_id", explode("-",  $testDevices[0])[0])->first();
        }
        if(isset($testDevice))      {
            if($testDevice != null) {
                $devices = device_orders::where("process_id", $testDevice->process_id)->get();
            }   
        }

        if($selectedDevices != null) {
            $selectedDevices = explode("!", str_replace(" ", "", $selectedDevices));
        }

        return view("forEmployees/packtisch/versenden")->with("selectedDevices", $selectedDevices)->with("devices", $devices)->with("persons", $persons)->with("countries", $countries)->with("contacts", $contacts)->with("versandContact", $versandContact);
    }

    public function versendenView(Request $req) {

        $persons    = new_leads_person_data::all();
        $persons    = $persons->merge(active_orders_person_data::all());
        $countries  = countrie::all();
        $contacts   = contact::all();
        $bpzs       = attachment::all();
        $ausgang    = warenausgang_history::where("ex_space", "Extern")->get();
        $ausgang    = $ausgang->merge(warenausgang::where("ex_space", "Extern")->get());

        return view("forEmployees/packtisch/versenden")->with("persons", $persons)->with("countries", $countries)->with("contacts", $contacts)->with("bpzs", $bpzs)->with("ausgang", $ausgang);
    }


    public function warenausgangZurück(Request $req, $id) {

        $ausgänge       = warenausgang_history::where("label", $id)->get();
        $einlagerungid  = uniqid();
        
        foreach($ausgänge as $his){

            $ausgang = warenausgang::where("component_number", $his->component_number)->first();
            if($ausgang == null) {

                $ausgang                        = new warenausgang();
                $ausgang->gummi                 = $his->gummi;
                $ausgang->protection            = $his->protection;
                $ausgang->seal                  = $his->seal;
                $ausgang->bpz1                  = $his->bpz1 ;
                $ausgang->bpz2                  = $his->bpz2;
                $ausgang->shipping_type         = $his->shipping_type;
                $ausgang->payment_type          = $his->payment_type;
                $ausgang->carriers_service      = $his->carriers_service;
                $ausgang->companyname           = $his->companyname;
                $ausgang->shortcut              = $his->shortcut;
                $ausgang->firstname             = $his->firstname;
                $ausgang->lastname              = $his->lastname;
                $ausgang->street                = $his->street;
                $ausgang->streetno              = $his->streetno;
                $ausgang->zipcode               = $his->zipcode;
                $ausgang->city                  = $his->city ;
                $ausgang->country               = $his->country;
                $ausgang->email                 = $his->email;
                $ausgang->mobilnumber           = $his->mobilnumber;
                $ausgang->phonenumber           = $his->phonenumber;
                $ausgang->amount                = $his->amount      ;
                $ausgang->length                = $his->length;
                $ausgang->weight                = $his->weight;
                $ausgang->height                = $his->height;
                $ausgang->width                 = $his->width   ;
                $ausgang->ex_space              = $his->ex_space;
                $ausgang->process_id            = $his->process_id;
                $ausgang->component_id          = $his->component_id;
                $ausgang->component_type        = $his->component_type;
                $ausgang->component_count       = $his->component_count;
                $ausgang->component_number      = $his->component_number;
                $ausgang->einlagerungid         = $einlagerungid;
                $ausgang->fotoauftrag           = $his->fotoauftrag;
                $ausgang->file_id               = $his->file_id;
                $ausgang->info                  = $his->info;
                $ausgang->save();

                $intern                     = new intern();
                $intern->process_id         = $his->process_id;
                $intern->component_type     = $his->component_type;
                $intern->component_count    = $his->component_count;
                $intern->component_number   = $his->component_number;
                $intern->component_id       = $his->component_id;
                $intern->info               = "Bitte den Auftrag Priorisieren. Erst nach dem Einlagerungsauftrag wird der Versandauftrag erstellt!, Packet mit Sendungsnummer: $his->label";
                $intern->auftrag_id         = "Einlagerungsauftrag";
                $intern->einlagerungid      = $his->einlagerungid;
                $intern->save();
                
                $ship = inshipping::where("component_number", $his->component_number)->first();
            
                if($ship != null) {
                    $this->packtischStatusÄndern($req, "packtisch", 581, $his->process_id, $his->component_number, null, $his->bpz1, $his->bpz2, $ship->label);
    
                    $this->warenausgangLabelLöschen($req, $his->label);
    
                    $ship->delete();
                } else {
                    $this->packtischStatusÄndern($req, "packtisch", 581, $his->process_id, $his->component_number, null, $his->bpz1, $his->bpz2,null);
                }
            }

       }
       return $this->packtischHistorieAllTracking($req, $id);
    }

    public function transportschadenView(Request $req, $id, $comp) {
        $parts      =   explode('-', $id);
        $shelfe     =   shelfe::where("process_id", "0")->first();
        return view('forEmployees/packtisch/transportschaden')->with("id", $id)->with('process_id', $parts[0])->with('comp', $comp)->with("shelfe", $shelfe);
    }

    public function transportschadenBeauftragen(Request $req) {

        $barcode        = $req->input("barcode");
        $shelfe         = $req->input("shelfe");
        $broken_report  = $req->input("broken-report");

        $parts          = explode("-", $barcode);
        $order          = active_orders_person_data::where("process_id", $parts[0])->first();
        $order->transportschaden = "yes";
        $order->update();

        $device     = device_orders::where("component_number", $barcode)->first();

        if($device == null) {
            $device_order                   = new device_orders();
            $device_order->process_id       = $parts[0];
            $device_order->component_id     = $parts[1];
            $device_order->component_type   = $parts[2];
            $device_order->component_count  = $parts[3];
            $device_order->component_number = $barcode;
            $device_order->transportschaden = "yes";
            $device_order->save();
    
            if($order == null) {
                $this->moveto_orders($req, $parts[0]);
            }
        }

        $wareneingang                   = new wareneingang();
        $wareneingang->process_id       = $parts[0];
        $wareneingang->component_id     = $parts[1];
        $wareneingang->component_type   = $parts[2];
        $wareneingang->component_number = $barcode;
        $wareneingang->component_count  = $parts[3];
        
        $wareneingang->save();

        $transportschaden       = new transportschaden();
        $transportschaden->component_number     = $barcode;
        $transportschaden->process_id     = $parts[0];
        $transportschaden->borken_report        = $broken_report;
        $transportschaden->employee             = $req->session()->get("username");
        $transportschaden->save();

        $order          = active_orders_person_data::where("process_id", $parts[0])->first();

        if($order  != null) {
            $order = true;
        } else {
            $order = false;
        }

        $this->changeStatus($req, "5", $parts[0], $req->session()->get("username"), $order);
-        
        DB::table('shelfes')
        ->where('shelfe_id', $shelfe)
        ->update(['process_id' => $parts[0], 'component_id' => $parts[1], 'component_number' => $barcode]);

        $message                = "Das Gerät <span class='text-green-600'>". $barcode . "</span> hat einen Transportschaden, Bitte Auftrag <a href='". url("/") ."/crm/transportschaden/". $barcode ."' style='color: blue;' class='underline'>". $parts[0] ."</a> anschauen";
        $widgetmessage          = "Das Gerät ". $barcode . " hat einen Transportschaden, Bitte Auftrag ". $parts[0] ." anschauen";

        $broadcast              = new ControllersBroadcast();
        $broadcast->channel     = "packtisch";
        $broadcast->event       = "transportschaden";
        $broadcast->data        = array("widgetmessage"=> $widgetmessage, "title" => "Transportschaden!","device" => $barcode, "shelfe" => $shelfe, "process_id" => $parts[0], "username" => $req->session()->get("username"), "message" => $message);
        $broadcast->push();

    }

    public function transportschadenBearbeitenView(Request $req, $id) {

        $transportschaden       = transportschaden::where("component_number", $id)->first();
        $shelfe                 = shelfe::where("component_number", $id)->first();
        if($transportschaden != null) {

            return view("forEmployees/packtisch/transportschadenBearbeiten")->with("transportschaden", $transportschaden)->with("shelfe", $shelfe);

        } else {
            return redirect()->back()->withErrors(["Der Transportschaden wurde bereits bearbeitet"]);
        }

    }

    public function tagesabschlussAbschließen(Request $req) {
        $seconddate         = date("Y-m-d h:m:s", strtotime('+24 hours', time()));
        $firstdate          = date('Y-m-d h:m:s', strtotime('-24 hours', time()));
        
        
        foreach($req->except("_token") as $key => $item) {
            if($item != null) {
                $abschluss      = new tagesabschluss();
                $abschluss->employee    = auth()->user()->id;
                $abschluss->item        = $key;
                $abschluss->count       = $item;
                $abschluss->skipped     = "no";
                $abschluss->save();
            }
        }

        DB::table('tagesabschluss')
        ->where('item', "skip")
        ->delete();

        $ausgang          = warenausgang_history::whereBetween('created_at', [$firstdate , $seconddate])->get();

        foreach($ausgang as $as) {
            $tec    = warenausgang_history::whereBetween('created_at', [$firstdate , $seconddate])->where("shortcut", $as->shortcut)->get();
            $labels = array();
            foreach($tec as $t) {
                if(in_array($t->label, $labels)) {
                    array_push($labels, $t->label);
                    
                } 
            }
        
        }
        if($labels != null) { 
            if($labels->count() > 1) {
                $email = email_template::where("id", 108)->first();

                Mail::to("test@steubel.de")->send(new technikerlabel($labels, $tec, $email));
    
            }
        }else {
            $email = email_template::where("id", 108)->first();

            Mail::to("test@steubel.de")->send(new technikerlabel($labels, $tec, $email));

        }
        

        return view("includes.tagesabschluss-packete")->with("ausgang", $ausgang);
        

    }

    public function lagerbestandtView(Request $req) {

        $latestitem         = tagesabschluss::latest()->first();
        $items              = tagesabschluss::where("created_at", $latestitem->created_at)->get();
        $skipped            = tagesabschluss::where("skipped", "yes")->get();
        
        return view("forEmployees/packtisch/lagerbestandt")->with("items", $items)->with("skipped", $skipped);

    }

    public function lagerbestandtBestellen(Request $req, $item) {

        switch ($item) {
            case 'Packetbänder':
                return redirect()->away('https://www.amazon.de');
                break;
            case 'S-Kartoons':
                return redirect()->away('https://www.amazon.de');
                break;
            case 'M-Kartoons':
                return redirect()->away('https://www.amazon.de');
                break;
            case 'XL-Kartoons':
                return redirect()->away('https://www.amazon.de');
                break; 
            default:
                return redirect()->away('https://www.amazon.de');
                break;
        }

    }

    public function skipMaterialinventur(Request $req) {

        $skipped        = tagesabschluss::where("skipped", "yes")->get();
        if($skipped->isEmpty()) {
            $skip       = new tagesabschluss();
            $skip->employee    = auth()->user()->id;
            $skip->item         = "skip";
            $skip->count        = "1";
            $skip->skipped      = "yes";
            $skip->save();
            
            $req->session()->flush();

            return redirect("/employee/login");
        } else if($skipped->count() < 7) {
            $skip       = new tagesabschluss();
            $skip->employee     = auth()->user()->id;
            $skip->item         = "skip";
            $skip->count        = "1";
            $skip->skipped      = "yes";
            $skip->save();
            

            return redirect("/crm/packtisch");
        } else if($skipped->count() >= 7) {
            return redirect()->back()->withErrors(["Du kannst nicht Überspringen! Heute bitte alles Abscannen!"]);
        }
        
    }

    public function technikerVersandLabelCheck(Request $req, $id) {
        
        $ausgang        = warenausgang::where("component_number", $id)->first();

       
       try {
        $all    = warenausgang_history::where("process_id", $ausgang->process_id)->get();

        $labels = array();
        foreach ($all as $as) {
            if(!in_array($as->label, $labels)) {
                array_push($labels, $as->label);
            }
        }
        if(count($labels) >= 1) {
            return "np";
        } else {
            return "ok";
        }
       } catch (\Throwable $th) {
            return $th;
       }
    }


    public function getFreiUmlagernView(Request $req) {

        return view("forEmployees/packtisch/freiUmlagern");

    }

    public function freiUmlagern(Request $req) {

    }

    public function freiesUmlagernAbschliessen(Request $req) {
        $barcode        = $req->input("device");
        $shelfe         = $req->input("shelfe");

        $device = device_orders::where("component_number", $barcode)->first();
        $shelfe = shelfe::where("shelfe_id", $shelfe)->first();

        if($device != null && $shelfe != null) {
            $old_shelfe     = used_shelfes::where("component_number", $barcode)->first();
            
            if($old_shelfe != null) {

                $old_shelfe->delete();

                $new_shelfe = new used_shelfes();
                $new_shelfe->shelfe_id = $req->input("shelfe");
                $new_shelfe->component_number = $barcode;
                $new_shelfe->save();

            } else {
                return redirect()->back()->withErrors(["Geärt wurde nicht im Lager gefunden"]);
            }
              
            return redirect("crm/packtisch");
        } else {
            return redirect()->back()->withErrors(["Geärt oder Lager konnte nicht gefunden werden"]);
        }
    }

    public function refreshWarenausgangFotoauftrag(Request $req, $id) {
;
        $ausgang        = warenausgang::where("process_id", $id)->with("shelfe")->get();
        $attch          = attachment::all();
        $files          = array();
        foreach($ausgang as $aus) {
            if($aus->upload_file != null) {
                if(file_exists("files/warenausgang/". $aus->process_id . "/". $aus->upload_file)) {
                    array_push($files, $aus->upload_file);
                }
            }
            
        }
        return view("forEmployees/packtisch/ausgang-kunde")->with("warenausgang", $ausgang)->with("id", $id)->with("attach", $attch)->with("files", $files);

    }
    
    public function packtischStatusÄndern($req, $area , $status, $process_id, $gerät, $old_shelfe = null, $bpz1 = null, $bpz2 = null, $label = null, $opend = null, $sticker = null) {

        
    }

    public function checkDeviceShelfe(Request $req, $id) {

        $shelfe = shelfe::where("component_number", $id)->first();
        if($shelfe != null) {
            return $shelfe->shelfe_id;
        } else {
            return "not found";
        }

    }

    public function getAbholauftragView(Request $req) {

        $countries  = countrie::all();
        $contacts   = contact::all();
        $pickups    = pickup::all();
        $statuses   = statuse::all();
        $users      = User::all();

        return view("forEmployees/administration/abholauftrag")
                    ->with("contacts", $contacts)
                    ->with("countries", $countries)
                    ->with("pickups", $pickups)
                    ->with("users", $users)
                    ->with("statuses", $statuses);
        
    }

    public function getAbholauftragAuftrag(Request $req, $id) {
        $countries = countrie::all();
        $contacts = contact::all();
        $pickups  = pickup::all();
        $statuses = statuse::all();
        $pickup = pickup::where("id", $id)->first();
        $users = user::all();

        return view("forEmployees/administration/abholauftrag")->with("users", $users)->with("pickup", $pickup)->with("contacts", $contacts)->with("countries", $countries)->with("pickups", $pickups)->with("statuses", $statuses);
        
    }

    public function getAbholauftragAdressbuch(Request $req, $id) {

        $pickupContact = contact::where("id", $id)->first();
        $contacts = contact::all();
        $countries = countrie::all();
        $pickups  = pickup::all();
        $statuses = statuse::all();

        if($pickupContact != null) {
            return view("forEmployees/administration/abholauftrag")->with("statuses", $statuses)->with("contacts", $contacts)->with("pickupContact", $pickupContact)->with("countries", $countries)->with("pickups", $pickups);
        } else {
            return redirect()->back()->withErrors(["Der Kontakt konnte nicht gefunden werden"]);
        }
    }

    public function redoAbholungView(Request $req, $id) {
        $countries = countrie::all();
        $contacts = contact::all();
        $pickups  = pickup::all();
        $statuses = statuse::all();
        $pickup = pickup::where("id", $id)->first();
        $contact = contact::where("lastname", $pickup->lastname)->first();

        return view("forEmployees/administration/abholauftrag")->with("pickupContact", $contact)->with("contacts", $contacts)->with("countries", $countries)->with("pickups", $pickups)->with("statuses", $statuses);
        
    }
    

    public function postAbholungBeauftragen(Request $req) {
       
        $country = countrie::where("name", $req->input("country"))->first();
        if($country == null) {
            $country = countrie::where("id", $req->input("country"))->first();
        }
        $dateparts  = explode("-", $req->input("pickupDate"));
        
        $pickupDate = $dateparts[0]  . $dateparts[1] . $dateparts[2];
        $date = $dateparts[2] . "." . $dateparts[1] . "." . $dateparts[0];

        if($req->input("phoneNumber") != null) {
            $telefoneNumber = $req->input("phoneNumber");
        } else {
            $telefoneNumber = $req->input("mobilNumber");
        }


        $vonmin = explode(":", $req->input("von"))[1];
        $bismin = explode(":", $req->input("bis"))[1];

        $vonhr = explode(":", $req->input("von"))[0];
        $bishr = explode(":", $req->input("bis"))[0];
        

        $countries = countrie::all();
        $contacts = contact::all();
        $pickups  = pickup::all();
        $statuses = statuse::all();

        $countries = countrie::all();
        $contacts = contact::all();
        $pickups  = pickup::all();
        $statuses = statuse::all();
        $pickupContact = contact::where("shortcut", $req->input("contact"))->first();

        $data = '{
            "PickupRateRequest": {
            "PickupAddress": {
            "AddressLine": "'. $req->input("street") . " " . $req->input("streetNumber") .'",
            "City": "'. $req->input("city") .'",
            "PostalCode": "'. $req->input("zipcode") .'",
            "CountryCode": "'. $country->code .'",
            "ResidentialIndicator": "Y"
            },
            "AlternateAddressIndicator": "N",
            "ServiceDateOption": "02",
            "PickupDateInfo": {
            "CloseTime": "'. $bishr . $bismin .'",
            "ReadyTime": "'. $vonhr . $vonmin .'",
            "PickupDate": "'. $pickupDate .'"
            }
            }
           }';

        
        if($req->input("shippingType") == "11") {
            $data = '{
                "PickupCreationRequest": {
                  "RatePickupIndicator": "N",
                  "Shipper": {
                    "Account": {
                      "AccountNumber": "A285F8",
                      "AccountCountryCode": "DE"
                    }
                  },
                  "PickupDateInfo": {
                    "CloseTime": "'. $bishr . $bismin .'",
                    "ReadyTime": "'. $vonhr . $vonmin .'",
                    "PickupDate": "'. $pickupDate .'"
                  },
                  "PickupAddress": {
                    "CompanyName": "'. $req->input("companyName") .'",
                    "ContactName": "'. $req->input("firstname") . " " . $req->input("lastname") .'",
                    "AddressLine": "'. $req->input("street") . " " . $req->input("streetNumber") .'",
                    "City": "'. $req->input("city") .'",
                    "PostalCode": "'. $req->input("zipcode") .'",
                    "CountryCode": "'. $country->code .'",
                    "ResidentialIndicator": "Y",
                    "Phone": {
                      "Number": "'. $telefoneNumber .'",
                      "Extension": "49"
                    }
                  },
                  "AlternateAddressIndicator": "Y",
                  "PickupPiece": [
                    {
                      "ServiceCode": "011",
                      "Quantity": "'. $req->input("packageCount") .'",
                      "DestinationCountryCode": "'. $country->code .'",
                      "ContainerCode": "01"
                    },
                    
                  ],
                  "TotalWeight": {
                    "Weight": "'. $req->input("packageWeight") .'",
                    "UnitOfMeasurement": "KGS"
                  },
                  "PaymentMethod": "01",
                  "SpecialInstruction": "'. $req->input("notice") .'",
                  "ReferenceNumber": "'. $req->input("refrenceNumber") .'",
                  "Notification": {
                    "ConfirmationEmailAddress": "test@steubel.de",
                    "UndeliverableEmailAddress": "test@steubel.de"
                  }
                }
              }';
    
        } else {
            $data = '{
                "PickupCreationRequest": {
                  "RatePickupIndicator": "N",
                  "Shipper": {
                    "Account": {
                      "AccountNumber": "A285F8",
                      "AccountCountryCode": "DE"
                    }
                  },
                  "PickupDateInfo": {
                    "CloseTime": "'. $bishr . $bismin .'",
                    "ReadyTime": "'. $vonhr . $vonmin .'",
                    "PickupDate": "'. $pickupDate .'"
                  },
                  "PickupAddress": {
                    "CompanyName": "'. $req->input("companyName") .'",
                    "ContactName": "'. $req->input("firstname") . " " . $req->input("lastname") .'",
                    "AddressLine": "'. $req->input("street") . " " . $req->input("streetNumber") .'",
                    "City": "'. $req->input("city") .'",
                    "PostalCode": "'. $req->input("zipcode") .'",
                    "CountryCode": "'. $country->code .'",
                    "ResidentialIndicator": "Y",
                    "Phone": {
                      "Number": "'. $telefoneNumber .'",
                      "Extension": "49"
                    }
                  },
                  "AlternateAddressIndicator": "Y",
                  "PickupPiece": [
                    {
                      "ServiceCode": "065",
                      "Quantity": "'. $req->input("packageCount") .'",
                      "DestinationCountryCode": "'. $country->code .'",
                      "ContainerCode": "01"
                    },
                    
                  ],
                  "TotalWeight": {
                    "Weight": "'. $req->input("packageWeight") .'",
                    "UnitOfMeasurement": "KGS"
                  },
                  "PaymentMethod": "01",
                  "SpecialInstruction": "'. $req->input("notice") .'",
                  "ReferenceNumber": "'. $req->input("refrenceNumber") .'",
                  "Notification": {
                    "ConfirmationEmailAddress": "test@steubel.de",
                    "UndeliverableEmailAddress": "test@steubel.de"
                  }
                }
              }';
    
        }
         if("1" == "1") {
            $ups = new UPS();
            $response = $ups->createPickup($data);
            if(isset($response->response->errors[0])) {

                $apiKey = 'AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg';
                $url = 'https://www.googleapis.com/language/translate/v2/languages?key=' . $apiKey;
            
                $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($response->response->errors[0]->message) . '&source=en&target='. "de";
            
                $handle = curl_init($url);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($handle);           
                $responseDecoded = json_decode($response, true);
                curl_close($handle);
                

                return redirect()->back()->withErrors($responseDecoded["data"]["translations"][0]["translatedText"]);
            } else {

                $pickup     = new pickup();
                $pickup->employee = auth()->user()->id;
                $pickup->shortcut = $req->input("contact");
                $pickup->refrence = $req->input("refrenceNumber");
                $pickup->pickup_date = $req->input("pickupDate") . " (" . $req->input("pickupStartHour") . ":" . $req->input("pickupStartMinute") . " - " . $req->input("pickupEndHour") . ":" . $req->input("pickupEndMinute") . ")";
                $pickup->status = "518";
                $pickup->packages = $req->input("packageCount");
                $pickup->weight = $req->input("packageWeight");
                $pickup->notice = $req->input("notice");
                $pickup->companyname = $req->input("companyName");
                $pickup->gender = $req->input("gender");
                $pickup->firstname = $req->input("firstname");
                $pickup->lastname = $req->input("lastname");
                $pickup->street = $req->input("street");
                $pickup->streetnumber = $req->input("streetNumber");
                $pickup->zipcode = $req->input("zipcode");
                $pickup->auftrag = $req->input("auftrag");
                $pickup->shippingtype = $req->input("shippingType");
                $pickup->date   = $date;
                $pickup->city = $req->input("city");
                $pickup->country = $req->input("country");
                $pickup->email = $req->input("email");
                $pickup->phonenumber    = $req->input("phoneNumber");
                $pickup->mobilnumber    = $req->input("mobilNumber");
                $pickup->von            = $req->input("von");
                $pickup->bis            = $req->input("bis");
                $pickup->prn        = "123";
                $pickup->save();
        
        
                Mail::to($pickup->email)->send(new abholung($pickup));
            }
            
         
    
            return view("forEmployees/administration/abholauftrag")->with("pickupContact", $pickupContact)->with("contacts", $contacts)->with("countries", $countries)->with("pickups", $pickups)->with("statuses", $statuses);
            
            
    

         }
    }

    public function technikerZusammenfassen(Request $req) {

        $technikerKontakt       = contact::where("shortcut", $req->input("techniker"))->first();

        $packid = uniqid();
         foreach($req->except("_token") as $techniker => $item) {
            if($techniker != "techniker") {

                $ausgang = warenausgang::where("shortcut", $item)->get();

                foreach($ausgang as $as) {
                    $as->companyname        = $technikerKontakt->companyname;
                    $as->shortcut           = $technikerKontakt->id;
                    $as->firstname          = $technikerKontakt->firstname;
                    $as->lastname           = $technikerKontakt->lastname;
                    $as->street             = $technikerKontakt->street;
                    $as->streetno           = $technikerKontakt->streetno;
                    $as->zipcode            = $technikerKontakt->zipcode;
                    $as->city               = $technikerKontakt->city;
                    $as->mobilnumber        = $technikerKontakt->mobilnumber;
                    $as->phonenumber        = $technikerKontakt->phonenumber;
                    $as->country            = $technikerKontakt->country;
                    $as->email              = $technikerKontakt->email;
                    $as->shipping_type      = $technikerKontakt->shipping_type;
                    $as->payment_type       = $technikerKontakt->payment_type;
                    $as->packid             = $packid;
                    $as->save();
                    
                }

            }
         }

         return redirect("crm/packtisch");

    }

    public function entsorgungZeitVerlängern(Request $req, $id) {

        $extendTime = entsorgung_extendtime::where("component_number", $id)->first();

        if($extendTime != null) {

            $extendTime->days = $extendTime->days + 90;
            $extendTime->update();

        } else {

            $parts      = explode("-", $id);

            $extendTime = new entsorgung_extendtime();
            $extendTime->process_id = $parts[0];
            $extendTime->component_id = $parts[1];
            $extendTime->component_type = $parts[2];
            $extendTime->component_count = $parts[3];
            $extendTime->component_number = $id;
            $extendTime->days = 90;
            $extendTime->save();

        }

        $phone = new phone_history();
        $phone->process_id = $parts[0];
        $phone->status = "Entsorgung";
        $phone->message = "Gerät $id um 90 Tage verlängert";
        $phone->lead_name = "";
        $phone->employee = auth()->user()->id;
        $phone->save();

        return redirect()->back();
        
    }

    public function entsorgungZeitKürzen(Request $req, $id) {

        $extendTime = entsorgung_extendtime::where("component_number", $id)->first();

        if($extendTime->days <= 0) {
            $extendTime->delete();
        } else {
            $extendTime->days = $extendTime->days - 90;
            $extendTime->update();
        }

        if($extendTime->days <= 0) {
            $extendTime->delete();
        }

        $phone = new phone_history();
        $phone->process_id = $extendTime->process_id;
        $phone->status = "Entsorgung";
        $phone->message = "Gerät $id um 90 Tage verkürzt";
        $phone->lead_name = "";
        $phone->employee = auth()->user()->id;
        $phone->save();

        return redirect()->back();
        
    }

    public function deleteAbholauftrag(Request $req, $id) {

        $pickup = pickup::where("id", $id)->first();
        $data = "{
            'Prn: '". $pickup->prn ."'
        }";

		$headers = array();
        $headers[] = "Authorization: Bearer ". $this->Auth()->access_token;
        $headers[] = 'Accept: application/json';
        $headers[] = "grant_type=client_credentials";
        $headers[] = "x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $headers[] = "Prn: " . $pickup->prn;
        $ch = curl_init('https://onlinetools.ups.com/api/shipments/v1/pickup/02');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);

        $pickup->status = "511";
        $pickup->update();

        return redirect()->back();
    }

    public function addToShelfe($newShelfe, $component) {

        $count      = shelfe_count::where("shelfe_id", $newShelfe)->first();

        $devices    = used_shelfes::where("shelfe_id", $newShelfe)->get();

        
        $counter = 0;
        foreach($devices as $device) {
            $counter++;
        }
        if($count == null) {
            $count = new shelfe_count();
            $count->count = 1;
        }
        if($counter >= $count->count) {

            return "error";
        } else {
            
            $shelfe     = new used_shelfes();
            $shelfe->shelfe_id = $newShelfe;
            $shelfe->component_number = $component;
            $shelfe->save();


            $count      = shelfe_count::where("shelfe_id", $shelfe->shelfe_id)->first();
            $devices    = used_shelfes::where("shelfe_id", $shelfe->shelfe_id)->get();
            if($count == null) {
                $count = new shelfe_count();
                $count->count = 1;
            }
            $counter = 0;
            foreach($devices as $device) {
                $counter++;
            }

            if($counter >= $count->count) {
            
                DB::table('shelfes')
                ->where('shelfe_id', $shelfe->shelfe_id)
                ->update(["full" => "true"]);
            }

            return "ok";
        }
    }

    public function getFreeShelfe() {

        $shelfe     = DB::table('shelfes')
        ->where('full', "false")
        ->first();
        $count      = shelfe_count::where("shelfe_id", $shelfe->shelfe_id)->first();
        $devices    = used_shelfes::where("shelfe_id", $shelfe->shelfe_id)->get();
        if($count == null) {
            $count = new shelfe_count();
            $count->count = 1;
        }
        $counter = 0;
        foreach($devices as $device) {
            $counter++;
        }
        if($counter >= $count->count) {
            
        DB::table('shelfes')
        ->where('shelfe_id', DB::table('shelfes')
        ->where('full', "false")
        ->first()->shelfe_id)
        ->update(["full" => "true"]);

        $this->getFreeShelfe();
        } else {
            
            if($shelfe == null) {
                $this->getFreeShelfe();
            } else {
                return $shelfe;
            }
            
        }

    }

    public function deleteShelfeDevice($shelfe, $device) {
        
        used_shelfes::where("shelfe_id", $shelfe)->delete();

        $count      = shelfe_count::where("shelfe_id", $shelfe)->first();

        $devices    = used_shelfes::where("shelfe_id", $shelfe)->get();

        if($count == null) {
            $count = new shelfe_count();
            $count->count = 1;
        }
        
        $counter    = 0;
        foreach($devices as $device) {
            $counter++;
        }
        if($counter >= $count->count) {

            DB::table('shelfes')
                ->where('shelfe_id', $shelfe)
                ->update(["full" => "false"]);
        } else {

        }

    }

    public function getVollmachtBeauftragen(Request $req) {

        $date = $req->input("date");
        $label = $req->input("label");
        $adressname = $req->input("adress");

        $pdf = new Fpdi(); 
        
        // set the source file
        $pdf->setSourceFile(public_path("/"). "pdf/vollmacht.pdf");

        $pdf->AddPage();
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId); 

        $pdf->SetFont("Arial", "", 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Text(40, 75,$adressname);

        $pdf->Text(60, 112,$label);

        $pdf->Text(37, 260,$date);

        $pdfData = $pdf->Output('temp/vollmacht.pdf','F');

        $intern = new intern();
        $intern->process_id = "";
        $intern->component_id = "";
        $intern->component_type = "";
        $intern->component_number = "";
        $intern->auftrag_id = "Vollmacht";
        $intern->auftrag_info = $label;
        $intern->locked = "no";
        $intern->save();

        return redirect()->back();

    }

    public function vollmachtAbschließen(Request $req) {

        $intern_old = intern::where("auftrag_id", "Vollmacht")->first();

        $intern     = new intern_history();
        $intern->process_id = "Vollmacht";
        $intern->component_id = "";
        $intern->component_type = "";
        $intern->component_count = "";
        $intern->component_number = "";
        $intern->employee           = auth()->user()->id;
        $intern->auftrag_id = "Vollmacht";
        $intern->auftrag_info = $intern_old->auftrag_info;
        $intern->save();

        $intern_old = intern::where("auftrag_id", "Vollmacht")->delete();

        return redirect()->back();
    }

    public function versandVersendenGetContact(Request $req, $id) {

        $contact = contact::where("id", $id)->first();
        $country = countrie::where("id", $contact->country)->first();

        $contact->country = $country->name;

        return $contact;
    }

    public function versandVersendenGetDevices(Request $req, $id) {

        $devices = device_orders::where("process_id", $id)->get();

        return $devices;
    }

    public function getShelfeEditView(Request $req, $id) {
        $editUsedShelfes = used_shelfes::where("component_number", $id)->with("entsorgung")->first();
        $editShelfe = shelfe::where("shelfe_id", $editUsedShelfes->shelfe_id)->first();
        $shelfes = used_shelfes::all();
        $statushistory = status_histori::all();
        $statuses = statuse::all();
        $contacts = contact::all();
        $countries = countrie::all();
        $allShelfes = shelfe::all();

        return view("forEmployees/packtisch/lagerplatzübersicht")->with("shelfes", $shelfes)->with("allShelfes", $allShelfes)->with("contacts", $contacts)->with("countries", $countries)->with("usedShelfes", $shelfes)->with("editShelfe", $editShelfe)->with("editUsedShelfes", $editUsedShelfes)->with("statushistory", $statushistory)->with("statuses", $statuses);
    }

    public function getShelfeEditModal(Request $req, $id) {
        $editUsedShelfes = used_shelfes::where("component_number", $id)->with("entsorgung")->first();
        $editShelfe = shelfe::where("shelfe_id", $editUsedShelfes->shelfe_id)->first();
        $shelfes = used_shelfes::all();
        $statushistory = status_histori::all();
        $statuses = statuse::all();
        $contacts = contact::all();
        $countries = countrie::all();
        $allShelfes = shelfe::all();
        return view("forEmployees/modals/editShelfeOrder")->with("shelfes", $shelfes)->with("allShelfes", $allShelfes)->with("contacts", $contacts)->with("countries", $countries)->with("usedShelfes", $shelfes)->with("editShelfe", $editShelfe)->with("editUsedShelfes", $editUsedShelfes)->with("statushistory", $statushistory)->with("statuses", $statuses);

    }

    public function entsorgungssperreAktivieren(Request $req, $id) {

        $device = device_orders::where("component_number", $id)->first();
        $device->entsorgungssperre = "yes";
        $device->update();

        return redirect()->back();
    }

    public function entsorgungssperreDeaktivieren(Request $req, $id) {

        $device = device_orders::where("component_number", $id)->first();
        $device->entsorgungssperre = "no";
        $device->update();

        return redirect()->back();
    }

    public function changeShelfeComponent(Request $req) {
        return redirect()->back();
    }

    public function lagerplatzÜbersichtFilterLager(Request $req, $id) {
        $shelfes = used_shelfes::where("shelfe_id", $id)->with("deviceOrders", "entsorgung")->get();
        $usedShelfes = used_shelfes::with("deviceOrders", "entsorgung")->get();
        $statushistory = status_histori::all();
        $statuses = statuse::all();
        $contacts = contact::all();
        $countries = countrie::all();
        $allShelfes = shelfe::all();
        
        return view("forEmployees/packtisch/lagerplatzübersicht")->with("filter", $id)->with("usedShelfes", $usedShelfes)->with("shelfes", $shelfes)->with("statushistory", $statushistory)->with("statuses", $statuses)->with("contacts", $contacts)->with("countries", $countries)->with("allShelfes", $allShelfes);

    }

    public function newComponentMuttergerätView(Request $req) {
        $barcode    = $req->input("barcode");
        $mother     = $req->input("mother");
        $device     = device_orders::where("component_number", $mother)->first();
        

        $freeShelfe = $this->getFreeShelfe();
        $kunde      = active_orders_person_data::where("process_id", $device->process_id)->first();
        $device     = $this->createATComponentId($barcode, $device->component_id);

        return view("forEmployees.packtisch.newDevice")->with("device", $device)->with("shelfe", $freeShelfe)->with("kunde", $kunde);
    }

    public function getNewComponentView(Request $req, $barcodePar = null, $at = null) {#

        if($barcodePar == null) {
            $barcode = $req->input("barcode");
        } else {
            $barcode = $barcodePar;
        }

        $seal = seal::where("code", $barcode)->first();
        if($seal != null) {
            if($seal->component_number != null) {
                $barcode = $seal->component_number;
            } else {
                return redirect()->back()->withErrors("Siegel hat kein zugehöriges Gerät!");
            }
        }
        
        //CHECKEN OB EINE SENDUNGSNUMMER EXISITERT UND RETURNEN WENN
        $ausgang = warenausgang_history::where("label", $barcode)->first();
        if($ausgang != null) {
            $as = $ausgang;
            $firstdate      = date("Y-m-d H:i:s", strtotime('+2 days'));
            $seconddate     = date('Y-m-d H:i:s', strtotime('-'. date('h') .' hours'));
            $intern         = intern::where("locked", null)->get();
            $ausgang        = warenausgang::where("locked", "!=", "yes")->orWhere("locked", null)->with("file")->get();
            $intern_history = intern_history::whereBetween('created_at', [$seconddate , $firstdate])->get();
            $ausgang_archive= warenausgang_history::whereBetween('created_at', [$seconddate , $firstdate])->with("shelfe")->get();
            $wareneingang   = wareneingang::whereBetween('created_at', [$seconddate, $firstdate])->with("shelfe")->get(); 
            $scans          = scanhistory::whereBetween('created_at', [$seconddate, $firstdate])->get(); 
            $contacts       = contact::all();    
            $hinweise       = hinweis::where("area", "Packtisch")->get();
            $employees      = User::all();
           
            return view("forEmployees/packtisch/main")
                    ->with('contacts', $contacts)
                    ->with("wareneingang", $wareneingang)
                    ->with("warenausgang_history", $ausgang_archive)
                    ->with("interns", $intern)
                    ->with("ausgang", $ausgang)
                    ->with("intern_history", $intern_history)
                    ->with("hinweise", $hinweise)
                    ->witH("employees", $employees)
                    ->with("scans", $scans)
                    ->with("tracking", $as->label);
        }

        if($at == null) {
            $at = $req->input("at");
        }

        $device = device_orders::where("component_number", $barcode)->first();
        $shelfe = used_shelfes::where("component_number", $barcode)->first();
        if($device != null && $shelfe == null && $at != "on") {
            $freeShelfe = $this->getFreeShelfe();
            $kunde = active_orders_person_data::where("process_id", $device->process_id)->first();
            return view("forEmployees.packtisch.wiedereinlagern")->with("device", $device)->with("shelfe", $freeShelfe)->with("kunde", $kunde);
        }

       if($at != "on") {
        $device = device_orders::where("component_number", $barcode)->first();
        if($device != null) {
            
            $shelfe = used_shelfes::where("component_number", $barcode)->first();
            if($shelfe != null) {
                
                $freeShelfe = $this->getFreeShelfe();
                $kunde = active_orders_person_data::where("process_id", $device->process_id)->first();
                return view("forEmployees.packtisch.umlagern")->with("device", $device)->with("currentShelfe", $shelfe)->with("freeShelfe", $freeShelfe)->with("kunde", $kunde);
            }
        }
       }


       if($at == "on") {
        $process_id = explode("-", $barcode);

        if(!isset($process_id[0])) {
            $process_id = [$barcode];
        }

        $device = device_orders::where("process_id", $process_id)->where("component_type", "ORG")->first();

        if($device != null) {

            $devices = device_orders::where("process_id", $device->process_id)->where("component_type", "ORG")->get();

            if($devices->count() == 1) {

                $freeShelfe = $this->getFreeShelfe();
                $kunde = active_orders_person_data::where("process_id", explode("-", $device->process_id)[0])->first();
                $device = $this->createATComponentId($barcode, $devices[0]->component_id);

                return view("forEmployees.packtisch.newDevice")->with("device", $device)->with("shelfe", $freeShelfe)->with("kunde", $kunde);
            } else {
                if(strlen($barcode) < 8) {
                    return $this->packtischView($req, ["Packtisch-mehrere-ORG", $devices, $barcode]);
                } else {

                    $device = device_orders::where("component_number", $barcode)->first();

                    if($device != null) {
                        $freeShelfe = $this->getFreeShelfe();
                        $kunde = active_orders_person_data::where("process_id", $device->process_id)->first();
                        $device = $this->createATComponentId($barcode, $device->component_id);

                        return view("forEmployees.packtisch.newDevice")->with("device", $device)->with("shelfe", $freeShelfe)->with("kunde", $kunde);
                    } else {
                        return redirect("crm/packtisch")->withErrors(["Das ORG konnte nicht gefunden werden."]);
                    }
                }
            }


        } else {
            return redirect()->back()->withErrors("Es existiert kein ORG");
        }
        
        } else {
            if(str_contains($barcode, "-")) {
                
            } else {
               $order = active_orders_person_data::where("process_id", $barcode)->first();
                if($order != null) {
                    $device = $this->createORGComponentId($barcode);
                    $freeShelfe = $this->getFreeShelfe();
                    $order->process_id = $barcode;
                    return view("forEmployees.packtisch.newDevice")->with("device", $device)->with("shelfe", $freeShelfe)->with("kunde", $order);
                } else {
                    $order = new_leads_person_data::where("process_id", $barcode)->first();
                    if($order != null) {
                        $device = $this->createORGComponentId($barcode);
                        $freeShelfe = $this->getFreeShelfe();

                        return view("forEmployees.packtisch.newDevice")->with("device", $device)->with("shelfe", $freeShelfe)->with("kunde", $order);
                    } else {
                        return redirect()->back()->withErrors("Auftrag konnte nicht gefunden werden");
                    }
                }
                
            }
        }

    }

    public function getOrderDocuments(Request $req, $device) {

        $user = auth()->user()->id;
        $process_id = explode("-", $device)[0];
        if(Storage::exists("/employee/" . $user . "/" . $process_id . "-a.pdf")) {
            if(Storage::exists("/files/aufträge/" . $process_id . "/" . $device . "-a.pdf")) {
                $id = random_int(1000, 10000);
                Storage::move("/files/aufträge/" . $process_id . "/" . $device . "-a.pdf", "/files/aufträge/" . $process_id . "/" . $device . "-a_$id.pdf");
                
                $file = file::where("component_number", $device)->first();
                if($file != null) {
                    $file->filename = "$device-a_$id.pdf";
                    $file->save();
                }

                Storage::move("/employee/" . $user . "/" . $process_id . "-a.pdf", "/files/aufträge/" . $process_id . "/" . $device . "-a.pdf");

                $file = new file();
                $file->process_id = $process_id;
                $file->component_number = $device;
                $file->filename = "$device-a.pdf";
                $file->type = "Auftragsdokumente";
                $file->save();
            } else {
                Storage::move("/employee/" . $user . "/" . $process_id . "-a.pdf", "/files/aufträge/" . $process_id . "/" . $device . "-a.pdf");

                $file = new file();
                $file->process_id = $process_id;
                $file->component_number = $device;
                $file->filename = "$device-a.pdf";
                $file->type = "Auftragsdokumente";
                $file->save();
            }
            
        } else {
            if(Storage::exists("/files/aufträge/" . $process_id . "/" ."auftragsdokument.pdf")) {

            } else {
                return "no files";
            }
            
        }
    }

    public function checkOrderDocuments(Request $req, $id) {
        $user = auth()->user()->id;
        if(file_exists(public_path() . "/employee/" . $user . "/" . $id . "-a.pdf")) {
            return "ok";
        } else {
            return "no-files";
        }
    }

    public function checkDeviceDocuments(Request $req, $id) {
        $user = auth()->user()->id;
        if(Storage::exists("/employee/" . $user . "/" . $id . "-g.pdf")) {
            return "ok";
        } else {
            return "no-files";
        }
    }
    public function getDeviceDocuments(Request $req, $device) {
        $user = auth()->user()->id;
        $process_id = explode("-", $device)[0];
        if(Storage::exists("/employee/" . $user . "/" . $process_id . "-g.pdf")) {
            if(Storage::exists("/files/aufträge/" . $process_id . "/" . $device . "-g.pdf")) {
                $id = random_int(1000, 10000);
                Storage::move("/files/aufträge/" . $process_id . "/" . $device . "-g.pdf", "/files/aufträge/" . $process_id . "/" . $device . "-g_$id.pdf");
                
                $file = file::where("component_number", $device)->first();
                if($file != null) {
                    $file->filename = "$device-g_$id.pdf";
                    $file->save();
                }

                Storage::move("/employee/" . $user . "/" . $process_id . "-g.pdf", "/files/aufträge/" . $process_id . "/" . $device . "-g.pdf");

                $file = new file();
                $file->process_id = $process_id;
                $file->component_number = $device;
                $file->filename = "$device-g.pdf";
                $file->type = "Gerätedokumente";
                $file->save();
            } else {
                Storage::move("/employee/" . $user . "/" . $process_id . "-g.pdf", "/files/aufträge/" . $process_id . "/" . $device . "-g.pdf");

                $file = new file();
                $file->process_id = $process_id;
                $file->component_number = $device;
                $file->filename = "$device-g.pdf";
                $file->type = "Gerätedokumente";
                $file->save();
            }
            
        } else {
            if(Storage::exists("/files/aufträge/" . $process_id . "/" ."$device-g.pdf")) {

            } else {
                return "no files";
            }
            
        }
    }

    public function saveUmlagerungGerät(Request $req, $device) {
        $intern = intern::where("component_number", $device)->first();
        if($intern != null) {
            $intern->delete();
        }

        used_shelfes::where("component_number", $device)->delete();
        $shelfe = new used_shelfes();
        $shelfe->shelfe_id = $req->input("shelfe");
        $shelfe->component_number = $device;
        $shelfe->save();

        $dev = device_orders::where("component_number", $device)->first();
                    $dev->ort = "Intern (Umlagerungsauftrag, abgschlossen)";
                    $dev->save();

        return redirect("crm/packtisch");
    }

    public function getInternBeschriftungsauftragView(Request $req, $id) {

        $intern = intern::where("id", $id)->first();
        $shelfe = used_shelfes::where("component_number", $intern->component_number)->first();
        if($intern->helpercode == null) {
            $newBarcode = $this->createORGComponentId($intern->component_number);
            $newBarcode = $intern->process_id . "-" . $newBarcode[0] . "-" . $newBarcode[1] . "-" . $newBarcode[2];
        } else {
            $newBarcode = $intern->helpercode;
        }
        
        return view("forEmployees/packtisch/beschriftungsauftrag")->with("intern", $intern)->with("shelfe", $shelfe)->with("newBarcode", $newBarcode);

    }

    public function getInternFotoauftragView(Request $req, $id) {
            
            $intern     = intern::where("id", $id)->first();
            $shelfe     = used_shelfes::where("component_number", $intern->component_number)->first();
            $kunde      = active_orders_person_data::where("process_id", $intern->process_id)->first();
            $device     = device_orders::where("component_number", $intern->component_number)->first();
            
            return view("forEmployees/packtisch/fotoauftrag")
                    ->with("intern", $intern)
                    ->with("shelfe", $shelfe)
                    ->with("kunde", $kunde)
                    ->with("device", $device);
    
    }

    public function internFotoauftragAbschließen(Request $req, $id) {

        $intern = intern::where("id", $id)->first();
        $shelfe = used_shelfes::where("component_number", $intern->component_number)->first();

        $internNew = new intern_history();
        $internNew->process_id = $intern->process_id;
        $internNew->component_number = $intern->component_number;
        $internNew->shelfeid           = $shelfe->shelfe_id;
        $internNew->auftrag_id = "Fotoauftrag";
        $internNew->employee = auth()->user()->id;

        $dev = device_orders::where("component_number", $intern->component_number)->first();
        $dev->ort = "Intern (Fotoauftrag, abgschlossen)";
        $dev->save();

        $his = new phone_history();
        $his->lead_name = "";
        $his->process_id = $intern->process_id;
        $his->status = "Fotoauftrag";
        $his->message = "Gerät $intern->component_number, abgeschlossen";
        $his->employee = auth()->user()->id;
        $his->save();

        $intern->delete();
        $internNew->save();
        


        return redirect("/crm/packtisch");
    }

    public function getKeinBarcodeView(Request $req) {

        $barcode            = rand(1000, 9999);
        $shelfe             = $this->getFreeShelfe();
        $kunde              = new active_orders_person_data();
        $kunde->process_id  = $barcode;

        return view('forEmployees.packtisch.keinBarcode')->with("barcode", $barcode)->with("shelfe", $shelfe)->with("kunde", $kunde);
    }

    public function unbekanntesGerätEinlagern(Request $req, $id) {

        $shelfe = $req->input("shelfe");

        $newUsedShelfe = new used_shelfes();
        $newUsedShelfe->shelfe_id = $shelfe;
        $newUsedShelfe->component_number = $id;
        $newUsedShelfe->save();

        $device_order                   = new device_orders();
        $device_order->process_id       = $id;
        $device_order->component_id     = $id;
        $device_order->component_type   = $id;
        $device_order->component_count  = $id;
        $device_order->component_number = $id;
        $device_order->status           = "Hilfsbarcode";
        $device_order->save();

        return redirect("crm/packtisch");
    }

    public function internBeschriftungsauftragAbschließen(Request $req, $id) {
        $intern         = intern::where("id", $id)->first();
        
        $parts = explode("-", $intern->helpercode);

        $first_device = device_orders::where("process_id", $parts[0])->first();
       
        $device_order                   = new device_orders();
        $device_order->process_id       = $parts[0];
        $device_order->component_id     = $parts[1];
        $device_order->component_type   = $parts[2];
        $device_order->component_count  = $parts[3];
        $device_order->component_number = $intern->helpercode;
        if($first_device == null) {
            $device_order->primary_device = "true";
        }
        
        $device_order->save();

        $shelfe = used_shelfes::where("component_number", $intern->component_number)->first();
        if($shelfe != null) {
            $shelfe->component_number = $intern->helpercode;
            $shelfe->save();
        }
        
        $device = device_orders::where("component_number", $intern->component_number)->first();
        if($device != null) {
            $device->delete();
        }

        $his                    = new intern_history();
        $his->process_id        = $intern->process_id;
        $his->component_id      = $intern->component_id;
        $his->component_type    = $intern->component_type;
        $his->component_count   = $intern->component_count;
        $his->shelfeid           = $shelfe->shelfe_id;
        $his->component_number  = $id;
        $his->employee           = auth()->user()->id;
        $his->auftrag_id        = $intern->auftrag_id;
        $his->auftrag_info      = $intern->info;
        $his->save();
        $intern->delete();

        return redirect("/crm/packtisch");
    }

    public function getInternUmlagerungsauftragView(Request $req, $id) {
        $intern = intern::where("id", $id)->first();
        $shelfe = used_shelfes::where("component_number", $intern->component_number)->first();
        $kunde = active_orders_person_data::where("process_id", $intern->process_id)->first();
        $device = device_orders::where("component_number", $intern->component_number)->first();
        $freeShelfe = shelfe::where("shelfe_id", $intern->auftrag_info)->first();
        return view("forEmployees/packtisch/umlagern")->with("intern", $intern)->with("currentShelfe", $shelfe)->with("freeShelfe", $freeShelfe)->with("kunde", $kunde)->with("device", $device);
    }

    public function getInternAbholauftragView(Request $req, $id) {

        $intern = intern::where("id", $id)->first();

        return view("forEmployees/packtisch/abholauftrag")->with("intern", $intern);
    }

    public function getAbholauftragDocument(Request $req, $id) {

        $intern = intern::where("id", $id)->first();


        $pdf = new Fpdi(); 

        $pdf->setSourceFile(public_path("/"). "/pdf/vollmacht.pdf");

        $pdf->AddPage();
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId);
        $pdf->SetFont("Arial", "", 12);
        
        $birthday = explode("-", $intern->abholung_birthday);
        $day = $birthday[2];
        $month = $birthday[1];
        $year = $birthday[0];

        $pdf->text(42, 74.5, $intern->abholung_abfirstname . " " . $intern->abholung_ablastname . " (Geb. $day.$month.$year)");
        $pdf->text(42, 80, $intern->abholung_abstreet . " " . $intern->abholung_abstreet_number);
        $pdf->text(42, 85.5, $intern->abholung_abzipcode . " " . $intern->abholung_abcity);


        $pdf->text(60, 112, $intern->abholung_trackingnumber);

        $pdf->text(25, 45, $intern->abholung_abfirstname . " " .  $intern->abholung_ablastname);
        $pdf->text(25, 50, $intern->abholung_abstreet . " " . $intern->abholung_abstreet_number);
        $pdf->text(25, 55, $intern->abholung_abzipcode . " " . $intern->abholung_abcity);

        dd($pdf->Output());
    }

    public function finishAbholauftrag(Request $req, $id) {

        $intern = intern::where("id", $id)->first();

        $this->newTelefonStatus($intern->process_id, 762, "Info: " . $intern->info);

        $history = new intern_history();
        $history->process_id = $intern->process_id;
        $history->component_id = $intern->component_id;
        $history->component_type = $intern->component_type;
        $history->component_count = $intern->component_count;
        $history->component_number = $intern->component_number;
        $history->employee = auth()->user()->id;
        $history->auftrag_id = $intern->auftrag_id;
        $history->auftrag_info = $intern->auftrag_info;
        $history->save();
        

        $intern->delete();

        return redirect("crm/packtisch");
    }

    
    public function newTelefonStatus($process_id, $status, $text = null, $auftrag = null, $email = null) {
        $dbStatus = statuse::where("id", $status)->first();
        if($dbStatus == null) {
            $dbStatus = statuse::where("name", $status)->first();
        }

        if($email == null) {
            $zuweisungen = array();
            if(str_contains($text, "@")) {
                $string = strip_tags($text);
                $parts = explode("@", $string);
                $c = 0;
                foreach($parts as $part) {
                    if($c != 0) {
                        $username = explode(" ", $part)[0];
                        $username = str_replace(":", "", $username);
                        $tage = explode(" Tage .", $part);
                        $tage = explode(" ", $tage[0]);
                        $tage = end($tage);
                        
                        array_push($zuweisungen, [$username => $tage]);
                    }
                    $c++;
                }
            }
        }

        $zw_id  = uniqid();

        $phone = new phone_history();
        $phone->process_id          = $process_id;
        $phone->lead_name           = "";
        $phone->employee            = auth()->user()->id;
        $phone->status              = $dbStatus->name;
        $phone->message             = $text;
        $phone->status_state        = true;
        $phone->textid              = $zw_id;
        $phone->auftragshistorie    = $auftrag;
        $phone->save();

        if(!empty($zuweisungen)) {
            foreach($zuweisungen as $zuweisung) {
                foreach($zuweisung as $key => $item) {
                    $user = user::where("username", $key)->first();
                    $zw = new zuweisung();
                    $zw->process_id = $process_id;
                    $zw->employee = $user->id;
                    $zw->textid = $zw_id;
                    $zw->tage = $item;
                    $zw->save();
                }
            }
        }

        $stat = new status_histori();
        $stat->process_id       = $process_id;
        $stat->last_status      = $dbStatus->id;
        $stat->changed_employee = auth()->user()->id;
        $stat->save();
   
}


    public function getInternNachforschungsauftragView(Request $req, $id) {

        $intern = intern::where("id", $id)->first();
        $files = file::where("nachforschungsauftrag_id", $intern->nachforschungsauftrag_id)->get();
        $shelfe = used_shelfes::where("component_number", $intern->component_number)->first();

        return view("forEmployees/packtisch/nachforschungsauftrag")->with("intern", $intern)->with("files", $files)->with("shelfe", $shelfe);
    }

    public function finishNachforschungsauftrag(Request $req, $id) {

        $intern = intern::where("id", $id)->first();

        $status = new status_histori();
        $status->process_id = explode("-", $intern->nachforschung_lastdevice)[0];
        $status->component_number = $intern->nachforschung_lastdevice;
        $status->changed_employee = auth()->user()->id;
        $status->last_status = "2852";
        $status->overwrite = "no";
        $status->information = $req->input("text");
        if($req->input("foundtype") == "found") {
            $status->auftrag = "Gefunden";
        } else {
            $status->auftrag = "Nicht gefunden";
        }

        $status->save();
        $intern->delete();

        return redirect("crm/packtisch");
    }

    public function getInternInventurauftragView(Request $req, $id) {

        $intern = intern::where("id", $id)->first();
        
        $shelfes = shelfe::all();
        $usedShelfes = used_shelfes::all();
        $devices = device_orders::all();

        return view("forEmployees/packtisch/inventurauftrag")->with("intern", $intern)->with("shelfes", $shelfes)->with("usedShelfes", $usedShelfes)->with("devices", $devices);
    }

    public function getMaterialinventurView(Request $req) {

        $inventar       = inventar::all();
        $abschluss      = tagesabschluss::all();
        $bestellungen   = inventar_bestellung::all();

        return view("forEmployees/packtisch/tagesabschluss")
                    ->with("inventar", $inventar)
                    ->with("abschluss", $abschluss)
                    ->with("bestellungen", $bestellungen);
    }

    public function saveNeuesInventarItem(Request $req, $id = null) {
        $name       = $req->input("name");
        $menge      = $req->input("menge");
        $einheit    = $req->input("einheit");
        $addresse   = $req->input("addresse");
        $epreis     = $req->input("epreis");
        $file       = $req->file("file");
        
        if($id == null) {
            $inventar = new inventar();
        } else {
            $inventar = inventar::where("id", $id)->first();
        }
        $inventar->name = $name;
        $inventar->min = $menge;
        $inventar->einheit = $einheit;
        $inventar->addresse = $addresse;
        $inventar->epreis   = $epreis;
        $inventar->timediff = $req->input("timediff");
        $inventar->save();
        
        if($file != null) {
            $file->storeAs("/files/inventar", $inventar->id . ".png");
        }

        return redirect("crm/packtisch/tagesabschluss");
    }

    public function getProduktBearbeitenInventar(Request $req, $id) {
        $inventar = inventar::all();
        $abschluss = tagesabschluss::all();
        $bestellungen = inventar_bestellung::all();
        $produkt    = inventar::where("id", $id)->first();

        return view("forEmployees/packtisch/tagesabschluss")->with("inventar", $inventar)->with("abschluss", $abschluss)->with("bestellungen", $bestellungen)->with("produkt", $produkt);
    }

    public function saveMaterialinventur(Request $req) {

        $inventar = inventar::all();
        foreach($inventar as $item) {
            $abschluss              = new tagesabschluss();
            $abschluss->item        = $item->id;
            $abschluss->count       = $req->input($item->id);
            $abschluss->skipped     = "no";
            $abschluss->employee    = auth()->user()->id;
            $abschluss->save();
        }
    
        return redirect("crm/packtisch");
    }

    public function getMaterialinventurBestellung(Request $req, $id) {
        $inventar = inventar::all();
        $abschluss = tagesabschluss::all();
        $bestellungen = inventar_bestellung::all();
        $bestellung = inventar_bestellung::where("itemid", $id)->get();
        $selectedItem   = inventar::where("id", $id)->first();
        if($bestellung == null) {
            $bestellung = array();
        }

        return view("forEmployees/packtisch/tagesabschluss")->with("selectedItem", $selectedItem)->with("inventar", $inventar)->with("abschluss", $abschluss)->with("bestellungen", $bestellungen)->with("bestellung", $bestellung);
    }

    public function neueBestellungZuInventar(Request $req, $id) {

        $bestellung = new inventar_bestellung();
        $bestellung->itemid = $id;
        $bestellung->url = $req->input("url");
        $bestellung->menge = $req->input("menge");
        $bestellung->save();

        return redirect()->back();
    }

    public function getWarenausgangView(Request $req, $id) {

        $ausgang = warenausgang::where("id", $id)->with("shelfe")->with("file")->first();
        $ausgänge = warenausgang::where("process_id", $ausgang->process_id)->with("shelfe")->with("file")->get();
        $bpzs = attachment::all();
        $seals = seal::where("used", null)->limit(10)->get();
        return view("forEmployees.packtisch.warenausgang-kunde")->with("ausgänge", $ausgänge)->with("bpzs", $bpzs)->with("seals", $seals);
        
    }

    public function checkLabel(Request $req, $id) {
        $firstdate = new DateTime();
        $firstdate = $firstdate->format("Y-m-d 00:00:00");
        $seconddate = new DateTime();

        $history = warenausgang_history::where("process_id", $id)->where("created_at", ">=", $firstdate)->where("created_at", "<=", $seconddate)->first();

        if($history == null) {
            return "ok";
        } else {
            return "no";
        }
    }

    public function warenausgangKundeVerpacken(Request $req, $id) {

        if($id == "entsorgung") {
            $devices        = warenausgang::where("ex_space", "entsorgung")->get();
        } else {
            $devices        = warenausgang::where("process_id", $id)->get();
        }

        $firstdate = new DateTime();
        $firstdate = $firstdate->format("Y-m-d 00:00:00");
        $seconddate = new DateTime();

        if($id == "entsorgung") {
            $history = warenausgang_history::where("ex_space", "entsorgung")->where("created_at", ">=", $firstdate)->where("created_at", "<=", $seconddate)->first();
        } else {
            $history = warenausgang_history::where("process_id", $id)->where("created_at", ">=", $firstdate)->where("created_at", "<=", $seconddate)->first();
        }

        if($history != null) {
            foreach($devices as $device) {

                $inshipping     = new inshipping();
                $inshipping->process_id         = $device->process_id;
                $inshipping->component_number   = $device->component_number;
                $inshipping->label_id           = $history->label;
                $inshipping->type               = $history->ex_space;
                $inshipping->firstname          = $device->firstname;
                $inshipping->lastname           = $device->lastname;
                $inshipping->save();
    
                
                $ausgang                        = new warenausgang_history();
                $ausgang->gummi                 = $device->gummi;
                $ausgang->protection            = $device->protection;
                $ausgang->employee              = auth()->user()->id;
                $ausgang->seal                  = $device->seal;
                $ausgang->bpz1                  = $device->bpz1 ;
                $ausgang->bpz2                  = $device->bpz2;
                $ausgang->shipping_type         = $device->shipping_type;
                $ausgang->payment_type          = $device->payment_type;
                $ausgang->carriers_service      = $device->carriers_service;
                $ausgang->companyname           = $device->companyname;
                $ausgang->shortcut              = $device->shortcut;
                $ausgang->firstname             = $device->firstname;
                $ausgang->lastname              = $device->lastname;
                $ausgang->street                = $device->street;
                $ausgang->streetno              = $device->streetno;
                $ausgang->zipcode               = $device->zipcode;
                $ausgang->city                  = $device->city ;
                $ausgang->country               = $device->country;
                $ausgang->email                 = $device->email;
                $ausgang->mobilnumber           = $device->mobilnumber;
                $ausgang->phonenumber           = $device->phonenumber;
                $ausgang->amount                = $device->amount      ;
                $ausgang->length                = $device->length;
                $ausgang->weight                = $device->weight;
                $ausgang->height                = $device->height;
                $ausgang->width                 = $device->width   ;
                $ausgang->ex_space              = $device->ex_space;
                $ausgang->process_id            = $device->process_id;
                $ausgang->component_id          = $device->component_id;
                $ausgang->component_type        = $device->component_type;
                $ausgang->component_count       = $device->component_count;
                $ausgang->component_number      = $device->component_number;
                $ausgang->label                 = $history->label;
    
                $ausgang->save();

                $dev = device_orders::where("component_number", $device->component_number)->first();
                $dev->ort = "Warenausgang (Kunde, versendet)";
                $dev->save();
    
                $sh = used_shelfes::where("component_number", $device->component_number)->first();
           
                $this->deleteShelfeDevice($sh->shelfe_id, $device->component_number);
            
        $device->delete();


        //return view("forEmployees/packtisch/verpacken-erfolg")->with("process_id", $devices[0]->process_id)->with("number", $history->label);

        }
    } else {
        return redirect()->back()->withErrors(["msg" => "Kein Label gefunden"]);
    }
    return redirect("crm/packtisch");
                 

        
    }

    public function warenausgangKundeVersenden(Request $req, $id) {
        $maindata               = maindata::where("company_id", "1")->first();
        
        if($id == "entsorgung") {
            $shipping_data          = warenausgang::where("ex_space", "Entsorgung")->first();
        } else {
            $shipping_data          = warenausgang::where("process_id", $id)->first();
        }

        $row_country_from       = countrie::where("id", "1")->first();

        $row_country_to         = countrie::where("name", $shipping_data->country)->first();
        if($row_country_to == null) {
            $row_country_to         = countrie::where("id", $shipping_data->country)->first();
        }

        $carriers_service       = $shipping_data->shippingtype;
        $to_companyname         = $shipping_data->companyname;
        $to_firstname           = $shipping_data->firstname;
        $to_lastname            = $shipping_data->lastname;
        $to_street              = $shipping_data->street;
        $to_streetno            = $shipping_data->streetno;
        $to_zipcode             = $shipping_data->zipcode;
        $to_city                = $shipping_data->city;
        $to_mobilnumber         = $shipping_data->mobilnumber;
        $to_phonenumber         = $shipping_data->phonenumber;
        $length                 = $shipping_data->length;
        $width                  = $shipping_data->width;
        $height                 = $shipping_data->height;
        $weight                 = $shipping_data->weight;
        $nachnahme              = $shipping_data->nachnahme;
        $type                   = $shipping_data->shippingtype;

        if($carriers_service == "Standard" || $carriers_service == "standard" || $carriers_service == "UPS Versand") {
            $carriers_service = "11";
        } else {
            $carriers_service = "65";
        }
       
        if(!isset($radio_saturday)) {
            $radio_saturday = 0;
        }
        if(!isset($radio_payment)) {
            $radio_payment = 0;
        }
        
        if($type == "Samstag") {
            $radio_saturday = 1;
        }
        

		if($carriers_service == "65" && $radio_saturday == 1){
			$saturday_delivery['SaturdayDeliveryIndicator'] = array('SATURDAY_DELIVERY');
		}


		if($radio_payment == 1){
			$saturday_delivery['COD'] = array(
				'CODFundsCode' => '1', 
				'CODAmount' => array(
					'CurrencyCode' => 'EUR', 
					'MonetaryValue' => '' . $amount
				)
			);
		}
        $person = active_orders_person_data::where("process_id", $id)->first();
        if(!isset($nachnahme) || $nachnahme == null || $nachnahme != "on") {
            if($person != null) {
                if($type == "Samstag") {
                    $cod = array('SaturdayDeliveryIndicator' => "true",
                        );
                } else {
                    $cod = array('COD' => array());
                }
            } else {
                $cod = array('COD' => array());
            }

            
        } else {

            $booking     = booking::where("process_id", $id)->latest()->first();
            
            if($booking == null) {
                return redirect()->back()->withErrors(["Keine Offene Summe gefunden, Nachnahme hat somit kein Geldwert"]);
            }
            if($person->shipping_type == "samstagszustellung") {
                $cod = array(
                    'COD' => array(
                        'description' => "test",
                        'CODFundsCode' => '1',
                        'CODAmount' => array(
                            'CurrencyCode' => "EUR",
                            'MonetaryValue' => $booking->open_sum,
                        )
                        ),
                    "SaturdayDeliveryIndicator" => "true",
                    );
            } else {
                $cod = array(
                    'COD' => array(
                        'description' => "test",
                        'CODFundsCode' => '1',
                        'CODAmount' => array(
                            'CurrencyCode' => "EUR",
                            'MonetaryValue' => $booking->open_sum,
                        )
                    )
                    );
            }
            
        }
       
		$data = array(
            "ShipmentRequest" => array(
            "Request" => array(
                "SubVersion" => "1801",
                "RequestOption" => "nonvalidate",
                "TransactionReference" => array(
                    "CustomerContext" => ""
                )
                ),
                "Shipment" => array(
                    "Description" => "GZAMotors",
                    'ShipmentServiceOptions' => $cod,
                    "Shipper" => array(
                        "Name" => "Gazi Ahmad",
                        "AttentionName" => "GZAMotors",
                        "TaxIdentificationNumber" => "456999",
                        "Phone" => array(
                            "Number" => "1115554758",
                            "Extension" => " "
                        ),
                        "ShipperNumber" => "A285F8",
                        "FaxNumber" => "8002222222",
                        "Address" => array(
                            "AddressLine" => "Strausberger Platz. 13",
                            "City" => "Berlin",
                            "StateProvinceCode" => "DE",
                            "PostalCode" => "10243",
                            "CountryCode" => "DE"
                        )
                        ),

                        
                        "ShipTo" => array(
                            "Name" => $to_firstname . $to_lastname,
                            "AttentionName" => $to_companyname,
                            "Phone" => array(
                                "Number" => "9225377171"
                            ),
                            "Address" => array(
                                "AddressLine" => $to_street . " " . $to_streetno,
                                "City" => $to_city,
                                "StateProvinceCode" => $row_country_to['code'],
                                "PostalCode" => $to_zipcode,
                                "CountryCode" => $row_country_to['code']
                            ),
                            "Residential" => " "
                        ),
                        "ShipFrom" => array(
                            "Name" => "Gazi Ahmad",
                            "AttentionName" => "GZAMotors",
                            "Phone" => array(
                                "Number" => "1234567890"
                            ),
                            "FaxNumber" => "1234567890",
                            "Address" => array(
                                "AddressLine" => "Strausberger Platz. 13",
                                "City" => "Berlin",
                                "StateProvinceCode" => "DE",
                                "PostalCode" => "10243",
                                "CountryCode" => "DE"
                            )
                            ),
                        
                            "PaymentInformation" => array(
                                "ShipmentCharge" => array(
                                    "Type" => "01",
                                    "BillShipper" => array(
                                        "AccountNumber" => "A285F8"
                                    )
                                )
                                    ),
                                    "Service" => array(
                                        "Code" => $carriers_service,
                                        "Description" => "UPS Standard"
                                    ),
                                    "Package" => array(
                                        "Description" => " ",
                                        "Packaging" => array(
                                            "Code" => "02",
                                            "Description" => "Steuergeräte"
                                        ),
                                        "Dimensions" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "CM",
                                                "Description" => "Zentimeter"
                                            ),
                                            "Length" => "15",
                                            "Width" => "15",
                                            "Height" => "15"
                                        ),
                                        "PackageWeight" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "KGS",
                                                "Description" => "Kilogramm"
                                            ),
                                            "Weight" => "2"
                                        )
                                        )),
                                        "LabelSpecification" => array(
                                            "LabelImageFormat" => array(
                                                "Code" => "GIF",
                                                "Description" => "GIF"
                                            ),
                                            "HTTPUserAgent" => "Mozilla/4.5"
                                        )
                                    )
                                        );


        
        $from_mobilnumber       = $maindata["mobilnumber"];
        $from_phonenumber       = $maindata["phonenumber"];
        $from_email             = $maindata["email"];

		$from_phonenumber1 = $from_mobilnumber != "" ? $from_mobilnumber : $from_phonenumber;

		if($from_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['Shipper']['Phone'] = array('Number' => $from_phonenumber1);
			$data['ShipmentRequest']['Shipment']['ShipFrom']['Phone'] = array('Number' => $from_phonenumber1);
		}

		$to_phonenumber1 = $to_mobilnumber != "" ? $to_mobilnumber : $to_phonenumber;

		if($to_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['ShipTo']['Phone'] = array('Number' => $to_phonenumber1);
		}



        
		$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);



        #Adress Validation
        $APIUrl = 'https://addressvalidation.googleapis.com/v1:validateAddress?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg';

        $Params = '{  "address": {    "regionCode": "'.$row_country_to->code.'",    "locality": "'.$row_country_to->city.'",    "postalCode": "'.$row_country_to->zipcode.'",    "addressLines": ["'.$row_country_to->street. ' ' . $row_country_to->streetno .'"]  },  "enableUspsCass": false}';

		$Params = json_decode($Params);

        $Params = json_encode($Params);


        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $ch = curl_init($APIUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $Params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);

        
		$headers = array();
        $headers[] = "Authorization: Bearer ". $this->Auth()->access_token;
        $headers[] = 'Accept: application/json';
        $headers[] = "grant_type=client_credentials";
        $headers[] = "x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $ch = curl_init('https://onlinetools.ups.com/api/shipments/v1/ship');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);
		sleep($maindata['sleep_shipping_label']);
        
		if(!isset($response->response->errors[0])){

            $data = 'data:image/png;base64,'. $response->ShipmentResponse->ShipmentResults->PackageResults->ShippingLabel->GraphicImage;

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            file_put_contents(public_path("/").'/temp/'. $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber . ".png", $data);
            if($id == "entsorgung") {
                $devices          = warenausgang::where("ex_space", "Entsorgung")->get();
            } else {
                $devices          = warenausgang::where("process_id", $id)->get();
            }

            foreach($devices as $device) {

                if(isset($device->fotoauftrag)) {
                    if(!file_exists('files/aufträge/'. $device->process_id ."/". $device->component_number ."_warenausgang.pdf")) {
                       $file = file::where("filename", $device->component_number ."_warenausgang.pdf")->first();
                       if($file == null) {
                        Storage::move('files/aufträge/'. $device->process_id ."/warenausgang.pdf", 'files/aufträge/'. $device->process_id ."/". $device->component_number ."_warenausgang.pdf");
                        $file = file::where("process_id", $device->process_id)->where("filename", "warenausgang.pdf")->first();
                        if($file != null) {
                            $file->filename = $device->component_number ."_warenausgang.pdf";
                            $file->update();
                        }
                       }
                    }
                   
                }

                $inshipping     = new inshipping();
                $inshipping->process_id         = $device->process_id;
                $inshipping->component_number   = $device->component_number;
                $inshipping->label_id           = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber;
                $inshipping->type               = "Kunde";
                $inshipping->firstname          = $device->firstname;
                $inshipping->lastname           = $device->lastname;
                $inshipping->save();

                
                $ausgang                        = new warenausgang_history();
                $ausgang->gummi                 = $device->gummi;
                $ausgang->protection            = $device->protection;
                $ausgang->seal                  = $device->seal;
                $ausgang->employee              = auth()->user()->id;
                $ausgang->bpz1                  = $device->bpz1 ;
                $ausgang->bpz2                  = $device->bpz2;
                $ausgang->shipping_type         = $device->shipping_type;
                $ausgang->payment_type          = $device->payment_type;
                $ausgang->carriers_service      = $device->carriers_service;
                $ausgang->companyname           = $device->companyname;
                $ausgang->shortcut              = $device->shortcut;
                $ausgang->firstname             = $device->firstname;
                $ausgang->lastname              = $device->lastname;
                $ausgang->street                = $device->street;
                $ausgang->streetno              = $device->streetno;
                $ausgang->zipcode               = $device->zipcode;
                $ausgang->city                  = $device->city ;
                $ausgang->country               = $device->country;
                $ausgang->email                 = $device->email;
                $ausgang->mobilnumber           = $device->mobilnumber;
                $ausgang->phonenumber           = $device->phonenumber;
                $ausgang->amount                = $device->amount      ;
                $ausgang->length                = $device->length;
                $ausgang->weight                = $device->weight;
                $ausgang->height                = $device->height;
                $ausgang->width                 = $device->width   ;
                $ausgang->ex_space              = $device->ex_space;
                $ausgang->info                  = $device->info;
                $ausgang->fotoauftrag           = $req->input("foto-$device->component_number");
                $ausgang->process_id            = $device->process_id;
                $ausgang->component_id          = $device->component_id;
                $ausgang->component_type        = $device->component_type;
                $ausgang->component_count       = $device->component_count;
                $ausgang->component_number      = $device->component_number;
                $ausgang->label                 = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber;
                $ausgang->file_id               = $device->file_id;
                $ausgang->save();

                $dev = device_orders::where("component_number", $device->component_number)->first();
                $dev->ort = "Warenausgang (Kunde, versendet)";
                $dev->save();

                foreach($req->except("_token") as $key => $item) {
                    if(str_contains($key, "seal")) {
                        $sealid = str_replace("seal-", "", $key);
                        
                        $seal = seal::where("code", $sealid)->first();
                        $seal->used = true;
                        $seal->used_by = auth()->user()->id;
                        $seal->used_date = new DateTime();
                        $seal->component_number = $item;
                        $seal->save();
                    }
                }
                
                $his = new phone_history();
                $his->process_id = $device->process_id;
                $his->lead_name = "";
                $his->status = "Kundenversand-versendet";
                $his->message = "$ausgang->label";
                $his->employee = auth()->user()->id;
                $his->auftragshistorie = true;
                $his->save();

                $sh = used_shelfes::where("component_number", $device->component_number)->first();

            if($device->exspace == "Entsorgung") {
                $this->packtischStatusÄndern($req, "packtisch", 517, $device->process_id, $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count, $sh->shelfe_id, $device->bpz1, $device->bpz2, $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);
            
                $order = order_id::where("process_id", $device->process_id)->first();
                
                $this->deleteShelfeDevice($sh->shelfe_id, $device->component_number);
            } else {
                $this->packtischStatusÄndern($req, "packtisch", 729, $device->process_id, $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count, $sh->shelfe_id, $device->bpz1, $device->bpz2, $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);
            
                $this->deleteShelfeDevice($sh->shelfe_id, $device->component_number);
            
            }

            }            

            
            $shipping_data->delete();

            $file = file::where("filename", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf")->where("description", "Erstvergleich")->first();
            if($file != null) {
                $file->delete();
            }
            return view("forEmployees/packtisch/versand-erfolg")->with("process_id", $devices[0]->process_id)->with("number", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);

        } else {
            $translator = new googleAPI();
            $translateted = $translator->translate("DE", $response->response->errors[0]->message, "EN");

            return redirect()->back()->withErrors([$translateted]);
        }


    }

    public function warenausgangEntsorgungVersenden(Request $req) {
        

        $maindata               = maindata::where("company_id", "1")->first();
        
        $shipping_data          = warenausgang::where("ex_space", "Entsorgung")->first();

        $row_country_from       = countrie::where("id", "1")->first();
        
        $row_country_to         = countrie::where("id", $shipping_data->country)->first();
        $carriers_service       = $shipping_data->carriers_service;
        $to_companyname         = $shipping_data->companyname;
        $to_firstname           = $shipping_data->firstname;
        $to_lastname            = $shipping_data->lastname;
        $to_street              = $shipping_data->street;
        $to_streetno            = $shipping_data->streetno;
        $to_zipcode             = $shipping_data->zipcode;
        $to_city                = $shipping_data->city;
        $to_mobilnumber         = $shipping_data->mobilnumber;
        $to_phonenumber         = $shipping_data->phonenumber;
        $length                 = $shipping_data->length;
        $width                  = $shipping_data->width;
        $height                 = $shipping_data->height;
        $weight                 = $shipping_data->weight;
        $nachnahme              = $shipping_data->nachnahme;

        if($carriers_service == "standard") {
            $carriers_service = "11";
        } else {
            $carriers_service = "65";
        }

       
        if(!isset($radio_saturday)) {
            $radio_saturday = 0;
        }
        if(!isset($radio_payment)) {
            $radio_payment = 0;
        }

		if($carriers_service == "65" && $radio_saturday == 1){
			$saturday_delivery['SaturdayDeliveryIndicator'] = array('SATURDAY_DELIVERY');
		}


		if($radio_payment == 1){
			$saturday_delivery['COD'] = array(
				'CODFundsCode' => '1', 
				'CODAmount' => array(
					'CurrencyCode' => 'EUR', 
					'MonetaryValue' => '' . $amount
				)
			);
		}
        $person = new active_orders_person_data();
        $person->shipping_type = "standard";
        if(!isset($nachnahme) || $nachnahme == null || $nachnahme != "on") {
            if($person->shipping_type == "samstagszustellung") {
                $cod = array('SaturdayDeliveryIndicator' => "true",
                    );
            } else {
                $cod = array('COD' => array(
                
                    )
                    );
            }

            
        } else {

            $booking     = booking::where("process_id", $id)->latest()->first();
            
            if($booking == null) {
                return redirect()->back()->withErrors(["Keine Offene Summe gefunden, Nachnahme hat somit kein Geldwert"]);
            }
            if($person->shipping_type == "samstagszustellung") {
                $cod = array(
                    'COD' => array(
                        'description' => "test",
                        'CODFundsCode' => '1',
                        'CODAmount' => array(
                            'CurrencyCode' => "EUR",
                            'MonetaryValue' => $booking->open_sum,
                        )
                        ),
                    "SaturdayDeliveryIndicator" => "true",
                    );
            } else {
                $cod = array(
                    'COD' => array(
                        'description' => "test",
                        'CODFundsCode' => '1',
                        'CODAmount' => array(
                            'CurrencyCode' => "EUR",
                            'MonetaryValue' => $booking->open_sum,
                        )
                    )
                    );
            }
            
        }
       
		$data = array(
            "ShipmentRequest" => array(
            "Request" => array(
                "SubVersion" => "1801",
                "RequestOption" => "nonvalidate",
                "TransactionReference" => array(
                    "CustomerContext" => ""
                )
                ),
                "Shipment" => array(
                    "Description" => "GZAMotors",
                    'ShipmentServiceOptions' => $cod,
                    "Shipper" => array(
                        "Name" => "Gazi Ahmad",
                        "AttentionName" => "GZAMotors",
                        "TaxIdentificationNumber" => "456999",
                        "Phone" => array(
                            "Number" => "1115554758",
                            "Extension" => " "
                        ),
                        "ShipperNumber" => "A285F8",
                        "FaxNumber" => "8002222222",
                        "Address" => array(
                            "AddressLine" => "Strausberger Platz. 13",
                            "City" => "Berlin",
                            "StateProvinceCode" => "DE",
                            "PostalCode" => "10243",
                            "CountryCode" => "DE"
                        )
                        ),

                        
                        "ShipTo" => array(
                            "Name" => $to_firstname . $to_lastname,
                            "AttentionName" => $to_companyname,
                            "Phone" => array(
                                "Number" => "9225377171"
                            ),
                            "Address" => array(
                                "AddressLine" => $to_street . " " . $to_streetno,
                                "City" => $to_city,
                                "StateProvinceCode" => $row_country_to['code'],
                                "PostalCode" => $to_zipcode,
                                "CountryCode" => $row_country_to['code']
                            ),
                            "Residential" => " "
                        ),
                        "ShipFrom" => array(
                            "Name" => "Gazi Ahmad",
                            "AttentionName" => "GZAMotors",
                            "Phone" => array(
                                "Number" => "1234567890"
                            ),
                            "FaxNumber" => "1234567890",
                            "Address" => array(
                                "AddressLine" => "Strausberger Platz. 13",
                                "City" => "Berlin",
                                "StateProvinceCode" => "DE",
                                "PostalCode" => "10243",
                                "CountryCode" => "DE"
                            )
                            ),
                        
                            "PaymentInformation" => array(
                                "ShipmentCharge" => array(
                                    "Type" => "01",
                                    "BillShipper" => array(
                                        "AccountNumber" => "A285F8"
                                    )
                                )
                                    ),
                                    "Service" => array(
                                        "Code" => $carriers_service,
                                        "Description" => "UPS Standard"
                                    ),
                                    "Package" => array(
                                        "Description" => " ",
                                        "Packaging" => array(
                                            "Code" => "02",
                                            "Description" => "Steuergeräte"
                                        ),
                                        "Dimensions" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "CM",
                                                "Description" => "Zentimeter"
                                            ),
                                            "Length" => $length,
                                            "Width" => $width,
                                            "Height" => $height
                                        ),
                                        "PackageWeight" => array(
                                            "UnitOfMeasurement" => array(
                                                "Code" => "KGS",
                                                "Description" => "Kilogramm"
                                            ),
                                            "Weight" => "10"
                                        )
                                        )),
                                        "LabelSpecification" => array(
                                            "LabelImageFormat" => array(
                                                "Code" => "GIF",
                                                "Description" => "GIF"
                                            ),
                                            "HTTPUserAgent" => "Mozilla/4.5"
                                        )
                                    )
                                        );


        
        $from_mobilnumber       = $maindata["mobilnumber"];
        $from_phonenumber       = $maindata["phonenumber"];
        $from_email             = $maindata["email"];

		$from_phonenumber1 = $from_mobilnumber != "" ? $from_mobilnumber : $from_phonenumber;

		if($from_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['Shipper']['Phone'] = array('Number' => $from_phonenumber1);
			$data['ShipmentRequest']['Shipment']['ShipFrom']['Phone'] = array('Number' => $from_phonenumber1);
		}

		$to_phonenumber1 = $to_mobilnumber != "" ? $to_mobilnumber : $to_phonenumber;

		if($to_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['ShipTo']['Phone'] = array('Number' => $to_phonenumber1);
		}



        
		$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);



        #Adress Validation
        $APIUrl = 'https://addressvalidation.googleapis.com/v1:validateAddress?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg';

        $Params = '{  "address": {    "regionCode": "'.$row_country_to->code.'",    "locality": "'.$row_country_to->city.'",    "postalCode": "'.$row_country_to->zipcode.'",    "addressLines": ["'.$row_country_to->street. ' ' . $row_country_to->streetno .'"]  },  "enableUspsCass": false}';

		$Params = json_decode($Params);

        $Params = json_encode($Params);


        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $ch = curl_init($APIUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $Params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);

        
		$headers = array();
        $headers[] = "Authorization: Bearer ". $this->Auth()->access_token;
        $headers[] = 'Accept: application/json';
        $headers[] = "grant_type=client_credentials";
        $headers[] = "x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $ch = curl_init('https://onlinetools.ups.com/api/shipments/v1/ship');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);
		sleep($maindata['sleep_shipping_label']);
		if(!isset($response->response->errors[0])){
		
            $data = 'data:image/png;base64,'. $response->ShipmentResponse->ShipmentResults->PackageResults->ShippingLabel->GraphicImage;

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            file_put_contents(public_path("/").'/temp/'."entsorgung" . ".png", $data);
            $devices        = warenausgang::where("ex_space", "Entsorgung")->get();

            foreach($devices as $device) {

                if(isset($device->fotoauftrag)) {
                    if(!file_exists('files/aufträge/'. $device->process_id ."/". $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf")) {
                       $file = file::where("filename", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf")->first();
                       if($file == null) {
                        Storage::move('files/aufträge/'. $device->process_id ."/warenausgang.pdf", 'files/aufträge/'. $device->process_id ."/". $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf");
                        $file = file::where("process_id", $device->process_id)->where("filename", "warenausgang.pdf")->first();
                        if($file != null) {
                            $file->filename = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf";
                            $file->update();
                        }
                       }
                    }
                   
                }

                $inshipping     = new inshipping();
                $inshipping->process_id         = $device->process_id;
                $inshipping->component_number   = $device->component_number;
                $inshipping->label_id           = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber;
                $inshipping->type               = "Kunde";
                $inshipping->firstname          = $device->firstname;
                $inshipping->lastname           = $device->lastname;
                $inshipping->save();

                
                $ausgang                        = new warenausgang_history();
                $ausgang->gummi                 = $device->gummi;
                $ausgang->protection            = $device->protection;
                $ausgang->seal                  = $device->seal;
                $ausgang->bpz1                  = $device->bpz1 ;
                $ausgang->bpz2                  = $device->bpz2;
                $ausgang->shipping_type         = $device->shipping_type;
                $ausgang->payment_type          = $device->payment_type;
                $ausgang->employee              = auth()->user()->id;

                $ausgang->carriers_service      = $device->carriers_service;
                $ausgang->companyname           = $device->companyname;
                $ausgang->shortcut              = $device->shortcut;
                $ausgang->firstname             = $device->firstname;
                $ausgang->lastname              = $device->lastname;
                $ausgang->street                = $device->street;
                $ausgang->streetno              = $device->streetno;
                $ausgang->zipcode               = $device->zipcode;
                $ausgang->city                  = $device->city ;
                $ausgang->country               = $device->country;
                $ausgang->email                 = $device->email;
                $ausgang->mobilnumber           = $device->mobilnumber;
                $ausgang->phonenumber           = $device->phonenumber;
                $ausgang->amount                = $device->amount      ;
                $ausgang->length                = $device->length;
                $ausgang->weight                = $device->weight;
                $ausgang->height                = $device->height;
                $ausgang->width                 = $device->width   ;
                $ausgang->ex_space              = $device->ex_space;
                $ausgang->process_id            = $device->process_id;
                $ausgang->component_id          = $device->component_id;
                $ausgang->component_type        = $device->component_type;
                $ausgang->component_count       = $device->component_count;
                $ausgang->info                  = $device->info;
                $ausgang->component_number      = $device->component_number;
                $ausgang->label                 = $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber;

                $ausgang->save();

                $dev = device_orders::where("component_number", $device->component_number)->first();
                $dev->ort = "Warenausgang (Entsorgungsauftrag, versendet)";
                $dev->save();

                $sh = used_shelfes::where("component_number", $device->component_number)->first();

                $sh->delete();
                $this->packtischStatusÄndern($req, "packtisch", 517, $device->process_id, $device->process_id . "-" . $device->component_id . "-" . $device->component_type . "-" . $device->component_count, $sh->shelfe_id, $device->bpz1, $device->bpz2, $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);
 

            }            

            
            $shipping_data->delete();

            $file = file::where("filename", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber ."_warenausgang.pdf")->where("description", "Erstvergleich")->first();
            if($file != null) {
                $file->delete();
            }
            return view("forEmployees/packtisch/versand-erfolg")->with("process_id", $devices[0]->process_id)->with("number", $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber);

        } else {
            $error = upsErrorCodes::where("code", $response->response->errors[0]->code)->first();
            $translator = new googleAPI();
            $translateted = $translator->translate("DE", $error->description, "EN");

            return redirect()->back()->withErrors([$translateted]);
        }


    }

    public function getWarenausgangTechnikerView(Request $req, $id) {
        $ausgänge   = warenausgang::where("shortcut", $id)->with("shelfe")->with("file")->where("einlagerungid", null)->get();
        return view("forEmployees.packtisch.warenausgang-techniker")->with("ausgänge", $ausgänge);
    }

    public function checkExistOrderDocuments(Request $req, $id, $device) {

        if(file_exists("files/aufträge/".$id."/".$device."-a.pdf")) {
            return "ok";
        } else {
            return "no-files";
        }
    }

    public function getWarenausgangEntsorgungView(Request $req) {

        $devicelist     = array();
        $ausgänge       = warenausgang::where("ex_space", "Entsorgung")
                                        ->with("shelfe")
                                        ->get();

        return view("forEmployees.packtisch.warenausgang-entsorgung")
                ->with("ausgänge", $ausgänge);
    }

    public function tagesabschlussBestellungLöschen(Request $req, $id) {

        $bestellung = inventar_bestellung::where("id", $id)->first();
        $bestellung->delete();
        
        return redirect()->back();
    }

    public function deleteDeviceDocuments(Request $req, $id) {

        $processid  = explode("-", $id)[0];
        $userid     = auth()->user()->id;

        if(file_exists("files/aufträge/$processid/$id-g.pdf")) {
            FacadesFile::delete("files/aufträge/$processid/$id-g.pdf");
        }

        if(file_exists("employee/$userid/$processid-g.pdf")) {
            FacadesFile::delete("employee/$userid/$processid-g.pdf");
        }

        
        $freeShelfe = $this->getFreeShelfe();
        $id     = str_replace($processid."-", "", $id);
        $id     = explode("-", $id);
        $kunde = active_orders_person_data::where("process_id", $processid)->first();
        return view("forEmployees.packtisch.newDevice")->with("device", $id)->with("shelfe", $freeShelfe)->with("kunde", $kunde);
    }

    public function deleteOrderDocuments(Request $req, $id) {

        $processid  = explode("-", $id)[0];
        $userid     = auth()->user()->id;
        if(file_exists("files/aufträge/$processid/$id-a.pdf")) {
            FacadesFile::delete("files/aufträge/$processid/$id-a.pdf");
        }

        if(file_exists("employee/$userid/$processid-a.pdf")) {
            FacadesFile::delete("employee/$userid/$processid-a.pdf");
        }

        $freeShelfe = $this->getFreeShelfe();
        $kunde = active_orders_person_data::where("process_id", $processid)->first();
        return view("forEmployees.packtisch.newDevice")->with("device", $id)->with("shelfe", $freeShelfe)->with("kunde", $kunde);
    }

    public function warenausgangEinzelnSperren(Request $req, $id) {

        $ausgang = warenausgang::where("id", $id)->first();
        $ausgang->locked = "true";
        $ausgang->update();

        return redirect()->back();
    }

    public function warenausgangEinzelnEntsperren(Request $req, $id) {

        $ausgang = warenausgang::where("id", $id)->first();
        $ausgang->locked = "false";
        $ausgang->update();

        return redirect()->back();
    }

    public function getWareneingangZuweisenView(Request $req, $id) {
        $orders = active_orders_person_data::all();
        $orders = new_leads_person_data::all()->merge($orders);

        return view('forEmployees.packtisch.hilfsbarcode-zuweisen')->with("id", $id)->with("orders", $orders);
    }

    public function getWareneingangArchivZuweisenView(Request $req, $id) {
        $orders = active_orders_person_data::all();
        $orders = new_leads_person_data::all()->merge($orders);

        return view('forEmployees.packtisch.hilfsbarcode-archiv-zuweisen')->with("id", $id)->with("orders", $orders);
    }

    public function getZuweisenNeuerAuftrag(Request $req) {

        $countries          = countrie::all();
        $components         = component_name::all();
        $kunde              = new kunde();
        $id                 = $kunde->createCustomId();

        return view("includes.packtisch.neuer-auftrag")->with("countries", $countries)->with("components", $components)->with("kunden_id", $id);
    }

    public function generateHelpercodeORG(Request $req, $process_id, $barcode) {
        $org = $this->createORGComponentId($process_id);

        return $org;
    }

    public function generateHelpercodeATwithORG(Request $req, $id) {

        $motherDevice = device_orders::where("process_id", $id)->where("component_type", "ORG")->first();
        
        if($motherDevice != null) {

            $at = $this->createATComponentId($id, $motherDevice->component_id);
            return [$at, $motherDevice];
        }
    }

    public function getAllORGDevices(Request $req, $id) {
        return device_orders::where("process_id", $id)->where("component_type", "ORG")->get();
    }

    public function generateATbyORG(Request $req, $id) {
        $motherDevice = device_orders::where("component_number", $id)->first();

        if($motherDevice != null) {

            $at = $this->createATComponentId($motherDevice->process_id, $motherDevice->component_id);
            return [$at, $motherDevice];
        }
    }

    public function setHelpercode(Request $req) {
        
        $devicename = $req->input("device");

        $parts = explode("-", $devicename);

        $first_device = device_orders::where("process_id", $parts[0])->first();
       
        $device_order                   = new device_orders();
        $device_order->process_id       = $parts[0];
        $device_order->component_id     = $parts[1];
        $device_order->component_type   = $parts[2];
        $device_order->component_count  = $parts[3];
        $device_order->component_number = $devicename;
        if($first_device == null) {
            $device_order->primary_device = "true";
        }
        $device_order->save();

        $device = device_orders::where("component_number", $req->input("old"))->first();
        $device->delete();

        $old = $req->input("old");

        $intern = new intern();
        $intern->process_id = $old;
        $intern->component_id = $old;
        $intern->component_type = $old;
        $intern->component_count = $old;
        $intern->component_number = $old;
        $intern->auftrag_id = "Beschriftungsauftrag";
        $intern->helpercode = $devicename;
        $intern->info = $req->input("comment");
        $intern->save();

        Storage::move('files/aufträge/'.$old.'/gerätdokumente.pdf', "files/aufträge/$parts[0]/$devicename-g.pdf");

        return redirect("/crm/auftragsübersicht-aktiv");
    }
    
    public function gerätNeuZuweisen(Request $req) {
        $devicename = $req->input("device");

        $parts = explode("-", $devicename);
       
        $old = $req->input("old");
        $parts = explode("-", $old);

        $intern = new intern();
        $intern->process_id = $parts[0];
        $intern->component_id = $parts[1];
        $intern->component_type = $parts[2];
        $intern->component_count = $parts[3];
        $intern->component_number = $old;
        $intern->helpercode = $devicename;
        $intern->auftrag_id = "Beschriftungsauftrag";
        $intern->save();

        Storage::move('files/aufträge/'.$parts[0]."/$old-g.pdf", "files/aufträge/$parts[0]/$devicename-g.pdf");
        Storage::move('files/aufträge/'.$parts[0]."/$old-a.pdf", "files/aufträge/$parts[0]/$devicename-a.pdf");
        
        return redirect("/crm/neue-auftraege");
    }

    public function neuerAbholauftrag(Request $req) {

        $process_id         = $req->input("process_id");
        $company            = $req->input("company");
        $firstname          = $req->input("firstname");
        $lastname           = $req->input("lastname");
        $street             = $req->input("street");
        $street_number      = $req->input("street_number");
        $zipcode            = $req->input("zipcode");
        $city               = $req->input("city");
        $country            = $req->input("country");
        $date               = $req->input("date");
        $trackingnumber     = $req->input("trackingnumber");
        $ab_firstname       = $req->input("ab_firstname");
        $ab_lastname        = $req->input("ab_lastname");
        $ab_street          = $req->input("ab_street");
        $ab_street_number   = $req->input("ab_street_number");
        $ab_zipcode         = $req->input("ab_zipcode");
        $ab_city            = $req->input("ab_city");
        $ab_country         = $req->input("ab_country");
        $ab_geb             = $req->input("ab_geb");
        $info               = $req->input("info");

        $intern = new intern();
        $intern->process_id                 = $process_id;
        $intern->auftrag_id                 = "Abholauftrag";
        $intern->info                       = $info;
        $intern->abholung_company           = $company;
        $intern->abholung_firstname         = $firstname;
        $intern->abholung_lastname          = $lastname;
        $intern->abholung_street            = $street;
        $intern->abholung_street_number     = $street_number;
        $intern->abholung_zipcode           = $zipcode;
        $intern->abholung_city              = $city;
        $intern->abholung_country           = $country;
        $intern->abholung_date              = $date;
        $intern->abholung_trackingnumber    = $trackingnumber;
        $intern->abholung_abfirstname       = $ab_firstname;
        $intern->abholung_ablastname        = $ab_lastname;
        $intern->abholung_abstreet          = $ab_street;
        $intern->abholung_abstreet_number   = $ab_street_number;
        $intern->abholung_abzipcode          = $ab_zipcode;
        $intern->abholung_abcity            = $ab_city;
        $intern->abholung_abcountry         = $ab_country;
        $intern->abholung_birthday          = $ab_geb;
        $intern->save();

        $info = "Abholort: $company, $firstname $lastname, $street $street_number, $zipcode $city, $country, Abholdatum: $date, Sendungsnummer: $trackingnumber, Abholer: $ab_firstname $ab_lastname, $ab_street $ab_street_number, $ab_zipcode $ab_city, $ab_country, Geburtstag: $ab_geb, Info: $info";

        $this->neuerHistorienText($process_id, 81, $info, true);

        if($req->input("global") == "true") {
            $shelfes        = shelfe::all();
            $orders         = active_orders_person_data::all();
            $orders         = archive_orders_person::all()->merge($orders);
            $countries      = countrie::all();

            return view("forEmployees/administration/globale-aufträge")->with("shelfes", $shelfes)->with("orders", $orders)->with("countries", $countries)->with("abholung", "true");
        } else {
            return $process_id;
        }

    }

    public function neuerHistorienText($process_id, $status, $info, $auftragshistorie = null) {

        $status = statuse::where("id", $status)->first();

        $his = new phone_history();
        $his->process_id = $process_id;
        $his->lead_name = "";
        $his->status = $status->name;
        $his->message = $info;
        $his->employee = auth()->user()->id;
        $his->status_state = true;
        if($auftragshistorie != null) {
            $his->auftragshistorie = true;
        }
        $his->save();
    }

    public function neuerFotoauftrag(Request $req) {
        
        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "device")) {
                $item = explode("e-", $key)[1];

                $intern                     = new intern();
                $intern->process_id         = $req->input("process_id");
                $intern->auftrag_id         = "Fotoauftrag";
                $intern->component_number   = $item;
                $intern->info               = $req->input("info");
                $intern->save();

                $dev = device_orders::where("component_number", $item)->first();
                $dev->ort = "Intern (Fotoauftrag)";
                $dev->save();

                if($req->input("info") != null) {
                    $info  = "Gerät $item an Packtisch gesendet, Info:". $req->input('info');
                } else {
                    $info  = "Gerät $item an Packtisch gesendet";
                }

                $this->neuerHistorienText($req->input("process_id"), 591, $info, true);
            }
        }
        return $req->input("process_id");
    }

    public function neuerEntsorgungsauftrag(Request $req) {

        $process_id = $req->input("process_id");
        $info = $req->input("info");
        
        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "device")) {

                $dev = device_orders::where("component_number", $item)->first();
                $contact = contact::where("id", "100")->first();

                $warenausgang                   = new warenausgang();
                $warenausgang->process_id       = $process_id;
                $warenausgang->component_id     = $dev->component_id;
                $warenausgang->component_type   = $dev->component_type;
                $warenausgang->component_count  = $dev->component_count;
                $warenausgang->component_number = $item;
                $warenausgang->ex_space         = "Entsorgung";
                $warenausgang->info             = $info;
                $warenausgang->firstname        = $contact->firstname;
                $warenausgang->lastname         = $contact->lastname;
                $warenausgang->street           = $contact->street;
                $warenausgang->streetno         = $contact->streetno;
                $warenausgang->zipcode          = $contact->zipcode;
                $warenausgang->city             = $contact->city;
                $warenausgang->country          = $contact->country;
                $warenausgang->email            = $contact->email;
                $warenausgang->mobilnumber      = $contact->mobilnumber;
                $warenausgang->phonenumber      = $contact->phonenumber;
                $warenausgang->amount           = $dev->amount;
                $warenausgang->shortcut         = $dev->shortcut;
                $warenausgang->length           = $dev->length;
                $warenausgang->weight           = $dev->weight;
                $warenausgang->height           = $dev->height;
                $warenausgang->width            = $dev->width;
                $warenausgang->save();
                
                $dev = device_orders::where("component_number", $item)->first();
                $dev->ort = "Warenausgang (Entsorgungsauftrag)";
                $dev->save();

                if($info != null) {
                    $info = "Gerät $item an Packtisch gesendet, Info:". $info;
                } else {
                    $info = "Gerät $item an Packtisch gesendet";
                }

                $this->neuerHistorienText($process_id, 6246, $info, true);
            }
        }
        return $process_id;
    }

    public function neuerUmlagerungsauftrag(Request $req) {
        
        foreach ($req->except("_token") as $key => $item) {
            if(str_contains($key, "shelfe")) {
                $shelfe = $item;
                $device = str_replace("shelfe-", "", $key);
                $usedShelfe = used_shelfes::where("component_number", $device)->first();

                if($usedShelfe != null) {
                    $process_id = $req->input("process_id");

                    $intern = new intern();
                    $intern->process_id = $process_id;
                    $intern->component_number = $device;
                    $intern->auftrag_id = "Umlagerungsauftrag";
                    $intern->auftrag_info = $shelfe;
                    $intern->info = $req->input("info");
                    $intern->save();

                    $dev = device_orders::where("component_number", $device)->first();
                    $dev->ort = "Intern (Umlagerungsauftrag)";
                    $dev->save();

                    if($req->input("info") != null) {
                        $info = "Gerät $device, Zielplatz $shelfe an Packtisch gesendet, Info:". $req->input('info');
                    } else {
                        $info = "Gerät $device, Zielplatz $shelfe an Packtisch gesendet";
                    }

                    $this->neuerHistorienText($process_id, 6547, $info, true);
                }
            }
        }

        return $req->input("process_id");

    }

    public function neuerHinweis(Request $req) {

        $process_id = $req->input("process_id");
        $type       = $req->input("type");
        $info    = $req->input("hinweis");
        $color      = $req->input("color");

        $hinweis = new hinweis();
        $hinweis->process_id = $process_id;
        $hinweis->area = $type;
        $hinweis->hinweis = $info;
        $hinweis->color = $color;
        $hinweis->employee = auth()->user()->id;
        $hinweis->save();

        

        if($process_id == "Globaler Auftrag") {
            return redirect()->back();
        } else {
            if($info != null) {
                $info = "Farbe: $color, Bereich: $type, Info: $info";
            } else {
                $info = "Farbe: $color, Bereich: $type";
            }

            $this->neuerHistorienText($process_id, 3294, $info, true);
        }

        return $process_id;

    }

    public function deleteHinweis(Request $req, $id) {

        $hinweis = hinweis::where("id", $id)->first();

        $überwachung = new überwachung();
        $überwachung->employee = $hinweis->employee;
        $überwachung->type = $hinweis->area;
        $überwachung->text = $hinweis->hinweis;
        $überwachung->ausgeblendet = auth()->user()->id;
        $überwachung->save();

        $hinweis->delete();

        return redirect()->back();
    }

    public function neuerNachforschungsauftrag(Request $req) {
        $process_id = $req->input("process_id");
        $info = $req->input("info");

        $devices = array();
        $deviceFiles = array();
        $fileNames = array();
        $files = array();

        $fileid = random_int(100000, 1000000);

        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "device-")) {
                array_push($devices, $item);
            }
            if(str_contains($key, "devicefile")) {
                $file = file::where("id", $item)->first();

                array_push($deviceFiles, $file);
                
                $datei = new file();
                $datei->process_id = "nachforschungsauftrag-auftrag";
                $datei->filename = $file->filename;
                $datei->component_number = $process_id;
                $datei->nachforschungsauftrag_id = $fileid;
                $datei->save();
                
            }
            if(str_contains($key, "filename")) {
                array_push($fileNames, $item);
            }
        }



        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "extrafile")) {
                $moveFile = $req->file($key);
                foreach($moveFile as $file) {
                    if(in_array($file->getClientOriginalName(), $fileNames)) {
                        $upload = new file();
                        $upload->process_id = "nachforschungsauftrag";
                        $upload->component_number = $process_id;
                        $upload->nachforschungsauftrag_id = $fileid;
                        $upload->filename = $file->getClientOriginalName();
                        $upload->save();

                        $filename = $file->getClientOriginalName();
                        $file->storeAs("files/aufträge/$process_id", $filename);

                        array_push($files, $file);
                    }
                }
            }
        }

        foreach($devices as $device) {
            $intern = new intern();
            $intern->process_id = $process_id;
            $intern->component_number = $device;
            $intern->auftrag_id = "Nachforschungsauftrag";
            $intern->info = $info;
            $intern->nachforschungsauftrag_id = $fileid;
            $intern->save();

            if($info != null) {
                $info = "Gerät $device an Packtisch gesendet, Info: ". $info;
            } else {
                $info = "Gerät $device an Packtisch gesendet";
            }

            $this->neuerHistorienText($process_id, 6335, $info, true);
        }

        return $process_id;
    }

    public function neuerKundenversandAnPacktisch(Request $req) {

        $process_id = $req->input("process_id");

        $devices = array(); 
        $usedFiles = array();
        $fileid = random_int(1000, 10000);
        
        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "device-")) {
                array_push($devices, $item);
            }

            if(str_contains($key, "extrafile")) {
                    foreach($item as $file) {
                        if(!in_array($file->getClientOriginalName(), $usedFiles)) {
                            $file->storeAs("files/aufträge/$process_id", $file->getClientOriginalName());

                            $f = new file();
                            $f->process_id = $process_id;
                            $f->filename = $file->getClientOriginalName();
                            $f->warenausgang_id = $fileid;
                            $f->save();

                            array_push($usedFiles, $file->getClientOriginalName());
                        }
                }
            }

            
            if(str_contains($key, "entsorgung")) {
                if($item != null) {
                    $his = new phone_history();
                    $his->process_id = $process_id;
                    $his->lead_name = "";
                    $his->employee = auth()->user()->id;
                    $his->message = "Gerät $item steht nun auf der Entsorgungsliste";
                    $his->status = "Entsorgung";
                    $his->save();
                    
                    $device = device_orders::where("component_number", $item)->first();
                    $device->entsorgung = true;
                    $device->save();
                }
            }
        }
        foreach($devices as $device) {
            
            $deviceParts = explode("-", $device);

            $ausgang = warenausgang::where("component_number", $device)->first();
            if($ausgang == null) {
                $ausgang = new warenausgang();
                $ausgang->process_id = $process_id;
                $ausgang->component_id = $deviceParts[1];
                $ausgang->component_number = $device;
                $ausgang->component_count = $deviceParts[3];
                $ausgang->component_type = $deviceParts[2];
                $ausgang->gummi = $req->input("gummi");
                $ausgang->protection = $req->input("prot");
                $ausgang->seal = $req->input("seal");
                $ausgang->bpz1 = $req->input("bpz1");
                $ausgang->bpz2 = $req->input("bpz2");

                if($req->input("country") != "Deutschland") {
                    $info = $req->input("info");
                    if($info == null) {
                        $info = "";
                    } 
                    $ausgang->info = "ACHTUNG AUSLANDSVERSAND. " . $info;
                } else {
                    $ausgang->info = $req->input("info");
                }

                $ausgang->carriers_service = $req->input("shippingtype");
                $ausgang->shipping_type = $req->input("shippingtype");
                $ausgang->companyname = $req->input("companyname");
                $ausgang->firstname = $req->input("firstname");
                $ausgang->lastname = $req->input("lastname");
                $ausgang->street = $req->input("street");
                $ausgang->streetno = $req->input("street_number");
                $ausgang->zipcode = $req->input("zipcode");
                $ausgang->city = $req->input("city");
                $ausgang->mobilnumber = $req->input("mobil");
                $ausgang->phonenumber = $req->input("phone");
                $ausgang->country = $req->input("country");
                $ausgang->email = $req->input("email");
                $ausgang->nachnahme = $req->input("nachnahme");
                $ausgang->fotoauftrag = $req->input("extrapicture");
                $ausgang->ex_space = "Kunde";
                $ausgang->nachnahme_betrag = $req->input("nachnahme_price");
                $ausgang->file_id = $fileid;
                $ausgang->employee = auth()->user()->id;
                $ausgang->save();

                $dev = device_orders::where("component_number", $device)->first();
                $dev->ort = "Warenausgang (Kunde)";
                $dev->save();

                if($req->input("info") != null) {
                    $info = "Gerät $device an Packtisch gesendet, " . "Adresse: ". $req->input("street") . " " . $req->input("street_number") . " BPZ1: ". $req->input('bpz1') . ", BPZ2: " . $req->input('bpz2') . ", Gummi: " . $req->input('gummi') . ", Schutz: " . $req->input('prot') . ", Siegel: " . $req->input('seal') . ", Versandart: " . $req->input('shippingtype') . ", Nachnahme: " . $req->input('nachnahme') . ", Nachnahme Betrag: " . $req->input('nachnahme_price') . " Info:". $req->input('info');
                } else {
                    $info = "Gerät $device an Packtisch gesendet, Adresse: ". $req->input("street") . " " . $req->input("street_number") . " BPZ1: ". $req->input('bpz1') . ", BPZ2: " . $req->input('bpz2') . ", Gummi: " . $req->input('gummi') . ", Schutz: " . $req->input('prot') . ", Siegel: " . $req->input('seal') . ", Versandart: " . $req->input('shippingtype') . ", Nachnahme: " . $req->input('nachnahme') . ", Nachnahme Betrag: " . $req->input('nachnahme_price');
                }

                $this->neuerHistorienText($process_id, 5899, $info, true);
            }
            
        }

        return $process_id;
    }

    public function changeKundenversandData(Request $req, $id) {

        $ausgang = warenausgang::where("id", $id)->first();
        $files = array();
        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "extrafile")) {
               if(!is_string($item)) {
                
                foreach($item as $file) {
                    if(!in_array($file->getClientOriginalName(), $files)) {
                        
                        $file->storeAs("files/aufträge/$ausgang->process_id", $file->getClientOriginalName());
    
                        $f = new file();
                        $f->process_id = $ausgang->process_id;
                        $f->filename = $file->getClientOriginalName();
                        $f->warenausgang_id = $ausgang->file_id;
                        $f->save();
                        
    
                        array_push($files, $file->getClientOriginalName());
                    }
            }
               }
        }
        }

        if($ausgang->shortcut != "" && $ausgang->shortcut != null) {
            $ausgänge = warenausgang::where("shortcut", $ausgang->shortcut)->with("file")->get();
        } else {
            $ausgänge = warenausgang::where("process_id", $ausgang->process_id)->with("file")->get();
        }
        
        foreach($ausgänge as $ausgang) {
            $ausgang->gummi = $req->input("gummi");
            $ausgang->protection = $req->input("prot");
            $ausgang->seal = $req->input("seal");
            $ausgang->bpz1 = $req->input("bpz1");
            $ausgang->bpz2 = $req->input("bpz2");
            $ausgang->info = $req->input("info");
            $ausgang->carriers_service = $req->input("carrier");
            $ausgang->shipping_type = $req->input("shippingtype");
            $ausgang->companyname = $req->input("companyname");
            $ausgang->gender = $req->input("gender");
            $ausgang->firstname = $req->input("firstname");
            $ausgang->lastname = $req->input("lastname");
            $ausgang->street = $req->input("street");
            $ausgang->streetno = $req->input("streetno");
            $ausgang->zipcode = $req->input("zipcode");
            $ausgang->city = $req->input("city");
            $ausgang->mobilnumber = $req->input("mobilnumber");
            $ausgang->phonenumber = $req->input("phonenumber");
            $ausgang->country = $req->input("country");
            $ausgang->email = $req->input("email");
            $ausgang->nachnahme = $req->input("nachnahme");
            $ausgang->fotoauftrag = $req->input("extrapicture");
            $ausgang->ex_space = "Kunde";
            $ausgang->nachnahme_betrag = $req->input("nachnahme_betrag");
            $ausgang->save();

        }

        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "extrafile")) {
                if($ausgänge[0]->file->where("filename", $item)->first() != null) {
                    array_push($files, $item);

                }
            }
        }

        foreach($ausgänge[0]->file as $file) {
            if(!in_array($file->filename, $files)) {
                $file->delete();
            }
        }

        return redirect("crm/packtisch");

    }

    public function neuerTechnikerversandAnPacktisch(Request $req) {

        $process_id = $req->input("process_id");
        
        $devices = array();
        $usedFiles = array();
        $fileid = random_int(1000, 10000);
        
        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "device-")) {
                array_push($devices, $item);
            }
            if(str_contains($key, "extrafile")) {
                    foreach($item as $file) {
                        if(!in_array($file->getClientOriginalName(), $usedFiles)) {
                            $file->storeAs("files/aufträge/$process_id", $file->getClientOriginalName());

                            $f = new file();
                            $f->process_id = $process_id;
                            $f->filename = $file->getClientOriginalName();
                            $f->warenausgang_id = $fileid;
                            $f->save();

                            array_push($usedFiles, $file->getClientOriginalName());
                        }
                }
            }
        }
        foreach($devices as $device) {

            $deviceParts = explode("-", $device);

            $ausgang = new warenausgang();
            $ausgang->process_id = $process_id;
            $ausgang->component_id = $deviceParts[1];
            $ausgang->component_number = $device;
            $ausgang->component_count = $deviceParts[3];
            $ausgang->component_type = $deviceParts[2];
            $ausgang->shortcut = $req->input("contact");
            $ausgang->gummi = $req->input("gummi");
            $ausgang->protection = $req->input("prot");
            $ausgang->seal = $req->input("seal");
            $ausgang->bpz1 = $req->input("bpz1");
            $ausgang->bpz2 = $req->input("bpz2");
            $ausgang->info = $req->input("info");
            $ausgang->carriers_service = $req->input("carrier");
            $ausgang->shipping_type = $req->input("shippingtype");
            $ausgang->companyname = $req->input("companyname");
            $ausgang->firstname = $req->input("firstname");
            $ausgang->lastname = $req->input("lastname");
            $ausgang->street = $req->input("street");
            $ausgang->streetno = $req->input("street_number");
            $ausgang->zipcode = $req->input("zipcode");
            $ausgang->city = $req->input("city");
            $ausgang->mobilnumber = $req->input("mobil");
            $ausgang->phonenumber = $req->input("phone");
            $ausgang->country = $req->input("country");
            $ausgang->email = $req->input("email");
            $ausgang->nachnahme = $req->input("nachnahme");
            $ausgang->fotoauftrag = $req->input("extrapicture");
            $ausgang->ex_space = "Techniker";
            $ausgang->nachnahme_betrag = $req->input("nachnahme_price");
            $ausgang->tec_info = $req->input("tec_info");
            $ausgang->file_id = $fileid;
            $ausgang->employee = auth()->user()->id;
            $ausgang->save();

            $devicedata = device_data::where("component_number", $device)->first();
            $devicedata->tec_info = $req->input("tec_info");

            $dev = device_orders::where("component_number", $item)->first();
            $dev->ort = "Warenausgang (Techniker)";
            $dev->save();

            if($req->input("info") != null) {
                $info = "Gerät $device an Packtisch gesendet, " . "Adresse: ". $req->input("street") . " " . $req->input("street_number") . " BPZ1: ". $req->input('bpz1') . ", BPZ2: " . $req->input('bpz2') . ", Gummi: " . $req->input('gummi') . ", Schutz: " . $req->input('prot') . ", Siegel: " . $req->input('seal') . ", Versandart: " . $req->input('shippingtype') . ", Nachnahme: " . $req->input('nachnahme') . ", Nachnahme Betrag: " . $req->input('nachnahme_price') . " Info:". $req->input('info');
            } else {
                $info = "Gerät $device an Packtisch gesendet, Adresse: ". $req->input("street") . " " . $req->input("street_number") . " BPZ1: ". $req->input('bpz1') . ", BPZ2: " . $req->input('bpz2') . ", Gummi: " . $req->input('gummi') . ", Schutz: " . $req->input('prot') . ", Siegel: " . $req->input('seal') . ", Versandart: " . $req->input('shippingtype') . ", Nachnahme: " . $req->input('nachnahme') . ", Nachnahme Betrag: " . $req->input('nachnahme_price');
            }

            $this->neuerHistorienText($process_id, 6530, $info, true);
        }

        return $process_id;
    }

    public function deleteWarenausgang(Request $req, $id) {

        $ausgang = warenausgang::where("id", $id)->first();

        if($ausgang->shortcut == null || $ausgang->shortcut == "") {
            $ausgänge = warenausgang::where("shortcut", $ausgang->shortcut)->with("file")->get();
        } else {
            $ausgänge = warenausgang::where("process_id", $ausgang->process_id)->with("file")->get();
        }

        foreach($ausgänge as $ausgang) {

            $dev = device_orders::where("component_number", $ausgang->component_number)->first();
            $dev->ort = "Warenausgang (gelöscht)";
            $dev->save();

            $ausgang->delete();
        }

        return redirect("crm/packtisch");
    }

    public function bearbeitenInternView(Request $req, $id) {

        $intern = intern::where("id", $id)->first();

        return view("forEmployees.packtisch.intern-bearbeiten")->with("intern", $intern);

    }

    public function checkAddress(Request $req) {

        $street     = $req->input("street");
        $streetno   = $req->input("streetno");
        $zipcode    = $req->input("zipcode");
        $city       = $req->input("city");
        $country    = $req->input("country");

        $country = countrie::where("name", $country)->first();

        $api = new googleAPI();
        $result = $api->verifyAdress($country->code, $city, $zipcode, $street, $streetno);
   
        if($result[0] == "ERROR") {
            $handle = curl_init("https://maps.googleapis.com/maps/api/place/queryautocomplete/json?input=". str_replace(" ", "%20", $street) ."%20". $streetno ."&key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg");
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handle);
            $responseDecoded = json_decode($response, true);
            curl_close($handle);
            
            return view("forEmployees.packtisch.versand-check-address")->with("response", $responseDecoded);

        } else {
            return "ok";
        }
    }

    public function getUnverifizierteKundenliste(Request $req) {

        $kunden = unv_kunde::all();

        return view("forEmployees.kunden.unverifiziert")->with("kunden", $kunden);

    }

    public function getWarenausgangBearbeiten(Request $req, $id) {

        $ausgang = warenausgang::where("id", $id)->first();

        if($ausgang->shortcut != null && $ausgang->shortcut != "") {
            $ausgänge = warenausgang::where("shortcut", $ausgang->shortcut)->where("einlagerungid", null)->with("file")->get();
        } else {
            $ausgänge = warenausgang::where("process_id", $ausgang->process_id)->where("einlagerungid", null)->with("file")->get();
        }

        $countries = countrie::all();

        $bpzs = attachment::all();

        return view("forEmployees.packtisch.edit-ausgang")
                    ->with("ausgänge", $ausgänge)
                    ->with("countries", $countries)
                    ->with("bpzs", $bpzs);

    }

    public function sildeoverGetAllFiles(Request $req, $id) {

        $files = file::where("process_id", $id)->get();

        foreach($files as $file) {
            if(file_exists(public_path() . "/files/aufträge/$id/". $file->filename)) {
                $file->manager = true;
            } else {
                $file->manager = false;
            }
            $file->type = $file->created_at->format("d.m.Y H:i");
        }

        return $files;

    }

    public function getWareningangBearbeiten(Request $req, $id) {

        $eingang = wareneingang::where("id", $id)->first();
        $users = User::all();

        return view("includes.packtisch.wareneingangBearbeiten")->with("eingang", $eingang)->with("users", $users);
    }

    public function deleteWareneingang(Request $req, $id) {
        
    }

    public function deleteTagesabschlussBild(Request $req, $id) {
        SystemFile::delete(public_path() . "/files/inventar/$id.png");

        return redirect()->back();
    }

    public function historieEingangSeite(Request $req, $site) {
        if($site == "1") {
            $eingang = wareneingang::latest()->limit($this->historie_site_counter)->get();
        } else {
            $count = $site*$this->historie_site_counter;
            $eingang = wareneingang::latest()->skip($count)->take($this->historie_site_counter)->get();

        }

        $users = user::all();

        return view("includes.packtisch.historie-eingang-table")->with("wareneingang", $eingang->sortByDesc("created_at"))->with("users", $users);
    }

    public function historieInternSeite(Request $req, $site) {
        if($site == "1") {
            $intern = intern_history::latest()->limit($this->historie_site_counter)->get();
        } else {
            $count = $site*$this->historie_site_counter;
            $intern = intern_history::latest()->skip($count)->take($this->historie_site_counter)->get();

        }

        $users = user::all();

        return view("includes.packtisch.historie-intern-table")->with("intern", $intern->sortByDesc("created_at"))->with("users", $users);
    }

    public function historieAusgangSeite(Request $req, $site) {
        if($site == "1") {
            $warenausgang = warenausgang_history::latest()->limit($this->historie_site_counter)->get();
        } else {
            $count = $site*$this->historie_site_counter;
            $warenausgang = warenausgang_history::latest()->skip($count)->take($this->historie_site_counter)->get();

        }

        $users = user::all();
        $trackings = tracking_history::all();
        $contacts       = contact::all();


        return view("includes.packtisch.historie-ausgang-table")
                    ->with("trackings", $trackings)
                    ->with("warenausgang", $warenausgang->sortByDesc("created_at"))
                    ->with("users", $users)
                    ->with("contacts", $contacts);
    }

    public function einlagerungsauftragAbschließen(Request $req, $id) {

        $device = $req->input("barcode");
        $shelfe = $req->input("shelfe");
        
        $intern = intern::where("id", $id)->first();

        $sh                     = new used_shelfes();
        $sh->shelfe_id          = $shelfe;
        $sh->component_number   = $device;
        $sh->save();

        $ausgang = warenausgang::where("component_number", $device)->first();
        $ausgang->einlagerungid = null;
        $ausgang->save();

        $his                    = new intern_history();
        $his->process_id        = $intern->process_id;
        $his->component_id      = $intern->component_id;
        $his->component_type    = $intern->component_type;
        $his->component_count   = $intern->component_count;
        $his->shelfeid          = $sh->shelfe_id;
        $his->component_number  = $device;
        $his->employee          = auth()->user()->id;
        $his->auftrag_id        = $intern->auftrag_id;
        $his->auftrag_info      = $intern->info;
        $his->save();

        $intern->delete();

        return redirect("crm/packtisch");
    }

    public function packtischHistorieFilterWareneingang(Request $req) {

        $wareneingang   = wareneingang::where("created_at", ">", $req->input("von"))->where("created_at", "<", $req->input("bis"))->get();
        $users          = user::all();

        return view("includes.packtisch.historie-eingang-table")->with("wareneingang", $wareneingang->sortByDesc("created_at"))->with("users", $users);
    }

    public function packtischHistorieFilterIntern(Request $req) {

        $intern   = intern_history::where("created_at", ">", $req->input("von"))->where("created_at", "<", $req->input("bis"))->get();
        $users    = user::all();

        return view("includes.packtisch.historie-intern-table")->with("intern", $intern->sortByDesc("created_at"))->with("users", $users);
    }

    public function packtischHistorieFilterWarenausgang(Request $req) {

        $ausgang    = warenausgang_history::where("created_at", ">", $req->input("von"))->where("created_at", "<", $req->input("bis"))->get();
        $users      = user::all();
        $trackings  = tracking_history::all();
        $contacts   = contact::all();


        return view("includes.packtisch.historie-ausgang-table")
                    ->with("warenausgang", $ausgang->sortByDesc("created_at"))
                    ->with("users", $users)
                    ->with("trackings", $trackings)
                    ->with("contacts", $contacts);
    }
 }
