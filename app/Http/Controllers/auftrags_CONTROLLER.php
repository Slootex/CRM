<?php

namespace App\Http\Controllers;

use App\Events\saveNewTrackingId as EventsSaveNewTrackingId;
use App\Mail\custom_mail;
use App\Models\artikel;
use App\Models\attachment;
use App\Models\auftragshistory;
use App\Models\callback;
use App\Models\device_data;
use App\Models\devicedata;
use App\Models\einkauf;
use App\Models\emails_history;
use App\Models\emailUUID;
use App\Models\faketime;
use App\Models\hinweis;
use App\Models\intern_history;
use App\Models\kba;
use App\Models\kundenkonto;
use App\Models\mahneinstellungen;
use App\Models\maindata;
use App\Models\rechnungsdaten_verlauf;
use App\Models\scanhistory;
use App\Models\shelfe_count;
use App\Models\used_shelfes;
use App\Models\user;
use App\Models\user_tracking;
use App\Models\user_workflow;
use App\Models\versand_statuscode;
use App\Models\zahlungen;
use App\Models\zeiterfassung;
use App\Models\zuweisung;
use DateTime;
use Google\Cloud\Translate\V3\TranslationServiceClient;
use Illuminate\Http\Request;
use App\Models\new_orders_person_declaration;
use App\Models\new_order_accepten;
use App\Models\car;
use App\Models\new_leads_person_data;
use App\Models\new_leads_car_data;
use App\Models\order_id;
use App\Models\statuse;
use App\Models\active_orders_person_data;
use App\Models\booking;
use App\Models\bpzfile;
use App\Models\active_orders_car_data;
use App\Models\orderhistory_message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\employee;
use Illuminate\Support\Str;
use App\Models\employee_account;
use App\Models\intern_admin;
use App\Models\status_histori;
use App\Models\email_templates;
use App\Models\phone_history;
use App\Models\shelfe;
use App\Models\order_process_data;
use App\Models\device_orders;
use App\Models\email_template;
use Illuminate\Tests\Database\Uppercase;
use PhpImap\Mailbox;
use Picqer\Barcode\BarcodeGeneratorJPG;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Form;
use App\Jobs\saveTrackingnumber;
use App\Listeners\saveNewTrackingId;
use App\Mail\repair_contract;
use App\Mail\mail_template;
use App\Models\archive_lead_car_data;
use App\Models\archive_lead_person_data;
use App\Models\archive_orders_car;
use App\Models\archive_orders_person;
use App\Models\component_name;
use App\Models\contact;
use App\Models\countrie;
use App\Models\emailinbox;
use App\Models\feiertage;
use App\Models\file as ModelsFile;
use App\Models\helpercode;
use App\Models\inshipping;
use App\Models\intern;
use App\Models\kundenkonto as kontoModel;
use App\Models\leads_archive_car;
use App\Models\leads_archive_person;
use App\Models\mahnungen;
use App\Models\primary_device;
use App\Models\rechnungen;
use App\Models\rechnungstext;
use App\Models\reklamation;
use App\Models\shelfes_archive;
use App\Models\statuscodes_select;
use App\Models\tracking;
use App\Models\tracking_history;
use App\Models\vergleichstext;
use App\Models\warenausgang;
use App\Models\warenausgang_history;
use App\Models\wareneingang;
use App\Models\workflow;
use Carbon\Carbon;
use Database\Seeders\active_orders_person_datas;
use FFI\Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Pdf;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use ZipArchive;

class auftrags_CONTROLLER extends Controller
{

    public $emailInbox;

    function ready_step_one(Request $req) {

        $versender = $req->input("consignor");
        $anrede = $req->input("salutation");
        $firstname = $req->input("firstname");
        $lastname = $req->input("lastname");
        $email = $req->input("email");
        $telefon = $req->input("landline");
        $mobil = $req->input("mobile");
        $straße = $req->input("street_name");
        $straßennummer = $req->input("street_number");
        $postleitzahl = $req->input("zipcode");
        $stadt = $req->input("city");
        $land = $req->input("country");
        $rücksendungsadresse = $req->input("adress_back_diff");

        $req->session()->put("consignor", $versender);
        $req->session()->put("salutation", $anrede);
        $req->session()->put("firstname", $firstname);
        $req->session()->put("lastname", $lastname);
        $req->session()->put("email", $email);
        $req->session()->put("landline", $telefon);
        $req->session()->put("mobile", $mobil);
        $req->session()->put("street_name", $straße);
        $req->session()->put("street_number", $straßennummer);
        $req->session()->put("zipcode", $postleitzahl);
        $req->session()->put("city", $stadt);
        $req->session()->put("country", $land);
        $req->session()->put("adress_back_diff", $rücksendungsadresse);

        

        return redirect("auftragsformular#step-2");

    }

    function ready_step_two(Request $req) {

        $car_company = $req->input("car_company");
        $car_model = $req->input("car_model");
        $production_year = $req->input("production_year");
        $car_identification_number = $req->input("car_identification_number");
        $car_power = $req->input("car_power");
        $mileage = $req->input("mileage");
        $transmission = $req->input("transmission");
        $fuel_type = $req->input("fuel_type");
        $broken_component = $req->input("broken_component");
        $device_manufacturer = $req->input("device_manufacturer");
        $from_car = $req->input("from_car");
        $error_message = $req->input("error_message");
        $device_partnumber = $req->input("device_partnumber");
        $past_car_modifications = $req->input("past_car_modifications");



        $req->session()->put("car_company", $car_company);
        $req->session()->put("car_model", $car_model);
        $req->session()->put("production_year", $production_year);
        $req->session()->put("car_identification_number", $car_identification_number);
        $req->session()->put("car_power", $car_power);
        $req->session()->put("mileage", $mileage);
        $req->session()->put("transmission", $transmission);
        $req->session()->put("fuel_type", $fuel_type);
        $req->session()->put("broken_component", $broken_component);
        $req->session()->put("device_manufacturer", $device_manufacturer);
        $req->session()->put("device_partnumber", $device_partnumber);
        $req->session()->put("error_message", $error_message);
        $req->session()->put("from_car", $from_car);
        $req->session()->put("past_car_modifications", $past_car_modifications);

        

        return redirect("auftragsformular#step-3");

    }

    function order_form_send(Request $req) {
        
        #NEW_ORDER_PERSON_DECLARATIONS
        $versender                      = $req->session()->get("consignor");
        $anrede                         = $req->session()->get("salutation");
        $firstname                      = $req->session()->get("firstname");
        $lastname                       = $req->session()->get("lastname");
        $email                          = $req->session()->get("email");
        $telefon                        = $req->session()->get("telefon");
        $mobil                          = $req->session()->get("mobil");
        $straße                         = $req->session()->get("street_name");
        $straßennummer                  = $req->session()->get("street_number");
        $postleitzahl                   = $req->session()->get("zipcode");
        $stadt                          = $req->session()->get("city");
        $land                           = $req->session()->get("country");
        $rücksendungsadresse            = $req->session()->get("adress_back_diff");

        #NEW_ORDER_CAR_DECLARATIONS
        $car_company                    = $req->session()->get("car_company");
        $car_model                      = $req->session()->get("car_model");
        $production_year                = $req->session()->get("production_year");
        $car_identification_number      = $req->session()->get("car_identification_number");
        $car_power                      = $req->session()->get("car_power");
        $mileage                        = $req->session()->get("mileage");
        $transmission                   = $req->session()->get("transmission");
        $fuel_type                      = $req->session()->get("fuel_type");
        $broken_component               = $req->session()->get("broken_component");
        $device_manufacturer            = $req->session()->get("device_manufacturer");
        $from_car                       = $req->session()->get("from_car");
        $error_message                  = $req->session()->get("error_message");
        $device_partnumber              = $req->session()->get("device_partnumber");
        $past_car_modifications         = $req->session()->get("past_car_modifications");

        #NEW_ORDER_SHIPPING_DELCARATIONS
        $back_shipping_type             = $req->input("back_shipping_type");
        $payment_type                   = $req->input("payment_type");
        $agb_agree                      = $req->input("agb_agree");
        $privacy_agree                  = $req->input("privacy_agree");
        $submit_type                    = $req->input("submit_type");

        #============================= { CREATE PRODUCTION ID } =============================

        $production_id                  = $this->createProductionId();

        #====================================================================================

        
        #SEND TO DATABASE

        #NEW PERSON
        $new_oders_person_declaration                           = new new_orders_person_declaration();
        $new_oders_person_declaration->process_id               = $production_id;
        $new_oders_person_declaration->instruct_as              = $versender;
        $new_oders_person_declaration->salutation               = $anrede;
        $new_oders_person_declaration->firstname                = $firstname;
        $new_oders_person_declaration->lastname                 = $lastname;
        $new_oders_person_declaration->email                    = $email;
        $new_oders_person_declaration->phone_number             = $telefon;
        $new_oders_person_declaration->mobile_number            = $mobil;
        $new_oders_person_declaration->home_street              = $straße;
        $new_oders_person_declaration->home_street_number       = $straßennummer;
        $new_oders_person_declaration->home_zipcode             = $postleitzahl;
        $new_oders_person_declaration->home_city                = $stadt;
        $new_oders_person_declaration->home_country             = $land;
        $new_oders_person_declaration->save();

        #NEW CAR
        $car                             = new car();
        $car->process_id                 = $production_id;
        $car->car_company                = $car_company;
        $car->car_model                  = $car_model;
        $car->production_year            = $production_year;
        $car->car_identification_number  = $car_identification_number;
        $car->car_power                  = $car_power;
        $car->mileage                    = $mileage;
        $car->transmission               = $transmission;
        $car->fuel_type                  = $fuel_type;
        $car->broken_component           = $broken_component;
        $car->device_manufacturer        = $device_manufacturer;
        $car->from_car                   = $from_car;
        $car->error_message              = $error_message;
        $car->device_partnumber          = $device_partnumber;
        $car->past_car_modifications     = $past_car_modifications;
        $car->save();

        #NEW ORDER ACCEPTEN
        $new_order_accepten                                     = new new_order_accepten();
        $new_order_accepten->process_id                         = $production_id;
        $new_order_accepten->back_shipping_type                 = $back_shipping_type;
        $new_order_accepten->payment_type                       = $payment_type;
        $new_order_accepten->agb_agree                          = $agb_agree;
        $new_order_accepten->privacy_agree                      = $privacy_agree;
        $new_order_accepten->submit_type                        = $submit_type;
        $new_order_accepten->save();

        #MASTER ODER ID
        $order_id = new order_id();
        $order_id->process_id                                   = $production_id;
        $order_id->kunden_id                                     = $lastname. "-" .$firstname;
        $order_id->save();

        $this->changeStatus($req, 3, $production_id, "intern", false);



        $req->session()->flush();

        return redirect()->back();
        
    }

    function form_change_status(Request $req, $id) {
        $status         = $req->input("lead_status_id");
        $order_id       = order_id::where("process_id", $id)->first();
        $this->changeStatus($req, $status, $order_id, "1", false);
        
        return redirect()->back();
    }
    function form_change_status_order(Request $req, $id) {
        $status         = $req->input("lead_status_id");
        $order_id       = order_id::where("process_id", $id)->first();

        $this->changeStatus($req, $status, $order_id, $req->session()->get("username"), true);
        
        return redirect("/crm/change/order/". $id ."/". "status");
    }

    public function sendSmsNotificaition() {
        $basic  = new \Vonage\Client\Credentials\Basic("d373412b", "UnArSqoVXLofQY5I");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("4917683412237", "tesawdawdt", 'A text messagadwa wda wd awe sent using the Nexmo SMS API')
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }

    function send_email_lead(Request $req, $id) {
        $mail_template      = $req->input("email_template");
        $lead               = new_leads_person_data::where("process_id", $id)->first();
        $this->send_email($req, $mail_template, $lead->email, $lead);
        return redirect()->back();
    }

    function send_email_order(Request $req, $id) {
        $mail = email_template::where("id", $req->input("email_template"))->first();
        $lead               = active_orders_person_data::where("process_id", $id)->first();
        if($lead == null) {
            $lead = new_leads_person_data::where("process_id", $id)->first();
        }
        if($mail->empfänger != null || $mail->empfänger != "") {
            $mail_template      = $req->input("email_template");
            $this->send_email($req, $mail_template, $mail->empfänger, $lead, $req->input("file"));
        } else {
            if($req->input("tec") != "null" && $req->input("tec") != null) {
                $mail_template      = $req->input("email_template");
        
                $contact            = contact::where("shortcut", $req->input("shortcut"))->first();
                $this->send_email($req, $mail_template, $contact->email, $contact, $req->input("file"));
               } else {
                $mail_template      = $req->input("email_template");
                $this->send_email($req, $mail_template, $lead->email, $lead, $req->input("file"));
               }
        }
       
        return redirect()->back();
    }


    function changeStatus($req, $status_id , $order_id, $changed_employee, $from_order) {
        
        $order_id                                   = order_id::where("process_id", $order_id->process_id)->first();

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
        if($lead == null) {
            $lead       = archive_orders_person::where("process_id", $order_id->process_id)->first();

            if($lead != null) {
                $this->moveToOrdersActive($req, $lead->process_id);
            }
        }
        $order_id                               = order_id::where("process_id", $order_id->process_id)->first();
        $order_id->current_status               = $status_id;

        $order_id->save();
        $new_status_history                     = new status_histori();
        $new_status_history->process_id         = $order_id->process_id;
        
        $status                             = statuse::where("id", $status_id)->first();
        if($status->admin == "yes") {
            $email_template                     = email_template::where("id", $status->email_template)->first();

            $maindata = maindata::where("company_id", 1)->first();
        
        Mail::to($maindata->email)->send(new mail_template($lead, $email_template));
        }
       

        if($order_id->current_status == null) {
            $new_status_history->last_status    = $status_id;
        } else {
            $new_status_history->last_status    = $order_id->current_status;
        }
        $new_status_history->changed_employee   = auth()->user()->name;

        if($req->has("email_sender")) {
            if($req->input("no_email") != null) {
                $status                             = statuse::where("id", $req->input("lead_status_id"))->first();
                $new_status_history->email_template = $status->email_template;
                $email_template                     = email_template::where("id", $status->email_template)->first();
                $new_status_history->email_message  = $email_template->subject;
                $this->send_email($req, $email_template, $lead->email, $lead);
            }
        }

        $new_status_history->save();
        
    }

    function createProductionId() {
        $char                   = strtoupper(chr( mt_rand( 97 , 122 ) ));

        if($char == "K") {
            $this->createProductionId();
        }

        $number                 = rand(1000,9999);

        $production_id = $char . $number;

        $database_production_id = order_id::where("process_id", $production_id)->first();

        if($database_production_id == null) {
            return $production_id;
        } else {
            $this->createProductionId();
        } 
    }

    function employee_login(Request $req) {
        dd("awd");
        $username               = $req->input("username");
        $password               = $req->input("password");

        $employee               = employee_account::where("username", $username)->first();

        if($employee != null) 
        {
            if($password == $employee->password) {
                $req->session()->put("username", $username);
                $req->session()->put("mitarbeiter_id", $employee->employee_id);
                return redirect("/");
            }
        } else {
            return dd("nutzer nicht gefunden");
        }
    }

    function add_new_lead(Request $req) {

        $production_id              = $this->createProductionId();

        $anrede                     = $req->input("gender");
        $company_name               = $req->input("companyname");
        $employee                   = $req->input("employee_name");
        $firstname                  = $req->input("firstname");
        $zipcode                    = $req->input("home_zipcode");
        $lastname                   = $req->input("lastname");
        $email                      = $req->input("email");
        $telefon                    = $req->input("phone_number");
        $mobil                      = $req->input("mobil_number");
        $straße                     = $req->input("home_street");
        $straßennummer              = $req->input("home_street_number");
        $stadt                      = $req->input("home_city");
        $land                       = $req->input("home_country");
        $send_back_company_name     = $req->input("send_back_company_name");
        $send_back_salutation       = $req->input("send_back_salutation");
        $send_back_firstname        = $req->input("send_back_firstname");
        $send_back_lastname         = $req->input("send_back_lastname");
        $send_back_street           = $req->input("send_back_street");
        $send_back_street_number    = $req->input("send_back_street_number");
        $send_back_zipcode          = $req->input("send_back_zipcode");
        $send_back_city             = $req->input("send_back_city");
        $pricemwst                  = $req->input("pricemwst");
        $shipping_type              = $req->input("shipping_type");
        $payment_type               = $req->input("payment_type");
        $send_back_country          = $req->input("send_back_country");
        $submit_type                = "intern";


        $car_company                = $req->input("car_company");
        $car_model                  = $req->input("car_model");
        $production_year            = $req->input("production_year");
        $car_identification_number  = $req->input("car_identification_number");
        $car_power                  = $req->input("car_power");
        $mileage                    = $req->input("mileage");
        $transmission               = $req->input("transmission");
        $fuel_type                  = $req->input("fuel_type");
        $broken_component           = $req->input("broken_component");
        $device_manufacturer        = $req->input("device_manufacturer");
        $from_car                   = $req->input("from_car");
        $error_message              = $req->input("error_message");
        $device_partnumber          = $req->input("device_partnumber");
        $component_company          = $req->input("component_company");
        $component_number           = $req->input("component_number");
        $car_cache                  = $req->input("error_message_cache");

        $files                      = $req->file("file");
        
        if($files != null) {
            $this->upload_files($files, $production_id);
        }
        #NEW LEAD
         $new_leads_person_data                           = new new_leads_person_data();
         $new_leads_person_data->send_back_company_name               = $send_back_company_name;
         $new_leads_person_data->send_back_gender             = $send_back_salutation;
         $new_leads_person_data->send_back_firstname               = $send_back_firstname;
         $new_leads_person_data->send_back_lastname               = $send_back_lastname;
         $new_leads_person_data->send_back_zipcode               = $send_back_zipcode;
         $new_leads_person_data->send_back_street               = $send_back_street;
         $new_leads_person_data->send_back_street_number               = $send_back_street_number;
         $new_leads_person_data->send_back_city               = $send_back_city;
         $new_leads_person_data->send_back_country               = $send_back_country;
         $new_leads_person_data->process_id               = $production_id;
         $new_leads_person_data->gender               = $anrede;
         $new_leads_person_data->employee               = $employee;
         $new_leads_person_data->company_name             = $company_name;
         $new_leads_person_data->firstname                = $firstname;
         $new_leads_person_data->lastname                 = $lastname;
         $new_leads_person_data->email                    = $email;
         $new_leads_person_data->phone_number             = $telefon;
         $new_leads_person_data->mobile_number            = $mobil;
         $new_leads_person_data->home_street              = $straße;
         $new_leads_person_data->home_street_number       = $straßennummer;
         $new_leads_person_data->home_zipcode             = $zipcode;
         $new_leads_person_data->home_city                = $stadt;
         $new_leads_person_data->home_country                = $land;
         $new_leads_person_data->pricemwst             = $pricemwst;
         $new_leads_person_data->shipping_type             = $shipping_type;
         $new_leads_person_data->payment_type             = $payment_type;
         $new_leads_person_data->submit_type             = $submit_type;


         $new_leads_person_data->save();
 
         #NEW CAR
         $car                             = new new_leads_car_data();
         $car->process_id                 = $production_id;
         $car->car_company                = $car_company;
         $car->car_model                  = $car_model;
         $car->production_year            = $production_year;
         $car->car_identification_number  = $car_identification_number;
         $car->car_power                  = $car_power;
         $car->mileage                    = $mileage;
         $car->transmission               = $transmission;
         $car->fuel_type                  = $fuel_type;
         $car->broken_component           = $broken_component;
         $car->device_manufacturer        = $device_manufacturer;
         $car->from_car                   = $from_car;
         $car->error_message              = $error_message;
         $car->device_partnumber          = $device_partnumber;
         $car->component_company          = $component_company;
         $car->component_number          = $component_number;
         $car->error_message_cache     = $car_cache;
         $car->save();
 
         #MASTER ORDER ID
         $order_id = new order_id();
         $order_id->process_id                                   = $production_id;
         $order_id->kunden_id                                     = $lastname. "-" .$firstname;
         $order_id->save();
 
        $lead       = new_leads_person_data::where("process_id", $production_id)->first();

         $this->send_repair_contract($req, $lead);
         $this->changeStatus($req, 36, $lead, $employee, false);

         return redirect("/crm/change/interessent/". $production_id);

    }

    function change_lead_data(Request $req, $id) {
        dd("awd");
        $anrede                     = $req->input("gender");
        $employee                   = "1"; #$req->session()->get("mitarbeiter_id");
        $firstname                  = $req->input("firstname");
        $zipcode                    = $req->input("home_zipcode");
        $lastname                   = $req->input("lastname");
        $email                      = $req->input("email");
        $telefon                    = $req->input("phone_number");
        $mobil                      = $req->input("mobil_number");
        $straße                     = $req->input("home_street");
        $straßennummer              = $req->input("home_street_number");
        $stadt                      = $req->input("home_city");
        $land                       = $req->input("home_country");
        $send_back_company_name     = $req->input("send_back_company_name");
        $send_back_salutation       = $req->input("send_back_salutation");
        $send_back_firstname        = $req->input("send_back_firstname");
        $send_back_lastname         = $req->input("send_back_lastname");
        $send_back_street           = $req->input("send_back_street");
        $send_back_street_number    = $req->input("send_back_street_number");
        $send_back_zipcode          = $req->input("send_back_zipcode");
        $send_back_city             = $req->input("send_back_city");
        $pricemwst                  = $req->input("pricemwst");
        $shipping_type              = $req->input("shipping_type");
        $payment_type               = $req->input("payment_type");
        $send_back_country          = $req->input("send_back_country");
        $submit_type                = "intern";

        


        $process_id                 = $req->input("process_id");
        if($firstname == null) {
            $car_company                = $req->input("car_company");
            $car_model                  = $req->input("car_model");
            $production_year            = $req->input("production_year");
            $car_identification_number  = $req->input("car_identification_number");
            $car_power                  = $req->input("car_power");
            $mileage                    = $req->input("mileage");
            $transmission               = $req->input("transmission");
            $fuel_type                  = $req->input("fuel_type");
            $broken_component           = $req->input("broken_component");
            $device_manufacturer        = $req->input("device_manufacturer");
            $from_car                   = $req->input("from_car");
            $error_message              = $req->input("error_message");
            $device_partnumber          = $req->input("device_partnumber");
            $component_company          = $req->input("component_company");
            $component_number           = $req->input("component_number");
            $car_cache                  = $req->input("error_message_cache");
    
    
             #NEW CAR
             $car                             = new_leads_car_data::where("process_id", $id)->first();
             $car->process_id                 = $id;
             $car->car_company                = $car_company;
             $car->car_model                  = $car_model;
             $car->production_year            = $production_year;
             $car->car_identification_number  = $car_identification_number;
             $car->car_power                  = $car_power;
             $car->mileage                    = $mileage;
             $car->transmission               = $transmission;
             $car->fuel_type                  = $fuel_type;
             $car->broken_component           = $broken_component;
             $car->device_manufacturer        = $device_manufacturer;
             $car->from_car                   = $from_car;
             $car->error_message              = $error_message;
             $car->device_partnumber          = $device_partnumber;
             $car->component_company          = $component_company;
             $car->component_number          = $component_number;
             $car->error_message_cache     = $car_cache;
             $car->save();

             return redirect()->back();
        } else {
            #NEW LEAD
            $new_leads_person_data                           = new_leads_person_data::where("process_id", $process_id)->first();
            $new_leads_person_data->send_back_company_name               = $send_back_company_name;
            $new_leads_person_data->send_back_gender             = $send_back_salutation;
            $new_leads_person_data->send_back_firstname               = $send_back_firstname;
            $new_leads_person_data->send_back_lastname               = $send_back_lastname;
            $new_leads_person_data->send_back_zipcode               = $send_back_zipcode;
            $new_leads_person_data->send_back_street               = $send_back_street;
            $new_leads_person_data->send_back_street_number               = $send_back_street_number;
            $new_leads_person_data->send_back_city               = $send_back_city;
            $new_leads_person_data->send_back_country               = $send_back_country;
            $new_leads_person_data->gender               = $anrede;
            $new_leads_person_data->firstname                = $firstname;
            $new_leads_person_data->lastname                 = $lastname;
            $new_leads_person_data->email                    = $email;
            $new_leads_person_data->phone_number             = $telefon;
            $new_leads_person_data->mobile_number            = $mobil;
            $new_leads_person_data->home_street              = $straße;
            $new_leads_person_data->home_street_number       = $straßennummer;
            $new_leads_person_data->home_zipcode             = $zipcode;
            $new_leads_person_data->home_city                = $stadt;
            $new_leads_person_data->home_country                = $land;
            $new_leads_person_data->pricemwst             = $pricemwst;
            $new_leads_person_data->shipping_type             = $shipping_type;
            $new_leads_person_data->payment_type             = $payment_type;
            $new_leads_person_data->submit_type             = $submit_type;


            $new_leads_person_data->save();

            $lead       = new_leads_person_data::where("process_id", $id)->first();

            $this->changeStatus($req, 36, $lead, $employee, false);

            return redirect()->back();
        }
        

    }

    function change_order_data(Request $req, $id) {

        $anrede                     = $req->input("gender");
        $employee                   = $req->session()->get("username");
        $firstname                  = $req->input("firstname");
        $zipcode                    = $req->input("home_zipcode");
        $lastname                   = $req->input("lastname");
        $email                      = $req->input("email");
        $company_name                      = $req->input("companyname");
        $telefon                    = $req->input("phone_number");
        $mobil                      = $req->input("mobil_number");
        
        $straße                     = $req->input("home_street");
        $straßennummer              = $req->input("home_street_number");
        $stadt                      = $req->input("home_city");
        $land                       = $req->input("home_country");
        $send_back_company_name     = $req->input("send_back_company_name");
        $send_back_salutation       = $req->input("send_back_gender");
        $send_back_firstname        = $req->input("send_back_firstname");
        $send_back_lastname         = $req->input("send_back_lastname");
        $send_back_street           = $req->input("send_back_street");
        $send_back_street_number    = $req->input("send_back_street_number");
        $send_back_zipcode          = $req->input("send_back_zipcode");
        $send_back_city             = $req->input("send_back_city");
        $pricemwst                  = $req->input("pricemwst");
        $shipping_type              = $req->input("shipping_type");
        $payment_type               = $req->input("payment_type");
        $send_back_country          = $req->input("send_back_country");
        $submit_type                = "intern";


        $process_id                 = $req->input("process_id");
        if($firstname == null) {
            $car_company                = $req->input("car_company");
            $car_model                  = $req->input("car_model");
            $production_year            = $req->input("production_year");
            $car_identification_number  = $req->input("car_identification_number");
            $car_power                  = $req->input("car_power");
            $mileage                    = $req->input("mileage");
            $transmission               = $req->input("transmission");
            $fuel_type                  = $req->input("fuel_type");
            $broken_component           = $req->input("broken_component");
            $device_manufacturer        = $req->input("device_manufacturer");
            $from_car                   = $req->input("from_car");
            $error_message              = $req->input("error_message");
            $device_partnumber          = $req->input("device_partnumber");
            $component_company          = $req->input("component_company");
            $component_number           = $req->input("component_number");
            $car_cache                  = $req->input("error_message_cache");
            $for_tech                    = $req->input("info_for_technician");
            
    
    
             #NEW CAR
             $car                             = active_orders_car_data::where("process_id", $id)->first();
             $car->process_id                 = $id;
             $car->car_company                = $car_company;
             $car->car_model                  = $car_model;
             $car->production_year            = $production_year;
             $car->car_identification_number  = $car_identification_number;
             $car->car_power                  = $car_power;
             $car->mileage                    = $mileage;
             $car->transmission               = $transmission;
             $car->fuel_type                  = $fuel_type;
             $car->broken_component           = $broken_component;
             $car->device_manufacturer        = $device_manufacturer;
             $car->from_car                   = $from_car;
             $car->error_message              = $error_message;
             $car->device_partnumber          = $device_partnumber;
             $car->component_company          = $component_company;
             $car->component_number           = $component_number;
             $car->error_message_cache        = $car_cache;
             $car->for_tech                    = $for_tech;
             $car->save();

             return redirect()->back();
        } else {
            #NEW LEAD
            $new_leads_person_data                           = active_orders_person_data::where("process_id", $id)->first();
            $new_leads_person_data->send_back_company_name               = $send_back_company_name;
            $new_leads_person_data->send_back_gender             = $send_back_salutation;
            $new_leads_person_data->send_back_firstname               = $send_back_firstname;
            $new_leads_person_data->send_back_lastname               = $send_back_lastname;
            $new_leads_person_data->send_back_zipcode               = $send_back_zipcode;
            $new_leads_person_data->send_back_street               = $send_back_street;
            $new_leads_person_data->send_back_street_number               = $send_back_street_number;
            $new_leads_person_data->send_back_city               = $send_back_city;
            $new_leads_person_data->send_back_country               = $send_back_country;
            $new_leads_person_data->gender               = $anrede;
            $new_leads_person_data->firstname                = $firstname;
            $new_leads_person_data->company_name                = $company_name;
            $new_leads_person_data->employee                 = auth()->user()->id;
            $new_leads_person_data->lastname                 = $lastname;
            $new_leads_person_data->email                    = $email;
            $new_leads_person_data->phone_number             = $telefon;
            $new_leads_person_data->mobile_number            = $mobil;
            $new_leads_person_data->home_street              = $straße;
            $new_leads_person_data->home_street_number       = $straßennummer;
            $new_leads_person_data->home_zipcode             = $zipcode;
            $new_leads_person_data->home_city                = $stadt;
            $new_leads_person_data->home_country                = $land;
            $new_leads_person_data->pricemwst             = $pricemwst;
            $new_leads_person_data->shipping_type             = $shipping_type;
            $new_leads_person_data->payment_type             = $payment_type;
            $new_leads_person_data->submit_type             = $submit_type;


            $new_leads_person_data->save();

            $lead       = new_leads_person_data::where("process_id", $id)->first();

            

            return redirect()->back();
        }
        

    }

    function change_interessenten_data(Request $req, $id) {
        dd("awd");
        $anrede                     = $req->input("gender");
        $employee                   = $req->session()->get("username");
        $firstname                  = $req->input("firstname");
        $zipcode                    = $req->input("home_zipcode");
        $lastname                   = $req->input("lastname");
        $email                      = $req->input("email");
        $company_name                      = $req->input("companyname");
        $telefon                    = $req->input("phone_number");
        $mobil                      = $req->input("mobil_number");
        
        $straße                     = $req->input("home_street");
        $straßennummer              = $req->input("home_street_number");
        $stadt                      = $req->input("home_city");
        $land                       = $req->input("home_country");
        $send_back_company_name     = $req->input("send_back_company_name");
        $send_back_salutation       = $req->input("send_back_salutation");
        $send_back_firstname        = $req->input("send_back_firstname");
        $send_back_lastname         = $req->input("send_back_lastname");
        $send_back_street           = $req->input("send_back_street");
        $send_back_street_number    = $req->input("send_back_street_number");
        $send_back_zipcode          = $req->input("send_back_zipcode");
        $send_back_city             = $req->input("send_back_city");
        $pricemwst                  = $req->input("pricemwst");
        $shipping_type              = $req->input("shipping_type");
        $payment_type               = $req->input("payment_type");
        $send_back_country          = $req->input("send_back_country");
        $submit_type                = "intern";


        $process_id                 = $req->input("process_id");
        if($firstname == null) {
            $car_company                = $req->input("car_company");
            $car_model                  = $req->input("car_model");
            $production_year            = $req->input("production_year");
            $car_identification_number  = $req->input("car_identification_number");
            $car_power                  = $req->input("car_power");
            $mileage                    = $req->input("mileage");
            $transmission               = $req->input("transmission");
            $fuel_type                  = $req->input("fuel_type");
            $broken_component           = $req->input("broken_component");
            $device_manufacturer        = $req->input("device_manufacturer");
            $from_car                   = $req->input("from_car");
            $error_message              = $req->input("error_message");
            $device_partnumber          = $req->input("device_partnumber");
            $component_company          = $req->input("component_company");
            $component_number           = $req->input("component_number");
            $car_cache                  = $req->input("error_message_cache");
            $for_tech                    = $req->input("info_for_technician");
            
    
    
             #NEW CAR
             $car                             = new_leads_car_data::where("process_id", $id)->first();
             $car->process_id                 = $id;
             $car->car_company                = $car_company;
             $car->car_model                  = $car_model;
             $car->production_year            = $production_year;
             $car->car_identification_number  = $car_identification_number;
             $car->car_power                  = $car_power;
             $car->mileage                    = $mileage;
             $car->transmission               = $transmission;
             $car->fuel_type                  = $fuel_type;
             $car->broken_component           = $broken_component;
             $car->device_manufacturer        = $device_manufacturer;
             $car->from_car                   = $from_car;
             $car->error_message              = $error_message;
             $car->device_partnumber          = $device_partnumber;
             $car->component_company          = $component_company;
             $car->component_number           = $component_number;
             $car->error_message_cache        = $car_cache;
             $car->for_tech                    = $for_tech;
             $car->save();

             return redirect()->back();
        } else {
            #NEW LEAD
            $new_leads_person_data                           = new_leads_person_data::where("process_id", $id)->first();
            $new_leads_person_data->send_back_company_name               = $send_back_company_name;
            $new_leads_person_data->send_back_gender             = $send_back_salutation;
            $new_leads_person_data->send_back_firstname               = $send_back_firstname;
            $new_leads_person_data->send_back_lastname               = $send_back_lastname;
            $new_leads_person_data->send_back_zipcode               = $send_back_zipcode;
            $new_leads_person_data->send_back_street               = $send_back_street;
            $new_leads_person_data->send_back_street_number               = $send_back_street_number;
            $new_leads_person_data->send_back_city               = $send_back_city;
            $new_leads_person_data->send_back_country               = $send_back_country;
            $new_leads_person_data->gender               = $anrede;
            $new_leads_person_data->firstname                = $firstname;
            $new_leads_person_data->company_name                = $company_name;
            $new_leads_person_data->employee                 = $employee;
            $new_leads_person_data->lastname                 = $lastname;
            $new_leads_person_data->email                    = $email;
            $new_leads_person_data->phone_number             = $telefon;
            $new_leads_person_data->mobile_number            = $mobil;
            $new_leads_person_data->home_street              = $straße;
            $new_leads_person_data->home_street_number       = $straßennummer;
            $new_leads_person_data->home_zipcode             = $zipcode;
            $new_leads_person_data->home_city                = $stadt;
            $new_leads_person_data->home_country                = $land;
            $new_leads_person_data->pricemwst             = $pricemwst;
            $new_leads_person_data->shipping_type             = $shipping_type;
            $new_leads_person_data->payment_type             = $payment_type;
            $new_leads_person_data->submit_type             = $submit_type;


            $new_leads_person_data->save();

            $lead       = new_leads_person_data::where("process_id", $id)->first();

            

            return redirect()->back();
        }
        

    }

    function upload_files($files, $id) {
        
        foreach($files as $filed) {

            $filename       = $filed->getClientOriginalName();
            $chars          = ["ä", "ö", "ü", ';', ";", ",", ".", "!", '"', "'", "#", " ", "$", "§", "%", "&", "?", "=", "*", "+", "(", ")"];
            $filename       = str_replace($chars, "_", $filename);
            $path = $filed->storeAs("/files/aufträge/". $id. "/" ,  $filename);

            $file                   = new ModelsFile();
            $file->process_id       = $id;
            $file->component_id     = "";
            $file->component_type   = "";
            $file->component_count  = "";
            $file->component_number = "";
            $file->employee         = "";
            $file->filename         = $filename;
            $file->description      = "";
            $file->type             = "";
            $file->save(); 
        }         
    }
   
