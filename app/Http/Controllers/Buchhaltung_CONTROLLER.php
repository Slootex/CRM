<?php

namespace App\Http\Controllers;

use App\Mail\inboxanswer;
use App\Mail\rechnung;
use App\Models\active_orders_person_data;
use App\Models\artikel;
use App\Models\audiofiles;
use App\Models\countrie;
use App\Models\email_template;
use App\Models\emailinbox;
use App\Models\kundenkonto;
use App\Models\rechnungen;
use App\Models\rechnungstext;
use App\Models\User;
use App\Models\vergleichstext;
use App\Http\Controllers\rechnung as rechnungController;
use App\Models\zahlungen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Buchhaltung_CONTROLLER extends Controller
{
    public function neueRechnungsposition(Request $req, $id) {

        $order = active_orders_person_data::where("process_id", $id)->first();

        $rechnung = new rechnungen();
        $rechnung->process_id       = $order->process_id;
        $rechnung->kundenid         = $order->kunden_id;
        $rechnung->rechnungsnummer  = $req->input("temp_id");
        $rechnung->menge            = $req->input("menge");
        $rechnung->artnr            = $req->input("artnr");
        $rechnung->epreis           = $req->input("epreis");
        $rechnung->bezeichnung      = $req->input("bezeichnung");
        $rechnung->nettobetrag      = $req->input("nettobetrag");
        $rechnung->bruttobetrag     = $req->input("bruttobetrag");
        $rechnung->type             = $req->input("type");
        $rechnung->mitarbeiter      = auth()->user()->id;
        $rechnung->save();

        $rechnungen = rechnungen::where("rechnungsnummer", $req->input("temp_id"))->get();

        if($req->input("mwsttype") == "false") {
            foreach($rechnungen as $rechnung) {
                if($rechnung->bezeichnung != "Rabatt") {
                    $rechnung->mwst = "no";
                    $rechnung->save();
                    $rechnung->bruttobetrag = $rechnung->nettobetrag;
                }
            }

            return view("includes.rechnungen.neue-rechnung-positions-table")->with("rechnungen", $rechnungen);
        } else {

            foreach($rechnungen as $rechnung) {
                if($rechnung->bezeichnung != "Rabatt") {
                    $rechnung->mwst = "ok";
                    $rechnung->save();
                }
            }

            return view("includes.rechnungen.neue-rechnung-positions-table")->with("rechnungen", $rechnungen);
        }

    }

    public function getRechnungenMwStOff(Request $req, $id) {
        $rechnungen = rechnungen::where("rechnungsnummer", $id)->get();

        foreach($rechnungen as $rechnung) {
            if($rechnung->bezeichnung != "Rabatt") {
                $rechnung->mwst = "no";
                $rechnung->save();
                $rechnung->bruttobetrag = $rechnung->nettobetrag;
            }
        }

        return view("includes.rechnungen.neue-rechnung-positions-table")->with("rechnungen", $rechnungen);
    }

    public function getRechnungenMwStOn(Request $req, $id) {
        $rechnungen = rechnungen::where("rechnungsnummer", $id)->get();

        foreach($rechnungen as $rechnung) {
            if($rechnung->bezeichnung != "Rabatt") {
                $rechnung->mwst = "ok";
                $rechnung->save();
            }
        }

        return view("includes.rechnungen.neue-rechnung-positions-table")->with("rechnungen", $rechnungen);
    }

    public function deletePosition(Request $req, $id, $type) {
        $position = rechnungen::where("id", $id)->first();
        $rechnungsnummer = $position->rechnungsnummer;
        $position->delete();

        $rechnungen = rechnungen::where("rechnungsnummer", $rechnungsnummer)->get();

        if($type == "false") {
            foreach($rechnungen as $rechnung) {
                if($rechnung->bezeichnung != "Rabatt") {
                    $rechnung->mwst = "no";
                    $rechnung->save();
                    $rechnung->bruttobetrag = $rechnung->nettobetrag;
                }
            }

            return view("includes.rechnungen.neue-rechnung-positions-table")->with("rechnungen", $rechnungen);
        } else {

            foreach($rechnungen as $rechnung) {
                if($rechnung->bezeichnung != "Rabatt") {
                    $rechnung->mwst = "ok";
                    $rechnung->save();
                }
            }

            return view("includes.rechnungen.neue-rechnung-positions-table")->with("rechnungen", $rechnungen);
        }
    }

    public function neueRechnung(Request $req) {
        
        $rechnungen = rechnungen::where("rechnungsnummer", $req->input("rechnungsnummer"))->get();
        $process_id = $rechnungen[0]->process_id;

        $type = $req->input("type");

        if($type == "Rechnung") {
            $type = "F";
        }
        if($type == "Gutschrift") {
            $type = "G";
        }
        if($type == "Angebot") {
            $type = "A";
        }

        $rechnungstext = rechnungstext::where("title", $req->input("rechnungstext"))->first();

        foreach($rechnungen as $rechnung) {
            $rechnung->rechnungsnummer = $type . $rechnung->rechnungsnummer;
            $rechnung->rechnungstext = $rechnungstext->id;
            $rechnung->zahlungsziel = $req->input("zahlungsziel");
            if($rechnung->mwst == "no") {
                $rechnung->bruttobetrag = $rechnung->nettobetrag;
            } 
            $rechnung->save();
        }

        $kundenkonto = kundenkonto::where("process_id", $process_id)->with("rechnungen")->first();
        $employees = user::all();
        $rechnungstexte = rechnungstext::all();

        return view("includes.orders.buchhaltung-table")->with("kundenkonto", $kundenkonto)->with("employees", $employees)->with("rechnungstexte", $rechnungstexte);
    }

    public function editRechnung(Request $req) {

        $rechnungen = rechnungen::where("rechnungsnummer", $req->input("rechnungsnummer"))->get();
        $process_id = $rechnungen[0]->process_id;

        $type = $req->input("type");

        if($type == "Rechnung") {
            $type = "F";
        }
        if($type == "Gutschrift") {
            $type = "G";
        }
        if($type == "Angebot") {
            $type = "A";
        }

        $rechnungstext = rechnungstext::where("title", $req->input("rechnungstext"))->first();

        foreach($rechnungen as $rechnung) {
            $rechnung->rechnungsnummer = str_replace(substr($rechnung->rechnungsnummer, 0, 1), $type, $rechnung->rechnungsnummer);
            $rechnung->rechnungstext = $rechnungstext->id;
            $rechnung->zahlungsziel = $req->input("zahlungsziel");
            if($rechnung->mwst == "no") {
                $rechnung->bruttobetrag = $rechnung->nettobetrag;
            } 
            $rechnung->save();
        }

        $kundenkonto = kundenkonto::where("process_id", $process_id)->with("rechnungen")->first();
        $employees = user::all();
        $rechnungstexte = rechnungstext::all();

        return view("includes.orders.buchhaltung-table")->with("kundenkonto", $kundenkonto)->with("employees", $employees)->with("rechnungstexte", $rechnungstexte);
    }

    public function deleteRechnung(Request $req, $id) {
        $rechnungen = rechnungen::where("rechnungsnummer", $id)->get();
        $process_id = $rechnungen[0]->process_id;

        foreach($rechnungen as $rechnung) {
            $rechnung->delete();
        }

        $kundenkonto = kundenkonto::where("process_id", $process_id)->with("rechnungen")->first();
        $employees = user::all();
        $rechnungstexte = rechnungstext::all();

        return view("includes.orders.buchhaltung-table")->with("kundenkonto", $kundenkonto)->with("employees", $employees)->with("rechnungstexte", $rechnungstexte);
    }

    public function getNeueAudiofile(Request $req, $id) {
        $rechnung = rechnungen::where("rechnungsnummer", $id)->first();
        $order = active_orders_person_data::where("process_id", $rechnung->process_id)->first();
        $countries = countrie::all();
        $audio = audiofiles::where("rechnungsnummer", $id)->first();

        return view("includes.rechnungen.neue-audio")->with("order", $order)->with("countries", $countries)->with("rechnung", $rechnung)->with("audio", $audio);
    }

    public function newAudioFile(Request $req) {

        $id             = $req->input("rechnungsnummer");
        $tophone        = $req->input("tophone");
        $acceptone      = $req->input("acceptone");
        $talkaccept     = $req->input("talkaccept");
        $talkname       = $req->input("talkname");
        $shipafterpay   = $req->input("shipafterpay");
        $priceok        = $req->input("priceok");
        $takebacktalk   = $req->input("takebacktalk");
        $birthday       = $req->input("birthday");
        $status         = $req->input("status");
        $audiofile      = $req->file("audiofile");
        $firstname      = $req->input("firstname");
        $lastname       = $req->input("lastname");
        $street         = $req->input("street");
        $streetno       = $req->input("streetno");
        $zipcode        = $req->input("zipcode");
        $city           = $req->input("city");
        $country        = $req->input("country");
        $worktime       = $req->input("worktime");
        $worktype       = $req->input("worktype");
        $accepttwo      = $req->input("accepttwo");

        $audio = audiofiles::where("rechnungsnummer", $id)->first();
        if($audio == null) {
            $audio                  = new audiofiles();
            $audio->rechnungsnummer = $id;
            $audio->tophone         = $tophone;
            $audio->acceptone       = $acceptone;
            $audio->speakaccept     = $talkaccept;
            $audio->talkname        = $talkname;
            $audio->shipafterpay    = $shipafterpay;
            $audio->priceok         = $priceok;
            $audio->takebacktalk    = $takebacktalk;
            $audio->birthday        = $birthday;
            $audio->status          = $status;
            $audio->firstname       = $firstname;
            $audio->lastname        = $lastname;
            $audio->street          = $street;
            $audio->streetno        = $streetno;
            $audio->zipcode         = $zipcode;
            $audio->city            = $city;
            $audio->country         = $country;
            $audio->worktype        = $worktype;
            $audio->worktime        = $worktime;
            $audio->accepttwo       = $accepttwo;
            $audio->file            = "yes";
            $audio->save();

        } else {
            $audio->rechnungsnummer = $id;
            $audio->tophone         = $tophone;
            $audio->acceptone       = $acceptone;
            $audio->speakaccept     = $talkaccept;
            $audio->talkname        = $talkname;
            $audio->shipafterpay    = $shipafterpay;
            $audio->priceok         = $priceok;
            $audio->takebacktalk    = $takebacktalk;
            $audio->birthday        = $birthday;
            $audio->status          = $status;
            $audio->firstname       = $firstname;
            $audio->lastname        = $lastname;
            $audio->worktype        = $worktype;
            $audio->worktime        = $worktime;
            $audio->street          = $street;
            $audio->streetno        = $streetno;
            $audio->zipcode         = $zipcode;
            $audio->city            = $city;
            $audio->country         = $country;
            $audio->accepttwo       = $accepttwo;
            $audio->file            = "yes";
            $audio->update();
        }

        if($audiofile != null) {
            $audiofile->move(public_path() . "/audiofiles/", $id . ".mp3");            
        }
    }

    public function getRechnungModal(Request $req, $id) {
        $rechnungen = rechnungen::where("rechnungsnummer", $id)->get();
        $order = active_orders_person_data::where("process_id", $rechnungen[0]->process_id)->first();
        $countries = countrie::all();
        $kundenkonto = kundenkonto::where("process_id", $order->process_id)->with("rechnungen")->first();
        $rechnungstexte = rechnungstext::all();
        $artikel = artikel::all();

        return view("includes.rechnungen.edit-rechnung")
                    ->with("order", $order)
                    ->with("countries", $countries)
                    ->with("rechnungen", $rechnungen)
                    ->with("rechnungstexte", $rechnungstexte)
                    ->with("kundenkonto", $kundenkonto)
                    ->with("artikel", $artikel);
    }

    public function getEmailModal(Request $req, $id) {

        $rechnung = rechnungen::where("rechnungsnummer", $id)->first();
        $order = active_orders_person_data::where("process_id", $rechnung->process_id)->first();
        $email = email_template::where("id", "79")->first();

        return view("includes.rechnungen.email")
                    ->with("rechnung", $rechnung)
                    ->with("order", $order)
                    ->with("email", $email);
    }

    public function sendRechnungEmail(Request $req) {

        $id         = $req->input("id");
        $subject    = $req->input("subject");
        $text       = $req->input("text");
        $bcc        = $req->input("bcc");
        $cc         = $req->input("cc");
        $rechnungModel   = rechnungen::where("rechnungsnummer", $req->input("rechnungsnummer"))->first();
       
        $rechnung = new rechnungController();
        //$rechnung->getPdfRechnung($req, $rechnungModel->rechnungsnummer);

        try {
            if($cc != "") {
                $cc = explode(" ", $cc);
            }
            if($bcc != "") {
                $bcc = explode(" ", $bcc);
            }

            Mail::to($cc[0])
                ->send(new rechnung($text, $subject, $rechnungModel->rechnungsnummer));
            


        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function getZahlungenModal(Request $req, $id) {
        $rechnungen = rechnungen::where("rechnungsnummer", $id)->with("zahlungen")->get();
        $order = active_orders_person_data::where("process_id", $rechnungen[0]->process_id)->first();
        $countries = countrie::all();
        $rechnungstexte = rechnungstext::all();
        $artikel = artikel::all();

        return view("includes.rechnungen.zahlungen")
                    ->with("order", $order)
                    ->with("countries", $countries)
                    ->with("rechnungen", $rechnungen)
                    ->with("rechnungstexte", $rechnungstexte)
                    ->with("artikel", $artikel);
    }

    public function getAllRechnungen(Request $req, $id) {
        $kundenkonto = kundenkonto::where("process_id", $id)->with("rechnungen.zahlungen")->first();
        $employees = user::all();
        $rechnungstexte = rechnungstext::all();


        return view("includes.orders.buchhaltung-table")
                    ->with("kundenkonto", $kundenkonto)
                    ->with("employees", $employees)
                    ->with("rechnungstexte", $rechnungstexte);
    }

    public function deleteZahlung(Request $req, $id) {
        $zahlung = zahlungen::where("id", $id)->first();
        $rechnungsnummer = $zahlung->rechnungsnummer;
        $zahlung->delete();

        $rechnungen = rechnungen::where("rechnungsnummer", $rechnungsnummer)->with("zahlungen")->get();

        return view("includes.rechnungen.zahlungen")->with("rechnungen", $rechnungen);
    }
}
