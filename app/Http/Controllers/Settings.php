<?php

namespace App\Http\Controllers;

use App\Events\saveNewTrackingId;
use App\Listeners\saveNewTrackingId as ListenersSaveNewTrackingId;
use App\Mail\inboxanswer;
use App\Mail\mail_template;
use App\Mail\repair_contract;
use App\Models\active_orders_car_data;
use App\Models\active_orders_person_data;
use App\Models\activity;
use App\Models\countrie;
use App\Models\emailaccount;
use App\Models\emailinbox;
use App\Models\emailinbox_history;
use App\Models\emails_history;
use App\Models\emailUUID;
use App\Models\email_inbox_entwurf;
use App\Models\file;
use App\Models\mahnungstext;
use App\Models\new_leads_person_data;
use App\Models\phone_history;
use App\Models\phonetexts;
use App\Models\rechnungstext;
use App\Models\reklamation;
use App\Models\shelfe;
use App\Models\shelfe_count;
use App\Models\statuscodes_select;
use App\Models\statuse;
use App\Models\status_histori;
use App\Models\tracking_history;
use App\Models\User;
use App\Models\user_tracking;
use App\Models\versand_statuscode;
use App\Models\warenausgang_history;
use App\Models\workflow_addon;
use App\Models\überwachung;
use eXorus\PhpMimeMailParser\Parser as parser;
use Auth;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use App\Models\allowBarcode;
use App\Models\archive_lead_person_data;
use App\Models\archive_orders_person;
use App\Models\artikel;
use App\Models\attachment;
use App\Models\carrier;
use App\Models\code_permission;
use App\Models\contact;
use App\Models\email_template;
use App\Models\employee;
use App\Models\feiertage;
use App\Models\globalsetting;
use App\Models\globalsettings;
use App\Models\inventar;
use App\Models\kundenkonto;
use App\Models\mahneinstellungen;
use App\Models\maindata;
use App\Models\permission;
use App\Models\rechnungen;
use App\Models\role;
use App\Models\role_has_permission;
use App\Models\rolepermission;
use App\Models\seal;
use App\Models\tracking;
use App\Models\ups_statuscodes;
use App\Models\user_workflow;
use App\Models\vergleichstext;
use App\Models\warenausgang;
use App\Models\workflow;
use App\Models\zahlart;
use App\Models\zeiterfassung;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Laravel\Octane\Exceptions\DdException;
use Phemail\MessageParser;
use PhpImap\Mailbox;
use Picqer\Barcode\BarcodeGeneratorJPG;
use Picqer\Barcode\BarcodeGeneratorPNG;
use setasign\Fpdi\Fpdi;
use ZBateson\MailMimeParser\MailMimeParser;

class Settings extends Controller
{
    public function allowBarcode(Request $req) {
        $setting        = $req->input("setting");
        $true         = allowBarcode::where("setting", "true")->first();
        if($true != null) {
            DB::table('allowbarcodes')
            ->where("setting", "true")
            ->update(["setting" => $setting]);
        }
        $false         = allowBarcode::where("setting", "false")->first();
       if($false != null) {
        DB::table('allowbarcodes')
        ->where("setting", "false")
        ->update(["setting" => $setting]);
       }

        return redirect()->back();
    }

    public function changeMwst(Request $req) {

        $mwst = $req->input("mwst");
        $data = globalsetting::where("id", "2")->first();
        $data->value = $mwst;
        $data->update();

        return redirect()->back();

    }

    public function getHelpercodePDF(Request $req, $id) {

        if(Storage::exists("files/aufträge/$id/gerätdokumente.pdf")) {
            return Storage::get("files/aufträge/$id/gerätdokumente.pdf");
        } else {
            return "<p style='font-family: Arial; font-weight: 600; text-align: center; color: red'>Keine Dokumente vorhanden</p>";
        }

    }

    public function changePermission(Request $req) {

        $user           = $req->input("user");
        $permissions    = $req->input("permission");

        $user           = employee::where("id", $user)->first();
        $permission     = permission::where("userid", $user)->first();

        if($permission == null) {
            $permission     = new permission();
        $permission->userid = $user->id;
        $permission->username = $user->name;
        $permission->permision = $permissions;
        $permission->save();
        }

        return redirect()->back();

    }
    public function deletePermission(Request $req) {

        $user           = $req->input("user");
        $permissions    = $req->input("permission");

        $permission     = permission::where("userid", $user)->first();
        if($permission != null) {
            $permission->delete();
        }

        return redirect()->back();

    }

