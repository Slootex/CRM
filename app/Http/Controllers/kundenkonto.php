<?php

namespace App\Http\Controllers;

use App\Models\active_orders_person_data;
use App\Models\artikel;
use App\Models\einkauf;
use App\Models\kundenkonto as ModelsKundenkonto;
use App\Models\mahneinstellungen;
use App\Models\maindata;
use App\Models\rechnungen;
use App\Models\rechnungstext;
use App\Models\tracking_history;
use App\Models\user;
use App\Models\warenausgang_history;
use Illuminate\Http\Request;

class kundenkonto {
 
    
    public function neuesKonto($process_id, $kundenid, $guthabenbrutto, $guthabennetto) {

        $konto = new ModelsKundenkonto();
        $konto->process_id      = $process_id;
        $konto->kundenid        = $kundenid;
        $konto->guthabenbrutto  = $guthabenbrutto;
        $konto->guthabennetto   = $guthabennetto;
        $konto->save();
    }

    public function neueRechnung(Request $req, $id) {
        
        $menge          = $req->input("menge");
        $artikelnummer  = $req->input("artikelnummer");
        $bezeichnung    = $req->input("bezeichnung");
        $nettobetrag    = $req->input("nettobetrag");
        $rabatt         = $req->input("rabatt");
        $mwst           = $req->input("mwst");
        $bruttobetrag   = $req->input("bruttobetrag");
        $type           = $req->input("type");
        $vorläufigeID   = $req->input("vorläufige_id");
        $rabatt_type    = $req->input("rabatt_type");
        $epreis         = $req->input("epreis");


        $auftrag        = active_orders_person_data::where("process_id", $id)->first();
        $kundenkonto    = ModelsKundenkonto::where("kundenid", $auftrag->kunden_id)->first();

        $rechnung = new rechnung();
        $savedRechnung = $rechnung->neueRechnung($kundenkonto->id, $auftrag->process_id, $auftrag->kunden_id, $epreis, $menge, $artikelnummer, $bezeichnung, $rabatt, $nettobetrag, $bruttobetrag, $mwst, $type, auth()->user()->id, $vorläufigeID, $rabatt_type);

        $per = floatval(str_replace(",", ".", $nettobetrag))/100;
        $mwstbet = $per*$mwst;
        $savedRechnung->mwstbet = $mwstbet;

        return $savedRechnung;
    }