    function lead_main_view(Request $req) {
        $statuses = statuse::all();
        $leads = new_leads_person_data::latest()->get();
        $order_ids = order_id::latest()->get();
        $employee = employee::all();
        return view("forMitarbeiter/interessenten_main")->with("statuses", $statuses)->with("leads", $leads)->with("order_ids", $order_ids)->with("employees", $employee);
        
        
    }

    function change_lead_view(Request $req, $lead_id) {
        
        $lead_person                = new_leads_person_data::where("process_id", $lead_id)->first();

        $lead_history               = status_histori::where("process_id", $lead_id)->
                                            latest('updated_at')->first();

        $lead_historys              = status_histori::where("process_id", $lead_id)->
                                            latest('updated_at')->get();
                                            
        $lead_car                   = new_leads_car_data::where("process_id", $lead_id)->first();

        $employee_created_lead      = employee::where("id", $lead_person->employee)->first();

        $employee_last_changed      = employee::where("id", $lead_history->changed_employee)->first();

        $statuses                   = statuse::all();

        $order_id                   = order_id::where("process_id", $lead_person->process_id)->first();

        $dir_files                  = Storage::files("/files/aufträge/". $lead_person->process_id);

        $employees                  = employee::all();

        $email_templates            = email_template::all();
        
        $device_orders              = device_orders::with("shelfe")->
                                        with("newLeadsPersonData")->
                                        with("component_name")->where("process_id", $lead_person->process_id)->get();


        $countries                  = countrie::all();


        $phone_history              = phone_history::where("process_id", $lead_person->process_id)->get();
        return view("forMitarbeiter/interessent_customer_data")->
                with("lead", $lead_person)->
                with("employee_created_lead", $employee_created_lead)->
                with("employee_last_changed", $employee_last_changed)->
                with("order_id", $order_id)->
                with("device_orders", $device_orders)->
                with("lead_car", $lead_car)->
                with("files", $dir_files)->
                with("statuses", $statuses)->
                with("status_historys", $lead_historys)->
                with("status_history_lead", $lead_history)->
                with("employees", $employees)->
                with("email_templates", $email_templates)->
                with("phone_historys", $phone_history)->
                with("countries", $countries);
                
    }

    function fillShelfDatabase(Request $req) {

        $ShelfFirstNumber = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
        $ShelfLetter = ["A", "B"];
        $ShelfSecondNumber = [1,2,3,4,5,6,7,8,9,10,11];
        foreach($ShelfFirstNumber as $FirstNumber) {
            foreach($ShelfLetter as $Letter) {
                foreach($ShelfSecondNumber as $SeconNumber) {
                    $shelve = new shelfe();
                    $shelve->shelfe_id = $FirstNumber. $Letter. $SeconNumber;
                    $shelve->process_id = "0";
                    $shelve->component_id = "0";
                    $shelve->component_number = "0";
                    $shelve->status = "0";
                    $shelve->should_shelfe_id = "0";
                    $shelve->should_device_number = "0";
                    $shelve->full = "false";
                    $shelve->save();

                    $shelfe = new shelfe_count();
                    $shelfe->shelfe_id = $FirstNumber. $Letter. $SeconNumber;
                    $shelfe->count = 1;
                    $shelfe->save();
                }
            }
        }

        $ShelfFirstNumber = [15,16,17,18,19,20];
        $ShelfLetter = ["A", "B"];
        $ShelfSecondNumber = [1,2,3,4,5,6,7,8,9,10,11];
        foreach($ShelfFirstNumber as $FirstNumber) {
            foreach($ShelfLetter as $Letter) {
                foreach($ShelfSecondNumber as $SeconNumber) {
                    $shelve = new shelfes_archive();
                    $shelve->shelfe_id = $FirstNumber. $Letter. $SeconNumber;
                    $shelve->process_id = "0";
                    $shelve->component_id = "0";
                    $shelve->component_number = "0";
                    $shelve->save();
                }
            }
        }

    }

    function createORGComponentId($process_id) {
        $order_from_db          = device_orders::where("process_id", $process_id)->where("component_type", "ORG")->get();
        
        if($order_from_db == null)
        {
            $first_number       = rand(1,9);
            $second_number      = rand(1,9);


            $component_id       = "-". $first_number. $second_number. "-";
            $component_type     = "-ORG-";
            $component_count    = "1";
            

            return [$component_id, $component_type, $component_count];
            
        } else
        {
            $first_number       = rand(1,9);
            $second_number      = rand(1,9);


            $component_id       = $first_number. $second_number;
            $component_type     = "ORG";
            if($order_from_db->count() == "0") {
                $component_count    = "1";
            } else {
                $component_count    = $order_from_db->count();
            }
            

            return [$component_id, $component_type, $component_count];
        }
    }

    function add_component(Request $req) {

        $process_number         = $req->input("process_number");
        $component_type         = $req->input("component");

        $process_id             = order_id::where("process_id", $process_number)->first();

        if($process_id != null) 
        {


           

        }

    }

    function new_device(Request $req, $id) {
       
        $shelfes            = shelfe::all();
        $lead               = active_orders_person_data::where("process_id", $id)->first();
        return redirect()->back();
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
    function add_device(Request $req, $id) {
        $shelfe_id                          = $req->input("shelfe_id");
        $component_type                     = $req->input("component_type");
        $component                          = $req->input("component");
        $device_manufacturer                = $req->input("device_manufacturer");
        $device_partnumber                  = $req->input("device_partnumber");
        $from_car                           = $req->input("from_car");
        $open_by_user                       = $req->input("open_by_user");
        $other_components                   = $req->input("other_components");
        $info                               = $req->input("info");
        $component_created                  = "null";
        if($component_type == "1") {
            $component_created                       = $this->createORGComponentId($id);
        } else if($component_type == "2") {
            dd("cant create AT");
        }
        $component_id                            = $component_created[0];
        $component_type                          = $component_created[1];
        $component_count                         = $component_created[2];
        

        $new_device                         = new device_orders();
        $new_device->process_id             = $id;
        $new_device->component_id           = $component_id;
        $new_device->component_type         = $component_type;
        $new_device->component_number        = $id. "-" .$component_id. "-" .$component_type. "-" .$component_count;
        $new_device->component_count        = $component_count;
        $new_device->component              = $component;
        $new_device->device_manufacturer    = $device_manufacturer;
        $new_device->device_partnumber      = $device_partnumber;
        $new_device->from_car               = $from_car;
        $new_device->open_by_user           = $open_by_user;
        $new_device->other_components       = $other_components;
        $new_device->info                   = $info;
        $new_device->save();

        DB::table('shelfes')
              ->where('shelfe_id', $shelfe_id)
              ->update(['process_id' => $id, 'component_id' => $component_id, 'component_number' => $id. "-" .$component_id. "-" .$component_type. "-" .$component_count]);

        return redirect("/crm/auftraege-neues-geraet/". $id);

    }
    
    function send_email(Request $req, $email_template, $email, $lead, $filename = null) {
        $mail               = email_template::where("id", $email_template)->first();
        if($mail == null) {
            $mail           = $email_template;
        }
        Mail::to($email)->send(new mail_template($lead, $mail, $req->session()->get("username"), $email, $filename));
   
    }

    function send_repair_contract(Request $req, $id) {
        $pdf = new Fpdi(); 
        
        // set the source file
        $pdf->setSourceFile(public_path("/"). "pdf/auftragsformular.pdf");

        for ($i=1; $i < 4; $i++) {
            $pdf->AddPage();
            $tplId = $pdf->importPage($i);
            $pdf->useTemplate($tplId); 
            if($i == 1) {
                 // The new content
                $fontSize = '15';
                


                //set the font, colour and text to the page.
                $pdf->SetFont("Arial", "B", 26);
                $pdf->SetTextColor(26, 105, 196);
                $pdf->Text(20,65,iconv('UTF-8', 'ISO-8859-1', "Ihre persönliche Vorgangs-Nr.: " . $id->process_id));

                $test = new BarcodeGeneratorPNG();
                file_put_contents('barcode.png', $test->getBarcode($id->process_id, $test::TYPE_CODE_128));
                $pdf->Image('barcode.png', 20, 280, 60);
               
                
            }

            if($i == 2) {
                $car_company                    = $req->input("car_company");
                $car_model                      = $req->input("car_model");
                $car_identification_number      = $req->input("car_identification_number");
                $car_power                      = $req->input("car_power");
                $car_year                       = $req->input("production_year");
                $mileage                        = $req->input("mileage");
                $transmission                   = $req->input("transmission");
                $broken_component               = $req->input("broken_component");
            
                
                $component_number               = $req->input("device_partnumber");
                $error_message                  = $req->input("error_message");
                $error_message_cache            = $req->input("error_message_cache");
                $from_car                       = $req->input("from_car");
                $opend = $req->input("opend");
                $device_manufacturer            = $req->input("device_manufacturer");
                $fuel                           = $req->input("fuel_type");
                if($transmission == "circuit") {
                    $transmission = "Schaltung";
                }
                if($transmission == "automatic") {
                    $transmission = "Automatik";
                }
                if($fuel == "petrol") {
                    $fuel = "Benzin";
                }
                if($fuel == "diesel") {
                    $fuel = "Diesel";
                }


                $pdf->SetFont("Arial", "B", 12);
                $pdf->SetTextColor(26, 105, 196);
                $pdf->Text(20,22,iconv('UTF-8', 'ISO-8859-1', "Ihre persönliche Vorgangs-Nr.: " . $id->process_id));

                
                $pdf->SetFont("Arial", "", 11);
                $pdf->SetTextColor(26, 105, 196);
                $pdf->Text(19,59, $car_company);

                $pdf->Text(19,63, $car_model);

                $pdf->Text(19,67, $car_year);

                $pdf->Text(61,60, $car_identification_number);

                $pdf->Text(164,60, $car_power);
                
                try {
                    if($milage != "0") {
                        $mil_10 = $mileage/1000;
                        $pdf->Text(184,60, $mil_10 . " T");
                    }
                } catch (\Throwable $th) {
                    $pdf->Text(184,60, $mileage);
                }

                $pdf->Text(116,60, $transmission);

                $pdf->Text(141,60, $fuel);

                $pdf->Text(19,94, $broken_component);

                if($device_manufacturer == null || $component_number == null) {
                    $pdf->Text(111,94, $device_manufacturer . " ". $component_number);
                } else {
                    $pdf->Text(111,94, $device_manufacturer . " / ". $component_number);
                }
               
                $pdf->SetXY(20,180);
                $pdf->MultiCell(175,4, $error_message);

                $pdf->SetXY(20,255);
                $pdf->MultiCell(175,4, $error_message_cache);

                $pdf->SetFont("Arial", "", 16);
                if($from_car == "yes") {
                    $pdf->Text(20.3,111.8, "X");
                } else if($from_car != "yes") {
                    $pdf->Text(20.3,117.5, "X");
                }

                $pdf->SetFont("Arial", "", 16);
                if($opend == "yes") {
                    $pdf->Text(20.3,135, "X");
                } else if($opend != "yes") {
                    $pdf->Text(20.3,140.5, "X");
                }
                
                $pdf->SetFont("Arial", "", 11);

                $test = new BarcodeGeneratorPNG();
                file_put_contents('barcode.png', $test->getBarcode($id->process_id, $test::TYPE_CODE_128));
                $pdf->Image('barcode.png', 20, 280, 40);
                $pdf->text( 20, 293, $id->process_id);

            }
            
            if($i == 3) {
                $firstname                      = $req->input("firstname");
                $firstname                      = $req->input("firstname");
                $lastname                       = $req->input("lastname");
                $company_name                   = $req->input("company_name");
                $home_street                    = $req->input("home_street");
                $home_street_number             = $req->input("home_street_number");
                $home_zipcode                   = $req->input("home_zipcode");
                $home_city                      = $req->input("home_city");
                $mobil_number                   = $req->input("mobil_number");
                $phone_number                   = $req->input("phone_number");
                $email                          = $req->input("email");
                $payment_type                   = $req->input("payment_type");
                $shipping_type                  = $req->input("shipping_type");
                $current_date                   = date('d.m.Y');

                $send_back_company_name         = $req->input("send_back_company_name");
                $send_back_firstname            = $req->input("send_back_firstname");
                $send_back_lastname             = $req->input("send_back_lastname");
                $send_back_street               = $req->input("send_back_street");
                $send_back_street_number        = $req->input("send_back_street_number");
                $send_back_zipcode              = $req->input("send_back_zipcode");
                $send_back_city                 = $req->input("send_back_city");
                
                if($company_name == null) {
                    $pdf->Text(19, 63, $firstname . " ". $lastname);
                } else {
                    $pdf->Text(19, 63, $company_name. ", " . $firstname . " ". $lastname);
                }

                if($send_back_company_name == null) {
                    $pdf->Text(110,63, iconv('UTF-8', 'ISO-8859-1', $send_back_firstname . " ". $send_back_lastname));
                } else {
                    $pdf->Text(110,63, iconv('UTF-8', 'ISO-8859-1', $send_back_company_name. ", " . $send_back_firstname . " ". $send_back_lastname));
                }
                

                $pdf->Text(19,71,iconv('UTF-8', 'ISO-8859-1', $home_street. ". ". $home_street_number));

                if($send_back_street != null) {
                    $pdf->Text(110,71,iconv('UTF-8', 'ISO-8859-1', $send_back_street. ". ". $send_back_street_number));
                }

                $pdf->Text(19,80,iconv('UTF-8', 'ISO-8859-1', $home_zipcode. ", ". $home_city));

                if($send_back_city != null) {
                    $pdf->Text(110,80,iconv('UTF-8', 'ISO-8859-1', $send_back_zipcode. ", ". $send_back_city));
                }

                if($mobil_number == null || $phone_number == null) {
                    $pdf->Text(19,87,iconv('UTF-8', 'ISO-8859-1', $mobil_number. " ". $phone_number));
                } else {
                    $pdf->Text(19,87,iconv('UTF-8', 'ISO-8859-1', $mobil_number. ", ". $phone_number));
                }

                $pdf->Text(19,104,iconv('UTF-8', 'ISO-8859-1', $email));
                
                if($payment_type == "transfer") {
                    $pdf->Text(20.8,119.3,iconv('UTF-8', 'ISO-8859-1', "X"));
                } else if($payment_type == "nachnahme") {
                    $pdf->Text(77.7,119.3,iconv('UTF-8', 'ISO-8859-1', "X"));
                } else if($payment_type == "cash") {
                    $pdf->Text(135.4,119.3,iconv('UTF-8', 'ISO-8859-1', "X"));
                }

                if($shipping_type == "standard") {
                    $pdf->Text(20.9,137.5,iconv('UTF-8', 'ISO-8859-1', "X"));
                } else if($shipping_type == "express") {
                    $pdf->Text(77.5,137.5,iconv('UTF-8', 'ISO-8859-1', "X"));
                } else if($shipping_type == "pickup") {
                    $pdf->Text(77.5,137.5,iconv('UTF-8', 'ISO-8859-1', "X"));
                } else if($shipping_type == "samstagszustellung") {
                    $pdf->Text(134.8,137.5,iconv('UTF-8', 'ISO-8859-1', "X"));
                }
                $pdf->Text(18,266,iconv('UTF-8', 'ISO-8859-1', $current_date));

                $test = new BarcodeGeneratorPNG();
                file_put_contents('barcode.png', $test->getBarcode($id->process_id, $test::TYPE_CODE_128));
                $pdf->Image('barcode.png', 20, 280, 40);
                $pdf->text( 20, 293, $id->process_id);
            }
            
        }

        $path = public_path('files/aufträge/'. $id->process_id);
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
    
        }
        
        $pdfData = $pdf->Output('files/aufträge/'. $id->process_id . '/' .$id->process_id. '-contract.pdf','F');

        $file = new ModelsFile();
        $file->process_id = $id->process_id;
        $file->filename = $id->process_id. '-contract.pdf';
        $file->description = "Erstvergleich";
        $file->type = "Auftragsdokumente";
        $file->employee = $req->session()->get("username");
        $file->save();

        Mail::to($id->email)->send(new repair_contract($id,null, $id->process_id));


       

    }

    function phone_new_message(Request $req, $id) {

        $lead                           = new_leads_person_data::where("process_id", $id)->first();

        $phone_message                  = new phone_history();
        $phone_message->process_id      = $id;
        $phone_message->message         = $req->input("message");
        $phone_message->lead_name       = $lead->firstname. " ". $lead->lastname;
        $phone_message->employee        = "1"; #$req->session()->get("mitarbeiter_id");
        $phone_message->save();

        return redirect()->back();

    }

    function phoneNewMessageOrder(Request $req, $id) {
        $lead                           = active_orders_person_data::where("process_id", $id)->first();

        $phone_message                  = new phone_history();
        $phone_message->process_id      = $id;
        $phone_message->message         = $req->input("message");
        $phone_message->lead_name       = $lead->firstname. " ". $lead->lastname;
        $phone_message->employee        = "1"; #$req->session()->get("mitarbeiter_id");
        $phone_message->save();

        return redirect()->back();
    }

    function moveto_orders(Request $req, $id) {
        
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
        $active_order_person->employee                              = auth()->user()->id;
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
        $active_order_person->kunden_id                          = $lead_person->kunden_id;
        $active_order_person->pricemwst = "";
        $active_order_person->submit_type = "";

        $active_order_person->save();

        $lead_person->delete();

        $lead_car               = new_leads_car_data::where("process_id", $id)->first();
       if($lead_car != null) {
         #NEW CAR
         $car                             = new active_orders_car_data();
         $car->process_id                 = $lead_car->process_id;
         $car->car_company                = $lead_car->car_company;
         $car->car_model                  = $lead_car->car_model;
         $car->production_year            = $lead_car->production_year;
         $car->car_identification_number  = $lead_car->car_identification_number;
         $car->car_power                  = $lead_car->car_power;
         $car->mileage                    = $lead_car->mileage;
         $car->transmission               = $lead_car->transmission;
         $car->fuel_type                  = $lead_car->fuel_type;
         $car->broken_component           = $lead_car->broken_component;
         $car->device_manufacturer        = $lead_car->device_manufacturer;
         $car->from_car                   = $lead_car->from_car;
         $car->error_message              = $lead_car->error_message;
         $car->device_partnumber          = $lead_car->device_partnumber;
         $car->component_company          = $lead_car->component_company;
         $car->component_number           = $lead_car->component_number;
         $car->error_message_cache        = $lead_car->car_cache;

         $car->save();

       }

        $konto = new kundenkonto();
        $konto->kundenid = $lead_person->kunden_id;
        $konto->guthabennetto = 0;
        $konto->guthabenbrutto = 0;
        $konto->process_id = $lead_person->process_id;
        $konto->save();

        return $this->active_orders_view($req, $lead_person->process_id);
    }

    function moveto_leads(Request $req, $id) {
        
        $lead_person            = active_orders_person_data::where("process_id", $id)->first();
        $active_order_person    = new new_leads_person_data();
        
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
        $active_order_person->kunden_id                          = $lead_person->kunden_id;       

        $active_order_person->save();

        active_orders_person_data::where('process_id', $id)->delete();
        
        $lead_car               = active_orders_car_data::where("process_id", $id)->first();
        #NEW CAR
        if($lead_car != null) {
            $car                             = new new_leads_car_data();
        $car->process_id                 = $lead_car->process_id;
        $car->car_company                = $lead_car->car_company;
        $car->car_model                  = $lead_car->car_model;
        $car->production_year            = $lead_car->production_year;
        $car->car_identification_number  = $lead_car->car_identification_number;
        $car->car_power                  = $lead_car->car_power;
        $car->mileage                    = $lead_car->mileage;
        $car->transmission               = $lead_car->transmission;
        $car->fuel_type                  = $lead_car->fuel_type;
        $car->broken_component           = $lead_car->broken_component;
        $car->device_manufacturer        = $lead_car->device_manufacturer;
        $car->from_car                   = $lead_car->from_car;
        $car->error_message              = $lead_car->error_message;
        $car->device_partnumber          = $lead_car->device_partnumber;
        $car->component_company          = $lead_car->component_company;
        $car->component_number           = $lead_car->component_number;
        $car->error_message_cache        = $lead_car->car_cache;
        }

        active_orders_car_data::where('process_id', $id)->delete();

        return $this->interessentenView($req, $id);
    }
    public function active_orders_view(Request $req, $id = null) {
        
        $person = active_orders_person_data::with("statuse.statuseMain")
                                            ->with("workflow")
                                            ->with("warenausgang")
                                            ->with("intern")
                                            ->with("activeOrdersCarData")
                                            ->with("userTracking.trackings.code.bezeichnungCustom")
                                            ->with("rechnungen.zahlungen")
                                            ->with("einkäufe")
                                            ->with("user")
                                            ->with("deviceData")
                                            ->with("zuweisung")
                                            ->get();
        
        $users = user::all();
        $email = emailinbox::where("read_at", null)->first();
        $allStats = statuse::all();
        $hinweise = hinweis::where("area", "Auftragsübersicht")->get();

        $hilfscodes = device_orders::where("status", "Hilfsbarcode")->get();

        if($id != null) {
            return view("forEmployees/orders/main")
                ->with("active_orders", $person)
                ->with("allStats", $allStats)
                ->with("users", $users)
                ->with("emailRead", $email)
                ->with("hinweise", $hinweise)
                ->with("hilfscodes", $hilfscodes)
                ->with("changeOrder", $id);
        } else {
            return view("forEmployees/orders/main")
                ->with("active_orders", $person)
                ->with("allStats", $allStats)
                ->with("users", $users)
                ->with("emailRead", $email)
                ->with("hinweise", $hinweise)
                ->with("hilfscodes", $hilfscodes);

        }
    }

    public function getOrderNewTab(Request $req, $id) {
        return $this->active_orders_view($req, $id);
    }

    public function getCustomTracking(Request $req, $id) {
        $trackingOrder = $id;
        $trackings = user_tracking::where("process_id", $id)->with("trackings.code")->get();

        
        return view('livewire.custom-tracking')->with("trackings", $trackings)->with("trackingOrder", $trackingOrder);
    }

    public function active_orders_viewTracking(Request $req, $id) {

        $person = active_orders_person_data::with("statuse")->with("activeOrdersCarData")->with("userTracking")->with("files")->get();
        $statuses = statuse::all();
        $users = user::all();
        $email = emailinbox::where("read_at", null)->get();
        $allStats = statuse::all();
        $hilfscodes = device_orders::where("status", "Hilfsbarcode")->get();
        $codes = versand_statuscode::all();
        $einkäufe = einkauf::all();

        
        return view("forEmployees/orders/main")
                ->with("active_orders", $person)
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("emailRead", $email)
                ->with("tracking", $id)
                ->with("hilfscodes", $hilfscodes)
                ->with("codes", $codes)
                ->with("einkäufe", $einkäufe);


    }

    public function active_leads_viewTracking(Request $req, $id) {

        $orders = new_leads_person_data::with("statuse")->with("newLeadsCarData")->with("userTracking.trackings")->with("files")->with("callbacks")->get();
        $statuses = statuse::all();
        $users = user::all();
        $email = emailinbox::where("read_at", null)->get();
        $allStats = statuse::all();
        $hilfscodes = device_orders::where("status", "Hilfsbarcode")->get();
        $codes = versand_statuscode::all();
        $einkäufe = einkauf::all();
        $konvertLeads = 0;
        foreach($orders as $order) {
            $status = status_histori::where("process_id", $order->process_id)->where("last_status", "36")->first();
            if($status == null) {
                $konvertLeads++;
            }
        }
        
        
        return view("forEmployees/interessenten/main")
                ->with("leads", $orders)
                ->with("orders", $orders)
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("emailRead", $email)
                ->with("tracking", $id)
                ->with("hilfscodes", $hilfscodes)
                ->with("codes", $codes)
                ->with("einkäufe", $einkäufe)
                ->with("konvertLeads", $konvertLeads);


    }
    public function active_orders_viewa(Request $req) {
       
       
        $person = active_orders_person_data::with("statuse")->with("activeOrdersCarData")->with("files")->get();
        $statuses = statuse::all();
        $users = user::all();
        $email = emailinbox::where("read_at", null)->get();
        $allStats = statuse::all();
        
        return view("forEmployees/orders/main")
                ->with("active_orders", $person)
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("emailRead", $email);
    }

    public function sortArchivOrdersMain(Request $req, $type, $sort) {

        $person = active_orders_person_data::with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->where("archiv", true)->get();

        if($sort == "up") {
            $sorting = "up";
            $person = $person->sortBy($type);
        } else {
            $sorting = "down";
            $person = $person->sortByDesc($type);
        }

        $statuses = statuse::all();
        $users = user::all();
        $email = emailinbox::where("read_at", null)->get();
        $allStats = statuse::all();
        $einkäufe = einkauf::all();

        return view("forEmployees/orders/archiv")
                ->with("active_orders", $person)
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("emailRead", $email)
                ->with("sorting", $type. "-" . $sort)
                ->with("einkäufe", $einkäufe);

    }

    public function sortActivOrdersMain(Request $req, $type, $sort) {

        $person = active_orders_person_data::with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->get();

        if($sort == "up") {
            $sorting = "up";
            $person = $person->sortBy($type);
        } else {
            $sorting = "down";
            $person = $person->sortByDesc($type);
        }

        $statuses = statuse::all();
        $users = user::all();
        $email = emailinbox::where("read_at", null)->get();
        $allStats = statuse::all();
        $einkäufe = einkauf::all();

        return view("forEmployees/orders/main")
                ->with("active_orders", $person)
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("emailRead", $email)
                ->with("sorting", $type. "-" . $sort)
                ->with("einkäufe", $einkäufe);

    }

    public function new_order_view(Request $req) {
        return view("forMitarbeiter/neuer-auftrag");
    }

    public function createKundeId() {

        $id = random_int(1000,9999);

        $order = active_orders_person_data::where("kunden_id", $id)->first();
        if($order == null) {
            $order = new_leads_person_data::where("kunden_id", $id)->first();
        }
        if($order == null) {
            return $id;
        } else {
            $this->createKundenId();
        }

    }