    public function vergleichsettingView(Request $req, $state = null, $text = null, $id = null) {
        $vergleichstexte        = vergleichstext::all();
        $rechnungstexte         = rechnungstext::all();
        $mahnungstexte          = mahnungstext::all();
        $phonetexte             = phonetexts::all();
        if($state != null) {
            if($state == "bearbeiten") {
                if($text == "rechnung") {
                        if($id != null) {
                            $text = rechnungstext::where("id", $id)->first();
                            return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("bearbeiten", true)->with("rechnung", $text)->with("t", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                        } else {
                            return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("bearbeiten", true)->with("rechnung", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                        }
                    } 
                if($text == "vergleich") {
                    if($id != null) {
                        $text = vergleichstext::where("id", $id)->first();
                        return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("bearbeiten", true)->with("vergleich", $text)->with("t", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                    } else {
                        return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("bearbeiten", true)->with("vergleich", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                    }                } 
                if($text == "mahnung") {
                    if($id != null) {
                        $text = mahnungstext::where("id", $id)->first();
                        return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("bearbeiten", true)->with("mahnung", $text)->with("t", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                    } else {
                        return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("bearbeiten", true)->with("mahnung", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                    }                
                } 
                if($text == "phone") {
                    if($id != null) {
                        $text = phonetexts::where("id", $id)->first();
                        return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("bearbeiten", true)->with("phone", $text)->with("t", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                    } else {
                        return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("bearbeiten", true)->with("phone", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                    }                
                } 

                }
                if($state == "löschen") {
                    if($text != null) {
                       if($text == "vergleich") {
                        $text       = vergleichstext::where("id", $id)->first();
                        $text->delete();
                        return redirect("/crm/vergleichsetting/redirect/vergleich");
                       }
                       if($text == "mahnung") {
                        $text       = mahnungstext::where("id", $id)->first();
                        $text->delete();
                        return redirect("/crm/vergleichsetting/redirect/mahnung");
                       }
                       if($text == "rechnung") {
                        $text       = rechnungstext::where("id", $id)->first();
                        $text->delete();
                        return redirect("/crm/vergleichsetting/redirect/rechnung");
                       }
                       if($text == "phone") {
                        $text       = phonetexts::where("id", $id)->first();
                        $text->delete();
                        return redirect("/crm/vergleichsetting/redirect/phone");
                       }
                    }
                }
                if($state == "redirect") {
                    if($text == "rechnung") {
                        if($id != null) {
                            $text = rechnungstext::where("id", $id)->first();
                            return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("rechnung", $text)->with("t", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                        } else {
                            return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("rechnung", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                        }
                    } 
                if($text == "vergleich") {
                    if($id != null) {
                        $text = vergleichstext::where("id", $id)->first();
                        return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("vergleich", $text)->with("t", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                    } else {
                        return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("vergleich", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                    }                } 
                if($text == "mahnung") {
                    if($id != null) {
                        $text = mahnungstext::where("id", $id)->first();
                        return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("mahnung", $text)->with("t", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                    } else {
                        return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("mahnung", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                    }                
                } 
                if($text == "phone") {
                    if($id != null) {
                        $text = phonetexts::where("id", $id)->first();
                        return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("phone", $text)->with("t", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                    } else {
                        return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("phone", $text)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);
                    }                
                }                 }
            } 
            
            
            return view("forEmployees/administration/vergleichstext")->with("vergleichstexte", $vergleichstexte)->with("phonetexte", $phonetexte)->with("rechnungstexte", $rechnungstexte)->witH("mahnungstexte", $mahnungstexte);

            
    }
    
    public function neuerVergleichstext(Request $req) {

        $id = $req->input("id");
        
        $mahnung = vergleichstext::where("id", $id)->first();

        if($mahnung != null) {
            $title      = $req->input("title");
            $text       = $req->input("text");

            $mahnung->title       = $title;
            $mahnung->text        = $text;
            $mahnung->save();
           } else {
            $title      = $req->input("title");
            $text       = $req->input("text");
    
            $vergleich              = new vergleichstext();
            $vergleich->title       = $title;
            $vergleich->text        = $text;
            $vergleich->save();
           }


        return redirect("/crm/vergleichsetting");
    }

    public function newPhoneText(Request $req) {
        $mahnung = phonetexts::where("id", "1")->first();

        if($mahnung != null) {
            $title      = $req->input("title");
            $text       = $req->input("text");
    
            $mahnung->title       = $title;
            $mahnung->text        = $text;
            $mahnung->employee    = $req->session()->get("username");
            $mahnung->update();
           } else {
            $title      = $req->input("title");
            $text       = $req->input("text");
    
            $vergleich              = new phonetexts();
            $vergleich->title       = $title;
            $vergleich->text        = $text;
            $vergleich->employee    = $req->session()->get("username");
            $vergleich->save();
           }


        return redirect("/crm/vergleichsetting");
    }

    public function neuerRechnungstext(Request $req) {

        $mahnung = rechnungstext::where("id", "1")->first();

        if($mahnung != null) {
            $title      = $req->input("title");
            $text       = $req->input("text");
    
            $mahnung->title       = $title;
            $mahnung->text        = $text;
            $mahnung->employee    = $req->session()->get("username");
            $mahnung->update();
           } else {
            $title      = $req->input("title");
            $text       = $req->input("text");
    
            $vergleich              = new rechnungstext();
            $vergleich->title       = $title;
            $vergleich->text        = $text;
            $vergleich->employee    = $req->session()->get("username");
            $vergleich->save();
           }

        return redirect("/crm/vergleichsetting");
    }

    public function neuerMahnungstext(Request $req) {
        
       $mahnung = mahnungstext::where("id", "1")->first();
       if($mahnung != null) {
        $title      = $req->input("title");
        $text       = $req->input("text");

        $mahnung->title       = $title;
        $mahnung->text        = $text;
        $mahnung->employee    = $req->session()->get("username");
        $mahnung->update();
       } else {
        $title      = $req->input("title");
        $text       = $req->input("text");

        $vergleich              = new mahnungstext();
        $vergleich->title       = $title;
        $vergleich->text        = $text;
        $vergleich->employee    = $req->session()->get("username");
        $vergleich->save();
       }

        return redirect("/crm/vergleichsetting");
    }

    public function emailVorlagenView(Request $req) {

       $systememails        = email_template::all();
       $customemails        = email_template::where("custom", "yes")->get();
       return view("forEmployees/administration/email-vorlagen")->with("systememails", $systememails)->with("customemails", $customemails);

    }

    public function emailBearbeiten(Request $req, $state = null, $id = null) {
        if($state == "neu") {
            $systememails        = email_template::where("custom", "no")->get();
            $customemails        = email_template::where("custom", "yes")->get();
            return view("forEmployees/administration/email-vorlagen")->with("systememails", $systememails)->with("customemails", $customemails)->with("bearbeiten", true);
        }
        if($state == "bearbeiten") {
            $temp      = email_template::where("id", $id)->first();
            $file      = file::where("id", $temp->file)->first();

            return [$temp, $file];
            
        }


        if($state == "löschen") {

            $email = email_template::where("id", $id)->first();
            $email->delete();

            return "";

        }

    }

    public function changeEmailTemplate(Request $req, $id = null) {
        
        $bereich        = $req->input("bereich");
        $name           = $req->input("name");
        $betreff        = $req->input("subject");
        
        $body           = $req->input("body");
        $absender       = $req->input("absender");
        $empfänger      = $req->input("empfänger");


        if($id == null) {
            try {
                $temp                       = new email_template();
                $temp->company_id           = 1;
                $temp->type                 = $bereich;
                $temp->admin_mail_subject   = "";
                $temp->pdf_php_code         = "";
                $temp->mail_with_pdf        = 1;
                $temp->name                 = $name;
                $temp->subject              = $betreff;
                $temp->body                 = $body;
                $temp->empfänger            = $empfänger;
                $temp->absender             = $absender;
                $temp->custom               = "yes";
                if($req->file("filee") != null) {
                    $file = new file();
                    $file->process_id = "email";
                    $file->filename = $req->file("filee")->getClientOriginalName();
                    $file->description = "email";
                    $file->type = "email";
                    $file->save();
        
                    $req->file("filee")->storeAs("mailAttachs", $temp->id .  $req->file("filee")->getClientOriginalExtension());
                    
                }
                if(isset($file)) {
                    $temp->file = $file->filename;
                }
                $temp->save();
            } catch (\Throwable $th) {
                return $th;
            }

        } else {
            $temp           = email_template::where("id", $id)->first();
            try {
                $temp->company_id           = 1;
                $temp->type                 = $bereich;
                $temp->admin_mail_subject   = "";
                $temp->pdf_php_code         = "";
                $temp->mail_with_pdf        = 1;
                $temp->name                 = $name;
                $temp->subject              = $betreff;
                $temp->body                 = $body;
                $temp->absender             = $absender;
                $temp->empfänger            = $empfänger;
                $temp->custom               = "no";
                if($req->file("filee") != null) {
                    $file = new file();
                    $file->process_id = "email";
                    $file->filename = $req->file("filee")->getClientOriginalName();
                    $file->description = "email";
                    $file->type = "email";
                    $file->save();
        
                    $req->file("filee")->storeAs("mailAttachs", "template-" . $id . "." . $req->file("filee")->getClientOriginalExtension());
                    
                }
                if(isset($file)) {
                    $temp->file = $file->filename;
                }
                $temp->update();
            } catch (\Throwable $th) {
                dd($th);
            }
        }

        if(isset($file)) {
            return [$temp, $file];
        } else {
            return [$temp, null];
        }
    }

    public function deleteEmailTemplate(Request $req, $id) {

        $email      = email_template::where("id", $id)->first();
        $email->delete();

        return redirect("/crm/email-vorlagen");

    }

    public function rollenView(Request $req) {

        $roles      = role::all();
        $rolepermissions = rolepermission::all();
        $employees  = User::all();

        return view("forEmployees/administration/roles")->with("roles", $roles)->with("rolepermissions", $rolepermissions)->with("employees", $employees);
    }

    public function rollenBearbeitenNeu(Request $req) {

        $roles      = role::all();
        $employees  = employee::all();

        return view("forEmployees/administration/roles")->with("roles", $roles)->with("employees", $employees)->with("bearbeiten", true);
        
    }

    public function rolleNeu(Request $req) {

        $role       = \Spatie\Permission\Models\Role::create(["name" => $req->input("name")]);
        foreach($req->except("_token") as $key => $item) {
            if(str_contains($key, "Perm")) {
                $role->givePermissionTo($item);
            }
        }

        return redirect()->back();
    }

    public function adressbuchView(Request $req) {
        $contacts        = contact::all();

        return view("forEmployees.administration.contacts")->with("contacts", $contacts);
    }

    public function getAdressbuchNeuView(Request $req) {
        $countries      = countrie::all();
        
        return view("forEmployees.modals.adressbuchBearbeiten")
                    ->with("countries", $countries);
    }

    public function getAdressbuchEditView(Request $req, $id) {
        $countries      = countrie::all();
        $contact        = contact::where("id", $id)->first();
        
        return view("forEmployees.modals.adressbuchBearbeiten")
                    ->with("countries", $countries)
                    ->with("con", $contact);
    }

    public function kontaktNeuView(Request $req) {
        $contracs        = contact::all();
        $countries      = countrie::all();
        return view("forEmployees/administration/contacts")->with("countries", $countries)->with("contacts", $contracs)->with("bearbeiten", true);
    }

    public function newContact(Request $req) {
      
        $con = new contact();
        $con->mobilnumber            = $req->input("mobilnumber");
        $con->firstname            = $req->input("firstname");
        $con->shortcut           = $req->input("shortcut");
        $con->companyname            = $req->input("companyname");
        $con->gender            = $req->input("gender");
        $con->lastname            = $req->input("lastname");
        $con->street            = $req->input("street");
        $con->streetno            = $req->input("streetno");
        $con->zipcode            = $req->input("zipcode");
        $con->city            = $req->input("city");
        $con->country            = countrie::where("name", $req->input("country"))->first()->id;
        $con->phonenumber            = $req->input("phonenumber");
        $con->email           = $req->input("email");
        $con->weight            = $req->input("weigth");
        $con->packets            = $req->input("packets");
        $con->servicecode           = $req->input("service");
        $con->pickuptimestart            = $req->input("pickuptimestart");
        $con->pickuptimeend            = $req->input("pickuptimeend");
        $con->language = $req->input("language");
        $con->save();

        $contacts        = contact::all();
        return view("includes.settings.contacts-table")->with("contacts", $contacts);

    }

    public function deleteContact(Request $req, $id) {
        $con = contact::where("id", $id)->first();
        $con->delete();
        
        $contacts        = contact::all();
        return view("includes.settings.contacts-table")->with("contacts", $contacts);
    }

    public function contactBearbeiten(Request $req, $id) {
        $contracs        = contact::all();
        $con            = contact::where("id", $id)->first();
        $countries      = countrie::all();
        return view("forEmployees/administration/contacts")->with("contacts", $contracs)->with("con", $con)->with("bearbeiten", true)->with("countries", $countries);
    }

    public function contactChange(Request $req, $id) {
        
        foreach($req->except("_token") as $key => $item) {
            $$key      = $item;
        }

        if(!isset($mobilnumber)) {
            $mobilnumber = "";
        }

        $country = countrie::where("id", $country)->first()->id;

        $con = contact::where("id", $id)->first();

        $con->mobilnumber = $mobilnumber;
        $con->firstname = $firstname;
        $con->shortcut = $shortcut;
        $con->companyname = $companyname;
        $con->gender = $gender;
        $con->lastname = $lastname;
        $con->street = $street;
        $con->streetno = $streetno;
        $con->zipcode = $zipcode;
        $con->city = $city;
        $con->country = $country;
        $con->phonenumber =" ";
        $con->email = $email;
        $con->weigth = $weigth;
        $con->packets = $packets;
        $con->pickuptimestart = $pickuptimestart;
        $con->servicecode = $service;
        $con->pickuptimeend = $pickuptimeend;
        $con->language = $language;
        $con->save();
        
        $contacts        = contact::all();
        return view("includes.settings.contacts-table")->with("contacts", $contacts);
    }

    /**
     * Summary of zusammenfassenView
     * @param Request $req
     * @return \Illuminate\Contracts\View\View|mixed
     */

    public function zusammenfassenView(Request $req) {

        $warenausgang = warenausgang::all();

        return view("forEmployees/administration/zusammenfassen")->with("warenausgang", $warenausgang);
        
    }

    /**
     * Summary of error_messag
     * @param Request $req
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function error(Request $req) {
        return view("forEmployees/administration/error");
    }

    public function statusView(Request $req) {

        $systemstatus = statuse::where("custom", "no")->get();
        $customstatus = statuse::where("custom", null)->get();
        $emails = email_template::all();
        return view("forEmployees/administration/statuse")->with("systemstatus", $systemstatus)->with("customstatus", $customstatus)->with("emails", $emails);

    }

    public function statusBearbeiten(Request $req, $id) {

        $stat = statuse::where("id", $id)->first();

        return $stat;
    }

    public function statusNeu(Request $req) {

        $systemstatus = statuse::where("custom", "no")->get();
        $customstatus = statuse::where("custom", null)->get();
        $emails = email_template::all();
        return view("forEmployees/administration/statuse")->with("systemstatus", $systemstatus)->with("customstatus", $customstatus)->with("bearbeiten", "true")->with("emails", $emails);

    }

    public function statusBearbeitenPOST(Request $req, $id = null) {
        if($id != null) {
            $stat = statuse::where("id", $id)->first();
            $stat->type = $req->input("area");
            $stat->name = $req->input("name");
            $stat->color = $req->input("color");
            $stat->statistik = $req->input("statistik");
            $stat->text_color = $req->input("text_color");
            $stat->email_template = $req->input("email");
            if($req->input("state") == "on") {
                $stat->public = 1;
            } else {
                $stat->public = 0;
            }
            if($req->input("kunde") == "yes") {
                $stat->kunde = "yes";
            } else {
                $stat->kunde = "no";
            }
            if($req->input("admin") == "yes") {
                $stat->admin = "yes";
            } else {
                $stat->admin = "no";
            }
            $stat->update();
            
            $template = email_template::where("id", $stat->email_template)->first();
            $stat->email_template = $template->name;

            return $stat;
        } else {
            $random_int = random_int(500, 10000);
            $stat = new statuse;
            $stat->id = $random_int;
            $stat->type = $req->input("area");
            $stat->statistik = $req->input("statistik");
            $stat->name = $req->input("name");
            $stat->color = $req->input("color");
            $stat->email_template = $req->input("email");

            if($req->input("kunde") == "yes") {
                $stat->kunde = "yes";
            } else {
                $stat->kunde = "no";
            }
            if($req->input("admin") == "yes") {
                $stat->admin = "yes";
            } else {
                $stat->admin = "no";
            }
            $stat->save();

            $template = email_template::where("id", $stat->email_template)->first();
            $stat->email_template = $template->name;

            $stat->sys_id = $random_int;

            return $stat;
        }
    }

    public function statusLöschen(Request $req, $id) {
        $stat = statuse::where("id", $id)->first();
        $stat->delete();

        return "ok";
    }

    public function emailUUIDCheck(Request $req, $id, $uuid) {

        $check = emailUUID::where("process_id", $id)->where("uuid", $uuid)->first();
        if($check != null) {
            $check->count = $check->count + 1;
            $check->update();
        }
        return "awd";


    }

    public function mailInboxView(Request $req) {
        $inbox = new mailInbox("test@zap489255-1.plesk07.zap-webspace.com", "Tarokyun12&&");
        $emails = $inbox->getEmails("contact");

        $orders = active_orders_person_data::all();
        $orders = $orders->merge(new_leads_person_data::all());

        $archivEmail = emailinbox_history::all();

        $emailHistory = emails_history::all();

        return view("forEmployees/administration/emailInbox")->with("emails", $emails)->with("orders", $orders)->with("emailHistory", $emailHistory)->with("inboxHistory", $archivEmail);
        
    }

    public function mailInboxBearbeitenView(Request $req, $id) {
       
        $inbox = new mailInbox("test@zap489255-1.plesk07.zap-webspace.com", "Tarokyun12&&");
        $emails = $inbox->getEmails("contact");
        $email = $inbox->findEmail($id);

        $orders = active_orders_person_data::all();
        $orders = $orders->merge(new_leads_person_data::all());
        $emailHistory = emails_history::all();


        if($email != null) {
            return view("forEmployees/administration/emailInbox")->with("emails", $emails)->with("changeEmail", $email)->with("bearbeiten", true)->with("orders", $orders)->with("emailHistory", $emailHistory);
        }

        
    }

    public function mailInboxZuweisen(Request $req, $account) {

        $acc    = emailaccount::where("id", $account)->first();

        $inbox = new mailInbox($acc->user, $acc->password, $acc->server, $acc->port);
        $mails = $inbox->assignToOrder($req);
        return $mails;
    }

    public function getAssignProxs(Request $req, $account) {

        $account = emailaccount::where("id", $account)->first();

        $inbox = new mailInbox($account->user, $account->password, $account->server, $account->port);  
        $emails = emailinbox::where("assigned", null)->where("account", $account->id)->get();
        $usedMails = array();


        foreach ($emails as $email) {
            $lastChar = "";

                if (str_contains($email->subject, '[#')) {
                    $firstPart = explode('#', $email->subject);
                    $secondPart = explode(']', $firstPart[1]);

                    $id = $secondPart[0];
                } else {
                    $counter = 0;
                    $id = '';
                    $found = false;
                    $first = "";

                    

                    foreach (str_split($email->subject) as $char) {
                        
                        if ($found == false) {
                            
                            if (is_int(intval($char)) && intval($char) != 0) {
                                $counter++;
                                $id = $id . $char;
                            } else {
                                if($char != "0") {
                                    $counter = 0;
                                    $id = '';
                                }
                            }
                            if($char == "0") {
                                    $counter++;
                                    $id = $id . $char;
                                
                            }
                        }

                        if ($counter == 4) {
                            $found = true;
                            $split = explode($id, $email->subject);
                            $split = substr($split[0], -1); // returns "s"

                            if(!is_int($split)) {
                                $first = $split;
                                $id = $first . $id;
                                
                            }
                            $counter = 0;
                            
                        }
                    }
                    $lastChar = $char;
                   
                }
                if (isset($id)) {
                    if($found == true) {
                        if($id != "") {
                            $user = active_orders_person_data::where('process_id', $id)->first();
                            if ($user == null) {
                                $user = new_leads_person_data::where('process_id', $id)->first();
                            }
                            
                            
                           }

                    }

                   
                }

                if (!isset($user)) {
                } else {
                    if (isset($id)) {
                        $his = emails_history::where('id', $email->id)->where('body', $email->text)->first();

                            
                        if($his == null) {
                            array_push($usedMails, $email->email_id . "*" . $id);
                        }
                        

                       
                    }
                }
            
        }

        return $usedMails;
    }

    public function mailInboxZuweisenManuel(Request $req, $account = 32) {

        $account = emailaccount::where("id","37")->first();

        $inbox = new mailInbox($account->user, $account->password, $account->server, $account->port);
        $email = emails_history::where("id", $req->input("email_id"))->first();

        if($email != null) {
            $email->delete();

            $email = emailinbox::where("id", $req->input("email_id"))->first();
            $phone = phone_history::where("lead_name", $email->subject)->first();
            $phone->delete();
        } else {
            $email = emailinbox::where("id", $req->input("email_id"))->first();
            $phone = new phone_history();
            $phone->process_id = $req->input("id");
            $phone->lead_name = $email->subject;
            $phone->status = "E-Mail";
            $phone->message = $email->text;
            $phone->employee = auth()->user()->id;
            $phone->save();
        }
        $email = $inbox->assignToOrderManuel($req, $req->input("id"), $req->input("email_id"));

        

        return $email;
    }

    public function uploadEML(Request $req) {

        $file = $req->file("file");
        if($file->getClientOriginalExtension() == "eml") {

            $file->storeAs("emls", $file->getClientOriginalName());

            $parser = new MessageParser();
            $message = $parser->parse("emls/".$file->getClientOriginalName());
            $email = new emailinbox();
            $email->email_id = random_int(100000, 999999);
            $email->subject = $message->getHeaderValue('subject');
            $email->absender = $message->getHeaderValue('from');
            $email->send_at = $message->getHeaderValue('date');
            $email->account = "1";
            $email->text = $message->getContents();
            $email->save();

            return $email;
        } else {
            return "not-eml";
        }
    }
    
    public function setBarcodeSpecialChar(Request $req) {

        $char       = $req->input("char");

        $barcode    = allowBarcode::where("settingName", "specialchar")->first();

        if($barcode != null) {
            $barcode->specialchar = $char;
            $barcode->update();
        } else {
            $barcode = new allowBarcode();
            $barcode->specialchar = $char;
            $barcode->settingName = "specialchar";
            $barcode->save();
        }

        return redirect()->back();

    }

    public function getMahnung() {

        $pdf = new Fpdi(); 
        

        // set the source file
        $pdf->setSourceFile(public_path("/"). "pdf/mahnung.pdf");

        $pdf->AddPage();
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId); 
        $pdf->SetTextColor(0, 0, 0);

        #Rechnugns.NR
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(152, 62.5, "F1049101");

        #Rechnungs Datum
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(152, 66.7, "26.01.2023");

        #Auftragsnummer
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(120, 76.3, "86301");

        #Bestelldatum
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(150, 76.3, "26.01.2023");

        #Seite
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(160, 85, "1 von 1");

        #Zahlungsart
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 89.6,  iconv('UTF-8', 'windows-1252',"Überweisung"));
        
        #Versandart
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 94.5, "Standardversand");

        #Bestellt durch
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 99.1,  iconv('UTF-8', 'windows-1252',"Ralph Hüskes"));

        #Bearbeiter
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 104, "Buchhaltung");

        #Bearbeiter Tel
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 108.7, "042159564922");

        #Bearbeiter Mail
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 113.6,  iconv('UTF-8', 'windows-1252',"info@gzamotors.de"));



        #Adresse Firma
        $pdf->SetFont("Arial", "", 9.5);
        $pdf->Text(25.2, 59.5,  iconv('UTF-8', 'windows-1252',"RKG Markenwelt GmbH & Co. KG"));

        #Adresse Name
        $pdf->SetFont("Arial", "", 9.5);
        $pdf->Text(25.2, 63.6,  iconv('UTF-8', 'windows-1252',"Herr Ralph Hüskes"));

        #Adresse Straße
        $pdf->SetFont("Arial", "", 9.5);
        $pdf->Text(25.2, 67.6, iconv('UTF-8', 'windows-1252',"Friedenstraße 51"));

        #Adresse Stadt/Postleitzahl
        $pdf->SetFont("Arial", "", 9.5);
        $pdf->Text(25.2, 73, "53229 Bonn");


        #Lieferanschrift
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(20.5, 102.7, "Lieferanschrift:");

        #Lieferanschrift Firma
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 102.7, iconv('UTF-8', 'windows-1252',"RKG Markenwelt GmbH & Co. KG"));

        #Lieferanschrift Name
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 106, iconv('UTF-8', 'windows-1252',"Herr Ralph Hüskes"));

        #Lieferanschrift Straße
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 108.5, iconv('UTF-8', 'windows-1252',"Friedenstraße 51"));

        #Lieferanschrift Stadt/Postleitzahl
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 111.2, "53229 Bonn");

        #Lieferanschrift Land
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 114, "Deutschland");



        #Rechnung POS
        $pdf->SetFont("Arial", "", 10);
        $pdf->Text(25.2, 154, iconv('UTF-8', 'windows-1252',"leider haben Sie auf unsere bisherigen Zahlungserinnerungen nicht reagiert. Wir bitten Sie daher den"));

        #Rechnung POS
        $pdf->SetFont("Arial", "", 10);
        $pdf->Text(25.2, 160, iconv('UTF-8', 'windows-1252',"überfälligen Betrag von 46,08 EUR bis zum 22.02.2023 auf unser Konto"));

        #Rechnung POS
        $pdf->SetFont("Arial", "", 10);
        $pdf->Text(25.2, 177, iconv('UTF-8', 'windows-1252',"Sollten Sie zwischenzeitlich bereits Zahlung geleistet haben, betrachten Sie dieses Schreiben bitte als"));
        #Rechnung POS
        $pdf->SetFont("Arial", "", 10);
        $pdf->Text(25.2, 183, iconv('UTF-8', 'windows-1252',"gegenstandslos."));


        #Rechnung POS
        $pdf->SetFont("Arial", "", 10);
        $pdf->Text(25.2, 200, iconv('UTF-8', 'windows-1252',"Mit freundlichen Grüßen,"));
        #Rechnung POS
        $pdf->SetFont("Arial", "", 10);
        $pdf->Text(25.2, 206, iconv('UTF-8', 'windows-1252',"Ihr Team von GZA MOTORS"));
        

        #Barcode Top
        $test = new BarcodeGeneratorJPG();
        file_put_contents('rechnung-barcode.JPG', $test->getBarcode("86301", $test::TYPE_CODE_128));
        $source = imagecreatefromjpeg('rechnung-barcode.JPG');
        // Rotate
        $rotate = imagerotate($source, 90, 0);
        //and save it on your server...
        imagejpeg($rotate, "rechnung-barcode.JPG");
        $pdf->Image("rechnung-barcode.JPG", 196, 100, 7, 40);

        #Rechnung Gesamtpreis (Netto)
        $pdf->SetFont("Arial", "B", 10);
        $pdf->Rotate(90, 200, 100);
        $pdf->Text(125, 100, iconv('UTF-8', 'windows-1252',"Auftrags Nr.: 86301"));

         #Rechnung Gesamtpreis (Netto)
         $pdf->SetFont("Arial", "B", 10);
         $pdf->Text(25, 100, iconv('UTF-8', 'windows-1252',"Auftrags Nr.: 86301"));

        $pdf->Rotate(0);
        #Barcode Top
        $test = new BarcodeGeneratorJPG();
        file_put_contents('rechnung-barcode.JPG', $test->getBarcode("86301", $test::TYPE_CODE_128));
        $source = imagecreatefromjpeg('rechnung-barcode.JPG');
        // Rotate
        $rotate = imagerotate($source, 90, 0);
        //and save it on your server...
        imagejpeg($rotate, "rechnung-barcode.JPG");
        $pdf->Image("rechnung-barcode.JPG", 196, 200, 7, 40);

        dd($pdf->Output());

    }

    public function getRechnung() {

        $pdf = new Fpdi(); 
        

        // set the source file
        $pdf->setSourceFile(public_path("/"). "pdf/rechnung.pdf");

        $pdf->AddPage();
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId); 
        $pdf->SetTextColor(0, 0, 0);

        #Rechnugns.NR
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(152, 62.5, "F1049101");

        #Rechnungs Datum
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(152, 66.7, "26.01.2023");

        #Auftragsnummer
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(120, 76.3, "86301");

        #Bestelldatum
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(150, 76.3, "26.01.2023");

        #Seite
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(160, 85, "1 von 1");

        #Zahlungsart
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 89.6,  iconv('UTF-8', 'windows-1252',"Überweisung"));
        
        #Versandart
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 94.5, "Standardversand");

        #Bestellt durch
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 99.1,  iconv('UTF-8', 'windows-1252',"Ralph Hüskes"));

        #Bearbeiter
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 104, "Buchhaltung");

        #Bearbeiter Tel
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 108.7, "042159564922");

        #Bearbeiter Mail
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 113.6,  iconv('UTF-8', 'windows-1252',"info@gzamotors.de"));



        #Adresse Firma
        $pdf->SetFont("Arial", "", 9.5);
        $pdf->Text(25.2, 59.5,  iconv('UTF-8', 'windows-1252',"RKG Markenwelt GmbH & Co. KG"));

        #Adresse Name
        $pdf->SetFont("Arial", "", 9.5);
        $pdf->Text(25.2, 63.6,  iconv('UTF-8', 'windows-1252',"Herr Ralph Hüskes"));

        #Adresse Straße
        $pdf->SetFont("Arial", "", 9.5);
        $pdf->Text(25.2, 67.6, iconv('UTF-8', 'windows-1252',"Friedenstraße 51"));

        #Adresse Stadt/Postleitzahl
        $pdf->SetFont("Arial", "", 9.5);
        $pdf->Text(25.2, 73, "53229 Bonn");


        #Lieferanschrift
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(20.5, 102.7, "Lieferanschrift:");

        #Lieferanschrift Firma
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 102.7, iconv('UTF-8', 'windows-1252',"RKG Markenwelt GmbH & Co. KG"));

        #Lieferanschrift Name
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 106, iconv('UTF-8', 'windows-1252',"Herr Ralph Hüskes"));

        #Lieferanschrift Straße
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 108.5, iconv('UTF-8', 'windows-1252',"Friedenstraße 51"));

        #Lieferanschrift Stadt/Postleitzahl
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 111.2, "53229 Bonn");

        #Lieferanschrift Land
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 114, "Deutschland");



        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(20.5, 130, "Pos");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(30, 130, "Menge");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(45, 130, "Art. Nr.");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(70, 130, "Bezeichnung");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(125, 130, "Gesamt");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(127.5, 133.5, "(Netto)");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(145, 130, "MwSt");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(160, 130, "E-Preis");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(178.5, 130, "Gesamt");

        #Rechnung Gesamtpreis (Netto)
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(130, 145, "Gesamtpreis Netto");

        #Rechnung Gesamtpreis (Netto)
        $pdf->SetFont("Arial", "", 9);
        $pdf->Text(138, 155, "MwSt. 19,00%");

        
        #Rechnung Gesamtpreis (Netto)
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(130, 165, "Gesamtpreis Netto");

        #Rechnung Gesamtpreis (Netto)
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(172, 145, iconv('UTF-8', 'windows-1252',"1.035,95 €"));
         #Rechnung Gesamtpreis (Netto)
         $pdf->SetFont("Arial", "", 9);
         $pdf->Text(175, 155, iconv('UTF-8', 'windows-1252',"196,83 €"));

          #Rechnung Gesamtpreis (Netto)
          $pdf->SetFont("Arial", "B", 9);
          $pdf->Text(172, 165, iconv('UTF-8', 'windows-1252',"1.232,78 €"));

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(20.5, 133.5, "________________________________________________________________________________________________");
        
        #Barcode Top
        $test = new BarcodeGeneratorJPG();
        file_put_contents('rechnung-barcode.JPG', $test->getBarcode("86301", $test::TYPE_CODE_128));
        $source = imagecreatefromjpeg('rechnung-barcode.JPG');
        // Rotate
        $rotate = imagerotate($source, 90, 0);
        //and save it on your server...
        imagejpeg($rotate, "rechnung-barcode.JPG");
        $pdf->Image("rechnung-barcode.JPG", 196, 100, 7, 40);

        #Rechnung Gesamtpreis (Netto)
        $pdf->SetFont("Arial", "B", 10);
        $pdf->Rotate(90, 200, 100);
        $pdf->Text(125, 100, iconv('UTF-8', 'windows-1252',"Auftrags Nr.: 86301"));

         #Rechnung Gesamtpreis (Netto)
         $pdf->SetFont("Arial", "B", 10);
         $pdf->Text(25, 100, iconv('UTF-8', 'windows-1252',"Auftrags Nr.: 86301"));

        $pdf->Rotate(0);
        #Barcode Top
        $test = new BarcodeGeneratorJPG();
        file_put_contents('rechnung-barcode.JPG', $test->getBarcode("86301", $test::TYPE_CODE_128));
        $source = imagecreatefromjpeg('rechnung-barcode.JPG');
        // Rotate
        $rotate = imagerotate($source, 90, 0);
        //and save it on your server...
        imagejpeg($rotate, "rechnung-barcode.JPG");
        $pdf->Image("rechnung-barcode.JPG", 196, 200, 7, 40);

        dd($pdf->Output());

    }
    public function getAngebot() {

        $pdf = new Fpdi(); 
        

        // set the source file
        $pdf->setSourceFile(public_path("/"). "pdf/rechnung.pdf");

        $pdf->AddPage();
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId); 
        $pdf->SetTextColor(0, 0, 0);

        #Rechnugns.NR
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(152, 62.5, "F1049101");

        #Rechnungs Datum
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(152, 66.7, "26.01.2023");

        #Auftragsnummer
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(120, 76.3, "86301");

        #Bestelldatum
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(150, 76.3, "26.01.2023");

        #Seite
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(160, 85, "1 von 1");

        #Zahlungsart
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 89.6,  iconv('UTF-8', 'windows-1252',"Überweisung"));
        
        #Versandart
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 94.5, "Standardversand");

        #Bestellt durch
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 99.1,  iconv('UTF-8', 'windows-1252',"Ralph Hüskes"));

        #Bearbeiter
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 104, "Buchhaltung");

        #Bearbeiter Tel
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 108.7, "042159564922");

        #Bearbeiter Mail
        $pdf->SetFont("Arial", "B", 8.5);
        $pdf->Text(140, 113.6,  iconv('UTF-8', 'windows-1252',"info@gzamotors.de"));



        #Adresse Firma
        $pdf->SetFont("Arial", "", 9.5);
        $pdf->Text(25.2, 59.5,  iconv('UTF-8', 'windows-1252',"RKG Markenwelt GmbH & Co. KG"));

        #Adresse Name
        $pdf->SetFont("Arial", "", 9.5);
        $pdf->Text(25.2, 63.6,  iconv('UTF-8', 'windows-1252',"Herr Ralph Hüskes"));

        #Adresse Straße
        $pdf->SetFont("Arial", "", 9.5);
        $pdf->Text(25.2, 67.6, iconv('UTF-8', 'windows-1252',"Friedenstraße 51"));

        #Adresse Stadt/Postleitzahl
        $pdf->SetFont("Arial", "", 9.5);
        $pdf->Text(25.2, 73, "53229 Bonn");


        #Lieferanschrift
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(20.5, 102.7, "Lieferanschrift:");

        #Lieferanschrift Firma
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 102.7, iconv('UTF-8', 'windows-1252',"RKG Markenwelt GmbH & Co. KG"));

        #Lieferanschrift Name
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 106, iconv('UTF-8', 'windows-1252',"Herr Ralph Hüskes"));

        #Lieferanschrift Straße
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 108.5, iconv('UTF-8', 'windows-1252',"Friedenstraße 51"));

        #Lieferanschrift Stadt/Postleitzahl
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 111.2, "53229 Bonn");

        #Lieferanschrift Land
        $pdf->SetFont("Arial", "", 7.5);
        $pdf->Text(42, 114, "Deutschland");



        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(20.5, 130, "Pos");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(30, 130, "Menge");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(45, 130, "Art. Nr.");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(70, 130, "Bezeichnung");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(125, 130, "Gesamt");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(127.5, 133.5, "(Netto)");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(145, 130, "MwSt");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(160, 130, "E-Preis");

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(178.5, 130, "Gesamt");

        #Rechnung Gesamtpreis (Netto)
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(130, 145, "Gesamtpreis Netto");

        #Rechnung Gesamtpreis (Netto)
        $pdf->SetFont("Arial", "", 9);
        $pdf->Text(138, 155, "MwSt. 19,00%");

        
        #Rechnung Gesamtpreis (Netto)
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(130, 165, "Gesamtpreis Netto");

        #Rechnung Gesamtpreis (Netto)
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(172, 145, iconv('UTF-8', 'windows-1252',"1.035,95 €"));
         #Rechnung Gesamtpreis (Netto)
         $pdf->SetFont("Arial", "", 9);
         $pdf->Text(175, 155, iconv('UTF-8', 'windows-1252',"196,83 €"));

          #Rechnung Gesamtpreis (Netto)
          $pdf->SetFont("Arial", "B", 9);
          $pdf->Text(172, 165, iconv('UTF-8', 'windows-1252',"1.232,78 €"));

        #Rechnung POS
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Text(20.5, 133.5, "________________________________________________________________________________________________");
        
        #Barcode Top
        $test = new BarcodeGeneratorJPG();
        file_put_contents('rechnung-barcode.JPG', $test->getBarcode("86301", $test::TYPE_CODE_128));
        $source = imagecreatefromjpeg('rechnung-barcode.JPG');
        // Rotate
        $rotate = imagerotate($source, 90, 0);
        //and save it on your server...
        imagejpeg($rotate, "rechnung-barcode.JPG");
        $pdf->Image("rechnung-barcode.JPG", 196, 100, 7, 40);

        #Rechnung Gesamtpreis (Netto)
        $pdf->SetFont("Arial", "B", 10);
        $pdf->Rotate(90, 200, 100);
        $pdf->Text(125, 100, iconv('UTF-8', 'windows-1252',"Auftrags Nr.: 86301"));

         #Rechnung Gesamtpreis (Netto)
         $pdf->SetFont("Arial", "B", 10);
         $pdf->Text(25, 100, iconv('UTF-8', 'windows-1252',"Auftrags Nr.: 86301"));

        $pdf->Rotate(0);
        #Barcode Top
        $test = new BarcodeGeneratorJPG();
        file_put_contents('rechnung-barcode.JPG', $test->getBarcode("86301", $test::TYPE_CODE_128));
        $source = imagecreatefromjpeg('rechnung-barcode.JPG');
        // Rotate
        $rotate = imagerotate($source, 90, 0);
        //and save it on your server...
        imagejpeg($rotate, "rechnung-barcode.JPG");
        $pdf->Image("rechnung-barcode.JPG", 196, 200, 7, 40);

        dd($pdf->Output());

    }




    public function deleteZuweisen(Request $req, $id, $process_id) {

        $email      = emails_history::where("process_id", $process_id)->where("id", $id)->first();
        $email->delete();

        return redirect()->back();

    }

    public function changeShelfeSingleCount(Request $req) {

        $shelfe = $req->input("shelfe");
        $count  = $req->input("count");

        $shelfeCount        = shelfe_count::where("shelfe_id", $shelfe)->first();

        if($shelfeCount != null) {
            $shelfeCount->count = $count;
            $shelfeCount->update();
        } else {
            $shelfeCount    = new shelfe_count;
            $shelfeCount->shelfe_id = $shelfe;
            $shelfeCount->count = $count;
            $shelfeCount->save();
        }
        DB::table('shelfes')
        ->where('shelfe_id', $shelfe)
        ->update(["full" => "false"]);

        return redirect()->back();

    }

    public function changeShelfeMultipleCount(Request $req) {

        $shelfe = $req->input("shelfe");
        $count  = $req->input("count");

        $shelfeCount        = shelfe_count::where("shelfe_id", $shelfe)->first();

        $shelfes            = shelfe::all();

        

        foreach($shelfes as $sh) {
            if(substr($sh->shelfe_id, 0, 1) == $shelfe) {
                $shelfeCount        = shelfe_count::where("shelfe_id", $sh->shelfe_id)->first();
                if($shelfeCount != null) {
                    $shelfeCount->count = $count;
                    $shelfeCount->update();
                } else {
                    $shelfeCount    = new shelfe_count;
                    $shelfeCount->shelfe_id = $sh->shelfe_id;
                    $shelfeCount->count = $count;
                    $shelfeCount->save();
                }
                DB::table('shelfes')
                    ->where('shelfe_id', $sh->shelfe_id)
                    ->update(["full" => "false"]);
            }
        }

        return redirect()->back();

    }

    public function getSendungenView(Request $req) {

        $trackings      = tracking_history::all();
        $statuses       = statuse::all();
        $warenausgang   = warenausgang_history::all();

        return view("forEmployees/administration/sendungenTracking")->with("trackings", $trackings)->with("statuses", $statuses)->with("warenausgang", $warenausgang);
    }

    public function getSendungModalView(Request $req, $label) {

        $trackings      = tracking_history::all();
        $statuses       = statuse::all();
        $warenausgang   = warenausgang_history::all();
        $lookTracking   = tracking_history::where("label", $label)->get();
        $warenausgangTracking = warenausgang_history::where("label", $label)->first();

        return view("forEmployees/administration/sendungenTracking")->with("lookTracking", $lookTracking)->with("warenausgangTracking", $warenausgangTracking)->with("trackings", $trackings)->with("statuses", $statuses)->with("warenausgang", $warenausgang)->with("bearbeiten", "true");

    }

    public function setMailInboxArchive(Request $req, $id) {

        $email      = emailinbox_history::where("email_id", $id)->first();
        if($email == null) {
            $email      = new emailinbox_history();

            $email->email_id = $id;
            $email->save();
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors(["Email ist bereits im Archiv"]);
        }
        

    }

    public function setMailInboxAktive(Request $req, $id) {

        $email      = emailinbox_history::where("email_id", $id)->first();
        if($email == null) {
            return redirect()->back()->withErrors(["Email ist im Aktiv"]);
        } else {
            $email->delete();
            return redirect()->back();
        }
    }

    public function getDateiVerteilenView(Request $req) {
        $files = file::where("verteilen", "true")->get();
        
        return view("forEmployees/administration/dateiverteilung")->with("files", $files);
    }

    public function uploadDateiVerteilenDatei(Request $req) {
        
        


            $file = $req->file("file");
            
        if($file == null) {
            return redirect("/crm/dateiverteilen")->withErrors(["Keine Datei ausgewählt"]);
        }
        $filename = $file->getClientOriginalName();

        $filename = str_replace(' ', '-', $filename); // Replaces all spaces with hyphens.
        $filename = preg_replace('/[^a-zA-Z0-9_.]/', '', $filename);
            
        $file->storeAs("/verteilen", $filename);

        $upload = new file();
        $upload->process_id = "";
        $upload->component_id = "";
        $upload->component_count = "";
        $upload->component_number = "";
        $upload->filename = $filename;
        $upload->description = "Verteilungssystem";
        $upload->verteilen = "true";
        $upload->größe = $file->getSize() / 1000;
        $upload->save();

        return redirect("/crm/dateiverteilen");

    }

    public function deleteDateiVerteilen(Request $req, $id) {
        file::where("id", $id)->delete();

        return redirect()->back();
    }

    public function dateiVerteilen(Request $req) {

        $files = file::where("verteilen", "true")->get();

        $notFoundFiles = array();
        $deletedFiles = array();

        foreach($files as $file) {
            $parts = explode(".", $file->filename);

            $person = active_orders_person_data::where("process_id", $parts[0])->first();
            if($person == null) {
                $person = new_leads_person_data::where("process_id", $parts[0])->first();
            }

            if($person != null) {

                Storage::move('verteilen/'. $file->filename, 'files/aufträge/'. $person->process_id . "/".$file->filename);

                $upload = new file();
                $upload->process_id = $person->process_id;
                $upload->component_id = "";
                $upload->component_count = "";
                $upload->component_number = "";
                $upload->filename = $file->filename;
                $upload->description = "Verteilungssystem";
                $upload->verteilen = "";
                $upload->größe = $file->größe;
                $upload->save();

                array_push($deletedFiles, $upload);

                $file->delete();
            } else {
                array_push($notFoundFiles, $file);
            }
        }

        $files = file::where("verteilen", "true")->get();
        
        return view("forEmployees/administration/dateiverteilung")->with("files", $files)->with("deletedFiles", $deletedFiles)->with("notFoundFiles", $notFoundFiles);

    }

    public function changeZuteilenFileName(Request $req) {

        try {
            $filename = $req->input("name");
            $id = $req->input("id");

            $filename = str_replace(' ', '-', $filename); // Replaces all spaces with hyphens.
            $filename = preg_replace('/[^a-zA-Z0-9_.]/', '', $filename);

            $file = file::where("id", $id)->first();

            Storage::move('verteilen/'. $file->filename, 'verteilen/'. $filename);

            $file->filename = $filename;
            $file->save();
        } catch (\Throwable $th) {
            return $th;
        }

    }

    public function changeNightMode(Request $req) {

        if($req->session()->get("nightMode") == null) {
            $req->session()->put("nightMode", "true");
            return redirect()->back();
                } else {
            if($req->session()->get("nightMode") == "true") {
                $req->session()->put("nightMode", "false");
                return redirect()->back();
            } else {
                $req->session()->put("nightMode", "true");
                return redirect()->back();
                        }
        }

    }

    public function neueTextvorlage(Request $req) {

        $type = $req->input("type");
        $name = $req->input("title");
        $textInput = $req->input("text");
        $id   = $req->input("id");
        $ak = $req->input("activate");
        $checked = false;   
        if($type == "vergleich") {
            $text = vergleichstext::where("id", $id)->first();
           
            if($text != null) {
                $text->title = $name;
                $text->text = $textInput;
                $text->aktiviert = $ak;
                $text->save();

            } else {
                $text = vergleichstext::where("id", $id)->first();
                if($text == null) {
                    $text == mahnungstext::where("id", $id)->first();
                }
                if($text == null) {
                    $text == rechnungstext::where("id", $id)->first();
                }
                if($text == null) {
                    $text == phonetexts::where("id", $id)->first();
                }
                if($text != null) {
                    if($type == "rechnung") {
                        $newText = new rechnungstext();
                        $newText->title = $text->title;
                        $newText->text = $text->text;
                        $newText->employee = "";
                        $newText->aktiviert = $ak;
                        $newText->save();
                        $checked = true;
        
                    }
                    if($type == "mahnung") {
                        $newText = new mahnungstext();
                        $newText->title = $text->title;
                        $newText->text = $text->text;
                        $newText->employee = "";
                        $newText->aktiviert = $ak;

                        $newText->save();
                        $checked = true;
                        $text->delete();
    
        
                    }
                    if($type == "vergleich") {
                        $newText = new vergleichstext();
                        $newText->title = $text->title;
                        $newText->text = $text->text;
                        $newText->employee = "";
                        $newText->aktiviert = $ak;

                        $newText->save();
                        $checked = true;
                        $text->delete();
    
        
                    }
                    if($type == "phone") {
                        $newText = new phonetexts();
                        $newText->title = $text->title;
                        $newText->text = $text->text;
                        $newText->employee = "";
                        $newText->aktiviert = $ak;

                        $newText->save();
                        $checked = true;
                        $text->delete();
                    }
                } else {
                    $text = new vergleichstext();
                    $text->title = $name;
                    $text->text = $textInput;
                    $text->aktiviert = $ak;

                    $text->employee = "";
                    $text->save();
                }
               

            }
            $checked = true;
        }

        if($type == "rechnung") {
            $text = rechnungstext::where("id", $id)->first();
            if($text != null) {
                $text->title = $name;
                $text->text = $textInput;
                $text->aktiviert = $ak;

                $text->save();
            } else {
               
                $text = vergleichstext::where("id", $id)->first();
                if($text == null) {
                    $text == mahnungstext::where("id", $id)->first();

                }
                if($text == null) {
                    $text == rechnungstext::where("id", $id)->first();
                }
                if($text == null) {
                    $text == phonetexts::where("id", $id)->first();
                }
                if($text != null) {
                    if($type == "rechnung") {
                        $newText = new rechnungstext();
                        $newText->title = $text->title;
                        $newText->text = $text->text;
                        $newText->aktiviert = $ak;

                        $newText->employee = "";
                        $newText->save();
                        $checked = true;
                        $text->delete();
    
                    }
                    if($type == "mahnung") {
                        $newText = new mahnungstext();
                        $newText->title = $text->title;
                        $newText->text = $text->text;
                        $newText->aktiviert = $ak;

                        $newText->employee = "";
                        $newText->save();
                        $checked = true;
                        $text->delete();
    
                    }
                    if($type == "vergleich") {
                        $newText = new vergleichstext();
                        $newText->title = $text->title;
                        $newText->text = $text->text;
                        $newText->employee = "";
                        $newText->aktiviert = $ak;

                        $newText->save();
                        $checked = true;
                        $text->delete();
    
                    }
                    if($type == "phone") {
                        $newText = new phonetexts();
                        $newText->title = $text->title;
                        $newText->text = $text->text;
                        $newText->aktiviert = $ak;

                        $newText->employee = "";
                        $newText->save();
                        $checked = true;
        
                    }
                } else {
                    $text = new rechnungstext();
                    $text->title = $name;
                    $text->text = $textInput;
                    $text->aktiviert = $ak;
                    $text->employee = "";
                    $text->save();
                }
                
            }
            $checked = true;
        }

        if($type == "mahnung") {
            $text = mahnungstext::where("id", $id)->first();
            if($text != null) {
                $text->title = $name;
                $text->text = $textInput;
                $text->aktiviert = $ak;
                $text->save();
            } else {
                $text = vergleichstext::where("id", $id)->first();
            if($text == null) {
                $text == mahnungstext::where("id", $id)->first();
            }
            if($text == null) {
                $text == rechnungstext::where("id", $id)->first();
            }
            if($text == null) {
                $text == phonetexts::where("id", $id)->first();
            }
            if($text != null) {
                if($type == "rechnung") {
                    $newText = new rechnungstext();
                    $newText->title = $text->title;
                    $newText->text = $text->text;
                    $newText->employee = "";
                    $newText->aktiviert = $ak;

                    $newText->save();
                    $checked = true;
                    $text->delete();
    
                }
                if($type == "mahnung") {
                    $newText = new mahnungstext();
                    $newText->title = $text->title;
                    $newText->text = $text->text;
                    $newText->employee = "";
                    $newText->aktiviert = $ak;

                    $newText->save();
                    $checked = true;
                    $text->delete();
    
                }
                if($type == "vergleich") {
                    $newText = new vergleichstext();
                    $newText->title = $text->title;
                    $newText->text = $text->text;
                    $newText->employee = "";
                    $newText->aktiviert = $ak;

                    $newText->save();
                    $checked = true;
                    $text->delete();
    
                }
                if($type == "phone") {
                    $newText = new phonetexts();
                    $newText->title = $text->title;
                    $newText->text = $text->text;
                    $newText->employee = "";
                    $newText->aktiviert = $ak;

                    $newText->save();
                    $checked = true;
                    $text->delete();
    
                }
            } else{
                $text = new mahnungstext();
                $text->title = $name;
                $text->text = $textInput;
                $text->employee = "";
                $text->aktiviert = $ak;

                $text->save();
            }
           
            }
        }


        if($type == "phone") {
            $text = phonetexts::where("id", $id)->first();
            if($text != null) {
                $text->title = $name;
                $text->text = $textInput;
                $text->aktiviert = $ak;
                $text->save();
            } else {
                $text = vergleichstext::where("id", $id)->first();
            if($text == null) {
                $text == mahnungstext::where("id", $id)->first();
            }
            if($text == null) {
                $text == rechnungstext::where("id", $id)->first();
            }
            if($text == null) {
                $text == phonetexts::where("id", $id)->first();
            }
            if($text != null) {
                if($type == "rechnung") {
                    $newText = new rechnungstext();
                    $newText->title = $text->title;
                    $newText->text = $text->text;
                    $newText->employee = "";
                    $newText->aktiviert = $ak;

                    $newText->save();
                    $checked = true;
                    $text->delete();
    
                }
                if($type == "mahnung") {
                    $newText = new mahnungstext();
                    $newText->title = $text->title;
                    $newText->text = $text->text;
                    $newText->aktiviert = $ak;

                    $newText->employee = "";
                    $newText->save();
                    $checked = true;
                    $text->delete();
    
                }
                if($type == "vergleich") {
                    $newText = new vergleichstext();
                    $newText->title = $text->title;
                    $newText->text = $text->text;
                    $newText->employee = "";
                    $newText->save();
                    $checked = true;
                    $text->delete();
    
                }
                if($type == "phone") {
                    $newText = new phonetexts();
                    $newText->title = $text->title;
                    $newText->text = $text->text;
                    $newText->aktiviert = $ak;

                    $newText->employee = "";
                    $newText->save();
                    $checked = true;
                    $text->delete();
    
                }
            } else{
                $text = new phonetexts();
                $text->title = $name;
                $text->aktiviert = $ak;
                $text->text = $textInput;
                $text->employee = "";
                $text->save();
            }
           
            }
        }

        if($text->getTable() == "rechnungstext") {
            return redirect("crm/vergleichsetting/redirect/rechnung");
        }
        if($text->getTable() == "vergleichstext") {
            return redirect("crm/vergleichsetting/redirect/vergleich");
        }
        if($text->getTable() == "mahnungstext") {
            return redirect("crm/vergleichsetting/redirect/mahnung");
        }
        if($text->getTable() == "phonetext") {
            return redirect("crm/vergleichsetting/redirect/phone");
        }



    }

    public function changeSignatur(Request $req) {
        $user = User::where("id", Auth()->user()->id)->first();
        $user->signatur = $req->input("body");
        $user->update();
        return redirect()->back();

    }

     #info@steubel.de = id 1;
    #info@gzamotors.de = id 1;
    public function refreshMailDatabase(Request $req, $id) {
        

        $account = emailaccount::where("id", $id)->first();
        $inboxClient = new mailInbox($account->user, $account->password, $account->server, $account->port);

        $emails = emailinbox::where("account", $id)->with("file")->get();
        $inboxes = $inboxClient->getEmails();
        foreach($inboxes as $inbox) {

            #$con = $inboxClient->connect();
            #$con->moveMail($inbox->id, "Archiv");

            if($emails->where("email_id", $inbox->id)->first() == null) {
                $email = new emailinbox();
                
                
                $inboxemail = emailinbox::where("subject", $inbox->subject)->where("absender", $inbox->fromAddress)->first();
                
                if($inboxemail != null) {
                    $email->email_id = $inboxemail->email_id;
                } else {
                    $email->email_id = $inbox->id;
                }

                $email->subject = $inbox->subject;
                $email->text = $inbox->textHtml;
                $email->absender = $inbox->fromAddress;
                $email->send_at = $inbox->date;
                $email->account = $id;
                $endcc = "";
                
               

                $inbox->getAttachments();

                if(!empty($inbox->getAttachments())) {
                    foreach($inbox->getAttachments() as $att) {
                        $file = new file();
                        $file->process_id = "inbox";
                        $file->component_id = $inbox->id;
                        $filePath = explode("\\", $att->filePath);
                        $file->filename = $filePath[count($filePath) - 1];
                        $file->verteilen = "false";
                        $file->save();
                    }
                    $email->files = "true";
                }
                $email->save();



            }

        }

        $emails = emailinbox::where("account", $id)->with("file")->where("send", null)->get()->sortBy("created_at");

        return $emails;
    }

    public function deleteEmailAccount(Request $req, $id) {
        $email = emailaccount::where("id", $id)->first();
        $email->delete();

        $emails = emailinbox::where("account", $id)->get();
        foreach($emails as $email) {
            $email->delete();
        }

        $emails = emailaccount::all();

        return $emails;
    }

    public function neuerEmailAccount(Request $req) {
        $server     = $req->input("server");
        $port       = $req->input("port");
        $user       = $req->input("user");
        $password   = $req->input("passwort");

        $email = new mailInbox($user, $password, $server, $port);
        try {
            $response = $email->connect();
            $response->countMails();

            $email              = new emailaccount();
            $email->server      = $server;
            $email->port        = $port;
            $email->user        = $user;
            $email->password    = $password;
            $email->save();

            $this->refreshMailDatabase($req, $email->id);

            
        } catch (\Throwable $th) {
            
            return "not-found";
        }


        return $email;
    }

    public function getMailsDatabase(Request $req, $id) {


        $emails = emailinbox::where("account", $id)->with("file")->get()->sortBy("created_at");
        
        return $emails;
    }

    public function getMailDatabase(Request $req, $account, $id) {
        $email = emailinbox::where("id", $id)->with("email_inbox_entwurf")->with("file")->first();

        $emails = emailinbox::where("subject", $email->subject)->with("file")->get();
        

        $text = "";
        foreach($emails as $em) {
            if($em->read_at == null) {
                DB::table("emailinbox")->where("id", $em->id)->update(array("read_at" => date("d.m.Y H:i")));
            }
            $date = strtotime($em->send_at);
            $text = $text . "<div class='py-4'><p class='text-gray-600 mr-6'><p> " .  date("d.m.Y H:i: ", $date) . "<span class='text-gray-400'
            >(" . $em->absender .")</span></p>";
            $anhang = "<p class='font-semibold text-sm'>Anhänge</p>";
            if($em->file != null) {
                foreach($em->file as $file) {
                    $anhang .= "<p class='text-sm'><a href='". url("/") ."/emailAttach/$file->filename' target='_blank' class='text-blue-500'>" . $file->filename . "</a></p>";
                }
            }
            $anhang .= "<br>";
            $textPart = "<p class='float-left ml-4'>" . $em->text . "</p></div>";
            $text = $text.$anhang.$textPart;
            
            
        }
        $email->text = $text;
        return $email;
    }

    public function emailVerschieben(Request $req, $id, $account) {
        $email = emailinbox::where("id", $id)->first();
        $new = new emailinbox();
        $new = $email;
        $new->account = $account;
        $new->save();

        $saveEmail = $email;

        return $saveEmail;

    }

    public function postMailEntwurfSpeichern(Request $req) {
        $subject = $req->input("subject");
        $text = $req->input("text");
        $id = $req->input("id");

        $entwurf = email_inbox_entwurf::where("email_id", $id)->first();
        if($entwurf != null) {
            $entwurf->subject = $subject;
            $entwurf->text = $text;
            $entwurf->employee = Auth()->user()->username;
            $entwurf->save();
        } else {
            $entwurf = new email_inbox_entwurf();
            $entwurf->email_id = $id;
            $entwurf->subject = $subject;
            $entwurf->text = $text;
            $entwurf->employee = Auth()->user()->username;
            $entwurf->save();
        }
    }

    public function postMailAnswer(Request $req) {

        $id         = $req->input("id");
        $subject    = $req->input("subject");
        $text       = $req->input("text");
        $file       = $req->file("filee");
        if($file != null) {
            $file->storeAs("/emailinbox", $file->getClientOriginalName());
        }


        try {
            Mail::to("test@steubel.de")->send(new inboxanswer($text, $subject, "a", $file));
        } catch (\Throwable $th) {
            return $th;
        }

        $email = new emailinbox();
        $email->email_id = $id;
        $email->subject = $subject;
        $email->text = $text;
        $email->absender = "intern@steubel.de";
        $email->send_at = "test@steubel.de";
        $email->account = 1;
        $email->send = "true";
        $endcc = "";
        $email->save();

        return $email;
    }

    public function postMailNew(Request $req) {

        $id         = $req->input("id");
        $subject    = $req->input("subject");
        $text       = $req->input("text");
        $file       = $req->file("file");
        $bcc        = $req->input("bcc");
        $cc         = $req->input("cc");
        $account    = $req->input("account");

        if($file != null) {
            $file->storeAs("/emailinbox", $file->getClientOriginalName());
        }


        try {
            if($cc != "") {
                $cc = explode(" ", $cc);
            }
            if($bcc != "") {
                $bcc = explode(" ", $bcc);
            }
            if($account == "1") {
                Mail::mailer("intern")->to("test@steubel.de")->cc($cc)->bcc($bcc)->send(new inboxanswer($text, $subject, "a", $file));
            }
            if($account == "2") {
                Mail::mailer("td")->to("test@steubel.de")->cc($cc)->bcc($bcc)->send(new inboxanswer($text, $subject, "a", $file));
            }
            if($account == "3") {
                Mail::mailer("service")->to("test@steubel.de")->cc($cc)->bcc($bcc)->send(new inboxanswer($text, $subject, "a", $file));
            }
        } catch (\Throwable $th) {
            return $th;
        }

        $email = new emailinbox();
        $email->email_id = $id;
        $email->subject = $subject;
        $email->text = $text;
        if($account == "1") {
            $email->absender = "intern@steubel.de";
        }
        if($account == "2") {
            $email->absender = "td@steubel.de";
        }
        if($account == "3") {
            $email->absender = "service@steubel.de";
        }
        $email->send_at = "test@steubel.de";
        $email->account = $account;
        $email->send = "true";
        $endcc = "";
        $email->save();

        return $email;

    }

    public function getMailOrders(Request $req) {
        
        $orders = active_orders_person_data::limit(50)->get();
        foreach($orders as $order) {
            $order->area = "Aufträge";
        }

        $leads = new_leads_person_data::limit(50)->get();
        foreach($leads as $lead) {
            $lead->area = "Aufträge";
        }

        $orders->merge($leads);

        return $orders;
    }

    public function getMailLeads(Request $req) {
        $orders = new_leads_person_data::all();

        return $orders;
    }

    public function getMailOrder(Request $req, $id) {
        $order = active_orders_person_data::where("process_id", $id)->first();
        if($order == null) {
            $order = new_leads_person_data::where("process_id", $id)->first();
        }

        return $order;
    }

    public function deleteEmailVorlagenPDF(Request $req, $id) {

        $email = email_template::where("id", $id)->first();
        $email->file = "";
        $email->save();

        return "ok";
    }
    public function getMahneinstellungenView(Request $req) {

        $mahnungen = mahneinstellungen::all();

        return view("rechnungen.mahneinstellungen")->with("mahneinstellungen", $mahnungen);
    }
    public function neueMahneinstellung(Request $req) {
        $mahnung = mahneinstellungen::where("id", $req->input("mahnid"))->first();

        $mahnung->bezeichnung = $req->input("bezeichnung");
        $mahnung->mahnstufe = $req->input("mahnstufe");
        $mahnung->mahngebür = str_replace("€", "", $req->input("mahngebuer"));
        $mahnung->zahlungsfrist = $req->input("zahlungsfrist");
        $mahnung->activ = $req->input("active");

        $mahnung->update();
    }

    public function searchOrders(Request $req, $key) {

      $orders =  active_orders_person_data::where("process_id", "LIKE", "%". $key . "%")->get();
      $orders =  $orders->toBase()->merge(archive_orders_person::where("process_id", "LIKE", "%". $key . "%")->get());
      $orders =  $orders->toBase()->merge(new_leads_person_data::where("process_id", "LIKE", "%". $key . "%")->get());
      $orders =  $orders->toBase()->merge(archive_lead_person_data::where("process_id", "LIKE", "%". $key . "%")->get());

      if($key == "null") {
        $orders = null;

        $orders =  active_orders_person_data::all();
        $orders =  $orders->toBase()->merge(archive_orders_person::all());
        $orders =  $orders->toBase()->merge(new_leads_person_data::all());
        $orders =  $orders->toBase()->merge(archive_lead_person_data::all());
      }

      return $orders;
    }

    public function changePDF(Request $req) {

        if($req->input("type") == "rechnung") {
            $pdf = new Fpdi(); 
        
            // set the source file
            $pdf->setSourceFile(public_path("/"). "pdf/rechnung_mwst_pdf_empty.pdf");
            $pdf->AddPage();
            $tplId = $pdf->importPage(1);
            $pdf->useTemplate($tplId); 
            $pdf->setFont("Arial");
            $pdf->SetFontSize(8);

            if($req->file("filee") != null) {
                $req->file("filee")->move(public_path("/") . "/uploads", "image.png");

            $pdf->Image('uploads/image.png', 10, 5, 100, 35);
            }

            if($req->input("top-1") !=null) {
                $pdf->setXY(110,10);
                $pdf->Cell(80, 8, $req->input("top-1"), 0, 0, "R");
            }
           
            if($req->input("top-2") != null) {
            $pdf->setXY(110,13);
            $pdf->Cell(80, 8, $req->input("top-2"), 0, 0, "R");
            }
            if($req->input("top-3") != null) {
            $pdf->setXY(110,16);
            $pdf->Cell(80, 8, $req->input("top-3"), 0, 0, "R");
            }
            if($req->input("top-4") != null) {
            $pdf->setXY(110,21);
            $pdf->Cell(80, 8, $req->input("top-4"), 0, 0, "R");
            }
            if($req->input("top-5") != null) {
            $pdf->setXY(110,26);
            $pdf->Cell(80, 8, $req->input("top-5"), 0, 0, "R");
            }
            if($req->input("top-6") != null) {
            $pdf->setXY(110,29);
            $pdf->Cell(80, 8, $req->input("top-6"), 0, 0, "R");
            }
            if($req->input("top-7") != null) {
            $pdf->setXY(110,34);
            $pdf->Cell(80, 8, $req->input("top-7"), 0, 0, "R");
            }
            if($req->input("top-8") != null) {
            $pdf->setXY(110,37);
            $pdf->Cell(80, 8, $req->input("top-8"), 0, 0, "R");
            }
            $pdf->SetFontSize(7);


            $pdf->setXY(25,50);
            $pdf->Cell(80, 8, $req->input("top-1") . ", " . $req->input("top-2") . ", " . $req->input("top-3"), 0, 0, "L");

            $pdfData = $pdf->Output('pdf/rechnung_mwst_pdf.pdf','F');
            return redirect()->back();
        }

    }

    public function uploadCSVFeiertage(Request $req) {

        $file = $req->file("file");
        feiertage::truncate();

        if($file->getClientOriginalExtension() != "csv") {
            return redirect()->back()->withErrors(["Datei ist keine CSV Datei"]);
        } else {
            $file->storeAs("/csv", "feiertage.csv");
            // Open the file for reading
            if (($h = fopen("csv/feiertage.csv", "r")) !== FALSE) 
            {
              // Convert each line into the local $data variable
              while (($data = fgetcsv($h, 2000, ",")) !== FALSE) 
              {		


                // Read the data from a single line
                $date = $data[0];
                $name = $data[1];
                $feiertag = new feiertage();
                $feiertag->datum = $date;
                $feiertag->bezeichnung = $name;
                $feiertag->save();
              }
        
              // Close the file
              fclose($h);
            }
        }

        $feiertage = feiertage::all();
        $employees = user::all();
        $employee = user::where("id", "4")->first();
        $date = new DateTime();
        try {
            $firstdate = new DateTime($date->format("Y-m") . "-01");
            $seconddate = new DateTime($firstdate->format("Y-m") . "-31");
        } catch(Exception $e) {
            try {
                $firstdate = new DateTime($date->format("Y-m") . "-01");
                $seconddate = new DateTime($firstdate->format("Y-m") . "-30");
            } catch(Exception $e) {
                try {
                    $firstdate = new DateTime($date->format("Y-m") . "-01");
                    $seconddate = new DateTime($firstdate->format("Y-m") . "-29");
                } catch(Exception $e) {
                    try {
                        $firstdate = new DateTime($date->format("Y-m") . "-01");
                        $seconddate = new DateTime($firstdate->format("Y-m") . "-28");
                    } catch(Exception $e) {
                        
                    }
                }
            }
        }
        
        if(!isset($year)) {
            $date = new DateTime();
            $year = $date->format("Y");
            $month = $date->format("m");
        }

        $employees = user::all();
        $onlines = array();
        foreach($employees as $e) {
            $time = zeiterfassung::where("employee", $e->id)->latest()->first();
            if($time != null) {
                if($time->type == "start") {
                    array_push($onlines, $e);
                }
            }
        }

        $times = zeiterfassung::where("employee", $employee->id)->whereBetween("created_at", [$firstdate, $seconddate])->get();
        $allTimes = zeiterfassung::whereBetween("created_at", [$firstdate->format($year . "-01-01 00:00:00"), $firstdate->format($year. "-12-31 23:59:59")])->where("employee", $employee)->get();

        return view('forEmployees/zeiterfassung/main')->with("feiertage", $feiertage)->with("uploadcsv", "true")->with("onlines", $onlines)->with("allTimes", $allTimes)->with("employees", $employees)->with("selectedEmployee", $employee)->with("times", $times);
 
        

    }

    public function getDateimanager(Request $req) {

        $files = file::where("manager", "true")->where("verteilen", "false")->get();

        return view("forEmployees/administration/dateimanager")->with("files", $files);

    }

    public function uploadDateimanagerFile(Request $req) {

        $file = $req->file("file");
            
        if($file == null) {
            return redirect("/crm/dateiverteilen")->withErrors(["Keine Datei ausgewählt"]);
        }
            
        $file->storeAs("/dateimanager", $file->getClientOriginalName());

        $upload = new file();
        $upload->process_id = "";
        $upload->component_id = "";
        $upload->component_count = "";
        $upload->component_number = "";
        $upload->filename = str_replace(" ", "_", $file->getClientOriginalName());
        $upload->description = "Dateimanager";
        $upload->verteilen = "false";
        $upload->manager = "true";
        $upload->größe = $file->getSize() / 1000;
        $upload->save();

        return redirect()->back();

    }

    public function changeDateimanagerFilename(Request $req) {
        try {
            $filename = $req->input("name");
            $id = $req->input("id");

            $file = file::where("id", $id)->first();

            Storage::move('verteilen/'. $file->filename, 'verteilen/'. $filename);

            $file->filename = $filename;
            $file->save();
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function getRollenView(Request $req) {

        $rollen = role::with("roleid.permission")->get();
        $perms  = code_permission::all();
        return view('forEmployees.administration.rollen')->with("rollen", $rollen)->with("perms", $perms);
    }

    public function saveRollenPermissions(Request $req, $id) {

        $perms = code_permission::all();
        foreach($perms as $perm) {

            $input = $req->input("permission-$id-$perm->permissions_id");


            if($input == "delete") {

                $permission = role_has_permission::where("role_id", $id)
                                                ->where("permission_id", $perm->permissions_id)
                                                ->first();

                if($permission != null) {
                    $permission->delete();
                }

            } else {
                $permission = role_has_permission::where("role_id", $id)
                                                ->where("permission_id", $perm->permissions_id)
                                                ->first();

                if($permission == null) {
                    if($input != null) {
                        $randID = random_int(1, 100000);

                        $permission                 = new role_has_permission();
                        $permission->permission_id  = $perm->permissions_id;
                        $permission->role_id        = $id;
                        $permission->id = random_int(1,100000);
                        $permission->save();
                    }
                }
            }
            
        }

        return redirect()->back();
    }

    public function createNewRole(Request $req) {

        $name           = $req->input("name");
        $description    = $req->input("description");

        if(!is_numeric($name)) {
            $role               = new role();
            $role->name         = $name;
            $role->guard_name   = "web";
            $role->description  = $description;
            $role->save();

            $perms = code_permission::all();
            foreach($perms as $perm) {

                $permission                 = new role_has_permission();
                $permission->permission_id  = $perm->permissions_id;
                $permission->role_id        = $role->id;
                $permission->id             = random_int(0, 1000000);
                $permission->save();

            }

            return redirect()->back();
        } else {
            return redirect()->back()->withErrors(["Rollenname darf nicht nur aus Zahlen bestehen"]);
        }
    }

    public function createNewPermission(Request $req) {

        $name           = $req->input("name");
        $description    = $req->input("description");
        $url            = $req->input("url");
        $id             = $req->input("id");


        $permission                 = new permission();
        $permission->name           = $name;
        $permission->guard_name     = "web";
        $permission->description    = $description;
        $permission->url            = $url;
        $permission->custom         = "true";
        $permission->save();

        $coePerm                 = new code_permission();
        $coePerm->name           = $name;
        $coePerm->description    = $description;
        $coePerm->permissions_id = $permission->userid;
        $coePerm->url            = $url;
        $coePerm->custom         = "true";
        $coePerm->save();

        $role   = new role_has_permission();
        $role->role_id = $id;
        $role->permission_id = $permission->userid;
        $role->save();

        return redirect()->back();
    }

    public function deleteCustomPermission(Request $req, $id) {

        $perm   = code_permission::where("id", $id)->first();

        $role   = role_has_permission::where("permission_id", $perm->permissions_id)->delete();

        permission::where("id", $perm->permissions_id)->delete();

        $perm->delete();

        return redirect()->back();
    }

    public function getBenutzerView(Request $req) {

        $users  = user::all();
        $rollen = role::all();

        return view("forEmployees.administration.benutzer")
                    ->with("users", $users)
                    ->with("rollen", $rollen);
    }

    public function getBenutzerBearbeitenView(Request $req, $id) {

        $users          = user::all();
        $changedUser    = user::where("id", $id)->first();
        $rollen         = role::all();

        return view("forEmployees.administration.benutzer")
                    ->with("users", $users)
                    ->with("changedUser", $changedUser)
                    ->with("rollen", $rollen);
    } 

    public function saveBenutzerÄnderungen(Request $req, $id) {

        $rolle              = role::where("id", $req->input("role"))->first();
        $nutzername         = $req->input("username");
        $name               = $req->input("name");
        $password           = $req->input("password");
        $email              = $req->input("email");
        $signatur           = $req->input("signatur");
        $file               = $req->file("file");
        $workdays           = $req->input("workdays");
        $soll               = $req->input("soll");
        $workhours          = $req->input("workhours");
        $allowed_vacations  = $req->input("allowed_vacations");

        $user           = user::where("id", $id)->first();
        $user->username = $nutzername;
        $user->name     = $name;

        if($password != "") {
            $user->password = Hash::make($password);
        }
        if($file != null) {
            $file->storeAs("employee/$id", "profile.png");
        }

        $user->email                = $email;
        $user->signatur             = $signatur;
        $user->workdays             = $workdays;
        $user->workhours            = $workhours;
        $user->allowed_vacations    = $allowed_vacations;
        $user->soll                 = $soll;
        $user->update();

        $oldRole    = role::where("name", $user->getRoleNames()->first())->first();

        if($oldRole != null) {
            $user->removeRole($oldRole->name);
        }


        $user->assignRole($rolle->name);

        return redirect()->back();
    }

    public function saveNeuenBenutzer(Request $req) {

        
        $rolle              = role::where("id", $req->input("role"))->first();
        $nutzername         = $req->input("username");
        $name               = $req->input("name");
        $password           = $req->input("password");
        $email              = $req->input("email");
        $signatur           = $req->input("signatur");
        $workdays           = $req->input("workdays");
        $soll               = $req->input("soll");
        $workhours          = $req->input("workhours");
        $allowed_vacations  = $req->input("allowed_vacations");

        $user                       = new user();
        $user->username             = $nutzername;
        $user->name                 = $name;
        $user->password             = Hash::make($password);
        $user->email                = $email;
        $user->signatur             = $signatur;
        $user->workdays             = $workdays;
        $user->workhours            = $workhours;
        $user->allowed_vacations    = $allowed_vacations;
        $user->soll                 = $soll;
        $user->save();

        $user->assignRole($rolle->name);

        return redirect("crm/benutzer");
    }

    public function deleteBenutzer(Request $req, $id) {

        user::where("id", $id)->first()->delete();

        return redirect("crm/benutzer");
    }

    public function deleteRolle(Request $req, $id) {

        role::where("id", $id)->first()->delete();

        return redirect("crm/rollen");
    }

    public function getKeinZugangView(Request $req) {

        return view("kein-zugang");
    }

    public function getKundenkontoCollection(Request $req, $id) {

        $konto = active_orders_person_data::where("process_id", $id)->first();
        if($konto != null) {
            if(archive_orders_person::where("process_id", $id)->first() != null) {
                $konto = archive_orders_person::where("process_id", $id)->first()->merge($konto);
            }
        } else {
            $konto = archive_orders_person::where("process_id", $id)->first();
        }

        return $konto;
    }

    public function getRechnungsnummern(Request $req, $id) {

        $konto = kundenkonto::where("process_id", $id)->first();

        $rechnungen = rechnungen::where("kundenid", $konto->kundenid)->get();

        return $rechnungen;
    }

    public function getBuchhaltungEinstellungenView(Request $req) {

        $artikelliste = artikel::all();
        $globalsettings = globalsetting::all();

        return view("forEmployees.administration.buchhaltungEinstellungen")->with("artikelliste", $artikelliste)->with("globalsettings", $globalsettings);
    }

    public function saveNewArtikel(Request $req) {

        $artikel        = new artikel();
        $artikel->artname   = $req->input("name");
        $artikel->artnr     = $req->input("artnr");
        $artikel->mwst      = $req->input("mwst");
        $artikel->netto     = $req->input("netto");
        $artikel->brutto    = $req->input("brutto");
        $artikel->save();

        return redirect()->back();
    }

    public function getBuchhaltungEinstellungenZahlartBearbeiten(Request $req, $id) {
        
        $zahlarten          = zahlart::all();
        $bearbeitenZahlart  = zahlart::where("id", $id)->first();
        $globalsettings = globalsetting::all();

        return view("forEmployees.administration.buchhaltungEinstellungen")->with("zahlarten", $zahlarten)->with("bearbeitenZahlart", $bearbeitenZahlart)->with("globalsettings", $globalsettings);
    }

    public function saveBearbeitenZahlart(Request $req, $id) {

        $zahlart        = zahlart::where("id", $id)->first();
        $zahlart->name  = $req->input("name");
        $zahlart->save();

        return redirect()->back();
    }

    public function getZahlungszielBearbeiten(Request $req) {

        $zahlarten = zahlart::all();
        $globalsettings = globalsetting::all();
        $zahlziel = globalsetting::where("id", "1")->first();

        return view("forEmployees.administration.buchhaltungEinstellungen")->with("zahlarten", $zahlarten)->with("globalsettings", $globalsettings)->with("zahlziel", $zahlziel);
    }

    public function saveZahlziel(Request $req) {

        $zahlziel        = globalsetting::where("id", "1")->first();
        $zahlziel->value  = $req->input("name");
        $zahlziel->save();

        return redirect()->back();
    }
    
    public function uploadAngebotPDF(Request $req) {

        $file = $req->file("file");
        $file->storeAs("pdf", "angebot_pdf.pdf");

        return redirect()->back();
    }
    public function uploadAngebotMWSTPDF(Request $req) {

        $file = $req->file("file");
        $file->storeAs("pdf", "angebot_mwst.pdf");

        return redirect()->back();
    }

    public function uploadRechnungPDF(Request $req) {

        $file = $req->file("file");
        $file->storeAs("pdf", "rechnung_pdf.pdf");

        return redirect()->back();
    }
    public function uploadRechnungMWSTPDF(Request $req) {

        $file = $req->file("file");
        $file->storeAs("pdf", "rechnung_mwst.pdf");

        return redirect()->back();
    }

    public function uploadGutschriftPDF(Request $req) {

        $file = $req->file("file");
        $file->storeAs("pdf", "gutschrift_pdf.pdf");

        return redirect()->back();
    }
    public function uploadGutschriftMWSTPDF(Request $req) {

        $file = $req->file("file");
        $file->storeAs("pdf", "gutschrift_mwst.pdf");

        return redirect()->back();
    }

    public function getEmailVorlagen(Request $req) {
        return [email_template::all(), auth()->user()];
    }
    
    public function getEmailVorlage(Request $req, $id) {
        return email_template::where("id", $id)->first();
    }

    public function getUPSStatuscodesView(Request $req) {

        $carrier = carrier::with("versandStatuscode")->get();

        return view("forEmployees.administration.statuscodes")->with("carrier", $carrier);
    }

    public function getStatuscodesBearbeiten(Request $req) {
        
        $carrier = carrier::with("versandStatuscode")->get();
        $changeCodeSelect = statuscodes_select::all();

        return view("forEmployees.administration.statuscodes")->with("carrier", $carrier)->with("changeCodeSelect", $changeCodeSelect);
    }

    public function getStatuscodesSelectNeu(Request $req) {
        $carrier            = carrier::with("versandStatuscode")->get();
        $changeCodeSelect   = statuscodes_select::all();

        return view("forEmployees.administration.statuscodes")
                ->with("carrier", $carrier)
                ->with("changeCodeSelect", $changeCodeSelect)
                ->with("newCodeSelect", "true");
    }

    public function getStatuscodesChange(Request $req, $id) {
         $carrier = carrier::with("versandStatuscode")->get();
         $changedCode = versand_statuscode::where("id", $id)->first();
         $selectCodes   = statuscodes_select::all();

        return view("forEmployees.administration.statuscodes")->with("carrier", $carrier)->with("changedCode", $changedCode)->with("selectCodes", $selectCodes);
    }

    public function saveStatuscodeChange(Request $req) {

        $id         = $req->input("id");
        $custom     = $req->input("custom");
        $color      = $req->input("color");
        $icon       = $req->input("icon");

        $status                 = versand_statuscode::where("id", $id)->first();
        $status->bezeichnung    = $custom;
        $status->color          = $color;
        $status->icon           = $icon;
        $status->save();

        return redirect("crm/ups-statuscodes");
    }

    public function getBuchhaltungEinstellungenArtikelBearbeiten(Request $req, $id) {

        $artikelliste   = artikel::all();
        $artikelEdit    = artikel::where("id", $id)->first();
        $globalsettings = globalsetting::all();

        return view("forEmployees.administration.buchhaltungEinstellungen")
                ->with("artikelliste", $artikelliste)
                ->with("globalsettings", $globalsettings)
                ->with("artikelEdit", $artikelEdit);
    }

    public function saveBearbeitenArtikel(Request $req, $id) {

        $artikel            = artikel::where("id", $id)->first();
        $artikel->artname   = $req->input("name");
        $artikel->mwst      = $req->input("mwst");
        $artikel->netto     = $req->input("netto");
        $artikel->brutto    = $req->input("brutto");
        $artikel->save();

        return redirect("/crm/buchhaltung-einstellungen");
    }

    public function getGerätezuweisungView(Request $req, $id) {

        $orders = active_orders_person_data::all();
        $orders = archive_orders_person::all()->merge($orders);
        $orders = new_leads_person_data::all()->merge($orders);
        $orders = archive_lead_person_data::all()->merge($orders);

        return view("forEmployees.packtisch.gerät-zuweisenändern")->with("id", $id)->with("orders", $orders);

    }

    public function getEmailInboxView(Request $req) {

        $accounts = emailaccount::all();

        return view("mails.inbox")->with("accounts", $accounts);
    }

    public function setEmailToSpam(Request $req, $id) {

        $email = emailinbox::where("id", $id)->first();
        
        if($email->spam == "true") {
            $email = emailinbox::where("absender", $email->absender)->get();
            foreach($email as $e) {
                $e->spam = "false";
                $e->save();
            }
        } else {
            $email = emailinbox::where("absender", $email->absender)->get();
            foreach($email as $e) {
                $e->spam = "true";
                $e->save();
            }
        }

        return redirect()->back();
    }

    public function saveNeueEmailEntwurf(Request $req) {

        $user = user::where("id", auth()->user()->id)->first();

        $user->email_entwurf_cc = $req->input("empf");
        $user->email_entwurf_subject= $req->input("subject");
        $user->email_entwurf_body = $req->input("text");

        $user->save();


    }

    public function changeReklamationKategorie(Request $req) {
        
        $id         = $req->input("id");
        $kategorie  = $req->input("kategorie");

        $reklamation            = reklamation::where("id", $id)->first();
        $reklamation->kategorie = $kategorie;
        $reklamation->save();

        return redirect()->back();
    }

    public function sortReklamationsübersicht(Request $req, $field, $type) {

        $allStats = statuse::all();
        $statuses = statuse::all();
        $statusHistory = status_histori::all();
        $reklamationen = reklamation::all();

        $orders = active_orders_person_data::all();
        $orders = $orders->merge(archive_orders_person::all());
        $orders = $orders->merge(new_leads_person_data::all());
        $orders = $orders->merge(archive_lead_person_data::all());

        $cars = active_orders_car_data::all();

        $users = user::all();

        if($type == "up") {
            $sorting    = "up";
            $orders     = $orders->sortByDesc($field);
            $cars       = $cars->sortByDesc($field);
        } else {
            $sorting    = "down";
            $orders     = $orders->sortBy($field);
            $cars       = $cars->sortBy($field);
        }

        return view("forEmployees.reklamation.main")
                ->with("allStats", $allStats)
                ->with("statuses", $statuses)
                ->with("users", $users)
                ->with("reklamationen", $reklamationen)
                ->with("orders", $orders)
                ->with("cars", $cars)
                ->with("statusHistory", $statusHistory)
                ->with("sorting", $field."-".$type);
    }

    public function getTrackingHistory(Request $req, $id) {

        $trackings = tracking::where("trackingnumber", $id)->get();

        foreach($trackings as $t) {
            $date           = new DateTime($t->event_date);
            $t->date = $date->format("d.m.Y (H:i)");
        }
        $trackings = $trackings->sortByDesc("event_date");
        return $trackings;
    }

    public function setNewTrackingnumber(Request $req) {

        $id         = $req->input("sendungsnummer");
        $process_id = $req->input("process_id");

        $tracking                   = new user_tracking();
        $tracking->process_id       = $process_id;
        $tracking->trackingnumber   = $id;
        $tracking->save();

        $tracking->date = $tracking->created_at->format("d.m.Y (H:i)");

        event(new ListenersSaveNewTrackingId($id));

        $auftrag = new auftrags_CONTROLLER();
        $auftrag->newTelefonStatus($process_id, 8212, "Sendungsnummer: $id"); 

        return $tracking;
    }

    public function deleteTrackingHistory(Request $req, $id) {
        $trackings = tracking::where("trackingnumber", $id)->get();
        foreach($trackings as $t) {
            $t->delete();
        }

        $trackings = user_tracking::where("trackingnumber", $id)->get();
        foreach($trackings as $t) {
            $t->delete();
        }

        return redirect()->back();
    }

    public function newStatuscodesSelect(Request $req) {

        if($req->input("id") == null) {
            $status = new statuscodes_select();
            $status->bezeichnung = $req->input("bezeichnung");
            $status->save();
        } else {
            $status = statuscodes_select::where("id", $req->input("id"))->first();
            $status->bezeichnung = $req->input("bezeichnung");
            $status->save();
        }

        return redirect("crm/statuscodes-bearbeiten");
    }

    public function deleteStatuscodeSelect(Request $req, $id) {

        $status = statuscodes_select::where("id", $id)->first();
        $status->delete();

        return redirect()->back();
    }

    public function getÜberwachungsSystem(Request $req) {

        $überwachungen = überwachung::all();
        $employees = User::all();

        return view("forEmployees.administration.überwachungssystem")->with("überwachungen", $überwachungen)->with("employees", $employees);
    }

    public function editStatuscodeSelect(Request $req, $id)  {

        $carrier = carrier::with("versandStatuscode")->get();
        $selectCodes   = statuscodes_select::all();
        $editCodeSelect = statuscodes_select::where("id", $id)->first();

        return view("forEmployees.administration.statuscodes")->with("carrier", $carrier)->with("newCodeSelect", "true")->with("")->with("selectCodes", $selectCodes)->with("editCodeSelect", $editCodeSelect);
    }

    public function toggleKundenSperre(Request $req, $id) {

        $orders = active_orders_person_data::where("kunden_id", $id)->get();

        foreach($orders as $order) {
            if($order->sperre == "true") {
                $order->sperre = "false";
            } else {
                $order->sperre = "true";
            }
            $order->save();
        }

    }

    public function emailZuweisungDelete(Request $req, $id) {
    
        $email = emailinbox::where("id", $id)->first();
        $email->assigned = null;
        $email->save();

        $email = emails_history::where("id", $email->id)->first();
        $email->delete();



        $history = phone_history::where("lead_name", $email->subject)->first();
        if($history != null) {
            $history->delete();
        }

        return "ok";

    }

    public function neuerWorkflowPunkt(Request $req) {

        $workflow = new workflow();
        $workflow->aktion = $req->input("aktion");
        $workflow->employee = auth()->user()->id;
        $workflow->team_id = $req->input("id");
        $workflow->addon = $req->input(str_replace(" ", "_", $req->input("aktion")));
        $workflow->save();

        $workflows = workflow::where("team_id", $req->input("id"))->where("main", null)->get();

        $statuses = statuse::all();
        $emails = email_template::all();

        return view("workflow.ablauf")->with("workflows", $workflows)->with("statuses", $statuses)->with("emails", $emails);
    }

    public function neuerWorkflow(Request $req) {
        $name       = $req->input("name");
        $workflow   = $req->input("workflow");
        $time       = $req->input("time");
        $id         = $req->input("id");

        if($workflow == "new") {
            $flow = new workflow();
            $flow->team_id = $id;
        } else {
            $flow = workflow::where("id", $workflow)->first();
        }
        $flow->name = $name;
        $flow->bearbeitungszeit = $time;
        $flow->employee = auth()->user()->id;
        $flow->main = true;
        $flow->save();

        return $this->getWorkflow($req, $flow->id);
    }
    public function editWorkflowPoint(Request $req, $id) {
        $aktion = $req->input("aktion");

        $workflow = workflow::where("id", $id)->first();
        $workflow->aktion = $aktion;
        $workflow->save();

        return $this->getWorkflow($req, $id);
    }

    public function getWorkflow(Request $req, $id) {

        $workflow = workflow::where("id", $id)->first();

        $workflows = workflow::where("team_id", $workflow->team_id)->where("main", null)->get();

        $statuses = statuse::all();
        $emails = email_template::all();
        return view("workflow.ablauf")->with("workflows", $workflows)->with("statuses", $statuses)->with("emails", $emails);
    }

    public function deleteWorkflowPoint(Request $req, $id) {
        $workflow = workflow::where("id", $id)->first();
        $teamid = $workflow->team_id;
        $workflow->delete();

        $workflows = workflow::where("team_id", $teamid)->where("main", null)->get();

        $statuses = statuse::all();
        $emails = email_template::all();
        return view("workflow.ablauf")->with("workflows", $workflows)->with("statuses", $statuses)->with("emails", $emails);
    }

    public function getWorkflowInfos(Request $req, $id) {
        $workflow = workflow::where("id", $id)->first();
        if($workflow == null) {
            $workflow = workflow::where("name", $id)->first();
        }
        return $workflow;
    }

    public function deleteWorkflow(Request $req, $id) {
        $flow = workflow::where("id", $id)->first();
        $flow->delete();

        return "ok";
    }

    public function getWorkflowAuftrag(Request $req, $id) {
        $order = active_orders_person_data::where("process_id", $id)->first();
        if($order == null) {
            $order = new_leads_person_data::where("process_id", $id)->first();
        }
        $flowNames = workflow::where("main", true)->get();
        $statuses = statuse::all();
        $emails = email_template::all();
        $workflows = user_workflow::where("process_id", $id)->with("workflowAddon")->get();
        $tecs = contact::all();

        return view("workflow.workflow_auftrag")
                ->with("order", $order)
                ->with("flowNames", $flowNames)
                ->with("statuses", $statuses)
                ->with("emails", $emails)
                ->with("workflows", $workflows)
                ->with("tecs", $tecs);
    }

    public function changeWorkflowTechniker(Request $req, $id, $tec) {

        $workflow = user_workflow::where("process_id", $id)->first();

        $addon = workflow_addon::where("workflowid", $workflow->id)->first();
        if($addon != null) {
            $addon->used = $tec;
        } else {
            $addon = new workflow_addon();
            $addon->process_id = $workflow->process_id;
            $addon->used = $tec;
            $addon->workflowid = $workflow->id;
        }

        $addon->save();

        return "ok";

    }

    public function changeWorkflowDevice(Request $req, $id, $type) {

        $workflow = user_workflow::where("process_id", $id)->first();

        $addon = workflow_addon::where("workflowid", $workflow->id)->first();
        if($addon != null) {
            $addon->used = $type;
        } else {
            $addon = new workflow_addon();
            $addon->process_id = $workflow->process_id;
            $addon->used = $type;
            $addon->workflowid = $workflow->id;
        }

        $addon->save();

        return "ok";
    }

    public function getPicklistAusgang(Request $req) {
        $pdf = new Fpdi(); 
        $pdf->setSourceFile(public_path("/"). "pdf/picklist.pdf");

        $ausgänge = warenausgang::with("shelfe")->get()->sortBy('shelfe.shelfe_id');

        $seitenCount = 0;
        $seiten = 1;
        foreach($ausgänge as $ausgang) {
            if($seitenCount == 10) {
                $seiten++;
                $seitenCount = 0;
            } else {
                $seitenCount++;
            }
            
        }

        for ($i=1; $i <= $seiten; $i++) {
            $pdf->AddPage();
            $tplId = $pdf->importPage(1);
            $pdf->useTemplate($tplId);
            $pdf->SetFont('Helvetica');
            
            $yLayout = 65;

            $date = new DateTime();

            $pdf->Text(160, 10, $date->format("d.m.Y"));
    
            
            foreach($ausgänge as $ausgang) {
                $pdf->Text(4.5, $yLayout + 1, $ausgang->component_number);
                if($ausgang->shelfe != null) {
                    $pdf->Text(71, $yLayout + 1, $ausgang->shelfe->shelfe_id);
                }
    
                $test = new BarcodeGeneratorJPG();
                file_put_contents('picklist-barcode.JPG', $test->getBarcode($ausgang->component_number, $test::TYPE_CODE_128));
                $source = imagecreatefromjpeg('picklist-barcode.JPG');
                // Rotate
                //and save it on your server...
                imagejpeg($source, "picklist-barcode.JPG");
                $pdf->Image("picklist-barcode.JPG", 116, $yLayout - 4, 65, 7);
                
                $yLayout += 10;
            }
    
        }
        dd($pdf->Output());
        }


    public function searchEmailInbox(Request $req, $account, $inp) {
        if($inp == "allemails") {
            return emailinbox::where("account", $account)->get();
        } else {
            return emailinbox::where("account", $account)->where("subject", "LIKE", "%" . $inp . "%")->get();
        }
    }

    public function getActivityMonitor(Request $req) {

        $activitys = activity::latest()->limit(30)->get();
        $users  = user::all();

        $count = activity::count();
        return view("forEmployees.administration.activitys")->with("activitys", $activitys->sortByDesc("created_at"))->with("users", $users)->with("count",$count);
    }

    public function aktivitätenFiltern(Request $req) {

        if($req->input("filter") == null) {
            $activitys = activity::latest()->limit(30)->get();
        } else {
            $activitys = activity::where("user", $req->input("filter"))->latest()->limit(50)->get();
        }
        $users  = user::all();

        return view("forEmployees.administration.activitys")->with("activitys", $activitys->sortByDesc("created_at"))->with("users", $users)->with("filter", $req->input("filter"));
    }

    public function getAktivitätenSeite(Request $req, $id) {
        
        if($id == "1") {
            $activitys = activity::latest()->limit(30)->get();
            $users  = user::all();
    
            $count = activity::count();
            return view("includes.settings.activity_table")->with("activitys", $activitys->sortByDesc("created_at"))->with("users", $users)->with("count",$count);
        } else {
            $count = $id*30;

            $activitys = activity::latest()->offset($count-30)->limit($count)->get();
            $users  = user::all();

            $count = activity::count();
            return view("includes.settings.activity_table")->with("activitys", $activitys->sortByDesc("created_at"))->with("users", $users)->with("count",$count);
        }
    }

    public function deleteInventarProd(Request $req, $id) {
        $item = inventar::where("id", $id)->first();
        $item->delete();

        return redirect("crm/packtisch/tagesabschluss");

    }

    public function APIGetComponents(Request $req) {
        return attachment::all();
    }

    public function getSiegelView(Request $req) {

        $seals = seal::with("user")->get();
        $data = maindata::where("id", "1")->first();

        return view("forEmployees.administration.seals")->with("seals", $seals)->with("data", $data);
    }

    public function uploadSiegel(Request $req) {
        $file = $req->file("file");
        $fileid = uniqid();

        $file->storeAs("/temp", "$fileid.csv");
        
        $data = str_getcsv(file_get_contents(public_path() . "/temp/$fileid.csv"));
        foreach($data as $d) {
            $d = str_replace("\r", "", $d);
            $d = str_replace("\n", "", $d);
            
            $seal = new seal();
            $seal->code = $d;
            $seal->save();
        }

        return redirect()->back();
    }

    public function deleteSiegel(Request $req, $id) {
        $seal = seal::where("id", $id)->first();
        $seal->delete();

        return redirect()->back();
    }

    public function checkSiegel(Request $req, $id) {
        $seal = seal::where("code", $id)->where("used", null)->first();
        if($seal != null) {
            return "ok";
        } else {
            return "error";
        }
    }

    public function setSealSettings(Request $req, $days) {
        $data = maindata::where("id", "1")->first();
        $data->seal_days = $days;
        $data->save();

        return "ok";
    }
       

}
    