    public function rechnungZusammenfassen(Request $req, $id) {

        $zahlungsziel = $req->input("zahlungsziel");
        if($zahlungsziel == "None") {
            $zahlungsziel = null;
        }

        
        if(str_contains($id, "F") || str_contains($id, "A") || str_contains($id, "G")) {
            $rechnungen = rechnungen::where("rechnungsnummer", $id)->get();

            $rechnungsbetrag = 0;
            foreach($rechnungen as $r) {
                $r->type = $req->input("type");
                $r->zahlungsziel = $zahlungsziel;
                $r->rechnungstext = $req->input("rechnungstext");
                $r->save();
                $rechnungsbetrag += $r->bruttobetrag;
            }
            $rechnung = rechnungen::where("rechnungsnummer", $id)->first();
            $rechnungsnummer = $id;
            $rechnung->zahlungsdatum = $rechnung->created_at->format("d.m.Y (H:i)");
            $rechnung->rechnungsbetrag = $rechnungsbetrag;

            $versandart = rechnungen::where("rechnungsnummer", $rechnungsnummer)->where("bezeichnung", "Standart")->latest()->first();
            if($versandart == null) {
                $versandart = rechnungen::where("rechnungsnummer", $rechnungsnummer)->where("bezeichnung", "Express")->latest()->first();
            }
            if($versandart != null) {
                $rechnung->versandart = $versandart->bezeichnung;
            } else {
                $rechnung->versandart = null;
            }
    
            $zahlart = rechnungen::where("rechnungsnummer", $rechnungsnummer)->where("bezeichnung", "Überweisung")->latest()->first();
            if($zahlart == null) {
                $zahlart = rechnungen::where("rechnungsnummer", $rechnungsnummer)->where("bezeichnung", "Bar")->latest()->first();
            }
            if($zahlart == null) {
                $zahlart = rechnungen::where("rechnungsnummer", $rechnungsnummer)->where("bezeichnung", "Nachnahme")->latest()->first();
            }
            if($zahlart != null) {
                $rechnung->zahlart = $zahlart->bezeichnung;
            } else {
                $rechnung->zahlart = null;
            }
    
            $employee = User::where("id", $rechnung->mitarbeiter)->first();
            $rechnung->edited = true;
            $rechnung->mitarbeiter = $employee->name;
    

        } else {
            $rechnung = new rechnung();
            $rechnungen = rechnungen::where("rechnungsnummer", $id)->get();
            $rechnungsnummer = $rechnung->neueRechnungsnummer();
            if($req->input("type") == "Angebot") {
                $rechnungsnummer = str_replace("F", "A", $rechnungsnummer);
            }
            if($req->input("type") == "Gutschrift") {
                $rechnungsnummer = str_replace("F", "G", $rechnungsnummer);
            }
            $rechnungsbetrag = 0;
            foreach($rechnungen as $r) {
                $r->rechnungsnummer = $rechnungsnummer;
                $r->type = $req->input("type");
                $r->zahlungsziel = $zahlungsziel;
                $r->rechnungstext = $req->input("rechnungstext");
                $r->save();
                $rechnungsbetrag += $r->bruttobetrag;
        }

        $rechnung = rechnungen::where("rechnungsnummer", $rechnungsnummer)->latest()->first();
        $rechnung->rechnungsbetrag = $rechnungsbetrag;
        $rechnung->zahlungsdatum = $rechnung->created_at->format("d.m.Y (H:i)");


        $versandart = rechnungen::where("rechnungsnummer", $rechnungsnummer)->where("bezeichnung", "Standart")->latest()->first();
        if($versandart == null) {
            $versandart = rechnungen::where("rechnungsnummer", $rechnungsnummer)->where("bezeichnung", "Express")->latest()->first();
        }
        if($versandart != null) {
            $rechnung->versandart = $versandart->bezeichnung;
        } else {
            $rechnung->versandart = null;
        }

        $zahlart = rechnungen::where("rechnungsnummer", $rechnungsnummer)->where("bezeichnung", "Überweisung")->latest()->first();
        if($zahlart == null) {
            $zahlart = rechnungen::where("rechnungsnummer", $rechnungsnummer)->where("bezeichnung", "Bar")->latest()->first();
        }
        if($zahlart == null) {
            $zahlart = rechnungen::where("rechnungsnummer", $rechnungsnummer)->where("bezeichnung", "Nachnahme")->latest()->first();
        }
        if($zahlart != null) {
            $rechnung->zahlart = $zahlart->bezeichnung;
        } else {
            $rechnung->zahlart = null;
        }

        $employee = User::where("id", $rechnung->mitarbeiter)->first();
        $rechnung->mitarbeiter = $employee->name;

        $rechnung->edited = false;
        }
        
        $kundenkonto = ModelsKundenkonto::where("process_id", $rechnung->process_id)->with("rechnungen")->first();
        $mahneinstellungen = mahneinstellungen::all();
        $employees = User::all();
        $rechnungstexte = rechnungstext::all();

               

        return view("includes.orders.buchhaltung-table")
                ->with("kundenkonto", $kundenkonto)
                ->with("mahneinstellungen", $mahneinstellungen)
                ->with("employees", $employees)
                ->with("rechnungstexte", $rechnungstexte);
    }

    public function copyRechnung(Request $request, $id) {
        $rechnungen = rechnungen::where("rechnungsnummer", $id)->get();

        $rModel = new rechnung();
        $rechnungsnummer = $rModel->neueRechnungsnummer();

        foreach($rechnungen as $rechnung) {
            $copy = new rechnungen();
            $copy->rechnungsnummer = $rechnungsnummer;
            foreach($rechnung->getAttributes() as $key => $item) {
                if($key != "id" && $key != "created_at" && $key != "updated_at" && $key != "rechnungsnummer") {
                    $copy->$key = $item;
                }
            }
            $copy->save();
        } 

        $kundenkonto =  \App\Models\kundenkonto::where("process_id", $rechnungen[0]->process_id)->with("rechnungen")->first();
        $rechnungstexte = rechnungstext::all();
        $mahneinstellungen = mahneinstellungen::all();
        $artikel = artikel::all();
        $employees = user::all();
        $einkäufe = einkauf::where("process_id", $id)->get();


        return view("includes.orders.buchhaltung-table")
                ->with("kundenkonto", $kundenkonto)
                ->with("rechnungstexte", $rechnungstexte)
                ->with("mahneinstellungen", $mahneinstellungen)
                ->with("artikel", $artikel)
                ->with("employees", $employees)
                ->with("mwst", "19")
                ->with("einkäufe", $einkäufe);
    }


}