    public function add_new_order(Request $req, $production_id = null) {
        if($production_id == null) {
            $production_id              = $this->createProductionId();
        }

        $anrede                     = $req->input("gender");
        
        if($req->input("kunden_id") == null || $req->input("kunden_id") == "") {
            $kunden_id = $this->createKundeId();
        } else {
            $kunden_id                  = $req->input("kunden_id");
        }

        $company_name               = $req->input("companyname");
        $home_fax                   = $req->input("home_fax");
        $send_back_fax              = $req->input("send_back_fax");
        $employee                   = Auth::user()->username;
        $firstname                  = $req->input("firstname");
        $zipcode                    = $req->input("home_zipcode");
        $lastname                   = $req->input("lastname");
        $email                      = $req->input("email");
        $telefon                    = $req->input("phone_number");
        $mobil                      = $req->input("mobil_number");
        $straße                     = $req->input("home_street");
        $straßennummer              = $req->input("home_street_number");
        $stadt                      = $req->input("home_city");
        $land                       = $req->input("home_country");
        $send_back_company_name     = $req->input("send_back_company_name");
        $send_back_salutation       = $req->input("send_back_salutation");
        $send_back_firstname        = $req->input("send_back_firstname");
        $send_back_lastname         = $req->input("send_back_lastname");
        $send_back_street           = $req->input("send_back_street");
        $send_back_street_number    = $req->input("send_back_street_number");
        $send_back_zipcode          = $req->input("send_back_zipcode");
        $send_back_city             = $req->input("send_back_city");
        $pricemwst                  = $req->input("pricemwst");
        $shipping_type              = $req->input("shipping_type");
        $payment_type               = $req->input("payment_type");
        $send_back_country          = $req->input("send_back_country");
        $submit_type                = "intern";
        $tofax                      = $req->input("email_type");

        $car_company                = $req->input("car_company");
        $car_model                  = $req->input("car_model");
        $production_year            = $req->input("production_year");
        $car_identification_number  = $req->input("car_identification_number");
        $car_power                  = $req->input("car_power");
        $mileage                    = $req->input("mileage");
        $transmission               = $req->input("transmission");
        $fuel_type                  = $req->input("fuel_type");
        $broken_component           = $req->input("broken_component");
        $device_manufacturer        = $req->input("device_manufacturer");
        $from_car                   = $req->input("from_car");
        $opend                      = $req->input("opend");
        $error_message              = $req->input("error_message");
        $device_partnumber          = $req->input("device_partnumber");
        $component_company          = $req->input("component_company");
        $component_number           = $req->input("component_number");
        $car_cache                  = $req->input("error_message_cache");

        $files                      = $req->file("filee");

        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "broken_component-")) {
                $id = explode("-", $key)[1];
                $dev = new devicedata();
                $dev->process_id = $production_id;
                $dev->component = $item;
                $dev->company = $req->input("device_manufacturer-$id");
                $dev->partnumber = $req->input("device_partnumber-$id");
                $dev->opend = $req->input("opend-$id");
                $dev->from_car = $req->input("from_car-$id");
                $dev->save();
            }
        }
        
        if($files != null) {
            $this->upload_files($files, $production_id);
        }

        $konto = new kontoModel();
        $konto->process_id      = $production_id;
        $konto->kundenid        = $kunden_id;
        $konto->guthabenbrutto  = "0";
        $konto->guthabennetto   = "0";
        $konto->save();

        $person                           = new active_orders_person_data();
        $person->kunden_id                  = $kunden_id;
        $person->send_back_company_name               = $send_back_company_name;
        $person->send_back_gender             = $send_back_salutation;
        $person->send_back_firstname               = $send_back_firstname;
        $person->send_back_lastname               = $send_back_lastname;
        $person->send_back_zipcode               = $send_back_zipcode;
        $person->send_back_street               = $send_back_street;
        $person->send_back_street_number               = $send_back_street_number;
        $person->send_back_city               = $send_back_city;
        $person->send_back_country               = $send_back_country;
        $person->process_id               = $production_id;
        $person->gender               = $anrede;
        $person->employee               = auth()->user()->id;
        $person->company_name             = $company_name;
        $person->firstname                = $firstname;
        $person->lastname                 = $lastname;
        $person->email                    = $email;
        $person->phone_number             = $telefon;
        $person->mobile_number            = $mobil;
        $person->home_street              = $straße;
        $person->home_street_number       = $straßennummer;
        $person->home_zipcode             = $zipcode;
        $person->home_city                = $stadt;
        $person->home_country                = $land;
        $person->pricemwst             = "12";
        $person->shipping_type             = $shipping_type;
        $person->payment_type             = $payment_type;
        $person->submit_type             = $submit_type;
        $person->zuteilung                             = 0;
        $person->last_payment                          = 0;

        $person->save();

        #NEW CAR
        $car                             = new active_orders_car_data();
        $car->process_id                 = $production_id;
        $car->car_company                = $car_company;
        $car->car_model                  = $car_model;
        $car->production_year            = $production_year;
        $car->car_identification_number  = $car_identification_number;
        $car->car_power                  = $car_power;
        $car->mileage                    = $mileage;
        $car->transmission               = $transmission;
        $car->fuel_type                  = $fuel_type;
        $car->broken_component           = $broken_component;
        $car->device_manufacturer        = $device_manufacturer;
        $car->from_car                   = $from_car;
        $car->error_message              = $error_message;
        $car->device_partnumber          = $device_partnumber;
        $car->component_company          = $component_company;
        $car->component_number           = $component_number;
        $car->error_message_cache        = $car_cache;
        $car->opend                      = $req->input("opend");
        $car->save();

        #MASTER ORDER ID
        $order_id = new order_id();
        $order_id->process_id                                   = $production_id;
        $order_id->kunden_id                                    = $lastname. "-" .$firstname;
        $order_id->save();

        $order_p    = active_orders_person_data::where("process_id", $production_id)->first();
        if($tofax != "none") {
            if($tofax == "fax") {
                $this->sendFaxContract($req, $order_p, $production_id);
                } else {
                    $this->send_repair_contract($req, $order_p);
                }
        }

        $status = new status_histori();
        $status->process_id = $production_id;
        $status->last_status = 36;
        $status->changed_employee = auth()->user()->id;
        $status->save();

        return $this->active_orders_view($req, $production_id);

    }
    public function add_new_interessenten(Request $req) {
        $production_id              = $this->createProductionId();
        $anrede                     = $req->input("gender");
        
        if($req->input("kunden_id") == null || $req->input("kunden_id") == "") {
            $kunden_id = $this->createKundeId();
        } else {
            $kunden_id                  = $req->input("kunden_id");
        }

        $kundenkonto                    = new kundenkonto();
        $kundenkonto->kundenid          = $kunden_id;
        $kundenkonto->guthabennetto     = 0;
        $kundenkonto->guthabenbrutto    = 0;
        $kundenkonto->process_id        = $production_id;
        $kundenkonto->save();

        $company_name               = $req->input("companyname");
        $home_fax                   = $req->input("home_fax");
        $send_back_fax              = $req->input("send_back_fax");
        $employee                   = Auth::user()->username;
        $firstname                  = $req->input("firstname");
        $zipcode                    = $req->input("home_zipcode");
        $lastname                   = $req->input("lastname");
        $email                      = $req->input("email");
        $telefon                    = $req->input("phone_number");
        $mobil                      = $req->input("mobil_number");
        $straße                     = $req->input("home_street");
        $straßennummer              = $req->input("home_street_number");
        $stadt                      = $req->input("home_city");
        $land                       = $req->input("home_country");
        $send_back_company_name     = $req->input("send_back_company_name");
        $send_back_salutation       = $req->input("send_back_salutation");
        $send_back_firstname        = $req->input("send_back_firstname");
        $send_back_lastname         = $req->input("send_back_lastname");
        $send_back_street           = $req->input("send_back_street");
        $send_back_street_number    = $req->input("send_back_street_number");
        $send_back_zipcode          = $req->input("send_back_zipcode");
        $send_back_city             = $req->input("send_back_city");
        $pricemwst                  = $req->input("pricemwst");
        $shipping_type              = $req->input("shipping_type");
        $payment_type               = $req->input("payment_type");
        $send_back_country          = $req->input("send_back_country");
        $submit_type                = "intern";
        $tofax                      = $req->input("email_type");

        $car_company                = $req->input("car_company");
        $car_model                  = $req->input("car_model");
        $production_year            = $req->input("production_year");
        $car_identification_number  = $req->input("car_identification_number");
        $car_power                  = $req->input("car_power");
        $mileage                    = $req->input("mileage");
        $transmission               = $req->input("transmission");
        $fuel_type                  = $req->input("fuel_type");
        $broken_component           = $req->input("broken_component");
        $device_manufacturer        = $req->input("device_manufacturer");
        $from_car                   = $req->input("from_car");
        $opend                      = $req->input("opend");
        $error_message              = $req->input("error_message");
        $device_partnumber          = $req->input("device_partnumber");
        $component_company          = $req->input("component_company");
        $component_number           = $req->input("component_number");
        $car_cache                  = $req->input("error_message_cache");

        $files                      = $req->file("filee");
        
        if($files != null) {
            $this->upload_files($files, $production_id);
        }

        $person                           = new new_leads_person_data();
        $person->kunden_id                  = $kunden_id;
        $person->send_back_company_name               = $send_back_company_name;
        $person->send_back_gender             = $send_back_salutation;
        $person->send_back_firstname               = $send_back_firstname;
        $person->send_back_lastname               = $send_back_lastname;
        $person->send_back_zipcode               = $send_back_zipcode;
        $person->send_back_street               = $send_back_street;
        $person->send_back_street_number               = $send_back_street_number;
        $person->send_back_city               = $send_back_city;
        $person->send_back_country               = $send_back_country;
        $person->process_id               = $production_id;
        $person->gender               = $anrede;
        $person->employee               = $employee;
        $person->company_name             = $company_name;
        $person->firstname                = $firstname;
        $person->lastname                 = $lastname;
        $person->email                    = $email;
        $person->phone_number             = $telefon;
        $person->mobile_number            = $mobil;
        $person->home_street              = $straße;
        $person->home_street_number       = $straßennummer;
        $person->home_zipcode             = $zipcode;
        $person->home_city                = $stadt;
        $person->home_country                = $land;
        $person->pricemwst             = "12";
        $person->shipping_type             = $shipping_type;
        $person->payment_type             = $payment_type;
        $person->submit_type             = $submit_type;
        $person->zuteilung                             = 0;
        $person->last_payment                          = 0;
        $person->save();

        #NEW CAR
        $car                             = new new_leads_car_data();
        $car->process_id                 = $production_id;
        $car->car_company                = $car_company;
        $car->car_model                  = $car_model;
        $car->production_year            = $production_year;
        $car->car_identification_number  = $car_identification_number;
        $car->car_power                  = $car_power;
        $car->mileage                    = $mileage;
        $car->transmission               = $transmission;
        $car->fuel_type                  = $fuel_type;
        $car->broken_component           = $broken_component;
        $car->device_manufacturer        = $device_manufacturer;
        $car->from_car                   = $from_car;
        $car->error_message              = $error_message;
        $car->device_partnumber          = $device_partnumber;
        $car->component_company          = $component_company;
        $car->component_number           = $component_number;
        $car->error_message_cache        = $car_cache;
        $car->opend                      = $req->input("opend");
        $car->save();

        $order_p    = new_leads_person_data::where("process_id", $production_id)->first();
        
        if($tofax == "fax") {
            $this->sendFaxContract($req, $order_p, $production_id);
            } else {
                $this->send_repair_contract($req, $order_p);
            }
    
        
        $status = new status_histori();
        $status->process_id = $production_id;
        $status->last_status = "36";
        $status->changed_employee = auth()->user()->id;
        $status->save();

        return $this->interessentenView($req, $production_id);

    }

    public function sendFaxContract(Request $req, $lead, $id) {
        $pdf = new Fpdi(); 
        

        // set the source file
        $pdf->setSourceFile(public_path("/"). "pdf/turbolader-reparatur_auftrag_pdf.pdf");

        for ($i=1; $i < 4; $i++) {
            $pdf->AddPage();
            $tplId = $pdf->importPage($i);
            $pdf->useTemplate($tplId); 
            if($i == 1) {
                 // The new content
                $fontSize = '15';
                


                //set the font, colour and text to the page.
                $pdf->SetFont("Arial", "B", 20);
                $pdf->SetTextColor(26, 105, 196);
                $pdf->Cell(100,100, "Ihre Vorgangsnummer: ". $lead->process_id);

                //see the results
                
            }

            if($i == 2) {
                $car_company                    = $req->input("car_company");
                $car_model                      = $req->input("car_model");
                $car_identification_number      = $req->input("car_identification_number");
                $car_power                      = $req->input("car_power");
                $mileage                        = $req->input("mileage");
                $transmission                   = $req->input("transmission");
                $broken_component               = $req->input("broken_component");
                if($broken_component != null) {
                    $component_name             = component_name::where("id", $broken_component)->first();
                    if(!isset($component_name->name)) {
                        $broken_component           = "";
                    } else {
                        $broken_component           = $component_name->name;
                    }
                }
                $component_number               = $req->input("component_number");
                $error_message                  = $req->input("error_message");
                $error_message_cache            = $req->input("error_message_cache");
                $from_car                       = $req->input("from_car");

                if($transmission == "circuit") {
                    $transmission = "Schaltung";
                }
                if($transmission == "automatic") {
                    $transmission = "Automatik";
                }



                
                $pdf->SetFont("Arial", "B", 12);
                $pdf->SetTextColor(26, 105, 196);
                $pdf->Text(20,59, $car_company);

                $pdf->Text(111,59, $car_model);

                $pdf->Text(20,68, $car_identification_number);

                $pdf->Text(111,68, $car_power);
                
                $pdf->Text(20,77, $mileage);

                $pdf->Text(20,86, $transmission);

                $pdf->Text(20,110, $broken_component);

                $pdf->Text(111,110, $component_number);

                $pdf->SetXY(20,159);
                $pdf->MultiCell(175,4, $error_message);

                $pdf->SetXY(20,215);
                $pdf->MultiCell(175,4, $error_message_cache);

                $pdf->SetFont("Arial", "B", 16);
                if($from_car == "yes") {
                    $pdf->Text(20,252, "X");
                } else if($from_car == "no") {
                    $pdf->Text(98,252, "X");
                }
                
                $pdf->SetFont("Arial", "B", 12);
            }
            
            if($i == 3) {
                $firstname                      = $req->input("firstname");
                $firstname                      = $req->input("firstname");
                $lastname                       = $req->input("lastname");
                $company_name                   = $req->input("company_name");
                $home_street                    = $req->input("home_street");
                $home_street_number             = $req->input("home_street_number");
                $home_zipcode                   = $req->input("home_zipcode");
                $home_city                      = $req->input("home_city");
                $mobil_number                   = $req->input("mobil_number");
                $phone_number                   = $req->input("phone_number");
                $email                          = $req->input("email");
                $payment_type                   = $req->input("payment_type");
                $shipping_type                  = $req->input("shipping_type");
                $current_date                   = date('d.m.Y');

                $send_back_company_name         = $req->input("send_back_company_name");
                $send_back_firstname            = $req->input("send_back_firstname");
                $send_back_lastname             = $req->input("send_back_lastname");
                $send_back_street               = $req->input("send_back_street");
                $send_back_street_number        = $req->input("send_back_street_number");
                $send_back_zipcode              = $req->input("send_back_zipcode");
                $send_back_city                 = $req->input("send_back_city");
                

                $pdf->Text(20,58, $company_name. ", " . $firstname . " ". $lastname);
                
                $pdf->Text(110,58, iconv('UTF-8', 'ISO-8859-1', $send_back_company_name. ", " . $send_back_firstname . " ". $send_back_lastname));

                $pdf->Text(20,67,iconv('UTF-8', 'ISO-8859-1', $home_street. ". ". $home_street_number));

                $pdf->Text(110,67,iconv('UTF-8', 'ISO-8859-1', $send_back_street. ". ". $send_back_street_number));

                $pdf->Text(20,75,iconv('UTF-8', 'ISO-8859-1', $home_zipcode. ", ". $home_city));

                $pdf->Text(110,75,iconv('UTF-8', 'ISO-8859-1', $send_back_zipcode. ", ". $send_back_city));

                $pdf->Text(20,83,iconv('UTF-8', 'ISO-8859-1', $mobil_number. ", ". $phone_number));

                $pdf->Text(20,99,iconv('UTF-8', 'ISO-8859-1', $email));
                
                if($payment_type == "transaction") {
                    $pdf->Text(21,118,iconv('UTF-8', 'ISO-8859-1', "X"));
                } else if($payment_type == "nachnahme") {
                    $pdf->Text(72,118,iconv('UTF-8', 'ISO-8859-1', "X"));
                } else if($payment_type == "cash") {
                    $pdf->Text(135,118,iconv('UTF-8', 'ISO-8859-1', "X"));
                }

                if($shipping_type == "standard") {
                    $pdf->Text(21,137,iconv('UTF-8', 'ISO-8859-1', "X"));
                } else if($shipping_type == "express") {
                    $pdf->Text(77,137,iconv('UTF-8', 'ISO-8859-1', "X"));
                } else if($shipping_type == "pickup") {
                    $pdf->Text(135,118,iconv('UTF-8', 'ISO-8859-1', "X"));
                } else if($shipping_type == "samstagszustellung") {
                    $pdf->Text(135,137,iconv('UTF-8', 'ISO-8859-1', "X"));
                }
                $pdf->Text(30,267,iconv('UTF-8', 'ISO-8859-1', $current_date));
            }
            
        }

        $path = public_path('files/aufträge/'. $lead->process_id);
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
    
        }

        $pdfData = $pdf->Output('files/aufträge/'.$lead->process_id . '/' .$lead->process_id. '-contract.pdf','F');
        Mail::to("gzamotors@alltofax.de")->send(new repair_contract($lead, $email, $id));

    }
    
    
    public function change_order_view(Request $req, $id) {
        
        $lead_person                = active_orders_person_data::where("process_id", $id)->first();

        $lead_history               = status_histori::where("process_id", $id)->
                                            latest('updated_at')->first();

        $lead_historys              = status_histori::where("process_id", $id)->
                                            latest('updated_at')->get();
                                            
        $lead_car                   = active_orders_car_data::where("process_id", $id)->first();

        $employee_created_lead      = employee::where("id", $lead_person->employee)->first();

        $employee_last_changed      = employee::where("id", $lead_history->changed_employee)->first();

        $statuses                   = statuse::where("type", 1)->get();

        $order_id                   = order_id::where("process_id", $lead_person->process_id)->first();

        $dir_files                  = ModelsFile::where("process_id", $lead_person->process_id)->get();

        $employees                  = employee::all();

        $email_templates            = email_template::all();
        
        $device_orders              = device_orders::with("shelfe")->
                                        with("newLeadsPersonData")->
                                        with("componentName")->where("process_id", $lead_person->process_id)->get();

        $phone_history              = phone_history::where("process_id", $lead_person->process_id)->get();
        
        $auftraghistoy              = orderhistory_message::where("process_id", $lead_person->process_id)->latest()->get();

        $booking                    = booking::where("process_id", $lead_person->process_id)->orderBy('created_at', 'desc')->first();

        $intern                     = intern_admin::where("process_id", $lead_person->process_id)->first();
        
        $shelfes                    = shelfe::all();

        $countries                  = countrie::all();

        $primary_device             = primary_device::where("process_id", $lead_person->process_id)->first();
            
        $wareneingang               = wareneingang::where("process_id", $lead_person->process_id)->get();
        $intern_                    = intern::where("process_id", $lead_person->process_id)->get();
        $warenausgang               = warenausgang::where("process_id", $lead_person->process_id)->get();


        
        $bpz                        = bpzfile::all();

        
        return response()->view("forMitarbeiter/orders-change-view", ["lead" => $lead_person,
        "lead" => $lead_person,
        "employee_created_lead" => $employee_created_lead,
        "employee_last_changed" => $employee_last_changed,
        "order_id" => $order_id,
        "device_orders" => $device_orders,
        "lead_car" => $lead_car,
        "files" => $dir_files,
        "statuses" => $statuses,
        "status_historys" => $lead_historys,
        "status_history_lead" => $lead_history,
        "employees" => $employees,
        "email_templates" => $email_templates,
        "phone_historys" => $phone_history,
        "auftragshistory" => $auftraghistoy,
        "booking" => $booking,
        "shelfes" => $shelfes,
        "booking_open_sum" => $booking,
        "primary_device" => $primary_device,
        "intern" => $intern,
        "countries" => $countries,
        "wareneingang" => $wareneingang,
        "intern_" => $intern_,
        "warenausgang" => $warenausgang,
        "bpz" => $bpz,]);

        
    }



    public function new_booking(Request $req, $id) {

        $standard           = 5.59;
        $express            = 8.95;
        $international      = 15;
        $pickup             = 0;

        $nachnahme          = 8;
        $tranfser           = 0;
        $cash               = 0;

        $samstagszusl       = 8.30;

        $purpose            = $req->input("intern_radio_purpose");
        $shipping_type      = $req->input("radio_shipping");
        $free_shipping      = $req->input("shipping_free");
        $payment_type       = $req->input("radio_payment");
        $free_payment       = $req->input("payment_free");
        $mwst               = $req->input("mwst");
        $samstagszuschlag   = $req->input("intern_radio_saturday");
        $br_nt              = $req->input("intern_radio_paying");

        $total_sum          = $req->input("intern_price_total");

        $db_booking         = booking::where("process_id", $id)->orderBy("created_at", "desc")->first();
        
        if($db_booking != null) {
            $db_booking_new     = new booking();
            if($free_shipping == 0) {
                if($shipping_type == "standard") {
                    $total_sum += $standard;
                } else if($shipping_type == "express") {
                    $total_sum += $express;
                } else if($shipping_type == "international") {
                    $total_sum += $international;
                } else if($shipping_type == "pickup") {
                    $total_sum += $pickup;
                }
            }
            
            if($free_payment != 1) {
                if($payment_type == "nachnahme") {
                    $total_sum += $nachnahme;
                }
            }

            if($samstagszuschlag == 1 || $samstagszuschlag == null) {
                $total_sum += $samstagszusl;
            }

            if($samstagszuschlag == 1 || $samstagszuschlag == null) {
                $total_sum += $samstagszusl;
            }

            if($total_sum != 0) {
                $mwst_brutto             = $db_booking->netto + $total_sum;
                $brutto                  = $mwst_brutto/100;
                $brr                     = $brutto*19;
                $brutoo                  = $mwst_brutto+$brr;
                $db_booking_new->brutto      = $brutoo;
                $db_booking_new->mwst_betrag     = $brr;
            } else {
                $mwst_brutto             = $br_nt;
                $brutto                  = $mwst_brutto/100;
                $brr                     = $brutto*19;
                $brutoo                  = $mwst_brutto+$brr;
                $db_booking_new->brutto      = $brutoo;
                $db_booking_new->mwst_betrag     = $brr;
            }
             
            $mwst_netto                 = $total_sum + $db_booking->netto;
            $db_booking_new->netto          = $mwst_netto;

            $db_booking_new->process_id     = $id;
            $db_booking_new->purpose        = $purpose;
            $db_booking_new->shipping_type  = $shipping_type;
            $db_booking_new->payment_type   = $payment_type;
            $db_booking_new->free_shipping  = $free_shipping;
            $db_booking_new->free_payment   = $free_payment;
            $db_booking_new->total_sum      = $total_sum;
            $db_booking_new->samstagszuschlag = $samstagszuschlag;
            $db_booking_new->mwst           = $mwst;
            
            $db_booking_new->open_sum       = $db_booking->open_sum += $brutoo;
            $db_booking_new->save();

            return redirect()->back();
        } else {
            $db_booking     = new booking();

          

            if($free_shipping == 0) {
                if($shipping_type == "standard") {
                    $total_sum += $standard;
                } else if($shipping_type == "express") {
                    $total_sum += $express;
                } else if($shipping_type == "international") {
                    $total_sum += $international;
                } else if($shipping_type == "pickup") {
                    $total_sum += $pickup;
                }
            }
            
            if($free_payment != 1) {
                if($payment_type == "nachnahme") {
                    $total_sum += $nachnahme;
                }
            }

            if($samstagszuschlag == 1 || $samstagszuschlag == null) {
                $total_sum += $samstagszusl;
            }

            if($samstagszuschlag == 1 || $samstagszuschlag == null) {
                $total_sum += $samstagszusl;
            }

            if($total_sum != 0) {
                $mwst_brutto             = $total_sum/100;
                $ad                      = $mwst_brutto*19;
                $db_booking->brutto      = $ad + $total_sum;
                $db_booking->mwst_betrag     = $ad;

            }
             
            $mwst_opensum               = $mwst/$total_sum;
            $mwst_netto                 = $total_sum;
            $db_booking->netto          = $mwst_netto;

            $db_booking->process_id     = $id;
            $db_booking->purpose        = $purpose;
            $db_booking->shipping_type  = $shipping_type;
            $db_booking->payment_type   = $payment_type;
            $db_booking->free_shipping  = $free_shipping;
            $db_booking->free_payment   = $free_payment;
            $db_booking->total_sum      = $total_sum;
            $db_booking->samstagszuschlag = $samstagszuschlag;
            $db_booking->mwst           = $mwst;
            
            $db_booking->open_sum       = $db_booking->open_sum += $total_sum;
            $db_booking->save();

            return redirect()->back();
        }

    }

    public function bookings_view(Request $req, $id) {
        $booking    = booking::where("process_id", $id)->orderBy("created_at", "desc")->get();
        return view("layouts/bookings")->with("bookings", $booking);
    }

    public function order_comarison(Request $req, $id) {
        $compare_price      = $req->input("intern_compare_price");
        
        $vergleich          = vergleichstext::where("id", $req->input("text"))->first();

        $pdf = new Fpdi(); 
        
        // set the source file
        $pdf->setSourceFile(public_path("/"). "pdf/Vergleichsvereinbarung.pdf");

        $person             = active_orders_person_data::where("process_id", $id)->first();

        for ($i=1; $i < 2; $i++) {
            $pdf->AddPage();
            $tplId = $pdf->importPage($i);
            $pdf->useTemplate($tplId); 
            if($i == 1) {
                 // The new content
                $fontSize = '15';
                


                //set the font, colour and text to the page.
                $pdf->SetFont("Arial", "", 9);
                $pdf->SetXY(17.4, 60);
                $pdf->MultiCell(175,4, $person->firstname. " ". $person->lastname);
                
                $pdf->SetXY(17.4, 64);
                $pdf->MultiCell(175,4, $person->home_street. " ". $person->home_street_number. ", ". $person->home_zipcode. " ". $person->home_city); 

                $pdf->SetFont("Arial", "B", 9);
                $pdf->SetXY(17.4, 115);
                $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1', $vergleich->text)); 

                $pdf->SetXY(17.4, 125);
                $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1', "- Der Vertragspartner zu 1) zahlt an den Vertragspartner zu 2) ein Betrag in Höhe von ". $compare_price ." Euro inkl. Mwst")); 
                //see the results
                
            }
           
        }
        $path = public_path('files/aufträge/'. $id);
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        $pdfData = $pdf->Output('files/aufträge/'. $id . '/' .$id. '-vergleich.pdf','F');
        $file               = new ModelsFile();
        $file->process_id   = $id;
        $file->filename     = $id. "-vergleich.pdf";
        $file->description  = "Vergleich";
        $file->type         = "Vergleich";
        $file->employee     = $req->session()->get("username");
        $file->save();

        return redirect()->back();

    }

    public function assign(Request $req, $id) {
        $assign_person           = $req->input("intern_allocation");
        $assign_info             = $req->input("intern_info");
        $intern_info             = $req->input("intern_note");
        $text_builds             = $req->input("intern_description");
        $tec_info                = $req->input("intern_text_module");

        $order                   = order_id::where("process_id", $id)->first();
        $order->zuteilung        = $assign_person;
        $order->assign_info      = $assign_info;
        $order->intern_info      = $intern_info;
        $order->text_builds      = $text_builds;
        $order->tec_info         = $tec_info;
        $order->update();
        return redirect()->back();
    }

    public function add_intern(Request $req, $id) {
        $prox_time                  = $req->input("intern_time");
        $result                    = $req->input("intern_text_module");
        $to_phonehistory            = $req->input("intern_to_history");
        $allowness_1                = $req->input("intern_acceptance_agreement_1");
        $verbal_contract            = $req->input("intern_verbal_contract");
        $verbal_partner             = $req->input("intern_conversation_partner");
        $shipping_after_payment     = $req->input("intern_shipping_after_paying");
        $release                    = $req->input("intern_release_price");
        $take_back_instruction      = $req->input("intern_redemption_instruction");
        $change_instruction         = $req->input("intern_exchange_instruction");
        $birthday                   = $req->input("intern_birthday");
        $allowness_2                = $req->input("intern_acceptance_agreement_2");
        $anrede                     = $req->input("gender");
        $company_name               = $req->input("companyname");
        $employee                   = $req->input("employee_name");
        $firstname                  = $req->input("firstname");
        $lastname                   = $req->input("lastname");
        $email                      = $req->input("email2");
        $telefon                    = $req->input("phonenumber2");
        $mobil                      = $req->input("mobilnumber2");
        $straße                     = $req->input("street");
        $straßennummer              = $req->input("streetno");
        $zipcode                    = $req->input("zipcode");
        $stadt                      = $req->input("city");
        $land                       = $req->input("country");
        $send_back_company_name     = $req->input("differing_companyname");
        $send_back_salutation       = $req->input("differing_gender");
        $send_back_firstname        = $req->input("differing_firstname");
        $send_back_lastname         = $req->input("differing_lastname");
        $send_back_street           = $req->input("differing_street");
        $send_back_street_number    = $req->input("differing_streetno");
        $send_back_zipcode          = $req->input("differing_zipcode");
        $send_back_city             = $req->input("differing_city");
        $send_back_country          = $req->input("differing_country");

        $intern_db                  = intern_admin::where("process_id", $id)->first();
        if($intern_db == null) {
            $intern                             = new intern_admin();
            $intern->process_id                 = $id;
            $intern->prox_time                  = $prox_time;
            $intern->result                     = $result;
            $intern->to_phonehistory            = $to_phonehistory;
            $intern->allowness_1                = $allowness_1;
            $intern->verbal_contract            = $verbal_contract;
            $intern->talked_partner             = $verbal_partner;
            $intern->shipping_after_payment     = $shipping_after_payment;
            $intern->release                    = $release;
            $intern->takeback_insturction       = $take_back_instruction;
            $intern->change_instruction         = $change_instruction;
            $intern->birthday                   = $birthday;
            $intern->allowness_2                = $allowness_2;
            $intern->employee                   = "Lucas Gloede"; # $req->session()->get("employee_name");
            $intern->company_name               = $company_name;
            $intern->gender                     = $anrede;
            $intern->firstname                  = $firstname;
            $intern->lastname                   = $lastname;
            $intern->email                      = $email;
            $intern->phone_number               = $telefon;
            $intern->mobile_number              = $mobil;
            $intern->home_street                = $straße;
            $intern->home_street_number         = $straßennummer;
            $intern->home_zipcode               = $zipcode;
            $intern->home_city                  = $stadt;
            $intern->home_country               = $land;
            $intern->send_back_company_name     = $send_back_company_name;
            $intern->send_back_gender           = $send_back_salutation;
            $intern->send_back_firstname        = $send_back_firstname;
            $intern->send_back_lastname         = $send_back_lastname;
            $intern->send_back_street           = $send_back_street;
            $intern->send_back_street_number    = $send_back_street_number;
            $intern->send_back_zipcode          = $send_back_zipcode;
            $intern->send_back_city             = $send_back_city;
            $intern->send_back_country          = $send_back_country;
            $intern->save();
        } else {
            $intern_db->process_id                 = $id;
            $intern_db->prox_time                  = $prox_time;
            $intern_db->result                     = $result;
            $intern_db->to_phonehistory            = $to_phonehistory;
            $intern_db->allowness_1                = $allowness_1;
            $intern_db->verbal_contract            = $verbal_contract;
            $intern_db->talked_partner             = $verbal_partner;
            $intern_db->shipping_after_payment     = $shipping_after_payment;
            $intern_db->release                    = $release;
            $intern_db->takeback_insturction       = $take_back_instruction;
            $intern_db->change_instruction         = $change_instruction;
            $intern_db->birthday                   = $birthday;
            $intern_db->allowness_2                = $allowness_2;
            $intern_db->employee                   = "Lucas Gloede"; # $req->session()->get("employee_name");
            $intern_db->company_name               = $company_name;
            $intern_db->gender                     = $anrede;
            $intern_db->firstname                  = $firstname;
            $intern_db->lastname                   = $lastname;
            $intern_db->email                      = $email;
            $intern_db->phone_number               = $telefon;
            $intern_db->mobile_number              = $mobil;
            $intern_db->home_street                = $straße;
            $intern_db->home_street_number         = $straßennummer;
            $intern_db->home_zipcode               = $zipcode;
            $intern_db->home_city                  = $stadt;
            $intern_db->home_country               = $land;
            $intern_db->send_back_company_name     = $send_back_company_name;
            $intern_db->send_back_gender           = $send_back_salutation;
            $intern_db->send_back_firstname        = $send_back_firstname;
            $intern_db->send_back_lastname         = $send_back_lastname;
            $intern_db->send_back_street           = $send_back_street;
            $intern_db->send_back_street_number    = $send_back_street_number;
            $intern_db->send_back_zipcode          = $send_back_zipcode;
            $intern_db->send_back_city             = $send_back_city;
            $intern_db->send_back_country          = $send_back_country;
            $intern_db->update();
        }
        return redirect("/crm/change/order/". $id . "/" . "intern");

        
    }

    public function search_orders(Request $req, $type = null)  {

        $rows                       = $req->input("rows");
        $sorting_field              = $req->input("sorting_field");
        $sorting_direction          = $req->input("sorting_direction");
        $extra_search                = $req->input("extra_search");
        #Bereich Status
        if($sorting_field == "0") {
            $statuses = statuse::all();
            if($sorting_direction == "1") {
                $order_ids = order_id::latest()->with("activeOrdersPersonData")->where("current_status", $extra_search)->limit($rows)->get();
            } else {
                $order_ids = order_id::oldest()->with("activeOrdersPersonData")->where("current_status", $extra_search)->limit($rows)->get();
            }
            $employee = employee::all();
            return view("forMitarbeiter/active-orders-main-view")->with("statuses", $statuses)->with("active_orders", $order_ids)->with("order_ids", $order_ids)->with("employees", $employee);
        }

    }

    public function addPrimaryDevice(Request $req, $id) {

        $process_parts      = explode("-", $id);
        $process_id         = $process_parts[0];

        
        $db_device          = primary_device::where("process_id", $process_id)->first();

        if($db_device == null) {
            $process_parts      = explode("-", $id);
            $process_id         = $process_parts[0];
            $component_id       = $process_parts[1];
            $component_type     = $process_parts[2];
            $component_count    = $process_parts[3];

            $primary_device                         = new primary_device();
            $primary_device->process_id             = $process_id;
            $primary_device->component_id           = $component_id;
            $primary_device->component_type         = $component_type;
            $primary_device->component_count        = $component_count;
            $primary_device->component_number       = $id;
            $primary_device->save();

            return redirect()->back();
        } else {

            $db_device->delete();
            
            $process_parts      = explode("-", $id);
            $process_id         = $process_parts[0];
            $component_id       = $process_parts[1];
            $component_type     = $process_parts[2];
            $component_count    = $process_parts[3];

            $primary_device                         = new primary_device();
            $primary_device->process_id             = $process_id;
            $primary_device->component_id           = $component_id;
            $primary_device->component_type         = $component_type;
            $primary_device->component_count        = $component_count;
            $primary_device->component_number       = $id;
            $primary_device->save();

            return redirect()->back();
        }

    }

    public function changeCarData(Request $req, $id, $gerät = null) {

        $car_company                = $req->input("car_company");
        $car_model                  = $req->input("car_model");
        $production_year            = $req->input("production_year");
        $car_identification_number  = $req->input("car_identification_number");
        $car_power                  = $req->input("car_power");
        $mileage                    = $req->input("mileage");
        $transmission               = $req->input("transmission");
        $fuel_type                  = $req->input("fuel_type");
        $broken_component           = $req->input("broken_component");
        $device_manufacturer        = $req->input("device_manufacturer");
        $from_car                   = $req->input("from_car");
        $error_message              = $req->input("error_message");
        $device_partnumber          = $req->input("device_partnumber");
        $component_company          = $req->input("component_company");
        $component_number           = $req->input("component_number");
        $car_cache                  = $req->input("error_message_cache");
        $for_tech                    = $req->input("info_for_technician");
        

         #NEW CAR
         $car                             = active_orders_car_data::where("process_id", $id)->first();
         $car->process_id                 = $id;
         $car->car_company                = $car_company;
         $car->car_model                  = $car_model;
         $car->production_year            = $production_year;
         $car->car_identification_number  = $car_identification_number;
         $car->car_power                  = $car_power;
         $car->mileage                    = $mileage;
         $car->transmission               = $transmission;
         $car->fuel_type                  = $fuel_type;
         $car->broken_component           = $broken_component;
         $car->device_manufacturer        = $device_manufacturer;
         $car->from_car                   = $from_car;
         $car->error_message              = $error_message;
         $car->device_partnumber          = $device_partnumber;
         $car->component_company          = $component_company;
         $car->component_number           = $component_number;
         $car->error_message_cache        = $car_cache;
         $car->for_tech                    = $for_tech;
         $car->save();

         return redirect("/crm/change/order/". $id . "/" . $gerät);


    }
    public function changeCarDataInteressent(Request $req, $id, $gerät = null) {
        
        $car_company                = $req->input("car_company");
        $car_model                  = $req->input("car_model");
        $production_year            = $req->input("production_year");
        $car_identification_number  = $req->input("car_identification_number");
        $car_power                  = $req->input("car_power");
        $mileage                    = $req->input("mileage");
        $transmission               = $req->input("transmission");
        $fuel_type                  = $req->input("fuel_type");
        $bk           = $req->input("bk");
        $device_manufacturer        = $req->input("device_manufacturer");
        $from_car                   = $req->input("from_car");
        $error_message              = $req->input("error_message");
        $device_partnumber          = $req->input("device_partnumber");
        $component_company          = $req->input("component_company");
        $component_number           = $req->input("component_number");
        $car_cache                  = $req->input("error_message_cache");
        $for_tech                    = $req->input("info_for_technician");
        

         #NEW CAR
         $car                             = new_leads_car_data::where("process_id", $id)->first();
         $car->process_id                 = $id;
         $car->car_company                = $car_company;
         $car->car_model                  = $car_model;
         $car->production_year            = $production_year;
         $car->car_identification_number  = $car_identification_number;
         $car->car_power                  = $car_power;
         $car->mileage                    = $mileage;
         $car->transmission               = $transmission;
         $car->fuel_type                  = $fuel_type;
         $car->broken_component           = $bk;
         $car->device_manufacturer        = "";
         $car->from_car                   = $from_car;
         $car->error_message              = $error_message;
         $car->device_partnumber          = "";
         $car->component_company          = $component_company;
         $car->component_number           = $component_number;
         $car->error_message_cache        = $car_cache;
         $car->for_tech                   = $for_tech;
         $car->save();

         return redirect("/crm/change/interessent/". $id . "/" . $gerät);


    }

    public function deleteDevice(Request $req, $id) {

        $device_orders          =  DB::table('device_orders')
        ->where('component_number', $id);
        if($device_orders != null) {
            $device_orders->delete();
        }


        $primary_key            = primary_device::where("component_number", $id)->first();
        if($primary_key != null) {
            $primary_key->delete();
        }

        DB::table('shelfes')
        ->where('component_number', $id)
        ->update(['process_id' => "0", 'component_id' =>"0", 'component_number' => "0"]);

        $intern                 = intern::where("component_number", $id)->first();
        if($intern != null) {
            $intern->delete();
        }
        
        $warenausgang           = warenausgang::where("component_number", $id)->first();
        if($warenausgang != null) {
            $warenausgang->delete();
        }

        return redirect()->back();

    } 

    public function changeDeviceView(Request $req, $id) {
        $process_parts      = explode("-", $id);
        $process_id         = $process_parts[0];
        $component_id       = $process_parts[1];
        $component_type     = $process_parts[2];
        $component_count    = $process_parts[3];

        $shelfe             = shelfe::where("component_number", $id)->first();
        
        $device             = device_orders::where("component_number", $id)->first();

        $component         = component_name::where("id", $device->component)->first();
        

        $empty_shelfes      = shelfe::where("process_id", "0")->get();

        return view("forMitarbeiter/change-device-view")->
                with("shelfe", $shelfe)->
                with("device", $device)->
                with("empty_shelfes", $empty_shelfes)->
                with("component", $component);

    }

  
   
    public function getLabel(Request $req, $id, $contact = null, $comp = null, $filename = null) {

             if(str_contains($id, "ORG") || str_contains($id, "AT")) {
                $comp = $id;
             }
        $pdf = new Fpdi(); 
       
        $data           = device_data::where("component_number", $comp)->first();
        $device         = device_orders::where("component_number", $comp)->first();

        if($device->opened == "on" || $device->opened == "true") {
            $pdf->setSourceFile(public_path("/"). "pdf/label_opened.pdf");
        } else {
            $pdf->setSourceFile(public_path("/"). "pdf/label.pdf");
        }

        $pdf->AddPage();
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId); 
        $pdf->SetFont("Arial", "", 16);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(159,11);
        $pdf->MultiCell(175,4, $id);

        if($data != null) {
            $pdf->SetFont("Arial", "", 12);
        $pdf->SetXY(60,41);
        $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1',$data->car_company ." / ". $data->car_model));

        $pdf->SetXY(60,47.5);
        $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1',$data->fin));

        $pdf->SetXY(60,54.5);
        $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1',$data->prod_year));

        $pdf->SetXY(60,61.5);
        $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1',$data->ps));
        
        $pdf->SetXY(60,68);
        $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1',$data->mileage));

        $pdf->SetXY(60,75);
        $pdf->MultiCell(175,4, $data->circuit);

        

        $pdf->SetXY(60,81.5);
        $pdf->MultiCell(175,4, $data->fueltype);
       

        $component         = component_name::where("name", $data->component)->first();

        if($component != null)  {
            $pdf->SetXY(155,40);
            $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1',$component->name));
        }

        $pdf->SetXY(155,47);
        $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1',$data->device_manufacturer));

        $pdf->SetXY(155,54);
        $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1',$data->device_partnumber));
        
       
       
        $pdf->SetFont("Arial", "", 24);
        $pdf->SetXY(12,202);

        if($contact != null) {
            $contact = contact::where("shortcut", $contact)->first();

            $google = new googleAPI();
            $translated = $google->translate($contact->language, $data->for_tech, "DE");
          
            $pdf->MultiCell(175,10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $translated));
            

            $translatedErrorMessageCache = $google->translate($contact->language, $data->error_message_cache, "DE");
            $pdf->SetXY(12,100);
            $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $translatedErrorMessageCache));


            $translatedErrorMessage = $google->translate($contact->language, $data->error_message_cache, "DE");

            $pdf->SetXY(12,150);
            $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$translatedErrorMessage));

        } else {
            
            if($data->tec_info_state == "true") {
                $pdf->MultiCell(175,10, iconv('UTF-8', 'ISO-8859-1',$data->tec_info));
            }

    
            if($data->errorcache_state == "true") {
                $pdf->SetXY(12,100);
                $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1',$data->errorcache));
            }

            if($data->errormessage_state == "true") {
                $pdf->SetXY(12,150);
                $pdf->MultiCell(175,4, iconv('UTF-8', 'ISO-8859-1',$data->errormessage));
            }
        }

        $date = new DateTime();

        $file = ModelsFile::where("filename", "LIKE", "%". $date->format("Y_m_d") . "_BPZ_Techniker_$data->component_number.pdf" . "%")->get();
        if($filename != null) {
            $pdf->Output(public_path() . "/files/aufträge/$data->process_id/". $filename . ".pdf", "F");
        } else {
            if($file->count() >= 1) {
                $pdf->Output(public_path() . "/files/aufträge/$data->process_id/".$date->format("Y.m.d"). "_BPZ_Techniker_".$data->component_number."_".$file->count()-1 . ".pdf", "F");
    
            } else {
                $pdf->Output(public_path() . "/files/aufträge/$data->process_id/".$date->format("Y.m.d"). "_BPZ_Techniker_".$data->component_number . ".pdf", "F");
    
            }
        }
        }

        


        return $pdf->Output();
    }

    public function getEmail(Request $req, $id, $pr_id) {

        $email      = email_template::where("id", $id)->first();
        $lead       = active_orders_person_data::where("process_id", $pr_id)->first();
        if($lead == null) {
            $lead       = new_leads_person_data::where("process_id", $pr_id)->first();
        }

        return view("mails/email_vorlage")->
            with("mail", $email)->
            with("lead", $lead);

    }

    public function moveToLeadsArchive(Request $req, $id) {

        $lead_person                                           = new_leads_person_data::where("process_id", $id)->first();
        $lead_car                                           = new_leads_car_data::where("process_id", $id)->first();


        $archive_person                                        = new leads_archive_person();

        $archive_person->send_back_company_name                = $lead_person->send_back_company_name;
        $archive_person->send_back_gender                      = $lead_person->send_back_salutation;
        $archive_person->send_back_firstname                   = $lead_person->send_back_firstname;
        $archive_person->send_back_lastname                    = $lead_person->send_back_lastname;
        $archive_person->send_back_zipcode                     = $lead_person->send_back_zipcode;
        $archive_person->send_back_street                      = $lead_person->send_back_street;
        $archive_person->send_back_street_number               = $lead_person->send_back_street_number;
        $archive_person->send_back_city                        = $lead_person->send_back_city;
        $archive_person->send_back_country                     = $lead_person->send_back_country;
        $archive_person->process_id                            = $lead_person->process_id;
        $archive_person->gender                                = $lead_person->gender;
        $archive_person->employee                              = $lead_person->employee;
        $archive_person->company_name                          = $lead_person->company_name;
        $archive_person->firstname                             = $lead_person->firstname;
        $archive_person->lastname                              = $lead_person->lastname;
        $archive_person->email                                 = $lead_person->email;
        $archive_person->phone_number                          = $lead_person->phone_number;
        $archive_person->mobile_number                         = $lead_person->mobile_number;
        $archive_person->home_street                           = $lead_person->home_street;
        $archive_person->home_street_number                    = $lead_person->home_street_number;
        $archive_person->home_zipcode                          = $lead_person->home_zipcode;
        $archive_person->home_city                             = $lead_person->home_city;
        $archive_person->home_country                          = $lead_person->home_country;
        $archive_person->pricemwst                             = $lead_person->pricemwst;
        $archive_person->shipping_type                         = $lead_person->shipping_type;
        $archive_person->payment_type                          = $lead_person->payment_type;
        $archive_person->submit_type                           = $lead_person->submit_type;
        $archive_person->zuteilung                             = $lead_person->zuteilung;
        $archive_person->last_payment                          = $lead_person->last_payment;
        $archive_person->save();

        $archive_car                             = new leads_archive_car();
        $archive_car->process_id                 = $lead_car->process_id;
        $archive_car->car_company                = $lead_car->car_company;
        $archive_car->car_model                  = $lead_car->car_model;
        $archive_car->production_year            = $lead_car->production_year;
        $archive_car->car_identification_number  = $lead_car->car_identification_number;
        $archive_car->car_power                  = $lead_car->car_power;
        $archive_car->mileage                    = $lead_car->mileage;
        $archive_car->transmission               = $lead_car->transmission;
        $archive_car->fuel_type                  = $lead_car->fuel_type;
        $archive_car->broken_component           = $lead_car->broken_component;
        $archive_car->device_manufacturer        = $lead_car->device_manufacturer;
        $archive_car->from_car                   = $lead_car->from_car;
        $archive_car->error_message              = $lead_car->error_message;
        $archive_car->device_partnumber          = $lead_car->device_partnumber;
        $archive_car->component_company          = $lead_car->component_company;
        $archive_car->component_number           = $lead_car->component_number;
        $archive_car->error_message_cache        = $lead_car->car_cache;
        $archive_car->save();

        $lead_car->delete();
        $lead_person->delete();

        return redirect("/crm/neue-interessenten");

    }

    public function moveToOrdersArchive(Request $req, $id) {

        $person                                           = active_orders_person_data::where("process_id", $id)->first();
        $lead_car                                           = active_orders_car_data::where("process_id", $id)->first();


        $archive_person                                        = new archive_orders_person();

        $archive_person->send_back_company_name                = $person->send_back_company_name;
        $archive_person->send_back_gender                      = $person->send_back_salutation;
        $archive_person->send_back_firstname                   = $person->send_back_firstname;
        $archive_person->send_back_lastname                    = $person->send_back_lastname;
        $archive_person->send_back_zipcode                     = $person->send_back_zipcode;
        $archive_person->send_back_street                      = $person->send_back_street;
        $archive_person->send_back_street_number               = $person->send_back_street_number;
        $archive_person->send_back_city                        = $person->send_back_city;
        $archive_person->send_back_country                     = $person->send_back_country;
        $archive_person->process_id                            = $person->process_id;
        $archive_person->gender                                = $person->gender;
        $archive_person->employee                              = $person->employee;
        $archive_person->company_name                          = $person->company_name;
        $archive_person->firstname                             = $person->firstname;
        $archive_person->lastname                              = $person->lastname;
        $archive_person->email                                 = $person->email;
        $archive_person->phone_number                          = $person->phone_number;
        $archive_person->mobile_number                         = $person->mobile_number;
        $archive_person->home_street                           = $person->home_street;
        $archive_person->home_street_number                    = $person->home_street_number;
        $archive_person->home_zipcode                          = $person->home_zipcode;
        $archive_person->home_city                             = $person->home_city;
        $archive_person->home_country                          = $person->home_country;
        $archive_person->pricemwst                             = $person->pricemwst;
        $archive_person->shipping_type                         = $person->shipping_type;
        $archive_person->payment_type                          = $person->payment_type;
        $archive_person->submit_type                           = $person->submit_type;
        $archive_person->zuteilung                             = $person->zuteilung;
        $archive_person->last_payment                          = $person->last_payment;
        $archive_person->save();

        $archive_car                             = new archive_orders_car();
        $archive_car->process_id                 = $lead_car->process_id;
        $archive_car->car_company                = $lead_car->car_company;
        $archive_car->car_model                  = $lead_car->car_model;
        $archive_car->production_year            = $lead_car->production_year;
        $archive_car->car_identification_number  = $lead_car->car_identification_number;
        $archive_car->car_power                  = $lead_car->car_power;
        $archive_car->mileage                    = $lead_car->mileage;
        $archive_car->transmission               = $lead_car->transmission;
        $archive_car->fuel_type                  = $lead_car->fuel_type;
        $archive_car->broken_component           = $lead_car->broken_component;
        $archive_car->device_manufacturer        = $lead_car->device_manufacturer;
        $archive_car->from_car                   = $lead_car->from_car;
        $archive_car->error_message              = $lead_car->error_message;
        $archive_car->device_partnumber          = $lead_car->device_partnumber;
        $archive_car->component_company          = $lead_car->component_company;
        $archive_car->component_number           = $lead_car->component_number;
        $archive_car->error_message_cache        = $lead_car->car_cache;
        $archive_car->save();

        if($person->last_payment == "0") {
            $this->umlagerungZumArchivePacktisch($req, $id);
        } else {

        }

        $lead_car->delete();
        $person->delete();

        return redirect("/crm/neue-auftraege");

    }

    public function moveToOrdersActive(Request $req, $id) {

        $person                                           = archive_orders_person::where("process_id", $id)->first();
        $lead_car                                           = archive_orders_car::where("process_id", $id)->first();


        $archive_person                                        = new active_orders_person_data();

        $archive_person->send_back_company_name                = $person->send_back_company_name;
        $archive_person->send_back_gender                      = $person->send_back_salutation;
        $archive_person->send_back_firstname                   = $person->send_back_firstname;
        $archive_person->send_back_lastname                    = $person->send_back_lastname;
        $archive_person->send_back_zipcode                     = $person->send_back_zipcode;
        $archive_person->send_back_street                      = $person->send_back_street;
        $archive_person->send_back_street_number               = $person->send_back_street_number;
        $archive_person->send_back_city                        = $person->send_back_city;
        $archive_person->send_back_country                     = $person->send_back_country;
        $archive_person->process_id                            = $person->process_id;
        $archive_person->gender                                = $person->gender;
        $archive_person->employee                              = $person->employee;
        $archive_person->company_name                          = $person->company_name;
        $archive_person->firstname                             = $person->firstname;
        $archive_person->lastname                              = $person->lastname;
        $archive_person->email                                 = $person->email;
        $archive_person->phone_number                          = $person->phone_number;
        $archive_person->mobile_number                         = $person->mobile_number;
        $archive_person->home_street                           = $person->home_street;
        $archive_person->home_street_number                    = $person->home_street_number;
        $archive_person->home_zipcode                          = $person->home_zipcode;
        $archive_person->home_city                             = $person->home_city;
        $archive_person->home_country                          = $person->home_country;
        $archive_person->pricemwst                             = $person->pricemwst;
        $archive_person->shipping_type                         = $person->shipping_type;
        $archive_person->payment_type                          = $person->payment_type;
        $archive_person->submit_type                           = $person->submit_type;
        $archive_person->zuteilung                             = $person->zuteilung;
        $archive_person->last_payment                          = $person->last_payment;
        $archive_person->save();

        $archive_car                             = new active_orders_car_data();
        $archive_car->process_id                 = $lead_car->process_id;
        $archive_car->car_company                = $lead_car->car_company;
        $archive_car->car_model                  = $lead_car->car_model;
        $archive_car->production_year            = $lead_car->production_year;
        $archive_car->car_identification_number  = $lead_car->car_identification_number;
        $archive_car->car_power                  = $lead_car->car_power;
        $archive_car->mileage                    = $lead_car->mileage;
        $archive_car->transmission               = $lead_car->transmission;
        $archive_car->fuel_type                  = $lead_car->fuel_type;
        $archive_car->broken_component           = $lead_car->broken_component;
        $archive_car->device_manufacturer        = $lead_car->device_manufacturer;
        $archive_car->from_car                   = $lead_car->from_car;
        $archive_car->error_message              = $lead_car->error_message;
        $archive_car->device_partnumber          = $lead_car->device_partnumber;
        $archive_car->component_company          = $lead_car->component_company;
        $archive_car->component_number           = $lead_car->component_number;
        $archive_car->error_message_cache        = $lead_car->car_cache;
        $archive_car->save();

        $konto = new kundenkonto();
        $konto->kundenid = $person->kunden_id;
        $konto->guthabennetto = 0;
        $konto->guthabenbrutto = 0;
        $konto->process_id = $person->process_id;
        $konto->save();

        $lead_car->delete();
        $person->delete();

        return redirect("/crm/neue-auftraege");

    }

    public function umlagerungZumArchivePacktisch(Request $req, $id) {

        $devices        = device_orders::where("process_id", $id)->get();
        if($devices != null) {
            foreach($devices as $device) {
                $intern                     = new intern();
                $parts                      = explode("-", $device->process_id. "-". $device->component_id. "-". $device->component_type . "-". $device->component_count);
                $intern->process_id         = $device->process_id;
                $intern->component_id       = $parts[1];
                $intern->component_type     = $parts[2];
                $intern->component_count    = $parts[3];
                $intern->component_number   = $device->process_id. "-". $device->component_id. "-". $device->component_type . "-". $device->component_count;
                $intern->auftrag_id         = "Umlagerungsauftrag-Archive";
                $intern->locked = "no";
                $intern->save();
            }
        } else {
            
        }

    }

    public function uploadFiles(Request $req, $id, $tab = null) {

        $files      = $req->file("file");
       
        $type       = $req->input("type");
       


        foreach($files as $filed) {
            $filename       = $filed->getClientOriginalName();
            $chars          = ["ä", "ö", "ü", ';', ";", ",", ".", "!", '"', "'", "#", " ", "$", "§", "%", "&", "?", "=", "*", "+", "(", ")"];
            $filename       = str_replace($chars, "_", $filename);
            $path = $filed->storeAs("/files/aufträge/". $id. "/" ,  $filename);

            $file                   = new ModelsFile();
            $file->process_id       = $id;
            $file->component_id     = "";
            $file->component_type   = "";
            $file->component_count  = "";
            $file->component_number = "";
            $file->employee         = $req->session()->get("username");
            $file->filename         = $filename;
            $file->description      = "";
            $file->type             = $type;
            $file->save(); 

        }         
        return redirect("/crm/change/order/". $id ."/". $tab);


    }

    public function deleteFile(Request $req, $id, $filename, $tab) {
        
        if(file_exists("files/aufträge/". $id . "/". $filename)) {
            Storage::delete("files/aufträge/". $id . "/". $filename);
            $db     = ModelsFile::where("process_id", $id)->where("filename", $filename)->delete();
            return redirect("/crm/change/order/". $id ."/". $tab);
        } else {
            return "Datei konnte nicht gefunden werden";
        }

    }

    public function orderAchivView(Request $req) {

        

        $person         = archive_orders_person::all();
        $car            = archive_orders_car::all();
        $statuses       = statuse::all();
        $orders         = order_id::all();
        $employees      = employee::all();

        return view("forMitarbeiter/aufträge/archive")->
                with("car", $car)->
                with("person", $person)->
                with("statuses", $statuses)->
                with("orders", $orders)->
                with("employees", $employees);

    }

    public function leadArchivView(Request $req) {
        $person         = leads_archive_person::all();
        $car            = leads_archive_car::all();
        $statuses       = statuse::all();
        $orders         = order_id::all();
        $employees      = employee::all();

        return view("forMitarbeiter/interessenten/archiv")->
                with("car", $car)->
                with("person", $person)->
                with("statuses", $statuses)->
                with("orders", $orders)->
                with("employees", $employees);
    }

    public function changeArchivView(Request $req, $id) {
        $lead_person                = archive_orders_person::where("process_id", $id)->first();

        $lead_history               = status_histori::where("process_id", $id)->
                                            latest('updated_at')->first();

        $lead_historys              = status_histori::where("process_id", $id)->
                                            latest('updated_at')->get();
                                            
        $lead_car                   = archive_orders_car::where("process_id", $id)->first();

        $employee_created_lead      = employee::where("id", $lead_person->employee)->first();

        $employee_last_changed      = employee::where("id", $lead_history->changed_employee)->first();

        $statuses                   = statuse::where("type", 1)->get();

        $order_id                   = order_id::where("process_id", $lead_person->process_id)->first();

        $dir_files                  = ModelsFile::where("process_id", $lead_person->process_id)->get();

        $employees                  = employee::all();

        $email_templates            = email_template::all();
        
        $device_orders              = device_orders::with("shelfe")->
                                        with("newLeadsPersonData")->
                                        with("componentName")->where("process_id", $lead_person->process_id)->get();

        $phone_history              = phone_history::where("process_id", $lead_person->process_id)->get();

        $auftraghistoy              = orderhistory_message::where("process_id", $lead_person->process_id)->latest()->get();

        $booking                    = booking::where("process_id", $lead_person->process_id)->orderBy('created_at', 'desc')->first();

        $intern                     = intern_admin::where("process_id", $lead_person->process_id)->first();
        
        $shelfes                    = shelfe::all();

        $countries                  = countrie::all();

        $primary_device             = primary_device::where("process_id", $lead_person->process_id)->first();
            
        $wareneingang               = wareneingang::where("process_id", $lead_person->process_id)->get();
        $intern_                    = intern::where("process_id", $lead_person->process_id)->get();
        $warenausgang               = warenausgang::where("process_id", $lead_person->process_id)->get();


        
        $bpz                        = bpzfile::all();

        
        return response()->view("forMitarbeiter/orders-change-view", ["lead" => $lead_person,
        "lead" => $lead_person,
        "employee_created_lead" => $employee_created_lead,
        "employee_last_changed" => $employee_last_changed,
        "order_id" => $order_id,
        "device_orders" => $device_orders,
        "lead_car" => $lead_car,
        "files" => $dir_files,
        "statuses" => $statuses,
        "status_historys" => $lead_historys,
        "status_history_lead" => $lead_history,
        "employees" => $employees,
        "email_templates" => $email_templates,
        "phone_historys" => $phone_history,
        "auftragshistory" => $auftraghistoy,
        "booking" => $booking,
        "shelfes" => $shelfes,
        "booking_open_sum" => $booking,
        "primary_device" => $primary_device,
        "intern" => $intern,
        "countries" => $countries,
        "wareneingang" => $wareneingang,
        "intern_" => $intern_,
        "warenausgang" => $warenausgang,
        "bpz" => $bpz,]);

    }

    public function changeContact(Request $req, $id) {

        $contact = $req->input("to_address");

        if($contact != null) {

            $db_contact     = contact::where("shortcut", $contact)->first();

            $lead_person                = active_orders_person_data::where("process_id", $id)->first();

            $lead_history               = status_histori::where("process_id", $id)->
                                                latest('updated_at')->first();
    
            $lead_historys              = status_histori::where("process_id", $id)->
                                                latest('updated_at')->get();
                                                
            $lead_car                   = active_orders_car_data::where("process_id", $id)->first();
    
            $employee_created_lead      = employee::where("id", $lead_person->employee)->first();
    
            $employee_last_changed      = employee::where("id", $lead_history->changed_employee)->first();
    
            $statuses                   = statuse::where("type", 1)->get();
    
            $order_id                   = order_id::where("process_id", $lead_person->process_id)->first();
    
            $dir_files                  = ModelsFile::where("process_id", $lead_person->process_id)->get();
    
            $employees                  = employee::all();
    
            $email_templates            = email_template::all();
            
            $device_orders              = device_orders::with("shelfe")->
                                            with("newLeadsPersonData")->
                                            with("componentName")->where("process_id", $lead_person->process_id)->get();
    
            $phone_history              = phone_history::where("process_id", $lead_person->process_id)->get();
    
            $auftraghistoy              = orderhistory_message::where("process_id", $lead_person->process_id)->latest()->get();
    
            $booking                    = booking::where("process_id", $lead_person->process_id)->orderBy('created_at', 'desc')->first();
    
            $intern                     = intern_admin::where("process_id", $lead_person->process_id)->first();
            
            $shelfes                    = shelfe::all();
    
            $countries                  = countrie::all();
    
            $primary_device             = primary_device::where("process_id", $lead_person->process_id)->first();
                
            $wareneingang               = wareneingang::where("process_id", $lead_person->process_id)->get();
            $intern_                    = intern::where("process_id", $lead_person->process_id)->get();
            $warenausgang               = warenausgang::where("process_id", $lead_person->process_id)->get();
    
    
            
            $bpz                        = bpzfile::all();
    
            
            return response()->view("forMitarbeiter/orders-change-view", ["lead" => $lead_person,
            "lead" => $lead_person,
            "employee_created_lead" => $employee_created_lead,
            "employee_last_changed" => $employee_last_changed,
            "order_id" => $order_id,
            "device_orders" => $device_orders,
            "lead_car" => $lead_car,
            "files" => $dir_files,
            "statuses" => $statuses,
            "status_historys" => $lead_historys,
            "status_history_lead" => $lead_history,
            "employees" => $employees,
            "email_templates" => $email_templates,
            "phone_historys" => $phone_history,
            "auftragshistory" => $auftraghistoy,
            "booking" => $booking,
            "shelfes" => $shelfes,
            "booking_open_sum" => $booking,
            "primary_device" => $primary_device,
            "intern" => $intern,
            "countries" => $countries,
            "wareneingang" => $wareneingang,
            "intern_" => $intern_,
            "warenausgang" => $warenausgang,
            "bpz" => $bpz,
            "contact" => $db_contact]);

        } else {
            return redirect()->back();
        }

    }

    public function tablePage(Request $req) {

        $tables         =  DB::select('SHOW TABLES');
        $tables         = array_map('current',$tables);
        
        return view("tables")->with("tables", $tables);


    }

    public function seeTable(Request $req) {

        $table      = $req->input("table");
        $columns    = DB::getSchemaBuilder()->getColumnListing($table);
        $columns_ar    = array();
        foreach($columns as $col) {
            array_push($columns_ar, $col);
        }
        
        

        $db_table   = DB::table("$table")->get();

        return view("table")->with("tables", $db_table)->with("columns", $columns)->with("columns_ar", $columns_ar)->with("tablename", $table);

    }

    public function changeRecords(Request $req, $tablename) {

        $vars       = array();

        foreach($req->except("_token") as $key => $value) {
            array_push($vars, $key);
            $$key       = "$value";
        }

    }

    public function addRecord(Request $req, $tablename) {

        $vars       = array();
        $items      = array();
        $tablenewName       = $tablename;
        foreach($req->except("_token") as $key => $item) {
           
            $$key       = $key;
            array_push($vars, $key);
            $$item       = $item;
            array_push($items, $item);
        }
        $columns    = DB::getSchemaBuilder()->getColumnListing("$tablename");
        if(substr($tablename, -1) == "s") {
            $tablename  = rtrim($tablename, substr($tablename, -1));
        }
        $tablename = "App\\Models\\". $tablename;
        
        $new        = new $tablename();
        $counter    = 0;
        
        foreach ($columns as $column) {
            $new->$column    	= $items[$counter];
            $counter++;
        }

        $new->save();
        
        $columns_ar    = array();
        foreach($columns as $col) {
            array_push($columns_ar, $col);
        }
        
        

        $db_table   = DB::table("$tablenewName")->get();

        return view("table")->with("tables", $db_table)->with("columns", $columns)->with("columns_ar", $columns_ar)->with("tablename", $tablenewName);




    }

    public function newOrderView(Request $req) {

        $countries          = countrie::all();
        $components         = component_name::all();
        $kunde              = new kunde();
        $id                 = $kunde->createCustomId();

        return view("forEmployees/orders/new-order")->with("countries", $countries)->with("components", $components)->with("kunden_id", $id);
    }

    public function searchKBA(Request $req) {
        $kba = kba::where("hsn", $req->input("hsn"))->where("tsn", $req->input("tsn"))->first();

        if($kba == null) {
            return "empty";
        } else {
            return $kba;
        }
    }

    public function neuerAuftragUndGerät(Request $req) {
        $production_id    = $this->createProductionId();

        $order = $this->add_new_order($req, $production_id);
        $devicename = $this->createORGComponentId($production_id);

        $parts = explode("-", $production_id . "-" . $devicename[0] . "-" . $devicename[1] . "-" . $devicename[2]);

        $first_device = device_orders::where("process_id", $parts[0])->first();
       
        $device_order                   = new device_orders();
        $device_order->process_id       = $parts[0];
        $device_order->component_id     = $parts[1];
        $device_order->component_type   = $parts[2];
        $device_order->component_count  = $parts[3];
        $device_order->component_number = $production_id . "-" . $devicename[0] . "-" . $devicename[1] . "-" . $devicename[2];
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
        $intern->info = $req->input("info");
        $intern->auftrag_id = "Beschriftungsauftrag";
        $intern->helpercode = $production_id . "-" . $devicename[0] . "-" . $devicename[1] . "-" . $devicename[2];
        $intern->save();

        Storage::move('files/aufträge/'.$old.'/gerätdokumente.pdf', "files/aufträge/$parts[0]/". $production_id . "-" . $devicename[0] . "-" . $devicename[1] . "-" . $devicename[2] ."-g.pdf");

        return redirect("/crm/auftragsübersicht-aktiv");
    }

    public function newInteressentenView(Request $req) {

        $countries          = countrie::all();
        $components         = component_name::all();
        $kunde              = new kunde();
        $id                 = $kunde->createCustomId();

        return view("forEmployees/interessenten/new-order")->with("countries", $countries)->with("components", $components)->with("kunden_id", $id);

    }

    public function getArchiveOrders(Request $req, $id = null) {
         
        $person = active_orders_person_data::with("statuse")->where("archiv", true)->with("activeOrdersCarData")->with("userTracking.trackings.code.bezeichnungCustom")->with("rechnungen.zahlungen")->with("files")->get();
        $statuses = statuse::all();
        $users = user::all();
        $email = emailinbox::where("read_at", null)->first();
        $allStats = statuse::all();
        $hinweise = hinweis::where("area", "Auftragsübersicht")->get();
        $employees = User::all();
        $einkäufe = einkauf::all();

        $hilfscodes = device_orders::where("status", "Hilfsbarcode")->get();

        if($id == null) {
            return view("forEmployees/orders/archiv")
                ->with("active_orders", $person)
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("emailRead", $email)
                ->with("hinweise", $hinweise)
                ->with("hilfscodes", $hilfscodes)
                ->with("employees", $employees)
                ->with("einkäufe", $einkäufe);
        } else {
            return view("forEmployees/orders/archiv")
                ->with("active_orders", $person)
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("emailRead", $email)
                ->with("hinweise", $hinweise)
                ->with("hilfscodes", $hilfscodes)
                ->with("employees", $employees)
                ->with("einkäufe", $einkäufe)
                ->with("changeOrder", $id);
        }

            
        
    }

    public function getArchiveLeads(Request $req) {
         
        $person = new_leads_person_data::with("statuse")->where("archiv", true)->with("userTracking.trackings.code.bezeichnungCustom")->with("files")->get();
        $statuses = statuse::where("type", "5")->get();
        $users = user::all();
        $email = emailinbox::where("read_at", null)->first();
        $allStats = statuse::where("type", "5")->get();
        $hinweise = hinweis::where("area", "Auftragsübersicht")->get();
        $employees = User::all();
        $einkäufe = einkauf::all();

        $hilfscodes = device_orders::where("status", "Hilfsbarcode")->get();

            return view("forEmployees/interessenten/archiv")
                ->with("active_orders", $person)
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("emailRead", $email)
                ->with("hinweise", $hinweise)
                ->with("hilfscodes", $hilfscodes)
                ->with("employees", $employees)
                ->with("einkäufe", $einkäufe);
        
    }

    public function moveToArchiveLeads(Request $req, $id) {
        $lead = new_leads_person_data::where("process_id", $id)->first();
        $lead->archiv = true;
        $lead->save();

        return $this->interessentenArchivView($req, $id);
    } 

    public function moveToActiveLeads(Request $req, $id) {
        $lead = new_leads_person_data::where("process_id", $id)->first();
        $lead->archiv = false;
        $lead->save();

        return $this->interessentenView($req, $id);
    } 

    public function interessentenArchivView(Request $req, $id = null) {
        $person         = new_leads_person_data::all();
        $car            = archive_lead_car_data::all();
        $statuses       = statuse::all();
        $orders         = order_id::all();
        $employees      = employee::all();
        $users          = user::all();

        if($id != null) {
            return view("forEmployees/interessenten/archiv")->
                with("car", $car)->
                with("active_orders", $person)->
                with("allStats", $statuses)->
                with("statuses", $statuses)->
                with("order_ids", $orders)->
                with("employees", $employees)
                ->with("users", $users)
                ->with("changeOrder", $id);
                
        } else {
            return view("forEmployees/interessenten/archiv")->
                with("car", $car)->
                with("active_orders", $person)->
                with("statuses", $statuses)->
                with("allStats", $statuses)->
                with("order_ids", $orders)->
                with("employees", $employees)
                ->with("users", $users);
        }
    }


    public function newDeviceView(Request $req)  {
        return view("forEmployees/Geräte/neues-Gerät");
    }
    
    public function changeOrderView(Request $req, $id, $tab = null, $contact = null) {
        
        $person             = active_orders_person_data::where("process_id", $id)->with("orderId.statuse")->with("activeOrdersCarData")->first();

        if($person->locked != "true") {
            return redirect()->back()->withErrors(["auftrag-gesperrt", $person->locked_message]);
        }

        $countries          = countrie::all();
        $statuses           = statuse::where("type", "1")->get()->sortBy("color");
        $shelfes            = used_shelfes::all();
        $files              = ModelsFile::where("process_id", $id)->get()->sortByDesc("created_at");

        $techniker          = contact::all();
    
        if($contact != null) {
            $contact        = contact::where("id", $contact)->first();
        }

        $status_history         = status_histori::where("process_id", $id)->get()->sortByDesc("created_at");

        $email_templates        = email_template::where("type", "1")->get();

        $devices                = device_orders::where("process_id", $id)->with("shelfe")->get()->sortByDesc("created_at");
        $components             = component_name::all();
        $order                  = order_id::where("process_id", $id)->first();

        $intern                 = intern_admin::where("process_id", $id)->first();
        $warenausgang           = warenausgang::where("process_id", $id)->get();
        $intern_af              = intern::where("process_id", $id)->get();

        $inshipping             = inshipping::where("process_id", $id)->get();

        $primary_device         = primary_device::where("process_id", $id)->first();
        if($primary_device != null) {
            $prim                   = device_orders::where("component_number", $primary_device->component_number)->first();
            $component             = component_name::where("id", $prim->component)->first();
            $action ="";
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
                if($action != null) {
                    $bpzs                   = bpzfile::where("component_name", $component->name)->where("action", $action)->first();

                } else {
                    $bpzs                   = null;
                }
            } else {
                $bpzs                   = null;
            }
        } else {
            $bpzs = null;
        }

        $vergleich      = vergleichstext::all();

        $contacts       = contact::all();

        $bookings      = booking::where("process_id", $id)->get();

        $email_history = emails_history::where("process_id", $id)->get();

        $phonehistory = phone_history::where("process_id", $id)->get();

        $arch_shelfes = shelfes_archive::all();

        $sh = shelfes_archive::where("process_id", $id)->get();

        $auftragshistory = auftragshistory::where("process_id", $id)->get();

        $emailUUIDS = emailUUID::where("process_id", $id)->get();
        
        $warenausgang = warenausgang_history::where("process_id", $id)->get();

        return view("forEmployees/orders/change")->with("person", $person)->with("countries", $countries)->with("statuses", $statuses)
            ->with("shelfes", $shelfes)
            ->with("devices", $devices) 
            ->with("tab", $tab)
            ->with("files", $files)
            ->with("status_history", $status_history)
            ->with("email_templates", $email_templates)
            ->with("components", $components)
            ->with("intern", $intern)
            ->with("techniker", $techniker)
            ->with("contactt", $contact)
            ->with("order", $order)
            ->with("intern_auf", $intern_af)
            ->with("warenausgang", $warenausgang)
            ->with("inshipping", $inshipping)
            ->with("primary_device", $primary_device)
            ->with("bpzs", $bpzs)
            ->with("vergleich", $vergleich)
            ->with("contacts", $contacts)
            ->with("e_his", $email_history)
            ->with("phonehistory", $phonehistory)
            ->with("arch_shelfes", $arch_shelfes)
            ->with("sh", $sh)
            ->with("auftragshistory", $auftragshistory)
            ->with("bookings", $bookings)
            ->with("emailUUIDS", $emailUUIDS)
            ->with("warenausgang", $warenausgang);
            

    }

    public function archiveOrderView(Request $req, $id, $tab = null, $contact = null,) {
        $person             = archive_orders_person::where("process_id", $id)->with("orderId.statuse")->with("activeOrdersCarData")->first();
        $countries          = countrie::all();
        $statuses           = statuse::where("type", "1")->get()->sortBy("color");
        $shelfes            = shelfe::all();
        $files              = ModelsFile::where("process_id", $id)->get()->sortByDesc("created_at");

        $techniker          = contact::all();
        if($contact != null) {
            $contact        = contact::where("id", $contact)->first();
        }


        $status_history         = status_histori::where("process_id", $id)->get()->sortByDesc("created_at");

        $email_templates        = email_template::where("type", "1")->get();

        $devices                = device_orders::where("process_id", $id)->with("shelfe")->get()->sortByDesc("created_at");
        $components             = component_name::all();
        $order                  = order_id::where("process_id", $id)->first();

        $intern                 = intern_admin::where("process_id", $id)->first();
        $warenausgang           = warenausgang::where("process_id", $id)->get();
        $intern_af              = intern::where("process_id", $id)->get();

        $inshipping             = inshipping::where("process_id", $id)->get();

        $primary_device         = primary_device::where("process_id", $id)->first();
        if($primary_device != null) {
            $prim                   = device_orders::where("component_number", $primary_device->component_number)->first();
            $component             = component_name::where("id", $prim->component)->first();
            $action ="";
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
                if($action != null) {
                    $bpzs                   = bpzfile::where("component_name", $component->name)->where("action", $action)->first();

                } else {
                    $bpzs                   = null;
                }
            } else {
                $bpzs                   = null;
            }
        } else {
            $bpzs = null;
        }

        $vergleich      = vergleichstext::all();

        $contacts       = contact::all();

        return view("forEmployees/orders/archivchange")->with("person", $person)->with("countries", $countries)->with("statuses", $statuses)
            ->with("shelfes", $shelfes)
            ->with("devices", $devices) 
            ->with("tab", $tab)
            ->with("files", $files)
            ->with("status_history", $status_history)
            ->with("email_templates", $email_templates)
            ->with("components", $components)
            ->with("intern", $intern)
            ->with("techniker", $techniker)
            ->with("contact", $contact)
            ->with("order", $order)
            ->with("intern_auf", $intern_af)
            ->with("warenausgang", $warenausgang)
            ->with("inshipping", $inshipping)
            ->with("primary_device", $primary_device)
            ->with("bpzs", $bpzs)
            ->with("vergleich", $vergleich)
            ->with("contacts", $contacts);
    }

    public function changeInteressentView(Request $req, $id, $tab = null, $contact = null) {


        $person             = new_leads_person_data::where("process_id", $id)->with("orderId.statuse")->with("newLeadsCarData")->first();
        $countries          = countrie::all();
        $statuses           = statuse::all()->sortBy("color");
        $shelfes            = shelfe::all();
        $files              = ModelsFile::where("process_id", $id)->get()->sortByDesc("created_at");

        $techniker          = contact::all();

        if($contact != null) {
            $contact        = contact::where("id", $contact)->first();
        }

        $status_history     = status_histori::where("process_id", $id)->get()->sortByDesc("created_at");

        $email_templates    = email_template::all();

        $devices            = device_orders::where("process_id", $id)->get()->sortByDesc("created_at");

        $components         = component_name::all();

        $intern             = intern_admin::where("process_id", $id)->first();

        $phone              = phone_history::where("process_id", $id)->get();

        $employeephone = phone_history::where("employee", $req->session()->get("username"))->get();

        $callback = callback::all();

        return view("forEmployees/interessenten/change")->with("person", $person)->with("countries", $countries)->with("statuses", $statuses)
            ->with("shelfes", $shelfes)
            ->with("devices", $devices) 
            ->with("tab", $tab)
            ->with("files", $files)
            ->with("status_history", $status_history)
            ->with("email_templates", $email_templates)
            ->with("components", $components)
            ->with("intern", $intern)
            ->with("techniker", $techniker)
            ->with("contact", $contact)
            ->with("phones", $phone)
            ->with("employeephone", $employeephone)
            ->with("callback", $callback)
            ->with("fromPhone", true);


    }

    public function changeDeviceData(Request $req, $id) {

        $component              = $req->input("component");
        $device_manufacturer    = $req->input("device_manufacturer");
        $device_partnumber      = $req->input("device_partnumber");
        $info                   = $req->input("info");
        $shelfe                 = $req->input("shelfe");
        $typ                    = $req->input("typ");
        
        $device                         = device_orders::where("component_number", $id)->first();
        $comp                           = str_replace($device->component_type, $typ, $id);
        $device->component              = $component;
        $device->device_manufacturer    = $device_manufacturer;
        $device->device_partnumber      = $device_partnumber;
        $device->info                   = $info;
        DB::table('device_orders')
        ->where('component_number', $id)
        ->update(['component_number' => $comp]);
        
        if($typ != $device->component_type) {
            DB::table('device_orders')
                ->where('component_number', $comp)
                ->update(['component_type' => $typ]);
            $intern     = new intern();
            $intern->process_id         = $device->process_id;
            $intern->component_id       = $device->component_id;
            $intern->component_type     = $typ;
            $intern->component_count    = $device->component_count;
            $intern->component_number   = $device->process_id."-".$device->component_id."-".$typ."-".$device->component_count;
            $intern->auftrag_id         = "Beschriftungsauftrag";
            $intern->locked              = "no";

            $intern->info               = $id;
            $intern->save();
        }
        $device->update();


        $shelfe_old     = shelfe::where("component_number", $device->process_id."-".$device->component_id."-".$typ."-".$device->component_count)->first();
        if($shelfe != $shelfe_old->shelfe_id) {
            DB::table('shelfes')
            ->where('component_number', $id)
            ->update(['process_id' => "0", 'component_id' =>"0", 'component_number' => "0"]);
 
            DB::table('shelfes')
            ->where('shelfe_id', $shelfe)
            ->update(['process_id' => $device->process_id, 'component_id' => $device->component_id, 'component_number' => $device->process_id."-".$device->component_id."-".$typ."-".$device->component_count]);
            
            $intern     = new intern();
            $intern->process_id         = $device->process_id;
            $intern->component_id       = $device->component_id;
            $intern->component_type     = $typ;
            $intern->component_count    = $device->component_count;
            $intern->component_number   = $device->process_id."-".$device->component_id."-".$typ."-".$device->component_count;
            $intern->auftrag_id         = "Umlagerungsauftrag";
            $intern->info         = $shelfe_old->shelfe_id;
            $intern->auftrag_info               = $shelfe;
            $intern->locked              = "no";
            $intern->save();
            
            return redirect("/crm/change/order/". $device->process_id . "/" . "auftragsdaten")->withErrors(["Gerät wurde umgelagert"]);

        } else {
            return redirect("/crm/change/order/". $device->process_id . "/" . "auftragsdaten");

        }



    }

    public function interessentenView(Request $req, $id = null) {

        if($id != null) {
            $person = new_leads_person_data::with("statuse")->with("newLeadsCarData")->with("zuweisung")->with("files")->with("userTracking.trackings")->with("callbacks")->get();
            $orders = active_orders_person_data::with("statuse")->get();
            $konvertLeads = 0;
            foreach($orders as $order) {
                $status = status_histori::where("process_id", $order->process_id)->where("last_status", "36")->first();
                if($status == null) {
                    $konvertLeads++;
                }
            }

            $statuses = statuse::where("type", "Interessenten")->get();
            $users = user::all();
            $email = emailinbox::where("read_at", null)->first();
            $allStats = statuse::where("type", "Interessenten")->get();
            $hinweise = hinweis::where("area", "Interessentenübersicht")->get();

            $employees = User::all();
            
            return view("forEmployees/interessenten/main")
                    ->with("leads", $person)
                    ->with("allStats", $allStats)
                    ->with("statuses", $statuses)
                    ->with("users", $users)
                    ->with("emailRead", $email)
                    ->with("konvertLeads", $konvertLeads)
                    ->with("orders", $orders)
                    ->with("hinweise", $hinweise)
                    ->with("employees", $employees)
                    ->with("changeOrder", $id);


        } else {

            $person = new_leads_person_data::with("statuse")->with("newLeadsCarData")->with("zuweisung")->with("files")->with("userTracking.trackings")->with("callbacks")->get();
            $orders = active_orders_person_data::with("statuse")->get();
            $konvertLeads = 0;
            foreach($orders as $order) {
                $status = status_histori::where("process_id", $order->process_id)->where("last_status", "36")->first();
                if($status == null) {
                    $konvertLeads++;
                }
            }

            $statuses = statuse::where("type", "Interessenten")->get();
            $users = user::all();
            $email = emailinbox::where("read_at", null)->first();
            $allStats = statuse::where("type", "Interessenten")->get();
            $hinweise = hinweis::where("area", "Interessentenübersicht")->get();

            $employees = User::all();

            return view("forEmployees/interessenten/main")
                    ->with("leads", $person)
                    ->with("allStats", $allStats)
                    ->with("statuses", $statuses)
                    ->with("users", $users)
                    ->with("emailRead", $email)
                    ->with("konvertLeads", $konvertLeads)
                    ->with("orders", $orders)
                    ->with("hinweise", $hinweise)
                    ->with("employees", $employees);
        }
    }

    public function keinBarcodeZuteilen(Request $req, $id) {

        $barcode        = helpercode::where("helper_code", $id)->first();

        $orders         = active_orders_person_data::all();
        $devices         = device_orders::all();
        $leads          = new_leads_person_data::all();

        return view("forEmployees/orders/barcode-zuteilen")->with("barcode", $barcode)->with("orders", $orders)->with("leads", $leads)->with("devices", $devices);

    }
    
    public function keinBarcodeKundeZuteilen(Request $req, $id) {
        
        $typ        = $req->input("typ");
        $helper     = $req->input("helper");
        $device     = $req->input("device");

        if($typ == "org") {
            $component_number   = $this->createORGComponentId($id);
            $component_id       = $component_number[0];
            $component_type     = $component_number[1];
            $component_count    = $component_number[2];

            $device                         = new device_orders();
            $device->process_id             = $id;
            $device->component_id           = $component_id;
            $device->component_type         = $component_type;
            $device->component_count        = $component_count;
            $device->component_number       = $id . "-". $component_id. "-". $component_type. "-". $component_count;
            $device->save();


            DB::table('shelfes')
            ->where('component_number', $helper)
            ->update(['process_id' => $id, 'component_id' => $component_id, 'component_number' => $id. "-" .$component_id. "-" .$component_type. "-" .$component_count]);
            
            $helpercode                     = helpercode::where("helper_code", $helper)->first();
            $helpercode->delete();

            $intern         = new intern();
            $intern->process_id     = $id;
            $intern->component_id   = $component_id;
            $intern->component_type = $component_type;
            $intern->component_count = $component_count;
            $intern->component_number = $id. "-" .$component_id. "-" .$component_type. "-" .$component_count;
            $intern->info           = $helper;
            $intern->auftrag_id    = "Beschriftungsauftrag";
            $intern->save();

            return redirect()->back();

        } else {
            if($device != "null") {

            $parts      = explode("-", $device);
            $component_number   = $this->createATComponentId($parts[0], $parts[1]);
            $component_id       = $component_number[0];
            $component_type     = $component_number[1];
            $component_count    = $component_number[2];

            $device                         = new device_orders();
            $device->process_id             = $id;
            $device->component_id           = $component_id;
            $device->component_type         = $component_type;
            $device->component_count        = $component_count;
            $device->component_number       = $id . "-". $component_id. "-". $component_type. "-". $component_count;
            $device->save();


            DB::table('shelfes')
            ->where('component_number', $helper)
            ->update(['process_id' => $id, 'component_id' => $component_id, 'component_number' => $id. "-" .$component_id. "-" .$component_type. "-" .$component_count]);
            
            $helpercode                     = helpercode::where("helper_code", $helper)->first();
            $helpercode->delete();

            $intern         = new intern();
            $intern->process_id     = $id;
            $intern->component_id   = $component_id;
            $intern->component_type = $component_type;
            $intern->component_count = $component_count;
            $intern->component_number = $id. "-" .$component_id. "-" .$component_type. "-" .$component_count;
            $intern->info           = $helper;
            $intern->auftrag_id    = "Beschriftungsauftrag";
            $intern->locked     = "no";
            $intern->save();

            return redirect()->back();
            }
        }

    }

    public function settingsView(Request $req) {

        $shelfes            = shelfe::all();
        $shelfes_archive    = shelfes_archive::all();
        $employees          = user::all();
        
        return view("forEmployees/administration/einstellungen")->with("shelfes", $shelfes)->with("shelfes_archive", $shelfes_archive)->with("employees", $employees);
    }

    public function fachZuArchive(Request $req) {
        $oldshelfe      = $req->input("oldshelfe");
        $newshelfe      = $req->input("newshelfe");

        $shelfe = shelfe::where("shelfe_id", $oldshelfe)->first();

        

        return redirect()->back();

    }

    public function regalZuArchive(Request $req) {
        $oldshelfe      = $req->input("oldshelfe");
        $newshelfe      = $req->input("newshelfe");
        $shelfes        = shelfe::all();

        foreach($shelfes as $shelfe) {
            $part1      = explode("A", $shelfe->shelfe_id);
            $part2      = explode("B", $shelfe->shelfe_id);

            if($part1[0] == $oldshelfe) {
                $new_shelfe = shelfe::where("shelfe_id", $shelfe->shelfe_id)->first();
                if($new_shelfe->process_id == "0") {
                    $shelfe_new    = new shelfes_archive();
                    $shelfe_new->process_id = "0";
                    $shelfe_new->shelfe_id  = $shelfe->shelfe_id;
                    $shelfe_new->component_number = "0";
                    $shelfe_new->component_id       = "0";
                    $shelfe_new->save();
                    DB::table('shelfes')
                    ->where('shelfe_id', $shelfe->shelfe_id)
                        ->delete();
                } else {
                    dd("Da is was im fach");
                }
            }
            if($part2[0] == $oldshelfe) {
                $new_shelfe = shelfe::where("shelfe_id", $shelfe->shelfe_id)->first();
                if($new_shelfe->process_id == "0") {
                   $shelfe_new    = new shelfes_archive();
                   $shelfe_new->process_id = "0";
                   $shelfe_new->shelfe_id  = $shelfe->shelfe_id;
                   $shelfe_new->component_number = "0";
                   $shelfe_new->component_id       = "0";
                   $shelfe_new->save();
                   DB::table('shelfes')
                   ->where('shelfe_id', $shelfe->shelfe_id)
                       ->delete();
                } else {
                    dd("Da is was im fach");
                }
            }
        }

        return redirect()->back();

    }

    public function fachZuAktive(Request $req) {
        $oldshelfe      = $req->input("oldshelfe");
        $newshelfe      = $req->input("newshelfe");

        $shelfe = shelfes_archive::where("shelfe_id", $oldshelfe)->first();

        if($shelfe->process_id == "0") {
            DB::table('shelfes_archive')
            ->where('shelfe_id', $oldshelfe)
                ->delete();
        
            $shelfe    = new shelfe();
            $shelfe->process_id = "0";
            $shelfe->shelfe_id  = $oldshelfe;
            $shelfe->component_number = "0";
            $shelfe->component_id       = "0";
            $shelfe->save();
        } else {}

        return redirect()->back();
    }

    public function regalZuAktive(Request $req) {
        $oldshelfe      = $req->input("oldshelfe");
        $newshelfe      = $req->input("newshelfe");
        $shelfes        = shelfes_archive::all();

        foreach($shelfes as $shelfe) {
            $part1      = explode("A", $shelfe->shelfe_id);
            $part2      = explode("B", $shelfe->shelfe_id);

            if($part1[0] == $oldshelfe) {
                $new_shelfe = shelfes_archive::where("shelfe_id", $shelfe->shelfe_id)->first();
                if($new_shelfe->process_id == "0") {
                    $shelfe_new    = new shelfe();
                    $shelfe_new->process_id = "0";
                    $shelfe_new->shelfe_id  = $shelfe->shelfe_id;
                    $shelfe_new->component_number = "0";
                    $shelfe_new->component_id       = "0";
                    $shelfe_new->save();
                    DB::table('shelfes_archive')
                    ->where('shelfe_id', $shelfe->shelfe_id)
                        ->delete();
                } else {
                    dd("Da is was im fach");
                }
            }
            if($part2[0] == $oldshelfe) {
                $new_shelfe = shelfes_archive::where("shelfe_id", $shelfe->shelfe_id)->first();
                if($new_shelfe->process_id == "0") {
                    $shelfe_new    = new shelfe();
                    $shelfe_new->process_id = "0";
                    $shelfe_new->shelfe_id  = $shelfe->shelfe_id;
                    $shelfe_new->component_number = "0";
                    $shelfe_new->component_id       = "0";
                    $shelfe_new->save();
                    DB::table('shelfes')
                    ->where('shelfe_id', $shelfe->shelfe_id)
                        ->delete();
                } else {
                    dd("Da is was im fach");
                }
            }
        }

       
       
       
       
       
       
       
       
       
       
       
       

        return redirect()->back();

    }
    
    public function regalLöschen(Request $req) {
        $shelfe         = $req->input("shelfe");
        
        $fach           = shelfe::where("shelfe_id", $shelfe)->first();
        if($fach != null) {
            DB::table('shelfes')
            ->where('shelfe_id', $shelfe)
                ->delete();
        } else {
            $fach       = shelfes_archive::where("shelfe_id", $shelfe)->first();
            if($fach != null) {
                DB::table('shelfes_archive')
                ->where('shelfe_id', $shelfe)
                    ->delete();
            } else {
                dd("error contact admin");
            }
        }
        return redirect()->back();
    }

    public function regalHinzufügen(Request $req) {

        $shelfe         = $req->input("shelfe");

        $fach                   = new shelfe();
        $fach->process_id       = "0";
        $fach->component_number = "0";
        $fach->component_id     = "0";
        $fach->shelfe_id        = $shelfe;
        $fach->save();

        return redirect()->back();

    }

    public function globaleAufträgeView(Request $req) {

        $shelfes        = shelfe::all();
        $orders         = active_orders_person_data::all();
        $countries      = countrie::all();

        return view("forEmployees/administration/globale-aufträge")->with("shelfes", $shelfes)->with("orders", $orders)->with("countries", $countries);

    }

    public function saveToPhoneHistory(Request $req, $id) {

        $history                = new phone_history();
        $history->process_id    = $id;
        $history->message       = $req->input("message");
        $history->lead_name     = $req->input("name");
        $history->employee      = $req->session()->get("username");
        $history->save();

        return redirect()->back();

    }

    public function newPhoneDate(Request $req, $id) {

        $date           = $req->input("date");
        $time           = $req->input("time");

        $callback = callback::where("process_id", $id)->first();

        if($callback != null) {
            $callback->employee   = $req->session()->get("username");
            $callback->date   = $date;
            $callback->time = $time;
            $callback->update();
        } else {
            $callback             = new callback();
            $callback->employee   = $req->session()->get("username");
            $callback->date   = $date;
            $callback->time = $time;
            $callback->process_id = $id;
            $callback->save();
        }

        return redirect()->back();

    }

    public function setPrimaryDevice(Request $req, $id) {
        $device     = device_orders::where("component_number", $id)->first();
        $primary        = primary_device::where("process_id", $device->process_id)->first();
        
        if($primary == null) {
            $primary    = new primary_device();
            $primary->process_id        = $device->process_id;
            $primary->component_number  = $id;
            $primary->component_id      = $device->component_id;
            $primary->component_count   = $device->component_count;
            $primary->component_type    = $device->component_type;
            $primary->save();
            return redirect()->back();
        } else {
            if($primary->component_number != $id) {
                $primary->delete();
                $primary    = new primary_device();
                $primary->process_id        = $device->process_id;
                $primary->component_number  = $id;
                $primary->component_id      = $device->component_id;
                $primary->component_count   = $device->component_count;
                $primary->component_type    = $device->component_type;
                $primary->save();
                return redirect()->back();
            } else {
                $primary->delete();
                return redirect()->back()->withErrors(["Das Gerät ist bereits ein Primäres Gerät! also wurde Gerät entfernt"]);
            }
        }
    }

    public function emailModalView(Request $req, $status, $id) {
        
        $status_id         = status_histori::where("process_id", $id)->where("last_status", $status)->first();
        if($status_id != null) {
            $mail           = email_template::where("id", $status-Id->email_template)->first();
        } else {
            $mail = null;
        }
        $person         = active_orders_person_data::where("process_id", $status)->first();
        if($mail != null) {
            return view("forEmployees/modals/email")->with("lead", $person)->with("mail", $mail);
        } else {
            $mail       = emails_history::where("process_id", $status)->where("created_at", $id)->first();
            if($mail != null) {
                return view("forEmployees/modals/email")->with("lead", $person)->with("mail", $mail);
            } else {
                return redirect()->back()->withErrors(["Es wurde keine Email bei diesem Status versendet"]);
            }
        }
    }

    public function getStatusView(Request $req) {
        $process_id     = $req->input("process_id");

        $person     = active_orders_person_data::where("process_id", $process_id)->first();

        if($person == null || $person == "") {
            return redirect("status")->withErrors(["Die Auftragsnummer existiert nicht."]);
        } else {
            $status         = status_histori::where("process_id", $process_id)->latest()->first();
            $statuses       = status_histori::where("process_id", $process_id)->get();
            $checkPublic    = statuse::where("id", $status->last_status)->first();
            if($status->last_status == "729") {
                $shipping   = warenausgang_history::where("process_id", $process_id)->first();
                if($shipping != null) {
                    return view("frontend/status")->with("faketime", null)->with("status", $status)->with("statusname", "Versand an Kunde")->with("shipping", $shipping);
                }
            } else {
                if($statuses->count() > 1) {
                    $currentDate = new DateTime();
                    if($status->updated_at->modify("+1 days") > $currentDate) {
                        $faketime = faketime::where("process_id", $process_id)->first();
                        if($faketime == null) {
                            $date = new DateTime(date("Y"). "-". date("m"). "-". date("d") - 1 . " ". random_int(8, 18). ":". random_int(1, 60) .":" . random_int(1, 60));
    
                            $faketime = new faketime();
                            $faketime->process_id = $process_id;
                            $faketime->time = $date;
                            $faketime->save();
                        } else {
                            $date = new DateTime($faketime->updated_at);
                            if($date->diff(new DateTime(date("Y"). "-". date("m"). "-". date("d") . " ". date("H:i:s")))->d >= 1) {
                                $date = new DateTime(date("Y"). "-". date("m"). "-". date("d") - 1 . " ". random_int(8, 18). ":". random_int(1, 60) .":" . random_int(1, 60));
                                $faketime->time = $date;
                                $faketime->update();
                            }
                        }
                    } else {
                        $faketime = null;
                    }
                } else {
                    $faketime = null;
                }
            }

            $dbstatus = statuse::where("id", $status->last_status)->first();
                if($person->blacklist_status == "yes") {
                    return view("frontend/status")->with("faketime", $faketime)->with("status", $dbstatus)->with("statusname", "Status konnte nicht gefunden werden.");
                } else {
                    return view("frontend/status")->with("faketime", $faketime)->with("status", $dbstatus)->with("person", $status);

                }
            

        }
        
    }

    public function getGlobaleSucheKeyword(Request $req, $search) {
        
        if($search != null) {
            $key        = $search;

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


            $active_orders = $active_orders->merge($leads);
            $active_orders = $active_orders->merge($rechnungen);
            return $active_orders;

        }

    }

    public function globaleSuche(Request $req) {

        $search         = $req->input("search");
        while(substr($search, 0, 1) == " ") {
            preg_replace('/0/', '', $search, 1);
        }

        $active         = active_orders_person_data::where("firstname", "LIKE", "%". $search . "%")->get();
        $active         = $active->toBase()->merge(active_orders_person_data::where("process_id", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(active_orders_person_data::where("lastname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(active_orders_person_data::where("company_name", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(active_orders_person_data::where("email", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(active_orders_person_data::where("phone_number", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(active_orders_person_data::where("mobile_number", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(active_orders_person_data::where("home_street", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(active_orders_person_data::where("send_back_street", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(active_orders_person_data::where("send_back_firstname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(active_orders_person_data::where("send_back_lastname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(active_orders_person_data::where("send_back_company_name", "LIKE", "%". $search . "%")->get()); 

        $active         = $active->toBase()->merge(archive_orders_person::where("process_id", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_orders_person::where("firstname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_orders_person::where("lastname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_orders_person::where("company_name", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_orders_person::where("email", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_orders_person::where("phone_number", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_orders_person::where("mobile_number", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_orders_person::where("home_street", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_orders_person::where("send_back_street", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_orders_person::where("send_back_firstname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_orders_person::where("send_back_lastname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_orders_person::where("send_back_company_name", "LIKE", "%". $search . "%")->get()); 

        $active         = $active->toBase()->merge(new_leads_person_data::where("process_id", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(new_leads_person_data::where("firstname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(new_leads_person_data::where("lastname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(new_leads_person_data::where("company_name", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(new_leads_person_data::where("email", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(new_leads_person_data::where("phone_number", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(new_leads_person_data::where("mobile_number", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(new_leads_person_data::where("home_street", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(new_leads_person_data::where("send_back_street", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(new_leads_person_data::where("send_back_firstname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(new_leads_person_data::where("send_back_lastname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(new_leads_person_data::where("send_back_company_name", "LIKE", "%". $search . "%")->get()); 

        $active         = $active->toBase()->merge(archive_lead_person_data::where("process_id", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_lead_person_data::where("firstname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_lead_person_data::where("lastname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_lead_person_data::where("company_name", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_lead_person_data::where("email", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_lead_person_data::where("phone_number", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_lead_person_data::where("mobile_number", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_lead_person_data::where("home_street", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_lead_person_data::where("send_back_street", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_lead_person_data::where("send_back_firstname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_lead_person_data::where("send_back_lastname", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(archive_lead_person_data::where("send_back_company_name", "LIKE", "%". $search . "%")->get()); 

        $active         = $active->toBase()->merge(warenausgang_history::where("label", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(warenausgang_history::where("process_id", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(warenausgang::where("process_id", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(warenausgang::where("component_number", "LIKE", "%". $search . "%")->get()); 

        $active         = $active->toBase()->merge(intern_history::where("component_number", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(intern_history::where("process_id", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(intern::where("process_id", "LIKE", "%". $search . "%")->get()); 
        $active         = $active->toBase()->merge(intern::where("component_number", "LIKE", "%". $search . "%")->get()); 

        $active         = $active->toBase()->merge(rechnungen::where("rechnungsnummer", "LIKE", "%". $search . "%")->get()); 

        $phones          = phone_history::where("message", "LIKE", "%". $search . "%")->get();
        foreach($phones as $phone) {
            if(active_orders_person_data::where("process_id", $phone->process_id)->get() != null) {
                $active         = $active->toBase()->merge(active_orders_person_data::where("process_id", $phone->process_id)->get()); 
            }
            if(archive_orders_person::where("process_id", $phone->process_id)->get() != null) {
                $active         = $active->toBase()->merge(archive_orders_person::where("process_id", $phone->process_id)->get()); 
            }
            if(new_leads_person_data::where("process_id", $phone->process_id)->get() != null) {
                $active         = $active->toBase()->merge(new_leads_person_data::where("process_id", $phone->process_id)->get()); 
            }
            if(archive_lead_person_data::where("process_id", $phone->process_id)->get() != null) {
                $active         = $active->toBase()->merge(archive_lead_person_data::where("process_id", $phone->process_id)->get()); 
            }
        }
        
        $active         = $active->unique();

     

        $statuses       = statuse::all();
        $orders         = order_id::all();

        return $active;

    }

    public function aufträgeFiltern(Request $req) {

        $count          = $req->input("count");
        $type           = $req->input("type");
        $direction      = $req->input("direction");
        $status         = $req->input("status");
        $ac_order       = collect();
        $status_param   = statuse::where("id", $status)->first();
        $statuses       = statuse::all();

        if($type == "Aktualisierungsdatum" || $type == "Erstelldatum" || $type == "Auftragsnummer") {
            if($status == "nachnahme") {
                $status = "none";
            }
        }
        
        if($type == "payment"){
            if($status != "nachnahme" && $status != "transfer" && $status != "cash") {
                $status         = "nachnahme";
            }
            $payments       = array("nachnahme", "transfer", "cash");
            switch ($status) {
                case 'nachnahme':
                    $param          = array($count, $type, $direction, $payments, "payment", "nachnahme", "Nachnahme");
                    break;
                case 'transfer':
                    $param          = array($count, $type, $direction, $payments, "payment", "transfer", "Überweisung");
                    break;
                case 'cash':
                    $param          = array($count, $type, $direction, $payments, "payment", "cash", "Bar");
                    break;
                default:
                    $param          = array($count, $type, $direction, $payments, "payment", "nachnahme", "Nachnahme");
                    break;
            }
        } else {
            if($status_param != null) {
                $param          = array($count, $type, $direction, $status_param, "status");
            } else {
                $param          = array($count, $type, $direction, "Bitte Auswählen", "status");
            }
        }
        switch ($type) {
            case 'Aktualisierungsdatum':
                if($status == "all") {
                    if($direction == "Aufsteigend") {
                        $orders     = active_orders_person_data::limit($count)->get();
                        return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortBy("updated_at"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);    
                    } else {
                        $orders     = active_orders_person_data::limit($count)->get();
                        return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortByDesc("updated_at"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                    } 
                }
                if($status == "none") {
                    if($direction == "Aufsteigend") {
                        $orders     = active_orders_person_data::limit($count)->get();
                        return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortBy("updated_at"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                    } else {
                        $orders     = active_orders_person_data::limit($count)->get();
                        return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortByDesc("updated_at"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                    }
                } else {
                    $status         = statuse::where("id", $status)->first();
                    if($status != null) {
                        if($direction == "Aufsteigend") {

                            $orders             = active_orders_person_data::all();
                            $order_status       = order_id::all();
                            $order_array        = active_orders_person_data::where("process_id", "awdawdawdawd")->first();
                            foreach($order_status as $order) {
                                if($order->current_status == $status->id) {

                                    if($ac_order->count() < $count) {
                                        $ac_order = $ac_order->toBase()->merge(active_orders_person_data::where("process_id", $order->process_id)->get());
                                    }                                   
                                }
                            }
                        return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $ac_order->sortBy("updated_at"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                    } else {
                        $orders             = active_orders_person_data::all();
                            $order_status       = order_id::all();
                            $order_array        = active_orders_person_data::where("process_id", "awdawdawdawd")->first();
                            foreach($order_status as $order) {
                                if($order->current_status == $status->id) {

                                    if($ac_order->count() < $count) {
                                        $ac_order = $ac_order->toBase()->merge(active_orders_person_data::where("process_id", $order->process_id)->get());
                                    }                                   
                                }
                            }
                        return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $ac_order->sortByDesc("updated_at"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                    }

                        } else {
                            
                    }
                }
                break;
            case 'Erstelldatum':
            if($status == "all") {
                if($direction == "Aufsteigend") {
                    $orders     = active_orders_person_data::limit($count)->get();
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortBy("created_at"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);    
                } else {
                    $orders     = active_orders_person_data::limit($count)->get();
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortByDesc("created_at"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                } 
            }
            if($status == "none") {
                if($direction == "Aufsteigend") {
                    $orders     = active_orders_person_data::limit($count)->get();
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortBy("created_at"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                } else {
                    $orders     = active_orders_person_data::limit($count)->get();
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortByDesc("created_at"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                }
            } else {
                $status         = statuse::where("id", $status)->first();
                if($status != null) {
                    if($direction == "Aufsteigend") {

                        $orders             = active_orders_person_data::all();
                        $order_status       = order_id::all();
                        $order_array        = active_orders_person_data::where("process_id", "awdawdawdawd")->first();
                        foreach($order_status as $order) {
                            if($order->current_status == $status->id) {

                                if($ac_order->count() < $count) {
                                    $ac_order = $ac_order->toBase()->merge(active_orders_person_data::where("process_id", $order->process_id)->get());
                                }                               
                            }
                        }
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $ac_order->sortBy("created_at"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                } else {
                    $orders             = active_orders_person_data::all();
                        $order_status       = order_id::all();
                        $order_array        = active_orders_person_data::where("process_id", "awdawdawdawd")->first();
                        foreach($order_status as $order) {
                            if($order->current_status == $status->id) {

                                if($ac_order->count() < $count) {
                                    $ac_order = $ac_order->toBase()->merge(active_orders_person_data::where("process_id", $order->process_id)->get());
                                }                               
                            }
                        }
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $ac_order->sortByDesc("created_at"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                }

                    } else {
                        
                }
            }
            case 'Auftragsnummer':
            if($status == "all") {
                if($direction == "Aufsteigend") {
                    $orders     = active_orders_person_data::limit($count)->get();
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortBy("process_id"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);    
                } else {
                    $orders     = active_orders_person_data::limit($count)->get();
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortByDesc("process_id"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                } 
            }
            if($status == "none") {
                if($direction == "Aufsteigend") {
                    $orders     = active_orders_person_data::limit($count)->get();
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortBy("process_id"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                } else {
                    $orders     = active_orders_person_data::limit($count)->get();
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortByDesc("process_id"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                }
            } else {
                $status         = statuse::where("id", $status)->first();
                if($status != null) {
                    if($direction == "Aufsteigend") {

                        $orders             = active_orders_person_data::all();
                        $order_status       = order_id::all();
                        $order_array        = active_orders_person_data::where("process_id", "awdawdawdawd")->first();
                        foreach($order_status as $order) {
                            if($order->current_status == $status->id) {

                                if($ac_order->count() < $count) {
                                    $ac_order = $ac_order->toBase()->merge(active_orders_person_data::where("process_id", $order->process_id)->get());
                                }
                            }
                        }
                        
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $ac_order->sortBy("process_id"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                } else {
                    $orders             = active_orders_person_data::all();
                        $order_status       = order_id::all();
                        $order_array        = active_orders_person_data::where("process_id", "awdawdawdawd")->first();
                        foreach($order_status as $order) {
                            if($order->current_status == $status->id) {

                                $ac_order = $ac_order->toBase()->merge(active_orders_person_data::where("process_id", $order->process_id)->get());
                               
                            }
                        }
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $ac_order->sortByDesc("process_id"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                }

                    } else {
                        
                }
            }

            case 'payment':
            if($status == "none") {
                if($direction == "Aufsteigend") {
                    $orders     = active_orders_person_data::limit($count)->get();
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortBy("process_id"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                } else {
                    $orders     = active_orders_person_data::limit($count)->get();
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $orders->sortByDesc("process_id"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                }
            } else {
                
                    if($direction == "Aufsteigend") {

                        $ac_order   = active_orders_person_data::where("payment_type", $status)->limit($count)->get();
                        
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $ac_order->sortBy("process_id"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                } else {
                        
                    $ac_order   = active_orders_person_data::where("payment_type", $status)->limit($count)->get();
                    return view("forEmployees/orders/main")->with("statuses", $statuses)->with("active_orders", $ac_order->sortByDesc("process_id"))->with("new_lead_count", 2)->with("lead_count", 2)->with("param", $param);
                }

                   
                
            }

            default:
                # code...
                break;
        }

    }

    public function sortTable(Request $req, $area, $type, $direction) {

        if($area == "orders") {
            
        }

    }

    public function vollmachtView(Request $req) {

        return view("forEmployees/administration/vollmacht");

    }

    public function internSperren(Request $req, $id) {

        $intern         = intern::where("process_id", $id)->first();

        if($intern != null) {
            $intern->locked     = "yes";
            $intern->update();
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors(["Auftrag wurde nicht gefunden"]);
        }

    }

    public function warenausgangSperren(Request $req, $id, $date) {

        $as         = warenausgang::where("component_number", $id)->where("created_at", $date)->first();
        if($as != null) {
            DB::table('warenausgang')
            ->where('component_number', $id)
            ->update(['locked' => "yes"]);

            return redirect()->back();
        } else {
            return redirect()->back()->withErrors(["Auftrag wurde nicht gefunden"]);
        }

    }

    public function warenausgangEntsperren(Request $req, $id, $date) {

        $as         = warenausgang::where("component_number", $id)->where("created_at", $date)->first();
        if($as != null) {
            DB::table('warenausgang')
            ->where('component_number', $id)
            ->update(['locked' => "no"]);

            return redirect()->back();
        } else {
            return redirect()->back()->withErrors(["Auftrag wurde nicht gefunden"]);
        }

    }

    /**
     * Summary of internEntsperren
     * @param Request $req
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse|mixed
     */  
    public function internEntsperren(Request $req, $id) {

        $intern         = intern::where("process_id", $id)->first();

        if($intern != null) {
            $intern->update();
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors(["Auftrag wurde nicht gefunden"]);
        }

    }

    public function sortOrders(Request $req, $type, $direc) {
       
            if($type == "status") {
                if($direc == "asc") {
                    $orders         = active_orders_person_data::with("orderId.statuse")->get()->sortBy("orderId.statuse.name");
                } else {
                    $orders         = active_orders_person_data::with("orderId.statuse")->get()->sortByDesc("orderId.statuse.name");
                }
            } else {
                if($direc == "asc") {
                    $orders         = active_orders_person_data::all()->sortBy($type);
                } else {
                    $orders         = active_orders_person_data::all()->sortByDesc($type);
                }
            }
        
        

        $helpercodes        = helpercode::all();
        
        
        return view("forEmployees/orders/main")->with("active_orders", $orders)->with("helpercodes", $helpercodes)->with("new_lead_count", "0")->with("lead_count", "0");

    }

    public function emailOrderBearbeitenView(Request $req, $id, $emailid) {

        $email      = email_template::where("id", $emailid)->first();
         $person             = active_orders_person_data::where("process_id", $id)->with("orderId.statuse")->with("activeOrdersCarData")->first();
        $countries          = countrie::all();
        $statuses           = statuse::where("type", "1")->get()->sortBy("color");
        $shelfes            = shelfe::all();
        $files              = ModelsFile::where("process_id", $id)->get()->sortByDesc("created_at");

        $techniker          = contact::all();
    

        $status_history         = status_histori::where("process_id", $id)->get()->sortByDesc("created_at");

        $email_templates        = email_template::where("type", "1")->get();

        $devices                = device_orders::where("process_id", $id)->with("shelfe")->get()->sortByDesc("created_at");
        $components             = component_name::all();
        $order                  = order_id::where("process_id", $id)->first();

        $intern                 = intern_admin::where("process_id", $id)->first();
        $warenausgang           = warenausgang::where("process_id", $id)->get();
        $intern_af              = intern::where("process_id", $id)->get();

        $inshipping             = inshipping::where("process_id", $id)->get();

        $primary_device         = primary_device::where("process_id", $id)->first();
        if($primary_device != null) {
            $prim                   = device_orders::where("component_number", $primary_device->component_number)->first();
            $component             = component_name::where("id", $prim->component)->first();
            $action ="";
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
                if($action != null) {
                    $bpzs                   = bpzfile::where("component_name", $component->name)->where("action", $action)->first();

                } else {
                    $bpzs                   = null;
                }
            } else {
                $bpzs                   = null;
            }
        } else {
            $bpzs = null;
        }

        $vergleich      = vergleichstext::all();

        $contacts       = contact::all();

        $bookings      = booking::where("process_id", $id)->get();
        $email_history = emails_history::where("process_id", $id)->get();

        $phonehistory = phone_history::where("process_id", $id)->get();

        $arch_shelfes = shelfes_archive::all();

        $sh = shelfes_archive::where("process_id", $id)->get();

        $auftragshistory = auftragshistory::where("process_id", $id)->get();

        return view("forEmployees/orders/change")->with("person", $person)->with("countries", $countries)->with("statuses", $statuses)
            ->with("shelfes", $shelfes)
            ->with("devices", $devices) 
            ->with("tab", "status")
            ->with("files", $files)
            ->with("status_history", $status_history)
            ->with("email_templates", $email_templates)
            ->with("components", $components)
            ->with("intern", $intern)
            ->with("techniker", $techniker)
            ->with("order", $order)
            ->with("intern_auf", $intern_af)
            ->with("warenausgang", $warenausgang)
            ->with("inshipping", $inshipping)
            ->with("primary_device", $primary_device)
            ->with("bpzs", $bpzs)
            ->with("vergleich", $vergleich)
            ->with("contacts", $contacts)
            ->with("email", $email)
            ->with("phonehistory", $phonehistory)
            ->with("e_his", $email_history)
            ->with("sh", $sh)
            ->with("auftragshistory", $auftragshistory);
            


    }

    public function sendCustomEmail(Request $req) {

        $absender       = $req->input("absender");
        $subject        = $req->input("betreff");
        $body           = $req->input("body");
        $process_id     = $req->input("process_id");
        $user           = active_orders_person_data::where("process_id", $process_id)->first();
        if($user == null) {
        $user       = new_leads_person_data::where("process_id", $process_id)->first();
        }

        $car = active_orders_car_data::where("process_id", $process_id)->first();
        if($car == null) {
            $car = new_leads_car_data::where("process_id", $process_id)->first();
        }

        try {
            Mail::to($user->email)->send(new custom_mail($subject, $body, $user, $car));
            $m = new emails_history();
            $m->process_id = $user->process_id;
            $m->subject = $subject;
            $m->employee    = $req->session()->get("username");
            $m->body        = $body;
            $m->save();

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function neuePhonehistory(Request $req, $id) {

        $comment        = $req->input("comment");

        $phone      = new phone_history();
        $phone->process_id  = $id;
        $phone->message     = $comment;
        $phone->employee    = $req->session()->get("username");
        $phone->lead_name = $req->input("subject");
        $phone->save();

        return redirect()->back();

    }

    public function neuerAuftraghistory(Request $req, $id) {

        $subject        = $req->input("subject");
        $comment        = $req->input("comment");
        $employee       = $req->session()->get("username");

        $his                = new auftragshistory;
        $his->subject       = $subject;
        $his->message       = $comment;
        $his->employee      = $employee;
        $his->process_id    = $id;
        $his->save();

        return redirect()->back();

    }

    public function externVersendenKundenauswahl(Request $req, $id, $selectedDevices = null, $contact = null) {


        $order      = active_orders_person_data::where("process_id", $id)->first();
        $devices    = device_orders::where("process_id", $id)->get();
        $persons    = active_orders_person_data::all();
        $countries  = countrie::all();
        $contacts   = contact::all();
        $versandContact = contact::where("id", $selectedDevices)->first();
        
        if($versandContact != null && $versandContact->id == $selectedDevices) {
            $contact = $versandContact->id;
            $selectedDevices = null;
        }
        $selectedDevices = explode("!", str_replace(" ", "", $selectedDevices));
        if($contact != null) {
            $versandContact = contact::where("id", $contact)->first();
            return view("forEmployees/packtisch/versenden")->with("selectedDevices", $selectedDevices)->with("versandContact", $versandContact)->with("order", $order)->with("contacts", $contacts)->with("persons", $persons)->with("devices", $devices)->with("countries", $countries);
        } else {
            return view("forEmployees/packtisch/versenden")->with("selectedDevices", $selectedDevices)->with("order", $order)->with("contacts", $contacts)->with("persons", $persons)->with("devices", $devices)->with("countries", $countries);

        }



    }

    public function addToBlacklist(Request $req, $id) {

        $person = active_orders_person_data::where("process_id", $id)->first();

        $person->blacklist_status = "yes";
        $person->update();

        return redirect()->back();

    }

    public function removeFromBlacklist(Request $req, $id) {
        $person = active_orders_person_data::where("process_id", $id)->first();

        $person->blacklist_status = "no";
        $person->update();

        return redirect()->back();

    }

    public function getShippingStatusView(Request $req, $label, $id) {

        $ups = new UPS();
        $trackings = $ups->getTracking($label);

        $ausgang = warenausgang_history::where("label", $label)->where("process_id", $id)->first();
      
        $person             = active_orders_person_data::where("process_id", $id)->with("orderId.statuse")->with("activeOrdersCarData")->first();
        $countries          = countrie::all();
        $statuses           = statuse::where("type", "1")->get()->sortBy("color");
        $shelfes            = shelfe::all();
        $files              = ModelsFile::where("process_id", $id)->get()->sortByDesc("created_at");

        $techniker          = contact::all();
    
        $contact = null;

        $status_history         = status_histori::where("process_id", $id)->get()->sortByDesc("created_at");

        $email_templates        = email_template::where("type", "1")->get();

        $devices                = device_orders::where("process_id", $id)->with("shelfe")->get()->sortByDesc("created_at");
        $components             = component_name::all();
        $order                  = order_id::where("process_id", $id)->first();

        $intern                 = intern_admin::where("process_id", $id)->first();
        $warenausgang           = warenausgang::where("process_id", $id)->get();
        $intern_af              = intern::where("process_id", $id)->get();

        $inshipping             = inshipping::where("process_id", $id)->get();

        $primary_device         = primary_device::where("process_id", $id)->first();
        if($primary_device != null) {
            $prim                   = device_orders::where("component_number", $primary_device->component_number)->first();
            $component             = component_name::where("id", $prim->component)->first();
            $action ="";
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
                if($action != null) {
                    $bpzs                   = bpzfile::where("component_name", $component->name)->where("action", $action)->first();

                } else {
                    $bpzs                   = null;
                }
            } else {
                $bpzs                   = null;
            }
        } else {
            $bpzs = null;
        }

        $vergleich      = vergleichstext::all();

        $contacts       = contact::all();

        $bookings      = booking::where("process_id", $id)->get();

        $email_history = emails_history::where("process_id", $id)->get();

        $phonehistory = phone_history::where("process_id", $id)->get();

        $arch_shelfes = shelfes_archive::all();

        $sh = shelfes_archive::where("process_id", $id)->get();

        $auftragshistory = auftragshistory::where("process_id", $id)->get();

        $emailUUIDS = emailUUID::where("process_id", $id)->get();

        return view("forEmployees/orders/change")->with("person", $person)->with("countries", $countries)->with("statuses", $statuses)
            ->with("shelfes", $shelfes)
            ->with("devices", $devices) 
            ->with("tab", "status")
            ->with("files", $files)
            ->with("status_history", $status_history)
            ->with("email_templates", $email_templates)
            ->with("components", $components)
            ->with("intern", $intern)
            ->with("techniker", $techniker)
            ->with("contactt", $contact)
            ->with("order", $order)
            ->with("intern_auf", $intern_af)
            ->with("warenausgang", $warenausgang)
            ->with("inshipping", $inshipping)
            ->with("primary_device", $primary_device)
            ->with("bpzs", $bpzs)
            ->with("vergleich", $vergleich)
            ->with("contacts", $contacts)
            ->with("e_his", $email_history)
            ->with("phonehistory", $phonehistory)
            ->with("arch_shelfes", $arch_shelfes)
            ->with("sh", $sh)
            ->with("auftragshistory", $auftragshistory)
            ->with("bookings", $bookings)
            ->with("emailUUIDS", $emailUUIDS)
            ->with("trackings", $trackings)
            ->with("ausgang", $ausgang);
    }
    
    public function setMultiStatusOrder(Request $req) {

        $status = $req->input("multistatus-status");
        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "-order")) {
                $stat = status_histori::where("process_id", $item)->latest()->first();
                if($stat->last_status != 7018) {
                   $this->newTelefonStatus($item, $status);
                }
            }
        }

        return redirect()->back();
    }

    public function setBottomStatus(Request $req) {
        $status = $req->input("bottom-sel");


        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "-order")) {
               if($status == "archiv") {
                    $this->moveOrderToArchiv($req, $item);
               } else {
                if($status == "orders") {
                    $this->moveto_orders($req, $item);
                } else {
                     $this->newTelefonStatus($item, $status);
              
                }
               }
            }
        }

        return redirect()->back();

    }

    public function setMultiStatusInteressenten(Request $req) {
        
        $status = $req->input("multistatus-status");
        

        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "-order")) {
                $this->newTelefonStatus($item, $status);
               
            }
        }

        return redirect()->back();
    }

    public function OrderViewSort(Request $req) {

        $count          = $req->input("count");
        $sort           = $req->input("direction");
        $type           = $req->input("field");
        $status         = $req->input("status");
        $buchhaltung    = $req->input("buchhaltung");
        $von            = $req->input("von");
        $bis            = $req->input("bis");
        $area           = $req->input("area");
        $zuweisung      = $req->input("zuweisung");

        $firstdate = new DateTime($von);
        $seconddate = new DateTime($bis);
        $filter = 0;

        if($buchhaltung != null) {

            if(str_contains($buchhaltung, "mahnstufe")) {
                $mahnstufe = explode("-", $buchhaltung)[1];
                $mahnungen = mahnungen::where("mahnstufe",$mahnstufe)->where("process_id", null)->get();
                $person = collect();
                $usedRechnunge = array();
                foreach ($mahnungen as $mahnung) {
                    $rechnung = rechnungen::where("rechnungsnummer", $mahnung->rechnungsnummer)->whereBetween("created_at", [$firstdate, $seconddate])->first();
                    if($rechnung != null) {
                        $kundenkonto = kontoModel::where("kundenid", $rechnung->kundenid)->first();
                        if($kundenkonto != null) {
                            $p = active_orders_person_data::where("process_id", $kundenkonto->process_id)->with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->first();

                            $person->push($p);
                        }
                    }
                    
                }
                $filter = "Mahnstufe";

            }

            if($buchhaltung == "mahnsperre") {
                $mahnungen = mahnungen::where("process_id","sperre")->get();
                $person = collect();

                foreach ($mahnungen as $mahnung) {
                    $rechnung = rechnungen::where("rechnungsnummer", $mahnung->rechnungsnummer)->whereBetween("created_at", [$firstdate, $seconddate])->first();
                    if($rechnung != null) {
                        $kundenkonto = kontoModel::where("kundenid", $rechnung->kundenid)->first();
                        if($kundenkonto != null) {
                            $p = active_orders_person_data::where("process_id", $kundenkonto->process_id)->with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->first();
                            $person->push($p);
                        }
                    }
                   
                }
                $filter = "Mahnsperre";

            }

            if($buchhaltung == "keine-rechnungen") {
                $kundenkonten = kontoModel::all();
                $person = collect();

                foreach($kundenkonten as $konto) {
                    $rechnung = rechnungen::where("process_id", $konto->process_id)->whereBetween("created_at", [$firstdate, $seconddate])->first();
                    if($rechnung == null) {
                        $p = active_orders_person_data::where("process_id", $konto->process_id)->with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->first();
                        if($p != null) {
                            $person->push($p);
                        }
                    }
                }
                $filter = "keine Rechnungen";

            }

            if($buchhaltung == "rechnungen") {
                $kundenkonten = kontoModel::all();
                $person = collect();

                foreach($kundenkonten as $konto) {
                    $rechnung = rechnungen::where("process_id", $konto->process_id)->whereBetween("created_at", [$firstdate, $seconddate])->first();
                    if($rechnung != null) {
                        $p = active_orders_person_data::where("process_id", $konto->process_id)->with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->first();
                        if($p != null) {
                            $person->push($p);
                        }
                    }
                }
                $filter = "Rechnungen";
            }

            if($buchhaltung == "gutschriften") {
                $person = collect();

                foreach($kundenkonten as $konto) {
                    $rechnung = rechnungen::where("process_id", $konto->process_id)->whereBetween("created_at", [$firstdate, $seconddate])->first();
                    if($rechnung != null) {
                        $p = active_orders_person_data::where("process_id", $konto->process_id)->with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->first();
                        if($p != null) {
                            $person->push($p);
                        }
                    }
                }
                                $filter = "Gutschrift";
            }

            if($buchhaltung == "nachnahme") {
                $person = collect();
                $kundenkonten = kontoModel::all();

                foreach($kundenkonten as $konto) {
                    $rechnung = rechnungen::where("process_id", $konto->process_id)->whereBetween("created_at", [$firstdate, $seconddate])->get();
                    if(isset($rechnung[0])) {
                        $rechnung = $rechnung->sortBy("created_at")->where("bezeichnung", "Nachnahme")->first();
                        if($rechnung != null) {
                            $p = active_orders_person_data::where("process_id", $konto->process_id)->with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->first();
                        if($p != null) {
                            $person->push($p);
                        }
                        }
                    }
                }
                                $filter = "Nachnahme";
            }

            if($buchhaltung == "bezahlt") {
                $kundenkonten = active_orders_person_data::all();
                $person = collect();

                foreach($kundenkonten as $konto) {
                    $rechnung = rechnungen::where("kundenid", $konto->kunden_id)->whereBetween("created_at", [$firstdate, $seconddate])->first();
                    if($rechnung != null) {
                        
                        $p = active_orders_person_data::where("process_id", $konto->process_id)->with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->first();
                        if($p != null) {
                            if($this->checkBezahlt($p->process_id) == "bezahlt") {
                                $person->push($p);
                            }
                        }
                    }
                }
                $filter = "Bezahlt";
            }

            if($buchhaltung == "nicht-bezahlt") {
                $kundenkonten = active_orders_person_data::all();
                $person = collect();

                foreach($kundenkonten as $konto) {
                    $rechnung = rechnungen::where("kundenid", $konto->kunden_id)->whereBetween("created_at", [$firstdate, $seconddate])->first();
                    if($rechnung != null) {
                        
                        $p = active_orders_person_data::where("process_id", $konto->process_id)->with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->first();
                        if($p != null) {
                            if($this->checkBezahlt($p->process_id) == "nicht-bezahlt") {
                                $person->push($p);
                            }
                        }
                    }
                }
                $filter = "Nicht bezahlt";
            }

            $users = user::all();
            $email = emailinbox::where("read_at", null)->get();
            $allStats = statuse::all();

            
            if($status != "all") {
                $statuses = statuse::where("id", $status)->get();
            } else {
                $statuses = statuse::all();
            }

            $einkäufe = einkauf::all();


            return view("forEmployees/orders/main")
                    ->with("active_orders", $person)
                    ->with("allStats", $allStats)
                    ->with("statuses", $statuses)
                    ->with("users", $users)
                    ->with("emailRead", $email)
                    ->with("buchhaltung", $buchhaltung)
                    ->with("sort_type", $type)
                    ->with("sort_count", $count)
                    ->with("einkäufe", $einkäufe)
                    ->with("filter", $filter)
                    ->with("area", $area)
                    ->with("von", $von)
                    ->with("bis", $bis);

        } else {
            if($zuweisung != null) {
                $person = active_orders_person_data::whereHas('zuweisung', function ($query) use ($zuweisung) {
                    $query->where('employee', $zuweisung);
                })->with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->whereBetween("created_at", [$firstdate, $seconddate])->limit($count)->get();    
            } else {
                $person = active_orders_person_data::with("statuse.statuseMain")->with("activeOrdersCarData")->with("files")->whereBetween("created_at", [$firstdate, $seconddate])->limit($count)->get();
            }


            if($sort == "up") {
                $sorting    = "up";
                $person     = $person->sortBy($type);
            } else {
                $sorting    = "down";
                $person     = $person->sortByDesc($type);
            }
    
            if($status != "all") {
                $statuses = statuse::where("id", $status)->get();
            } else {
                $statuses = statuse::all();
            }
            $users = user::all();
            $email = emailinbox::where("read_at", null)->get();
            $allStats = statuse::all();
            
            $einkäufe = einkauf::all();
            if($area == "both") {
                foreach($person as $p) {
                    $p->archiv = false;
                }
            }


            return view("forEmployees/orders/main")
                    ->with("active_orders", $person)
                    ->with("allStats", $allStats)
                    ->with("statuses", $statuses)
                    ->with("users", $users)
                    ->with("emailRead", $email)
                    ->with("sorting", $type. "-" . $sort)
                    ->with("buchhaltung", $buchhaltung)
                    ->with("sort_type", $type)
                    ->with("sort_count", $count)
                    ->with("von", $von)
                    ->with("bis", $bis)
                    ->with("zuweisung", $zuweisung)
                    ->with("einkäufe", $einkäufe);

        }
    }

    public function checkBezahlt($process_id) {
        $id = $process_id;
        $order = active_orders_person_data::where("process_id", $id)->first();


        $rechnungen = rechnungen::where("kundenid", $order->kunden_id)->get();
        $rechnungsPrice = 0;
        foreach($rechnungen as $rechnung) {
            if(strlen($rechnung->rechnungsnummer) > 4) {
                $rechnungsPrice += $rechnung->bruttobetrag;
            }
        }

        $zahlungen = zahlungen::where("kundenid", $order->kunden_id)->get();
        $gezahlt = 0;
        foreach($zahlungen as $zahlung) {
            $gezahlt += $zahlung->betrag;
        }

        $price = $rechnungsPrice - $gezahlt;

        if($price <= 0) {
            return "bezahlt";
        } else {
            return "nicht-bezahlt";
        }
    }
    
    public function InteressentenViewSort(Request $req) {

        $count          = $req->input("count");
        $sort           = $req->input("direction");
        $type           = $req->input("field");
        $status         = $req->input("status");
        $buchhaltung    = $req->input("buchhaltung");
        $zuweisung      = $req->input("buchhaltung");
        
        $orders = active_orders_person_data::with("statuse")->get();

        $konvertLeads = 0;
        foreach($orders as $order) {
            $stat = status_histori::where("process_id", $order->process_id)->where("last_status", "36")->first();
            if($stat == null) {
                $konvertLeads++;
            }
        }
        
        $person = new_leads_person_data::whereHas('zuweisung', function ($query) use ($zuweisung) {
            $query->where('employee', $zuweisung);
        })->with("statuse.statuseMain")->with("newLeadsCarData")->with("files")->limit($count)->get();

    
        if($sort == "up") {
            $sorting    = "up";
            $person     = $person->sortBy($type);
        } else {
            $sorting    = "down";
            $person     = $person->sortByDesc($type);
        }
        
        if($status != "all") {
            $statuses = statuse::where("id", $status)->get();
        } else {
            $statuses = statuse::where("type", "Interessenten")->get();
        }
    
        $users = user::all();
        $email = emailinbox::where("read_at", null)->get();
        $allStats = statuse::where("type", "Interessenten")->get();

        return view("forEmployees/interessenten/main")
                ->with("leads", $person)
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("emailRead", $email)
                ->with("sorting", $type. "-" . $sort)
                ->with("buchhaltung", $buchhaltung)
                ->with("sort_type", $type)
                ->with("sort_count", $count)
                ->with("konvertLeads", $konvertLeads)
                ->with("orders", $orders)
                ->with("statusfilter", $status);
                

    }

    public function setQuickStatus(Request $req) {
        $newStatus      = $req->input("status");
        $process_id     = $req->input("process_id");
        $statuse       = statuse::where("id", $newStatus)->first();
        $this->newTelefonStatus($process_id, $statuse->id);

        return redirect()->back();

    }

    public function getKundenübersichtView(Request $req) {

        $allStats = statuse::all();
        $statuses = statuse::all();
        $kunden = kontoModel::with("merged_person_datas")->get();
        $users = user::all();

        return view("forEmployees.kunden.main")
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("kunden", $kunden)
                ->with("users", $users);
    }


    public function editKundenData(Request $req, $id) {

        $allStats = statuse::all();

        $users = user::all();
        $countries = countrie::all();

        $editKunde = active_orders_person_data::where("kunden_id", $id)->with("activeOrdersCarData")->with("statuse.statuseMain")->get();
        $editKundenHistory = rechnungsdaten_verlauf::where("process_id", $editKunde[0]->process_id)->get()->sortByDesc("created_at");

        return view("forEmployees.modals.kundenÜbersichtEdit")
                ->with("allStats", $allStats)
                ->with("users", $users)
                ->with("editKunde", $editKunde)
                ->with("countries", $countries)
                ->with("editKundenHistory", $editKundenHistory);
    }

    public function changeKundenDatenSave(Request $req) {
    
        $auftrag = active_orders_person_data::where("process_id", $req->input("id"))->first();
        if($auftrag == null) {
            $auftrag = new_leads_person_data::where("process_id", $req->input("id"))->first();
        }

        $auftrag->firstname                 = $req->input("firstname");
        $auftrag->lastname                  = $req->input("lastname");
        $auftrag->gender                    = $req->input("gender");
        $auftrag->company_name              = $req->input("home_companyname");
        $auftrag->home_street               = $req->input("home_street");
        $auftrag->home_street_number        = $req->input("home_street_number");
        $auftrag->home_zipcode              = $req->input("home_zipcode");
        $auftrag->home_city                 = $req->input("home_city");
        $auftrag->home_country              = $req->input("home_country");
        $auftrag->email                     = $req->input("email");
        $auftrag->mobile_number             = $req->input("mobil_number");
        $auftrag->phone_number              = $req->input("phone_number");
        $auftrag->send_back_gender          = $req->input("send_back_gender");
        $auftrag->send_back_company_name    = $req->input("send_back_company_name");
        $auftrag->send_back_firstname       = $req->input("send_back_firstname");
        $auftrag->send_back_lastname        = $req->input("send_back_lastname");
        $auftrag->send_back_street          = $req->input("send_back_street");
        $auftrag->send_back_street_number   = $req->input("send_back_street_number");
        $auftrag->send_back_zipcode         = $req->input("send_back_zipcode");
        $auftrag->send_back_city            = $req->input("send_back_city");
        $auftrag->send_back_country         = $req->input("send_back_country");
        $auftrag->save();

        $history                = new rechnungsdaten_verlauf();
        $history->firstname     = $req->input("firstname");
        $history->lastname      = $req->input("lastname");
        $history->gender        = $req->input("gender");
        $history->street        = $req->input("home_street");
        $history->streetno      = $req->input("home_street_number");
        $history->zipcode       = $req->input("home_zipcode");
        $history->city          = $req->input("home_city");
        $history->country       = $req->input("home_country");
        $history->phone         = $req->input("phone_number");
        $history->mobil         = $req->input("mobile_number");
        $history->email         = $req->input("email");
        $history->process_id    = $auftrag->process_id;

        $history->la_firstname  = $req->input("send_back_firstname");
        $history->la_lastname   = $req->input("send_back_lastname");
        $history->la_gender     = $req->input("send_back_gender");
        $history->la_street     = $req->input("send_back_street");
        $history->la_streetno   = $req->input("send_back_street_number");
        $history->la_zipcode    = $req->input("send_back_zipcode");
        $history->la_city       = $req->input("send_back_city");
        $history->la_country    = $req->input("send_back_ountry");
        $history->save();

        return $this->editKundenData($req, $auftrag->kunden_id);
    }

    public function sortKundenDatenTable(Request $req, $field, $type) {

        $allStats = statuse::all();
        $statuses = statuse::all();
        $kundenkonten = kontoModel::all();

        $active_orders = collect();
        foreach($kundenkonten as $konto) {
            $order = active_orders_person_data::where("kunden_id", $konto->kundenid)->with("files")->latest()->first();
            if($order != null) {
                $active_orders->push($order);
            }
        }

        $users = user::all();   

        if($type == "up") {
            $sorting    = "up";
            $active_orders     = $active_orders->sortByDesc($field);
        } else {
            $sorting    = "down";
            $active_orders     = $active_orders->sortBy($field);
        }

            
        return view("forEmployees.kunden.main")
        ->with("allStats", $allStats)
        ->with("statuses", $statuses)
        ->with("active_orders", $active_orders)
        ->with("users", $users)
        ->with("sorting", $field."-".$sorting);
    }

    public function interessentenSortieren(Request $req, $field, $type) {

        $person = new_leads_person_data::with("statuse")->with("newLeadsCarData")->with("zuweisung")->with("files")->get();

        $orders = active_orders_person_data::with("statuse")->get();

        $konvertLeads = 0;
        foreach($orders as $order) {
            $status = status_histori::where("process_id", $order->process_id)->where("last_status", "36")->first();
            if($status == null) {
                $konvertLeads++;
            }
        }

        $statuses = statuse::where("type", "Interessenten")->get();
        $users = user::all();
        $email = emailinbox::where("read_at", null)->get();
        $allStats = statuse::where("type", "Interessenten")->get();

        if($type == "up") {
            $sorting    = "up";
            $person     = $person->sortByDesc($field);
        } else {
            $sorting    = "down";
            $person     = $person->sortBy($field);
        }
        
        return view("forEmployees/interessenten/main")
                ->with("leads", $person)
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("emailRead", $email)
                ->with("konvertLeads", $konvertLeads)
                ->with("orders", $orders)
                ->with("sorting", $field."-".$type);
    }

    public function getReklamationsübersichtView(Request $req) {

        $allStats = statuse::all();
        $statuses = statuse::all();
        $statusHistory = status_histori::all();
        $reklamationen = reklamation::where("archiv", null)->orWhere("archiv", "false")->get();

        $orders = active_orders_person_data::with("statuse.statuseMain")->with("devices.deviceData")->get();
        $orders = $orders->merge(new_leads_person_data::with("statuse.statuseMain")->get());

        $orders = $orders->filter(function ($order) {
            return $order->statuse->sortByDesc("created_at")->first()->statuseMain->main == "Reklamation";
        });

        $ordersNotInReklamation = $orders->filter(function ($order) use ($reklamationen) {
            return !$reklamationen->contains('process_id', $order->process_id);
        });

        foreach ($ordersNotInReklamation as $order) {
            if($reklamationen->where("process_id", $order->process_id)->first() == null) {
                $reklamation = new reklamation();
                $reklamation->process_id = $order->process_id;
                $reklamation->employee = auth()->user()->id;
                $reklamation->archiv = "false";
                $reklamation->kategorie = "Reklamation";
                $reklamation->save();
            }
        }

        $reklamationen = reklamation::where("archiv", null)->orWhere("archiv", "false")->get();

        $users = user::all();

        return view("forEmployees.reklamation.main")
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("reklamationen", $reklamationen)
                ->with("orders", $orders)
                ->with("statusHistory", $statusHistory);
    }
    
    public function getChangeActiveOrderView(Request $req, $id) {
        $order      = active_orders_person_data::where("process_id", $id)
                                                    ->with("activeOrdersCarData")
                                                    ->with("statuse.statuseMain")
                                                    ->with("devices.deviceData")
                                                        ->first();
        if($order == null) {

            $order      = new_leads_person_data::where("process_id", $id)
                                                        ->first();
            $countries  = countrie::all();
            $shelfes    = shelfe::all();
            $bpzs       = attachment::all();
            $contacts   = contact::all();
            $components = component_name::all();
            $texts      = phone_history::where("process_id", $id)->get();
            $employees  = User::all();
            $statuses   = statuse::all();
            $emails     = email_template::all();
            $nextCall   = phone_history::where("status", "Rückruf")->latest()->first();
            $kundenkonto = kontoModel::where("process_id", $id)->with("rechnungen")->first();
            $files    = ModelsFile::where("process_id", $id)->get();

            $phoneTimes = phone_history::where("employee", auth()->user()->id)->where("status", "Rückruf")->where("rückruf_time", "!=", null)->get();

            return view("forEmployees.interessenten.change")
                    ->with("order", $order)
                    ->with("countries", $countries)
                    ->with("shelfes", $shelfes)
                    ->with("bpzs", $bpzs)
                    ->with("contacts", $contacts)
                    ->with("components", $components)
                    ->with("texts", $texts)
                    ->with("employees", $employees)
                    ->with("phoneTimes", $phoneTimes)
                    ->with("statuses", $statuses)
                    ->with("emails", $emails)
                    ->with("nextCall", $nextCall)
                    ->with("kundenkonto", $kundenkonto)
                    ->with("files", $files)
                    ->with("fromPhone", true);

            
        } else {

            $countries  = countrie::all();
            $components = component_name::all();
            $employees = User::all();
            $statuses = statuse::all();
            $deviceCount = device_orders::where("process_id", $id)->get();
            if($deviceCount != null) {
                $deviceCount = $deviceCount->count();
            }
            $devices  = device_data::where("process_id", $id)->get();
            
            $deviceinfo = null;
            foreach($devices as $dev) {
                if($deviceinfo == null) {
                    $deviceinfo = $dev;
                } else if(strlen($dev->tec_info) > strlen($deviceinfo->tec_info)) {
                    $deviceinfo = $dev;
                }
            }
            if($deviceinfo == null) {
                $deviceinfo = device_orders::where("process_id", $id)->first();
            }

            $files = ModelsFile::where("process_id", $id)->get();


            return view("forEmployees.orders.change")
                    ->with("order", $order)
                    ->with("countries", $countries)
                    ->with("components", $components)
                    ->with("employees", $employees)
                    ->with("statuses", $statuses)
                    ->with("deviceCount", $deviceCount)
                    ->with("files", $files)
                    ->with("fromPhone", true)
                    ->with("deviceinfo", $deviceinfo);

        }
    }


    public function getAuftragBuchhaltungView(Request $req, $id) {
        $kundenkonto =  kontoModel::where("process_id", $id)->with("rechnungen")->first();
        $rechnungstexte = rechnungstext::all();
        $mahneinstellungen = mahneinstellungen::all();
        $artikel = artikel::all();
        $employees = User::all();
        $einkäufe = einkauf::where("process_id", $id)->get();
        $order = active_orders_person_data::where("process_id", $id)->first();
        $countries = countrie::all();


        return view("includes.orders.buchhaltung")
                ->with("kundenkonto", $kundenkonto)
                ->with("rechnungstexte", $rechnungstexte)
                ->with("mahneinstellungen", $mahneinstellungen)
                ->with("artikel", $artikel)
                ->with("employees", $employees)
                ->with("mwst", "19")
                ->with("einkäufe", $einkäufe)
                ->with("order", $order)
                ->with("countries", $countries);
    }
    public function getAuftragsverlaufView(Request $req, $id) {
        $order      = active_orders_person_data::where("process_id", $id)
                                                    ->with("files")
                                                    ->with("statuse.statuseMain")
                                                    ->with("warenausgang")
                                                    ->with("intern")
                                                    ->with("devices.usedShelfes")
                                                        ->first();

        if($order == null) {
            $order      = new_leads_person_data::where("process_id", $id)
                                                    ->with("files")
                                                    ->with("statuse.statuseMain")
                                                        ->first();
        }


        $employees = User::all();
        $statuses = statuse::all();
        $texts      = phone_history::where("process_id", $id)->get();
        $emails = email_template::all();
        $shelfes    = shelfe::all();
        $contacts   = contact::all();
        $countries  = countrie::all();
        $bpzs       = attachment::all();
        $files     = ModelsFile::where("process_id", $id)->get();


        return view("includes.packtisch.auftragsbody-head")
                ->with("shelfes", $shelfes)
                ->with("bpzs", $bpzs)
                ->with("contacts", $contacts)
                ->with("emails", $emails)
                ->with("texts", $texts)
                ->with("statuses", $statuses)
                ->with("order", $order)
                ->with("employees", $employees)
                ->with("countries", $countries)
                ->with("files", $files);
    }

    public function getAuftragsverlaufUpdate(Request $req, $id) {

        $order      = new_leads_person_data::where("process_id", $id)
                                                ->first();

        if($order == null) {
            $order      = active_orders_person_data::where("process_id", $id)
                                                ->first();
        }

        $countries  = countrie::all();
        $shelfes    = shelfe::all();
        $bpzs       = attachment::all();
        $contacts   = contact::all();
        $components = component_name::all();
        $texts      = phone_history::where("process_id", $id)->get();
        $employees  = User::all();
        $statuses   = statuse::where("type", "Interessenten")->get();
        $emails     = email_template::all();
        $nextCall   = phone_history::where("status", "Rückruf")->latest()->first();
        $kundenkonto = kontoModel::where("process_id", $id)->with("rechnungen")->first();

        $phoneTimes = phone_history::where("employee", auth()->user()->id)->where("status", "Rückruf")->where("rückruf_time", "!=", null)->get();

        return view("includes.interessenten.telefonverlauf")
        ->with("order", $order)
        ->with("countries", $countries)
        ->with("shelfes", $shelfes)
        ->with("bpzs", $bpzs)
        ->with("contacts", $contacts)
        ->with("components", $components)
        ->with("texts", $texts)
        ->with("employees", $employees)
        ->with("phoneTimes", $phoneTimes)
        ->with("statuses", $statuses)
        ->with("emails", $emails)
        ->with("nextCall", $nextCall)
        ->with("kundenkonto", $kundenkonto);
    }

    public function getDokumenteUpdate(Request $req, $id) {

        $order      = new_leads_person_data::where("process_id", $id)
                                                ->first();

        if($order == null) {
            $order      = active_orders_person_data::where("process_id", $id)
                                                ->first();
        }

        $countries  = countrie::all();
        $shelfes    = shelfe::all();
        $bpzs       = attachment::all();
        $contacts   = contact::all();
        $components = component_name::all();
        $texts      = phone_history::where("process_id", $id)->get();
        $employees  = User::all();
        $statuses   = statuse::where("type", "Interessenten")->get();
        $emails     = email_template::all();
        $nextCall   = phone_history::where("status", "Rückruf")->latest()->first();
        $kundenkonto = kontoModel::where("process_id", $id)->with("rechnungen")->first();

        $phoneTimes = phone_history::where("employee", auth()->user()->id)->where("status", "Rückruf")->where("rückruf_time", "!=", null)->get();

        return view("includes.interessenten.dokumente")
        ->with("order", $order)
        ->with("countries", $countries)
        ->with("shelfes", $shelfes)
        ->with("bpzs", $bpzs)
        ->with("contacts", $contacts)
        ->with("components", $components)
        ->with("texts", $texts)
        ->with("employees", $employees)
        ->with("phoneTimes", $phoneTimes)
        ->with("statuses", $statuses)
        ->with("emails", $emails)
        ->with("nextCall", $nextCall)
        ->with("kundenkonto", $kundenkonto);
    }

    public function getStatuseUpdate(Request $req, $id) {
        $order      = new_leads_person_data::where("process_id", $id)
                                                ->first();

        if($order == null) {
            $order      = active_orders_person_data::where("process_id", $id)
                                                ->first();
        }

        $countries  = countrie::all();
        $shelfes    = shelfe::all();
        $bpzs       = attachment::all();
        $contacts   = contact::all();
        $components = component_name::all();
        $texts      = phone_history::where("process_id", $id)->get();
        $employees  = User::all();
        $statuses   = statuse::all();
        $emails     = email_template::all();
        $nextCall   = phone_history::where("status", "Rückruf")->latest()->first();
        $kundenkonto = kontoModel::where("process_id", $id)->with("rechnungen")->first();

        $phoneTimes = phone_history::where("employee", auth()->user()->id)->where("status", "Rückruf")->where("rückruf_time", "!=", null)->get();
        return view("includes.orders.statuses")
        ->with("order", $order)
        ->with("countries", $countries)
        ->with("shelfes", $shelfes)
        ->with("bpzs", $bpzs)
        ->with("contacts", $contacts)
        ->with("components", $components)
        ->with("texts", $texts)
        ->with("employees", $employees)
        ->with("phoneTimes", $phoneTimes)
        ->with("statuses", $statuses)
        ->with("emails", $emails)
        ->with("nextCall", $nextCall)
        ->with("kundenkonto", $kundenkonto);
    }

    public function getStatusFilter(Request $req, $id, $process_id) {
        $order      = new_leads_person_data::where("process_id", $process_id)
                                                ->first();

        if($order == null) {
            $order      = active_orders_person_data::where("process_id", $process_id)
                                                ->first();
        }

        $countries  = countrie::all();
        $shelfes    = shelfe::all();
        $bpzs       = attachment::all();
        $contacts   = contact::all();
        $components = component_name::all();
        $texts      = phone_history::with("zuweisung")->where("process_id", $process_id)->get();
        $employees  = User::all();
        $statuses   = statuse::all();
        $emails     = email_template::all();
        $nextCall   = phone_history::where("status", "Rückruf")->latest()->first();
        $kundenkonto = kontoModel::where("process_id", $process_id)->with("rechnungen")->first();

        $phoneTimes = phone_history::with("zuweisung")->where("employee", auth()->user()->id)->where("status", "Rückruf")->where("rückruf_time", "!=", null)->get();

        $texts = $texts->filter(function($item) use ($id) {
            $zw = $item->zuweisung->where("employee", $id)->first();
            return $zw != null;
        });
        

        return view("includes.orders.statuses")
        ->with("order", $order)
        ->with("countries", $countries)
        ->with("shelfes", $shelfes)
        ->with("bpzs", $bpzs)
        ->with("contacts", $contacts)
        ->with("components", $components)
        ->with("texts", $texts)
        ->with("employees", $employees)
        ->with("phoneTimes", $phoneTimes)
        ->with("statuses", $statuses)
        ->with("emails", $emails)
        ->with("nextCall", $nextCall)
        ->with("kundenkonto", $kundenkonto);
    }

    public function getAuftragFilter(Request $req, $id, $process_id, $type) {
        $order      = new_leads_person_data::where("process_id", $process_id)
                                                ->first();

        if($order == null) {
            $order      = active_orders_person_data::where("process_id", $process_id)
                                                ->first();
        }

        $countries      = countrie::all();
        $shelfes        = shelfe::all();
        $bpzs           = attachment::all();
        $contacts       = contact::all();
        $components     = component_name::all();
        $employees      = User::all();
        $statuses       = statuse::all();
        $emails         = email_template::all();
        $nextCall       = phone_history::where("status", "Rückruf")->latest()->first();
        $kundenkonto    = kontoModel::where("process_id", $process_id)->with("rechnungen")->first();

        $phoneTimes     = phone_history::with("zuweisung")->where("employee", auth()->user()->id)->where("status", "Rückruf")->where("rückruf_time", "!=", null)->get();

        if($id != "empty") {
            $status = statuse::where("id", $id)->first();
            $texts  = phone_history::with("zuweisung")->where("process_id", $process_id)->where("status", $id)->get();

        } else {
            $status = statuse::where("type", $type)->get();
            $texts  = phone_history::with("zuweisung")->where("process_id", $process_id)->get();
            $textList = collect();
            foreach($texts as $text) {
                if($status->where("id", $text->status)->where("type", $type)->first() != null) {
                    $textList->push($text);
                }
            }
            $texts = $textList;
        }
        
        $files = ModelsFile::where("process_id", $process_id)->get();

        return view("includes.orders.historienverlauf")
        ->with("order", $order)
        ->with("countries", $countries)
        ->with("shelfes", $shelfes)
        ->with("bpzs", $bpzs)
        ->with("contacts", $contacts)
        ->with("components", $components)
        ->with("texts", $texts)
        ->with("employees", $employees)
        ->with("phoneTimes", $phoneTimes)
        ->with("statuses", $statuses)
        ->with("emails", $emails)
        ->with("nextCall", $nextCall)
        ->with("kundenkonto", $kundenkonto)
        ->with("files", $files);
    }


    public function getAllUpdate(Request $req, $id) {
        $order      = new_leads_person_data::where("process_id", $id)
                                                ->first();
        if($order == null) {
            $order      = active_orders_person_data::where("process_id", $id)
                                                    ->with("activeOrdersCarData")
                                                    ->with("statuse.statuseMain")
                                                    ->with("devices.deviceData")
                                                        ->first();
        }
        $countries  = countrie::all();
        $shelfes    = shelfe::all();
        $bpzs       = attachment::all();
        $contacts   = contact::all();
        $components = component_name::all();
        $texts      = phone_history::where("process_id", $id)->get();
        $employees  = User::all();
        $statuses   = statuse::all();
        $emails     = email_template::all();
        $nextCall   = phone_history::where("status", "Rückruf")->latest()->first();
        $kundenkonto = kontoModel::where("process_id", $id)->with("rechnungen")->first();

        $phoneTimes = phone_history::where("employee", auth()->user()->id)->where("status", "Rückruf")->where("rückruf_time", "!=", null)->get();
        return view("includes.orders.allHistorien")
        ->with("order", $order)
        ->with("countries", $countries)
        ->with("shelfes", $shelfes)
        ->with("bpzs", $bpzs)
        ->with("contacts", $contacts)
        ->with("components", $components)
        ->with("texts", $texts)
        ->with("employees", $employees)
        ->with("phoneTimes", $phoneTimes)
        ->with("statuses", $statuses)
        ->with("emails", $emails)
        ->with("nextCall", $nextCall)
        ->with("kundenkonto", $kundenkonto);
    }


    public function getGerätedatenView(Request $req, $id) {
        $order      = active_orders_person_data::where("process_id", $id)
                                           ->with("devices.usedShelfes")
                                           ->with("activeOrdersCarData")
                                           ->with("statuse.statuseMain")
                                           ->with("devices.deviceData")
                                               ->first();
        
        $components = attachment::all();

        $shelfes    = shelfe::all();
        $usedShelfes = used_shelfes::all();

        return view("forEmployees.orders.device.main")
                ->with("order", $order)
                ->with("components", $components)
                ->with("usedShelfes", $usedShelfes)
                ->with("shelfes", $shelfes);
    }

    public function changeDeviceDataOrder(Request $req) {
        $device = $req->input("component_number");
        $model = $req->input("model");
        $fin = $req->input("fin");
        $shelfe = $req->input("shelfe");
        $component = $req->input("component");
        $info = $req->input("info");

        $devicedata = device_data::where("component_number", $device)->first();
        if($devicedata == null) {
            $devicedata = new device_data();
            $devicedata->component_number = $device;
            $devicedata->car_model = $model;
            $devicedata->fin = $fin;
            $devicedata->component = $component;
            $devicedata->save();
        } else {
            $devicedata->car_model = $model;
            $devicedata->fin = $fin;
            $devicedata->component = $component;
            $devicedata->save();
        }

        $deviceChange = device_orders::where("component_number", $device)->first();
        $deviceChange->info = $info;

        if($req->input("sticker") == "true") {
            $deviceChange->sticker = "on";
        } else {
            $deviceChange->sticker = "";
        }
        if($req->input("opened") == "true") {
            $deviceChange->opened = "on";
        } else {
            $deviceChange->opened = "";
        }

        $deviceChange->save();

        $changeShelfe = used_shelfes::where("component_number", $device)->first();
        if($changeShelfe != null) {
            if($changeShelfe->shelfe_id != $shelfe) {

                $device = device_orders::where("component_number", $device)->first();

                $intern                     = new intern();
                    $intern->process_id         = $device->process_id;
                    $intern->component_id       = $device->component_id;
                    $intern->component_type     = $device->component_type;
                    $intern->component_count    = $device->component_count;
                    $intern->component_number   = $device->component_number;
                    $intern->auftrag_id         = "Umlagerungsauftrag";
                    $intern->auftrag_info       = $changeShelfe->shelfe_id;
                    $intern->info               = $shelfe;
                    $intern->save();
            }
        }

        $order      = active_orders_person_data::where("process_id", $deviceChange->process_id)
        ->with("devices.usedShelfes")
        ->with("activeOrdersCarData")
        ->with("statuse.statuseMain")
        ->with("devices.deviceData")
            ->first();
            $order->updated = new DateTime();
            $order->save();

$components = attachment::all();

$shelfes    = shelfe::all();
$usedShelfes = used_shelfes::all();

return view("forEmployees.orders.device.main")
->with("order", $order)
->with("components", $components)
->with("usedShelfes", $usedShelfes)
->with("shelfes", $shelfes);
    }

    public function getHinweisView(Request $req, $id) {
        $order      = active_orders_person_data::where("process_id", $id)
                                               ->first();
        if($order == null) {
            $order      = new_leads_person_data::where("process_id", $id)
                                               ->first();
        }

        return view("forEmployees.orders.hinweis")
                ->with("order", $order);
    }


    public function kundendatenAuftragBearbeiten(Request $req, $id) {

        $order = active_orders_person_data::where("process_id", $id)->first();
        if($order == null) {
            $order = new_leads_person_data::where("process_id", $id)->first();
        }

        foreach($req->except("_token") as $key => $item) {
                    $order->$key = $item;
        }
        $order->save();

        $history = new rechnungsdaten_verlauf();
        $history->firstname = $req->input("firstname");
        $history->lastname = $req->input("lastname");
        $history->gender = $req->input("gender");
        $history->street = $req->input("home_street");
        $history->streetno = $req->input("home_street_number");
        $history->zipcode = $req->input("home_zipcode");
        $history->city = $req->input("home_city");
        $history->country = $req->input("home_country");
        $history->phone = $req->input("phone_number");
        $history->mobil = $req->input("mobile_number");
        $history->email = $req->input("email");
        $history->process_id = $order->process_id;

        $history->la_firstname = $req->input("send_back_firstname");
        $history->la_lastname = $req->input("send_back_lastname");
        $history->la_gender = $req->input("send_back_gender");
        $history->la_street = $req->input("send_back_street");
        $history->la_streetno = $req->input("send_back_street_number");
        $history->la_zipcode = $req->input("send_back_zipcode");
        $history->la_city = $req->input("send_back_city");
        $history->la_country = $req->input("send_back_ountry");

        $history->save();

        return "ok";
    } 
    
    public function kundendatenAuftragBeipackzettelBearbeiten(Request $req, $id) {

        $process_id = explode("-", $id)[0];

        
        $data = device_data::where("component_number", $req->input("device"))->first();
        if($data == null) {
            $data = new device_data();
            $data->process_id          = $req->input("process_id");
            $data->component_number = $req->input("device");
        }
        $data->errorcache    = $req->input("errorcache");
        $data->errormessage    = $req->input("errormessage");
        $data->tec_info    = $req->input("tec_info");
        $data->errormessage_state    = $req->input("errormessage_state");
        $data->errorcache_state    = $req->input("errorcache_state");
        $data->tec_info_state    = $req->input("tec_info_state");
        $data->save();


        $devices = device_orders::where("process_id", $process_id)->get();
        
        foreach($devices as $device) {
            $d = device_data::where("component_number", $device->component_number)->first();

            
            if($d == null) {
                $d                      = new device_data();
                $d->process_id          = $data->process_id;
                $d->component_number    = $data->component_number;
            }

            $d->car_model               = $req->input("car_model");
            $d->car_company             = $req->input("car_company");
            $d->ps                      = $req->input("ps");
            $d->fin                     = $req->input("fin");
            $d->prod_year               = $req->input("prod_year");
            $d->mileage                 = $req->input("mileage");
            $d->devicedata              = $req->input("devicedata");
            $d->fueltype                = $req->input("fueltype");
            $d->circuit                 = $req->input("circuit");
            $d->hsn                     = $req->input("hsn");
            $d->tsn                     = $req->input("tsn");

            $d->save();
        }

        return "ok";
    } 

    public function getKundendatenAuftragGerätedaten(Request $req, $id) {

        $data = device_data::where("component_number", $id)->first();

        if($data == null) {
            $data = array();

            $firstData = device_data::first();
            
            foreach($firstData->getAttributes() as $key => $item) {
                $data[$key] = "";
            }
        }

        return $data;
    }

    public function toggleKundedatenLieferaddresse(Request $req, $id) {

        $order = active_orders_person_data::where("process_id", $id)->first();

        if($order->toggle_diff_address == "true") {
            $order->toggle_diff_address = "false";
        } else {
            $order->toggle_diff_address = "true";
        }
        
        $order->save();
    }

    public function getEinkaufsübersichtView(Request $req) {

        $einkäufe = einkauf::where("pos", "false")->where("archiv", null)->get();
        
        return view("forEmployees.einkauf.main")->with("einkäufe", $einkäufe);
    }

    public function getNeuerEinkaufModal(Request $req) {

        $contacts = contact::all();
        $orders = active_orders_person_data::all();

        return view("forEmployees.einkauf.neuer-einkauf")->with("contacts", $contacts)->with("orders", $orders);
    }

    public function neuerEinkaufAnlegen(Request $req) {

        $einkauf                    = new einkauf();
        $einkauf->pos               = "true";
        $einkauf->pos_id            = $req->input("id");
        $einkauf->new               = "true";
        $einkauf->save();

        $einkauf  = einkauf::where("pos_id", $req->input("id"))->where("pos", "true")->get();
        
        return view("forEmployees.einkauf.einkaufs-liste-modal")->with("einkaufsListe", $einkauf);
    }

    public function einkaufPositionBearbeiten(Request $req) {

        $einkauf                = einkauf::where("id", $req->input("id"))->first();
        $einkauf->menge         = $req->input("menge");
        $einkauf->artnr         = $req->input("artnr");
        $einkauf->bezeichnung   = $req->input("bezeichnung");
        $einkauf->mwst          = $req->input("mwst");
        $einkauf->netto         = $req->input("netto");
        $einkauf->mwstbetrag    = $req->input("mwstbetrag");
        $einkauf->rabatt        = $req->input("rabatt");
        $einkauf->brutto        = $req->input("brutto");
        $einkauf->new           = "false";
        $einkauf->save();

        $einkauf  = einkauf::where("pos_id", $einkauf->pos_id)->where("pos", "true")->get();

        return view("forEmployees.einkauf.einkaufs-liste-modal")->with("einkaufsListe", $einkauf);
    }

    public function getEinkaufsPositionen(Request $req, $id) {

        $einkauf  = einkauf::where("id", $id)->where("pos", "false")->first();
        $einkauf  = einkauf::where("pos_id", $einkauf->pos_id)->where("pos", "true")->get();


        return view("forEmployees.einkauf.einkaufs-liste-modal")->with("einkaufsListe", $einkauf);
    }

    public function getEinkaufPositionBearbeiten(Request $req, $id) {

        $einkauf      = einkauf::where("id", $id)->first();
        $einkauf->new = "true";
        $einkauf->save();

        $einkauf  = einkauf::where("pos_id", $einkauf->pos_id)->where("pos", "true")->get();

        return view("forEmployees.einkauf.einkaufs-liste-modal")->with("einkaufsListe", $einkauf);
    }

    public function deleteEinkaufPosition(Request $req, $id) {

        $einkauf      = einkauf::where("id", $id)->first();
        $einkauf->delete();

        $einkauf  = einkauf::where("pos_id", $einkauf->pos_id)->where("pos", "true")->get();

        return view("forEmployees.einkauf.einkaufs-liste-modal")->with("einkaufsListe", $einkauf);
    }

    public function checkAuftragsnummer(Request $req, $id) {

        $order = active_orders_person_data::where("process_id", $id)->first();
        if($order == null) {
            $order = new_leads_person_data::where("process_id", $id)->first();
        }

        if($order == null) {
            return "not-found";
        } else {
            return "found";
        }
    }

    public function einkaufZusammenfassen(Request $req) {
       
        if($req->input("einkauf-edit-state") == "true") {
            $list = einkauf::where("pos_id", $req->input("id"))->where("pos", "false")->first();
        } else {
            $list = new einkauf();
        }
        
        $list->process_id           = $req->input("process_id");
        $list->rechnungs_datum      = $req->input("date");
        $list->price                = $req->input("price");
        $list->contact              = $req->input("contact");
        $list->plattform            = $req->input("plattform");
        $list->lieferantendaten     = $req->input("lieferant");
        $list->url                  = $req->input("url");
        $list->rechnungsnummer      = $req->input("rechnungsnummer");
        $list->bezeichnung          = $req->input("bezeichnung");
        $list->zahlart              = $req->input("zahlart");
        $list->status               = $req->input("status");
        $list->tracking             = $req->input("tracking");
        $list->pos_id               = $req->input("id");
        $list->type                 = $req->input("type");
        $list->pos                  = "false";
        $list->save();

        if($req->input("tracking") != null) {

            $tracking = user_tracking::where("process_id", $req->input("process_id"))->where("trackingnumber", $req->input("tracking"))->first();

            if($tracking == null) {
                $id         = $req->input("tracking");
                $process_id = $req->input("process_id");

                $tracking                   = new user_tracking();
                $tracking->process_id       = $process_id;
                $tracking->trackingnumber   = $id;
                $tracking->save();

                event(new saveNewTrackingId($id));
            }
        }

        $einkäufe = einkauf::where("pos", "false")->where("archiv", null)->get();

        return view("forEmployees.einkauf.main-liste")->with("einkäufe", $einkäufe);
    }

    public function getEinkauf(Request $req, $id) {

        $selectedEinkauf = einkauf::where("id", $id)->first();
        $einkaufsListe   = einkauf::where("pos_id", $selectedEinkauf->pos_id)->where("pos", "true")->get();
        $orders          = active_orders_person_data::all();

        $contacts = contact::all();

        return view("forEmployees.einkauf.edit-einkauf")->with("orders", $orders)->with("contacts", $contacts)->with("selectedEinkauf", $selectedEinkauf)->with("einkaufsListe", $einkaufsListe);
    }

    public function togglePrimaryDevice(Request $req, $device) {

        $device = device_orders::where("component_number", $device)->first();

        $device->primary_device = "true";

        $oldDevice = device_orders::where("process_id", $device->process_id)->where("primary_device", "true")->first();

        if($oldDevice != null) {
            $oldDevice->primary_device = "false";
            $oldDevice->save();
        }

        $device->save();

        $order = active_orders_person_data::where("process_id", $device->process_id)->first();
        $order->updated = new DateTime();
        $order->save();
    }

    public function toggleReklamationDevice(Request $req, $id) {

        $device = device_orders::where("component_number", $id)->first();

        if($device->reklamation == null || $device->reklamation == "false") {
            $device->reklamation = "true";
        } else {
            $device->reklamation = "false";
        }

        $device->save();
    }

    public function checkNewOrder(Request $req) {
        
        $zipcode    = $req->input("zipcode");
        $city       = $req->input("city");
        $tsn        = $req->input("tsn");
        $hsn        = $req->input("hsn");
        $email      = $req->input("email");
        $phone      = $req->input("phone");
        $firstname  = $req->input("firstname");
        $lastname   = $req->input("lastname");

        $order = active_orders_person_data::where(function ($query) use ($zipcode, $city, $tsn, $hsn, $email, $phone, $firstname, $lastname) {
            $query->where('home_zipcode', $zipcode)
                ->orWhere('home_city', $city)
                ->orWhere('email', $email)
                ->orWhere('phone_number', $phone)
                ->orWhere('firstname', $firstname)
                ->orWhere('lastname', $lastname);
        })->orWhere(function ($query) use ($zipcode, $city, $tsn, $hsn, $email, $phone, $firstname, $lastname) {
            $query->whereIn('id', function ($subquery) use ($zipcode, $city, $tsn, $hsn, $email, $phone, $firstname, $lastname) {
                $subquery->select('process_id')
                    ->from('new_leads_person_datas')
                    ->where('home_zipcode', $zipcode)
                    ->orWhere('home_city', $city)
                    ->orWhere('email', $email)
                    ->orWhere('phone_number', $phone)
                    ->orWhere('firstname', $firstname)
                    ->orWhere('lastname', $lastname);
            });
        })->get();

    if($order->isEmpty()) {
        return "empty";
    } else {
        return view("forEmployees.orders.new-order-check")->with("duplikate", $order);
    }
}

    

    public function deleteEinkauf(Request $req, $id) {

        $list = einkauf::where("pos_id", $id)->get();

        foreach($list as $item) {
            $item->archiv = "true";
            $item->save();
        }

        $einkäufe = einkauf::where("pos", "false")->where("archiv", null)->get();

        return view("forEmployees.einkauf.main-liste")->with("einkäufe", $einkäufe);
    }

    public function deleteEinkaufReverse(Request $req, $id) {

        $list = einkauf::where("pos_id", $id)->get();

        foreach($list as $item) {
            $item->archiv = null;
            $item->save();
        }

        $einkäufe = einkauf::where("pos", "false")->where("archiv", "false")->get();

        return view("forEmployees.einkauf.main-liste")->with("einkäufe", $einkäufe);

    }

    public function getEinkaufArchiv(Request $req) {
        $einkäufe = einkauf::where("pos", "false")->where("archiv", "true")->get();

        return view("forEmployees.einkauf.main-liste")->with("einkäufe", $einkäufe);
    }

    public function getOrder(Request $req, $id) {

        return active_orders_person_data::where("process_id", $id)->first();

    }

    public function checkReklamationStatus(Request $req, $id, $process_id) {

        $status = statuse::where("id", $id)->first();
        
        if($status->statistik != null && $status->statistik == "reklamation") {

            $devices = device_orders::where("process_id", $process_id)->get();

            if($devices->count() == 1) {
                return "one-device";
            } else {

                return view("forEmployees.modals.orders.selectReklamationDevice")->with("devices", $devices);
            }
            
        } else {
                return "ok";
        }
    }

    public function setReklamationSelectDevices(Request $req) {

        $process_id = "";
        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "device")) {

                $device = device_orders::where("component_number", $item)->first();

                $process_id = $device->process_id;

                $reklamation = reklamation::where("component_number", $item)->first();

                if($reklamation == null) {

                    $reklamation = new reklamation();
                    $reklamation->employee = auth()->user()->id;
                    $reklamation->process_id = $device->process_id;
                    $reklamation->component_number = $item;
                    $reklamation->kategorie = "Reklamation";
                    $reklamation->save();

                    $device->reklamation = "true";
                    $device->save();

                }
            }
        }

        $stat = status_histori::where("process_id", $process_id)->latest()->first();
        if($stat->last_status != 7018) {
            $status = new status_histori();
            $status->process_id = $process_id;
            $status->last_status = $req->input("status");
            $status->changed_employee = auth()->user()->id;
            $status->save();
        }
       

        return redirect()->back();
    }

    public function setReklamationSelectOneDevice(Request $req) {

        $device = device_orders::where("process_id", $req->input("device"))->first();

        if($device != null) {
            $reklamation = reklamation::where("component_number", $device->component_number)->first();

        } else {
            $reklamation = "awdawd";
        }
        
        if($reklamation == null) {

            $reklamation = new reklamation();
            $reklamation->employee = auth()->user()->id;
            $reklamation->process_id = $device->process_id;
            $reklamation->component_number = $device->component_number;
            $reklamation->kategorie = "Reklamation";
            $reklamation->save();

            $device->reklamation = "true";
            $device->save();
        }

        $stat = status_histori::where("process_id", $req->input("device"))->latest()->first();
        if($stat->last_status != 7018) {
            $status = new status_histori();
            $status->process_id = $req->input("device");
            $status->last_status = $req->input("status");
            $status->changed_employee = auth()->user()->id;
            $status->save();
        }

       

        $order = active_orders_person_data::where("process_id", $req->input("device"))->first();
        $order->archiv = false;
        $order->save();
    
        return redirect()->back();
}

    public function deleteReklamation(Request $req, $id) {

        $rek = reklamation::where("id", $id)->first();

        $device = device_orders::where("component_number", $rek->component_number)->first();
        $device->reklamation = "false";
        $device->save();

        $rek->delete();

        return redirect()->back();
    }

    public function toggleReklamationArchiv(Request $req, $id) {

        $reklamation = reklamation::where("id", $id)->first();

        if($reklamation->archiv == "true") {
            $reklamation->archiv = "false";
        } else {
            $reklamation->archiv = "true";
        }

        $reklamation->save();

        return redirect()->back();
    }

    public function getReklamationArchiv(Request $req) {
        $allStats = statuse::all();
        $statuses = statuse::all();
        $statusHistory = status_histori::all();
        $reklamationen = reklamation::where("archiv", "true")->get();

        $orders = active_orders_person_data::all();
        $orders = $orders->merge(new_leads_person_data::all());


        $users = user::all();

        return view("forEmployees.reklamation.main")
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("reklamationen", $reklamationen)
                ->with("orders", $orders)
                ->with("statusHistory", $statusHistory);
    }

    public function neuerTelefonText(Request $req) {

        $process_id     = $req->input("id");
        $name           = $req->input("name");
        $text           = $req->input("text");
        $rückruf        = $req->input("rückruf");
        $extraStatus    = $req->input("extrastatus");
        $tracking       = $req->input("trackingnumber");
        $email          = $req->input("body");
        $zuweisungen    = $req->input("zuweisung");
        $status         = "Telefonhistorie";
        $empf           = "";

        $order          = active_orders_person_data::where("process_id", $process_id)->first();
        if($order == null) {
            $order = new_leads_person_data::where("process_id", $process_id)->first();
        }
        
        if($req->input("subject") != null) {
            $ccs = explode(" ", $req->input("cc"));
            foreach($ccs as $cc) {
                $file = $req->file("emailfile");
                if($file != null) {
                    $file->storeAs("files/aufträge/" . $req->input("id"), $file->getClientOriginalName());
                    Mail::to($cc)->send(new mail_template($order, $req->input("subject"), $req->input("body"), $file->getClientOriginalName()));
                } else {
                    Mail::to($cc)->send(new mail_template($order, $req->input("subject"), $req->input("body")));
                }

                $fileinfo = "";
                if($file != null) {
                    $fileinfo = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 ml-2">  <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z" clip-rule="evenodd" /></svg>';
                }

                $info = "CC: $cc, Betreff: " . $req->input("subject") . ", Nachricht: " . $req->input("body") . " " . $fileinfo;

                if($file != null) {
                    $this->newTelefonStatus($req->input("id"), 38, $info, null, true, null, null, $req->input("body"), $file->getClientOriginalName(), $cc, $req->input("subject"));
                } else {
                    $this->newTelefonStatus($req->input("id"), 38, $info, null, true, null, null, $req->input("body"), null, $cc, $req->input("subject"));
                }
            }
        }
        if($rückruf != null) {
            $status = "Rückruf";
        }
        if($extraStatus != null) {
            $statusNew = statuse::where("name", $extraStatus)->first();
            $this->newTelefonStatus($process_id, $statusNew->id, $text);
        }

        if($tracking != null) {
            $this->setNewTrackingnumber($tracking, $process_id);
        }
        if($zuweisungen != null) {
            foreach($zuweisungen as $zuweisung) {
                $user = user::where("id", $zuweisung)->first();

                $zw = new zuweisung();
                $zw->process_id = $process_id;
                $zw->employee = $user->id;
                $zw->tage = $req->input("tage");
                $zw->save();

                $this->newTelefonStatus($process_id, 2844, "Zugewiesen zu $user->username, Von: ". auth()->user()->username . " (" . $req->input("tage") . " Tage)" , null, true);
            }
        }
        

        if($text != null) {
            $this->newTelefonStatus($process_id, 2304, $text, true, null, $rückruf);
        }

        return $process_id;

    }

    public function neuerAuftragsText(Request $req) {
        $process_id     = $req->input("id");
        $name           = $req->input("name");
        $text           = $req->input("text");
        $rückruf        = $req->input("rückruf");
        $extraStatus    = $req->input("extrastatus");
        $tracking       = $req->input("trackingnumber");
        $email          = $req->input("emailbody");
        $zuweisungen    = $req->input("zuweisung");
        $status         = "Auftragshistorie";
        $empf           = "";

        $order          = active_orders_person_data::where("process_id", $process_id)->first();
        
        if($req->input("subject") != null) {
            $ccs = explode(" ", $req->input("cc"));
            foreach($ccs as $cc) {
                $file = $req->file("emailfile");
                if($file != null) {
                    $file->storeAs("files/aufträge/" . $req->input("id"), $file->getClientOriginalName());
                    Mail::to($cc)->send(new mail_template($order, $req->input("subject"), $req->input("body"), $file->getClientOriginalName()));
                } else {
                    Mail::to($cc)->send(new mail_template($order, $req->input("subject"), $req->input("body")));
                }

                $fileinfo = "";
                if($file != null) {
                    $fileinfo = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 ml-2">  <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z" clip-rule="evenodd" /></svg>';
                }

                $info = "CC: $cc, Betreff: " . $req->input("subject") . ", Nachricht: " . $req->input("body") . " " . $fileinfo;


                if($file != null) {
                    $this->newTelefonStatus($req->input("id"), 38, $info, null, true, null, [], $req->input("body"), $file->getClientOriginalName(), $cc, $req->input("subject"));
                } else {
                    $this->newTelefonStatus($req->input("id"), 38, $info, null, true, null, [], $req->input("body"), null, $cc, $req->input("subject"));
                
                }
            }
        }
        if($rückruf != null) {
            $status = "Rückruf";
        }
        if($extraStatus != null) {
            $this->newTelefonStatus($process_id, $extraStatus, $text);
        }

        if($tracking != null) {
            $this->setNewTrackingnumber($tracking, $process_id);
        }
        

        if($zuweisungen != null) {
            foreach($zuweisungen as $zuweisung) {
                $user = user::where("id", $zuweisung)->first();

                $t = $this->newTelefonStatus($process_id, 2844, "Zugewiesen zu $user->username, Von: ". auth()->user()->username . " (" . $req->input("tage") . " Tage)", null, true);

                $zw = new zuweisung();
                $zw->process_id = $process_id;
                $zw->employee = $user->id;
                $zw->tage = $req->input("tage");
                $zw->textid = $t->textid;
                $zw->save();
            }
        }
        
        if($text != null) {
            $this->newTelefonStatus($process_id, 7496, $text, true);
        }

        return $process_id;

    }

    public function moveOrderToArchiv(Request $req, $id) {
        $order = active_orders_person_data::where("process_id", $id)->first();
        if($order == null) {
            $order = new_leads_person_data::where("process_id", $id)->first();
        }

        $order->archiv = true;
        $order->save();

        return $this->getArchiveOrders($req, $id);
    }

    public function moveOrderToActive(Request $req, $id) {
        $order = active_orders_person_data::where("process_id", $id)->first();
        $order->archiv = null;
        $order->save();

        return $this->active_orders_view($req, $id);
    }

    public function sendNewEmail($id, $subject, $text) {

        $order = new_leads_person_data::where("process_id", $id)->first();

        Mail::to($order->email)->send(new mail_template($order, $subject, $text));

    }

    public function setNewTrackingnumber($id, $process_id) {

        $tracking                   = new user_tracking();
        $tracking->process_id       = $process_id;
        $tracking->trackingnumber   = $id;
        $tracking->save();

        $phone = new phone_history();
        $phone->process_id      = $process_id;
        $phone->lead_name       = "";
        $phone->employee        = auth()->user()->id;
        $phone->message         = $id;
        $phone->status          = "Sendungsverfolgung";
        $phone->rückruf_time    = "";
        $phone->save();

        $sendTrackingJob = new saveTrackingnumber($id);
        $this->dispatch($sendTrackingJob);


    }

    public function newTelefonStatus($process_id, $status, $text = null, $auftrag = null, $email = null, $callback = null, $args = [], $body = null, $file = null, $emp = null, $sub = null) {
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
            
            if(!empty($zuweisungen)) {
                if (is_array($zuweisungen) && count(array_filter($zuweisungen, 'is_int')) === count($zuweisungen)) {
                    foreach ($zuweisungen as $zuweisung) {
                        foreach ($zuweisung as $key => $item) {
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

            }

            if(isset($args["email-all"])) {
                if($args["email-all"] == "true") {
                    if($dbStatus->email_template != null) {
    
                        $email = email_template::where("id", $dbStatus->email_template)->first();
                        if($email != null) {
                            if($args["email-kunde"] == "true") {
    
                                $order = active_orders_person_data::where("process_id", $process_id)->first();
                                if($order == null) {
                                    $order = new_leads_person_data::where("process_id", $process_id)->first();
                                }
                                Mail::to($order->email)->send(new mail_template($order, $email->subject, $email->text));
                                $body = $email->text;
                            }
                            //EMAIL ADMIN SENDEN ADMIN_EMAIL BESPRECHUNG (Was ist Admin email)
                        }
                    }
                }
            }

            if(isset($args["fileid"])) {
                $file = $args["fileid"];
            }

            $phone = new phone_history();
            $phone->process_id          = $process_id;
            $phone->lead_name           = "";
            $phone->employee            = auth()->user()->id;
            $phone->status              = $dbStatus->id;
            $phone->message             = $text;
            $phone->status_state        = true;
            $phone->textid              = $zw_id;
            $phone->auftragshistorie    = $auftrag;
            $phone->rückruf_time        = $callback;
            $phone->email               = $body;
            $phone->file                = $file;
            $phone->empfänger           = $emp;
            $phone->betreff             = $sub;
            $phone->save();

            $stat = new status_histori();
            $stat->process_id       = $process_id;
            $stat->last_status      = $dbStatus->id;
            $stat->changed_employee = auth()->user()->id;
            $stat->save();

            return $phone;
       
    }

    public function getAuftragsverlauf(Request $req, $id) {
        
        $verlauf    = phone_history::where("id", $id)->first();
        $verlauf->read_state = "true";
        $verlauf->save();
        $employees  = User::all();

        $statuses = statuse::all();

        if($verlauf->status == 4196 || $verlauf->status == 3736) {

            $parts = explode(",", $verlauf->message);
            $device = explode(" ", $parts[0])[1];
            $device = device_orders::where("component_number", $device)->first();
            $files = ModelsFile::where("process_id", $device->process_id)->get();
            return view("includes.interessenten.verlauf-erweitert")->with("statuses", $statuses)->with("verlauf", $verlauf)->with("employees", $employees)->with("device", $device)->with("files", $files);
        } else {
            if($verlauf->status == "Sendungsverfolgung") {
                $tracking = tracking::where("trackingnumber", $verlauf->message)->get();
                return view("includes.interessenten.verlauf-erweitert")->with("statuses", $statuses)->with("verlauf", $verlauf)->with("employees", $employees)->with("tracking", $tracking);
            } else {
                
                return view("includes.interessenten.verlauf-erweitert")->with("statuses", $statuses)->with("verlauf", $verlauf)->with("employees", $employees);
            }
        }

        
    }

    public function uploadAuftragDokumente(Request $req) {
        $files = $req->file("files");
        $description = $req->input("description");
        $type = $req->input("type");
        $process_id = $req->input("process_id");
        $extraStatus = $req->input("extrastatus");
        $zuweisungen = $req->input("zuweisung");

        if(!is_array($files)) {

            $upload = new ModelsFile();
            $upload->process_id = $process_id;
            $upload->filename = $files->getClientOriginalName();
            $upload->type = $type;
            $upload->description = $description;
            $upload->employee = auth()->user()->id;
            $upload->save();

            $this->newTelefonStatus($process_id, 6646, "Datei: ". $files->getClientOriginalName() .", Dateityp: $type, Größe: ". $this->size_as_kb($files->getSize()) .", Info: $description", null, null, null, ["fileid" => $upload->id]);

            $filename = $files->getClientOriginalName();
            
            $files->storeAs("files/aufträge/$process_id", $filename);
        } else {

            foreach($files as $file) {

                $upload = new ModelsFile();
                $upload->process_id = $process_id;
                $upload->filename = $file->getClientOriginalName();
                $upload->type = $type;
                $upload->description = $description;
                $upload->employee = auth()->user()->id;
                $upload->save();

                $this->newTelefonStatus($process_id, 6646, "Datei: ". $file->getClientOriginalName() .", Dateityp: $type, Größe: ". $this->size_as_kb($file->getSize()) .", Info: $description", null, null, null, ["fileid" => $upload->id]);

                $filename = $file->getClientOriginalName();
                
                $file->storeAs("files/aufträge/$process_id", $filename);
            }
        }
        
        if($extraStatus != null) {
            $statusNew = statuse::where("name", $extraStatus)->first();
            $this->newTelefonStatus($process_id, $statusNew->id, $description);
        }


        $order      = active_orders_person_data::where("process_id", $process_id)
                        ->with("files")
                        ->first();
        if($order == null) {
            $order      = new_leads_person_data::where("process_id", $process_id)
                            ->with("files")
                            ->first();
        }           
        
        if($req->input("subject") != null) {
            $ccs = explode(" ", $req->input("cc"));
            foreach($ccs as $cc) {
                $file = $req->file("emailfile");
                if($file != null) {
                    $file->storeAs("files/aufträge/" . $process_id, $file->getClientOriginalName());
                    Mail::to($cc)->send(new mail_template($order, $req->input("subject"), $req->input("body"), $file->getClientOriginalName()));
                } else {
                    Mail::to($cc)->send(new mail_template($order, $req->input("subject"), $req->input("body")));
                }

                $fileinfo = "";
                if($file != null) {
                    $fileinfo = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 ml-2">  <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z" clip-rule="evenodd" /></svg>';
                }

                $info = "CC: $cc, Betreff: " . $req->input("subject") . ", Nachricht: " . $req->input("body") . " " . $fileinfo;

                if($file != null) {
                    $this->newTelefonStatus($process_id, 38, $info, null, null, null, null, $req->input("body"), $file->getClientOriginalName(), $cc, $req->input("subject"));
                } else {
                    $this->newTelefonStatus($process_id, 38, $info, null, null, null, null, $req->input("body"),null, $cc, $req->input("subject"));
                }
            }
        }
        if($zuweisungen != null) {
            foreach($zuweisungen as $zuweisung) {
                $user = user::where("id", $zuweisung)->first();

                $t = $this->newTelefonStatus($process_id, 2844, "Zugewiesen zu $user->username, Von: ". auth()->user()->username . " (" . $req->input("tage") . " Tage)", null, true);

                $zw = new zuweisung();
                $zw->process_id = $process_id;
                $zw->employee = $user->id;
                $zw->tage = $req->input("tage");
                $zw->textid = $t->textid;
                $zw->save();
            }
        }
    
        return $process_id;
    }

    public function size_as_kb($yoursize) {
        if($yoursize < 1024) {
          return "{$yoursize} bytes";
        } elseif($yoursize < 1048576) {
          $size_kb = round($yoursize/1024);
          return "{$size_kb} KB";
        } else {
          $size_mb = round($yoursize/1048576, 1);
          return "{$size_mb} MB";
        }
      }

    public function getDokumenteInspect(Request $req, $id) {

        $file = ModelsFile::where("id", $id)->first();
        
        return view("includes.interessenten.dokumente-inspect")->with("process_id", $file->process_id)->with("filename", $file->filename);
    }

    public function getWorkflowView(Request $req) {
        $order      = active_orders_person_data::where("process_id", "N6332")
                        ->with("devices")
                        ->first();
        $flowNames = workflow::where("main", true)->get();

        $statuses = statuse::all();
        $emails    = email_template::all();

        return view("workflow")->with("order" ,$order)->with("statuses", $statuses)->with("emails", $emails)->with("flowNames", $flowNames);
    }

    public function editAuftragHinweis(Request $req) {

        $date = date("d.m.Y");

        $order = active_orders_person_data::where("process_id", $req->input("id"))->first();
        if($order == null) {
            $order = new_leads_person_data::where("process_id", $req->input("id"))->first();
        }
        $order->hinweis = $req->input("text");
        $order->hinweis_sign = "von " . auth()->user()->username . "(" . $date . ")"  ;
        $order->save();
    }

    public function neuerAuftragTextQuick(Request $req) {
    foreach($req->except("_token") as $key => $item) {
        if(str_contains($key, "order")) {
            // Add new phone_history
            $phone_history = new phone_history();
            $phone_history->process_id = $item;
            $phone_history->lead_name = "";
            $phone_history->employee = auth()->user()->id;
            $phone_history->status = "Auftragshistorie";
            $phone_history->message = $req->input("message");
            $phone_history->save();

          
        }
    }
    return redirect()->back();
}


    public function exportOrderFiles(Request $req) {
        $files = array();

        $rows = array();
        array_push($rows, "Auftragsnummer");
        array_push($rows, "Vorname");
        array_push($rows, "Nachname");
        array_push($rows, "Adresse");
        array_push($rows, "Plz");
        array_push($rows, "Stadt");
        array_push($rows, "land");
        array_push($rows, "Gerätenummer");
                    array_push($rows, "Autofirma");
                    array_push($rows, "Automodell");
                    array_push($rows, "PS");
                    array_push($rows, "FIN");
                    array_push($rows, "Herstellungsjahr");
                    array_push($rows, "Kilometerstand");
                    array_push($rows, "Kraftstoff");
                    array_push($rows, "Getriebe");
                    array_push($rows, "Fehlernachricht");
                    array_push($rows, "Fehlerspeicher");
                    array_push($rows, "Techniker Info");
                    array_push($rows, "\n");

        if($req->input("geräte") != null) {
            $devicelist = array();
        array_push($devicelist, "Auftragsnummer");
        array_push($devicelist, "Gerätenummer");
        array_push($devicelist, "Autofirma");
        array_push($devicelist, "Automodell");
        array_push($devicelist, "PS");
        array_push($devicelist, "FIN");
        array_push($devicelist, "Herstellungsjahr");
        array_push($devicelist, "Kilometerstand");
        array_push($devicelist, "Kraftstoff");
        array_push($devicelist, "Getriebe");
        array_push($devicelist, "Fehlernachricht");
        array_push($devicelist, "Fehlerspeicher");
        array_push($devicelist, "Techniker Info");
        array_push($devicelist, "\n");
        } else {
            $devicelist = array();

        }

        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "order")) {
                $from = new DateTime($req->input("from_date"));
                $to = new DateTime($req->input("to_date"));

                $order = active_orders_person_data::where("process_id", $item)->first();
                $rechnungen = rechnungen::where("kundenid", $order->kunden_id)->get();
                $usedRechnungen = array();
                foreach($rechnungen as $rechnung) {
                    if(!in_array($rechnung->rechnungsnummer, $usedRechnungen)) {
                        
                        if(file_exists( public_path() . "/rechnungspdfs/rechnung-". $rechnung->rechnungsnummer . ".pdf")) {
                            if(strlen($rechnung->rechnungsnummer) > 4) {
                                   if($req->input("rechnungen-addon") != null) {
                                    array_push($files, "/rechnungspdfs/rechnung-". $rechnung->rechnungsnummer . ".pdf");
                                   }
                                
                            }
                        
                        }
                    
                        array_push($usedRechnungen, $rechnung->rechnungsnummer);
                    }
                }
            
                



                

                $columns = array();
                array_push($rows, $order->process_id);
                array_push($rows, $order->firstname);
                array_push($rows, $order->lastname);
                array_push($rows, $order->home_street . " " . $order->home_street_number);
                array_push($rows, $order->home_zipcode);
                array_push($rows, $order->home_city);
                array_push($rows, $order->home_country);

                $devices = device_data::where("process_id", $order->process_id)->get();
                if($devices->count() == 1) {
                

                   if($req->input("geräte") != null) {
                    array_push($rows, $devices[0]->component_number);
                    array_push($rows, $devices[0]->car_company);
                    array_push($rows, $devices[0]->car_model);
                    array_push($rows, $devices[0]->ps);
                    array_push($rows, $devices[0]->fin);
                    array_push($rows, $devices[0]->prod_year);
                    array_push($rows, $devices[0]->mileage);
                    array_push($rows, $devices[0]->fuel_type);
                    array_push($rows, $devices[0]->circuit);
                    array_push($rows, $devices[0]->errormessage);
                    array_push($rows, $devices[0]->errorcache);
                    array_push($rows, $devices[0]->for_tec);
                   }

                }

                if($devices->count() > 1) {
                    if($req->input("geräte") != null) {
                        foreach($devices as $device) {
                            array_push($devicelist, $device->process_id);
                            array_push($devicelist, $device->component_number);
                            array_push($devicelist, $device->car_company);
                            array_push($devicelist, $device->car_model);
                            array_push($devicelist, $device->ps);
                            array_push($devicelist, $device->fin);
                            array_push($devicelist, $device->prod_year);
                            array_push($devicelist, $device->mileage);
                            array_push($devicelist, $device->fuel_type);
                            array_push($devicelist, $device->circuit);
                            array_push($devicelist, $device->errormessage);
                            array_push($devicelist, $device->errorcache);
                            array_push($devicelist, $device->for_tec);
                        }
                    }
                }

                array_push($rows, "\n");

                array_push($devicelist, "\n");


                if($req->input("historien") != null) {
                    array_push($devicelist, "Auftragsnummer");
                    array_push($devicelist, "Historie-Datum");
                    array_push($devicelist, "Historie-Mitarbeiter");
                    array_push($devicelist, "Historie-Status");
                    array_push($devicelist, "Historie-Text");
                    array_push($devicelist, "\n");
                
                    $texts = phone_history::where("process_id", $order->process_id)->get();
                    foreach($texts as $text) {
                        array_push($devicelist, $text->process_id);
                        array_push($devicelist, $text->created_at->format("d.m.Y (H:i)"));
                        array_push($devicelist, $text->employee);
                        array_push($devicelist, $text->status);
                        array_push($devicelist, $text->message);
                        array_push($devicelist, "\n");
                    }
                }


                
               if($req->input("rechnungen-addon") != null) {
                array_push($devicelist, "Auftragsnummer");
                array_push($devicelist, "Rechnungsnummer");
                array_push($devicelist, "Rechnung-Datum");
                array_push($devicelist, "Rechnung-Betrag");
                array_push($devicelist, "Rechnung-Bezahlt");
                array_push($devicelist, "\n");
               
                $rechnungen = rechnungen::where("kundenid", $order->kunden_id)->get();
                $usedRechnungs = array();
                foreach($rechnungen as $rechnung) {
                    if(!in_array($rechnung->rechnungsnummer, $usedRechnungs)) {

                        $payed = "Nicht bezahlt";
                        $betrag = 0;
                        foreach($rechnungen->where("rechnungsnummer", $rechnung->rechnungsnummer) as $rech) {
                            
                            
                                $betrag += str_replace(",", ".", $rech->bruttobetrag);

                        }

                        $zahlungen = zahlungen::where("rechnungsnummer", $rechnung->rechnungsnummer)->get();
                        $gezahlt = 0;
                        foreach($zahlungen as $zahlung) {
                            $gezahlt += $zahlung->betrag;
                        }



                        array_push($devicelist, $rechnung->process_id);
                        array_push($devicelist, $rechnung->rechnungsnummer);
                        array_push($devicelist, $rechnung->created_at->format("d.m.Y (H:i)"));
                        array_push($devicelist, $betrag);
                        $betrag -= $gezahlt;

                        if($betrag <= 0) {
                            $payed = "Bezahlt";
                        }
                        array_push($devicelist, $payed);
                        array_push($devicelist, "\n");
                        array_push($usedRechnungs, $rechnung->rechnungsnummer);

                    }
                }
               
               }


            
                if($req->input("data") == null) {
                    if($req->input("kundendaten") != null) {
                        array_push($files, "auftragsdaten.csv");
                    }
                    if($req->input("rechnungen") != null || $req->input("geräte") != null || $req->input("historien") != null) {
                        array_push($files, "addons.csv");
                    }
                }
            }
        }
        $path = "auftragsdaten.csv";
        $fp = fopen($path, 'w'); // open in write only mode (write at the start of the file)
        fputcsv($fp, $rows);
        fclose($fp);

        $path = "addons.csv";
        $fp = fopen($path, 'w'); // open in write only mode (write at the start of the file)
        fputcsv($fp, $devicelist);
        fclose($fp);

        if(file_exists(public_path() . "/file.zip")) {
            unlink (public_path() . "/file.zip"); 
        }


        $zipname = 'file.zip';
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);
        foreach ($files as $file) {
            $filenameParts = explode("/", $file);
            if(count($filenameParts) > 2) {
                $filename = $filenameParts[count($filenameParts) - 1];
                $date = new DateTime();
                $zip->addFile(public_path() . $file, $order->process_id . "-" . $filename . "-" . $date->format("d_m_Y") . ".pdf");
            } else {
                
                $date = new DateTime();
                $zip->addFile($file,  $date->format("d_m-Y") . "-" . $file);
            }
        }
        $zip->close();
        if($files == []) {
            return redirect()->back();
        } else {
            return response()->file($zipname);
        }

    }

    public function changeWorkflow(Request $req, $id, $workflow) {
        $order = active_orders_person_data::where("process_id", $id)->first();
        if($order == null) {
            $order = new_leads_person_data::where("process_id", $id)->first();
        }
        $order->workflowpause = "pause";
        $order->workflow = $id;
        $order->save();

        $workflowMain = workflow::where("id", $workflow)->first();
        $workflows = workflow::where("team_id", $workflowMain->team_id)->where("main", null)->get();

        //WF = workflow
        $userWF = user_workflow::where("process_id", $id)->get();
        if($userWF != null) {
            foreach($userWF as $wf) {
                $wf->delete();
            }
        }

        $teamid = random_int(1000,100000);
        foreach($workflows as $wf) {
            $userWF = new user_workflow();
            $userWF->process_id = $id;
            $userWF->team_id = $teamid;
            $userWF->aktion = $wf->aktion;
            $userWF->addon = $wf->addon;
            $userWF->save();
        }

        $workflows = user_workflow::where("process_id", $id)->get();

        $statuses = statuse::all();
        $emails = email_template::all();
        
        return view("workflow.order_ablauf")->with("workflows", $workflows)->with("statuses", $statuses)->with("emails", $emails);
    }

    public function deleteWorkflow(Request $req, $id) {
        $wf = user_workflow::where("id", $id)->first();
        $process_id = $wf->process_id;
        $wf->delete();

        $workflows = user_workflow::where("process_id", $process_id)->get();

        $statuses = statuse::all();
        $emails = email_template::all();
        
        return view("workflow.order_ablauf")->with("workflows", $workflows)->with("statuses", $statuses)->with("emails", $emails);
    }

    public function editWorkflowPoint(Request $req, $id) {
        $wf = user_workflow::where("id", $id)->first();
        $wf->aktion = $req->input("aktion");
        $wf->addon = $req->input("addon");
        $wf->checked = "";
        $wf->save();

        $order = active_orders_person_data::where("process_id", $wf->process_id)->first();
        $order->workflowpause = "pause";
        $order->save();

        $workflows = user_workflow::where("process_id", $wf->process_id)->get();

        $statuses = statuse::all();
        $emails = email_template::all();
        
        return view("workflow.order_ablauf")->with("workflows", $workflows)->with("statuses", $statuses)->with("emails", $emails);
    }

    public function workflowNeuerPunkt(Request $req) {

        $id = $req->input("id");
        $aktion = $req->input("aktion");
        $addon = $req->input("addon");
        
        $workflow = user_workflow::where("process_id", $id)->first();

        $wf = new user_workflow();
        $wf->process_id = $workflow->process_id;
        $wf->aktion = $aktion;
        $wf->addon = $addon;
        $wf->team_id = $workflow->team_id;

        $wf->save();

        $workflows = user_workflow::where("process_id", $wf->process_id)->get();

        $statuses = statuse::all();
        $emails = email_template::all();

        
        return view("workflow.order_ablauf")->with("workflows", $workflows)->with("statuses", $statuses)->with("emails", $emails);
    }

    public function pauseWorkflow(Request $req, $id) {
        $order = active_orders_person_data::where("process_id", $id)->first();
        
        if($order->workflowpause != "pause") {

            $order->workflowpause = "pause";
            
            $order->save();
    
            
        } else {

            $workflow = new workflow_Controller();
            $workflow->workflowCases($id);

            $order = active_orders_person_data::where("process_id", $id)->first();
            
            if($order->workflowpause != "error") {
                $order->workflowpause = "";
            
                $order->save();

                
            } 
        }
        $order = active_orders_person_data::where("process_id", $id)->first();

        $workflows = user_workflow::where("process_id", $id)->get();
    
                $statuses = statuse::all();
                $emails = email_template::all();
    
                return view("workflow.order_ablauf")->with("workflows", $workflows)->with("statuses", $statuses)->with("emails", $emails)->with("order", $order);

    }

    public function appendWorkflow(Request $req, $id, $workflowid) {

        $mainWorkflow = workflow::where("id", $workflowid)->first();
        $workflows = workflow::where("team_id", $mainWorkflow->team_id)->where("main", null)->get();

        foreach($workflows as $workflow) {
            $wf = new user_workflow();
            $wf->process_id = $id;
            $wf->team_id = $workflow->team_id;
            $wf->aktion = $workflow->aktion;
            $wf->addon = $workflow->addon;
            $wf->save();
        }

        $order = active_orders_person_data::where("process_id", $id)->first();

        $workflows = user_workflow::where("process_id", $id)->get();
    
        $statuses = statuse::all();
        $emails = email_template::all();
    
        return view("workflow.order_ablauf")->with("workflows", $workflows)->with("statuses", $statuses)->with("emails", $emails);
    }

    public function deleteAllWorkflow(Request $req, $id) {
        $workflows = user_workflow::where("process_id", $id)->get();
        $order = active_orders_person_data::where("process_id", $id)->first();

        $order->workflow = null;
        $order->workflowpause = "";
        $order->save();
        foreach($workflows as $workflow) {
            $workflow->delete();
        }

        $order = active_orders_person_data::where("process_id", $id)->first();

        $workflows = user_workflow::where("process_id", $id)->get();
    
        $statuses = statuse::all();
        $emails = email_template::all();
    
        return view("workflow.order_ablauf")->with("workflows", $workflows)->with("statuses", $statuses)->with("emails", $emails);
    }

    public function getNewDeviceData(Request $req) {
        $components  = component_name::all();
        $randid = random_int(1000,100000);

        return view("includes.orders.devicedata")->with("components", $components)->with("randid", $randid);
    }
    
    function getOrdersLike($input) {
        if($input == "null") {
            $orders = active_orders_person_data::all();
        } else {
            $orders = active_orders_person_data::where("process_id", "like", "%$input%")->get();
            $orders = $orders->merge(active_orders_person_data::where("firstname", "like", "%$input%")->get());
            $orders = $orders->merge(active_orders_person_data::where("lastname", "like", "%$input%")->get());
        }
        return $orders;
    }

    public function getOrderViewFilter(Request $req, $id) {
        $person = active_orders_person_data::where("kunden_id", $id)->with("statuse")->with("activeOrdersCarData")->with("userTracking.trackings.code.bezeichnungCustom")->with("rechnungen.zahlungen")->with("files")->get();
        $statuses = statuse::where("type", "2")->get();
        $users = user::all();
        $email = emailinbox::where("read_at", null)->get();
        $allStats = statuse::where("type", "2")->get();
        $hinweise = hinweis::where("area", "Auftragsübersicht")->get();
        $employees = User::all();
        $einkäufe = einkauf::all();

        $hilfscodes = device_orders::where("status", "Hilfsbarcode")->get();

            return view("forEmployees/orders/main")
                ->with("active_orders", $person)
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("emailRead", $email)
                ->with("hinweise", $hinweise)
                ->with("hilfscodes", $hilfscodes)
                ->with("employees", $employees)
                ->with("einkäufe", $einkäufe)
                ->with("filterKunde", $id);
    }

    public function getLeadsViewFilter(Request $req, $id) {
        $person = new_leads_person_data::where("kunden_id", $id)->with("statuse")->with("newLeadsCarData")->with("zuweisung")->with("files")->with("userTracking.trackings")->with("callbacks")->get();
        $orders = active_orders_person_data::with("statuse")->get();
        $konvertLeads = 0;
        foreach($orders as $order) {
            $status = status_histori::where("process_id", $order->process_id)->where("last_status", "36")->first();
            if($status == null) {
                $konvertLeads++;
            }
        }

        $statuses = statuse::where("type", "Interessenten")->get();
        $users = user::all();
        $email = emailinbox::where("read_at", null)->first();
        $allStats = statuse::where("type", "Interessenten")->get();
        $hinweise = hinweis::where("area", "Interessentenübersicht")->get();

        $employees = User::all();
        
        return view("forEmployees/interessenten/main")
                ->with("leads", $person)
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("emailRead", $email)
                ->with("konvertLeads", $konvertLeads)
                ->with("orders", $orders)
                ->with("hinweise", $hinweise)
                ->with("employees", $employees)
                ->with("filterKunde", $id);
    }

    public function setNewOrderStatus(Request $req) {

        $zuweisungen = $req->input("zuweisung");
        $process_id = $req->input("id");
        
        $order = active_orders_person_data::where("process_id", $req->input("id"))->with("statuse")->with("activeOrdersCarData")->with("userTracking.trackings.code.bezeichnungCustom")->with("rechnungen.zahlungen")->with("files")->first();
        if($order == null) {
            $order = new_leads_person_data::where("process_id", $req->input("id"))->with("statuse")->with("newLeadsCarData")->with("zuweisung")->with("files")->with("userTracking.trackings")->with("callbacks")->first();
        }

        if($req->input("subject") != null) {
            $ccs = explode(" ", $req->input("cc"));
            foreach($ccs as $cc) {
                $file = $req->file("emailfile");
                if($file != null) {
                    $file->storeAs("files/aufträge/" . $req->input("id"), $file->getClientOriginalName());
                    Mail::to($cc)->send(new mail_template($order, $req->input("subject"), $req->input("body"), $file->getClientOriginalName()));
                } else {
                    Mail::to($cc)->send(new mail_template($order, $req->input("subject"), $req->input("body")));
                }

                $fileinfo = "";
                if($file != null) {
                    $fileinfo = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 ml-2">  <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z" clip-rule="evenodd" /></svg>';
                }

                $info = "CC: $cc, Betreff: " . $req->input("subject") . ", Nachricht: " . $req->input("body") . " " . $fileinfo;

                if($file != null) {
                    $this->newTelefonStatus($req->input("id"), 38, $info, null, null, null, null, $req->input("body"), $file->getClientOriginalName(), $cc, $req->input("subject"));
                } else {
                    $this->newTelefonStatus($req->input("id"), 38, $info, null, null, null, null, $req->input("body"),null, $cc, $req->input("subject"));
                }
            }
        }

        if($zuweisungen != null) {
            foreach($zuweisungen as $zuweisung) {
                $user = user::where("id", $zuweisung)->first();

                $t = $this->newTelefonStatus($process_id, 2844, "Zugewiesen zu $user->username, Von: ". auth()->user()->username . " (" . $req->input("tage") . " Tage)", null, true);

                $zw = new zuweisung();
                $zw->process_id = $process_id;
                $zw->employee = $user->id;
                $zw->tage = $req->input("tage");
                $zw->textid = $t->textid;
                $zw->save();
            }
        }
       
        $this->newTelefonStatus($req->input("id"), $req->input("extrastatus"), $req->input("text"), null, null, null, ["email-all" => $req->input("email-all"), "email-kunde" => $req->input("email-kunde")]);
        $texts      = phone_history::where("process_id", $req->input("id"))->get();


        return $process_id;
    }

    public function deleteWareneingangHilfsbarcode(Request $req, $id) {

        $device = device_orders::where("process_id", $id)->first();
        $device->archiv = true;
        $device->save();

        return redirect("crm/auftragsübersicht-aktiv");
    } 

    public function getTrackingTableView(Request $req, $id) {

        $trackings = user_tracking::where("process_id", $id)->with("trackings.code")->get();

        return view("includes.tracking.table")->with("trackings", $trackings);
    }

    public function getTrackingLike(Request $req, $inp, $id) {

        if($inp == "all") {
            $trackings = user_tracking::where("process_id", $id)->with("trackings.code")->get();
            $inp = "";
        } else {
            $trackings = user_tracking::where("trackingnumber", "LIKE", "%$inp%")->where("process_id", $id)->with("trackings.code")->get();
        }

        return view("includes.tracking.table")->with("trackings", $trackings)->with("inp", $inp);
    }

    public function checkBPZUpload(Request $req, $id, $dev) {

        $date = new DateTime();

        $file = ModelsFile::where("filename", $date->format("Y.m.d") . "_BPZ_Techniker_$dev.pdf")->first();
        
        if($file != null) {
            return view("forEmployees.modals.checkBPZUpload");
        } else {
            return "not-found";
        }
    }

    public function newScanHistory(Request $req, $scan, $type, $bereich) {
        $his = new scanhistory();
        $his->scan = $scan;
        $his->employee = auth()->user()->id;
        $his->type = $type;
        $his->bereich = $bereich;
        $his->save();
    }

    public function getZeitefassungDropdown(Request $req, $id) {

        $seconddate = new DateTime();
        $firstdate = new DateTime($seconddate->format("Y-m-d 00:00:00"));

        $onlineUsers = array();
        $users = user::all();

        foreach($users as $user) {
            $zeit = zeiterfassung::where("employee", $user->id)->latest()->first();
            if($zeit != null) {
                if($zeit->type == "start") {
                    array_push($onlineUsers, $user);
                }
            }
        }

        $zeiten = zeiterfassung::whereBetween("created_at", [$firstdate, $seconddate])->where("employee", auth()->user()->id)->get();

        return view("includes.zeiterfassung.dropdown")->with("zeiten", $zeiten)->with("onlineUsers", $onlineUsers)->with("users", $users);
    }

    public function stopZeiterfassungAuto(Request $req, $id) {

        $time = new zeiterfassung();

        $time->employee = auth()->user()->id;
        $time->type = "feierabend";

            $time->reason = "Arbeit";
       
        $time->info = "";
        $time->id = $id;
        $time->save();

        $user = user::where("id", auth()->user()->id)->first();
        $user->workstate = null;
        $user->save();

        $seconddate = new DateTime();
        $firstdate = new DateTime($seconddate->format("Y-m-d 00:00:00"));

        $zeiten = zeiterfassung::whereBetween("created_at", [$firstdate, $seconddate])->where("employee", auth()->user()->id)->get();

        $onlineUsers = array();
        $users = user::all();

        foreach($users as $user) {
            $zeit = zeiterfassung::where("employee", $user->id)->latest()->first();
            if($zeit != null) {
                if($zeit->type == "start") {
                    array_push($onlineUsers, $user);
                }
            }
        }

        return view("includes.zeiterfassung.dropdown")->with("zeiten", $zeiten)->with("onlineUsers", $onlineUsers)->with("users", $users);
    }

    public function startZeiterfassungAuto(Request $req) {

        $time = new zeiterfassung();

        $time->employee = auth()->user()->id;
        $time->type = "start";

            $time->reason = "Arbeit";
       
        $time->info = "";
        $time->id = uniqid();
        $time->save();

        $user = user::where("id", auth()->user()->id)->first();
        $user->workstate = "work";
        $user->save();


        $seconddate = new DateTime();
        $firstdate = new DateTime($seconddate->format("Y-m-d 00:00:00"));

        $zeiten = zeiterfassung::whereBetween("created_at", [$firstdate, $seconddate])->where("employee", auth()->user()->id)->get();

        $onlineUsers = array();
        $users = user::all();

        foreach($users as $user) {
            $zeit = zeiterfassung::where("employee", $user->id)->latest()->first();
            if($zeit != null) {
                if($zeit->type == "start") {
                    array_push($onlineUsers, $user);
                }
            }
        }

        return view("includes.zeiterfassung.dropdown")->with("zeiten", $zeiten)->with("onlineUsers", $onlineUsers)->with("users", $users);
    }

    public function getFeiertage(Request $req) {
        $feiertage = feiertage::all();

        return view("includes.zeiterfassung.feiertage")->with("feiertage", $feiertage);
    }

    public function deleteFeiertag(Request $req, $id) {
        $f = feiertage::where("id", $id)->first();
        $f->delete();

        return "ok";
    }

    public function neuerInteressentExtern(Request $req) {
        
        $process_id     = $this->createProductionId();

        foreach($req->file("files") as $file) {
            $file->storeAs("files/aufträge/$process_id", $file->getClientOriginalName());
            $f = new ModelsFile();
            $f->process_id = $process_id;
            $f->filename = $file->getClientOriginalName();
            $f->employee = "";
            $f->save();
        }


        $person                     = new new_leads_person_data();
        $person->process_id         = $process_id;
        $person->kunden_id           = $this->createKundeId();
        $person->gender             = $req->input("gender");
        $person->firstname          = $req->input("firstname");
        $person->lastname           = $req->input("lastname");
        $person->email              = $req->input("email");
        $person->phone_number       = $req->input("phone");
        $person->mobile_number      = $req->input("mobile");
        $person->home_street        = $req->input("street");
        $person->home_street_number = $req->input("streetno");
        $person->home_zipcode       = $req->input("zipcode");
        $person->home_city          = $req->input("city");
        $person->home_country       = $req->input("country");
        $person->shipping_type      = $req->input("shipping");
        $person->payment_type       = $req->input("payment");
        $person->save();

        $car                            = new new_leads_car_data();
        $car->process_id                = $process_id;
        $car->car_company               = $req->input("marke");
        $car->car_model                 = $req->input("model");
        $car->production_year           = $req->input("year");
        $car->car_identification_number = $req->input("vin");
        $car->car_power                 = $req->input("power");
        $car->mileage                   = $req->input("mileage");
        $car->transmission              = $req->input("getriebe");
        $car->fuel_type                 = $req->input("fuel");
        $car->broken_component          = $req->input("broken_comp");
        $car->from_car                  = $req->input("from_car");
        $car->device_manufacturer       = $req->input("comp_company");
        $car->device_partnumber         = $req->input("comp_number");
        $car->error_message_cache       = $req->input("error_cache");
        $car->error_message             = $req->input("error_message");
        $car->save();


        return redirect("https://www.steubel.de/");
    }

    public function getSliderHistory(Request $req) {
        
        $firstdate      = date("Y-m-d H:i:s", strtotime('+2 days'));
        $seconddate     = date('Y-m-d H:00:00', strtotime('-'. date('H') .' hours'));
        $intern_history = intern_history::whereBetween('created_at', [$seconddate , $firstdate])->get();
        $ausgang_archive= warenausgang_history::whereBetween('created_at', [$seconddate , $firstdate])->with("shelfe")->get();
        $wareneingang   = wareneingang::whereBetween('created_at', [$seconddate, $firstdate])->with("shelfe")->get(); 
        $scans          = scanhistory::whereBetween('created_at', [$seconddate, $firstdate])->get(); 
        $contacts       = contact::all();    
        $employees      = User::all();

        return view("slideOvers.packtisch_historie")
                ->with('contacts', $contacts)
                ->with("wareneingang", $wareneingang)
                ->with("warenausgang_history", $ausgang_archive)
                ->with("intern_history", $intern_history)
                ->witH("employees", $employees)
                ->with("scans", $scans);
    }

    public function getAuftragUpdate(Request $req, $id) {
        $order      = new_leads_person_data::where("process_id", $id)
        ->first();

        if($order == null) {
        $order      = active_orders_person_data::where("process_id", $id)
                    ->with("activeOrdersCarData")
                    ->with("statuse.statuseMain")
                    ->with("devices.deviceData")
                        ->first();
        }

        $countries  = countrie::all();
        $shelfes    = shelfe::all();
        $bpzs       = attachment::all();
        $contacts   = contact::all();
        $components = component_name::all();
        $texts      = phone_history::where("process_id", $id)->get();
        $employees  = User::all();
        $statuses   = statuse::all();
        $emails     = email_template::all();
        $nextCall   = phone_history::where("status", "Rückruf")->latest()->first();
        $kundenkonto = kontoModel::where("process_id", $id)->with("rechnungen")->first();
        $files     = ModelsFile::where("process_id", $id)->get();

        $phoneTimes = phone_history::where("employee", auth()->user()->id)->where("status", "Rückruf")->where("rückruf_time", "!=", null)->get();
        return view("includes.orders.historienverlauf")
        ->with("order", $order)
        ->with("countries", $countries)
        ->with("shelfes", $shelfes)
        ->with("bpzs", $bpzs)
        ->with("contacts", $contacts)
        ->with("components", $components)
        ->with("texts", $texts)
        ->with("employees", $employees)
        ->with("phoneTimes", $phoneTimes)
        ->with("statuses", $statuses)
        ->with("emails", $emails)
        ->with("nextCall", $nextCall)
        ->with("kundenkonto", $kundenkonto)
        ->with("files", $files);
    }

    public function hideTextAuftragsverlauf(Request $req, $id) {
        $text = phone_history::where("id", $id)->first();
        if($text->hide == true) {
            $text->hide = null;
            $text->save();
        } else {
            $text->hide = true;
            $text->save();
        }

        return $text->process_id;
    }

    public function setHistorientextZuweisungChecked(Request $req, $id) {
        $text = phone_history::where("id", $id)->first();
        $zw = zuweisung::where("textid", $text->textid)->first();
        
        if($text->checked == true) {
            $text->checked = null;
            $text->save();
            
            $zw->checked = null;
            $zw->save();
        } else {
            $now = new DateTime();

            $text->checked = "erledigt";
            $text->checked_by = auth()->user()->id;
            $text->checked_date = $now->format("d.m.Y (H:i)");
            $text->save();

            $zw->checked = true;
            $zw->save();
        }

        return $text->process_id;
    }

    public function getTechnikerInfo(Request $req, $id) {
        $devicedata = device_data::where("component_number", $id)->first();
        if($devicedata == null) {
            return "";
        } else {
            return $devicedata->tec_info;
        }
    }

    public function checkSecret(Request $req, $password) {
        $maindata = maindata::where("id", 1)->first();
        if($maindata->secret_password == $password) {
            return "ok";
        } else {
            return "no";
        }
    }

    public function filterKundenübersicht(Request $req) {

        $kundenid   = $req->input("kundenid");
        $area       = $req->input("area");
        $count      = $req->input("count");

        if($kundenid == null) {
            if($area == "Aufträge") {
                $kunden = kontoModel::with("active_orders_person_datas")->limit($count)->get();
            }
            if($area == "Interessenten") {
                $kunden = kontoModel::with("new_leads_person_datas")->limit($count)->get();
            }
            if($area == "Beide") {
                $kunden = kontoModel::with("merged_person_datas")->limit($count)->get();
            }
        } else {
            if($area == "Aufträge") {
                $kunden = kontoModel::with("active_orders_person_datas")->where("kundenid", $kundenid)->limit($count)->get();
            }
            if($area == "Interessenten") {
                $kunden = kontoModel::with("new_leads_person_datas")->where("kundenid", $kundenid)->limit($count)->get();
            }
            if($area == "Beide") {
                $kunden = kontoModel::with("merged_person_datas")->where("kundenid", $kundenid)->limit($count)->get();
            }
        }

        $allStats = statuse::all();
        $statuses = statuse::all();
        $users = user::all();

        return view("forEmployees.kunden.table")
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("kunden", $kunden)
                ->with("area", $area)
                ->with("users", $users);
    }

    public function getBuchhaltungNeueRechnung(Request $req, $id) {
        $rechnungstexte = rechnungstext::all();
        $kundenkonto    = kontoModel::where("process_id", $id)->first();
        $artikel        = artikel::all();
        $mwst           = "19";

        return view("includes.rechnungen.neue-rechnung")
                    ->with("rechnungstexte", $rechnungstexte)
                    ->with("kundenkonto", $kundenkonto)
                    ->with("artikel", $artikel)
                    ->with("mwst", $mwst);
    }

    public function getStammdatenModal(Request $req, $id) {
        $allStats = statuse::all();

        $users = user::all();
        $countries = countrie::all();

        $order = active_orders_person_data::where("process_id", $id)->with("activeOrdersCarData")->with("statuse.statuseMain")->first();

        $editKunde = active_orders_person_data::where("kunden_id", $order->kunden_id)->with("activeOrdersCarData")->with("statuse.statuseMain")->get();
        $editKundenHistory = rechnungsdaten_verlauf::where("process_id", $editKunde[0]->process_id)->get()->sortByDesc("created_at");

        return view("forEmployees.modals.kundenÜbersichtEdit")
                ->with("allStats", $allStats)
                ->with("users", $users)
                ->with("editKunde", $editKunde)
                ->with("countries", $countries)
                ->with("editKundenHistory", $editKundenHistory);
    }

    public function getKundendaten(Request $req, $id) {
        $order = active_orders_person_data::where("process_id", $id)->with("activeOrdersCarData")->with("devices")->with("statuse.statuseMain")->first();
        $countries = countrie::all();
        $deviceinfo = null;
        foreach($order->devices as $dev) {
            if($deviceinfo == null) {
                $deviceinfo = $dev;
            } else if(strlen($dev->tec_info) > strlen($deviceinfo->tec_info)) {
                $deviceinfo = $dev;
            }
        }
        if($deviceinfo == null) {
            $deviceinfo = device_orders::where("process_id", $id)->first();
        }

        return view("includes.kundenübersicht.body")->with("order", $order)
                ->with("countries", $countries)
                ->with("deviceinfo", $deviceinfo);
    }
}
