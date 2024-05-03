<?php

namespace App\Http\Controllers;

use App\Mail\inboxanswer;
use App\Mail\mahnung;
use App\Models\active_orders_person_data;
use App\Models\archive_orders_person;
use App\Models\artikel;
use App\Models\audiofiles;
use App\Models\countrie;
use App\Models\kundenkonto;
use App\Models\mahneinstellungen;
use App\Models\mahnungen;
use App\Models\mahnungstext;
use App\Models\maindata;
use App\Models\rechnungen;
use App\Models\rechnungstext;
use App\Models\tracking_history;
use App\Models\User;
use App\Models\vergleichstext;
use App\Models\warenausgang_history;
use App\Models\zahlungen;
use App\Models\überwachung;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Picqer\Barcode\BarcodeGeneratorJPG;
use Picqer\Barcode\BarcodeGeneratorPNG;
use setasign\Fpdi\Fpdi;
use Soundasleep\Html2Text;

class rechnung {
 
    
    public function neueRechnung($kontonummer, $process_id, $kundenid, $epreis, $menge, $artnr, $bezeichnung, $rabatt, $netto, $brutto, $mwst, $type, $mitarbeiter, $vorläufigeID, $rabatt_type) {

        $rechnung = new rechnungen();
        $rechnung->kontonummer      = $kontonummer;
        $rechnung->process_id       = $process_id;
        $rechnung->kundenid         = $kundenid;
        $rechnung->rechnungsnummer  = $vorläufigeID;
        $rechnung->pos              = "1";
        $rechnung->menge            = $menge;
        $rechnung->artnr            = $artnr;
        $rechnung->epreis           = $epreis;
        $rechnung->bezeichnung      = $bezeichnung;
        if($rabatt_type == "prozent") {
            $rechnung->rabatt           = $rabatt . "%";
        }
        if($rabatt_type == "euro") {
            $rechnung->rabatt           = $rabatt . "€";
        }
        $rechnung->nettobetrag      = $netto;
        $rechnung->bruttobetrag     = $brutto;
        $rechnung->mwst             = $mwst;
        $rechnung->type             = "";
        $rechnung->mitarbeiter      = $mitarbeiter;
        $rechnung->save();

        return $rechnung;
    }

    public function neueRechnungsnummer() {

        $rechnung = rechnungen::where("rechnungstext", "!=", null)->latest()->first();

        if($rechnung != null) {
            $rechnungsnummer = str_replace("F", "", $rechnung->rechnungsnummer);
            $rechnungsnummer = str_replace("A", "", $rechnungsnummer);
            $rechnungsnummer = str_replace("G", "", $rechnungsnummer);
            $rechnungsnummer++;

            return "F" . $rechnungsnummer;
        } else {
            $rechnungsnummer = "F387254";
            return $rechnungsnummer;
        }
    }

    public function neuerArtikel(Request $req) {
        $nummer = $req->input("artnummer");
        $name = $req->input("artname");
        $netto = $req->input("netto");
        $mwst = $req->input("mwst");
        $brutto = $req->input("brutto");

        $artikel = new artikel();
        $artikel->artnr = $nummer;
        $artikel->artname = $name;
        $artikel->netto = $netto;
        $artikel->mwst = $mwst;
        $artikel->brutto = $brutto;
        $artikel->save();

        return $artikel;
    }

    public function bearbeitenArtikel(Request $req) {
        $nummer = $req->input("artnummer");
        $name = $req->input("artname");
        $netto = $req->input("netto");
        $mwst = $req->input("mwst");
        $brutto = $req->input("brutto");

        $artikel = artikel::where("artnr", $nummer)->first();
        $artikel->artnr = $nummer;
        $artikel->artname = $name;
        $artikel->netto = $netto;
        $artikel->mwst = $mwst;
        $artikel->brutto = $brutto;
        $artikel->save();

        return $artikel;
    }

    public function bearbeitenPos(Request $req) {

        $id             = $req->input("id");
        $menge          = $req->input("menge");
        $artnr          = $req->input("artnr");
        $bezeichnung    = $req->input("bezeichnung");
        $mwst           = $req->input("mwst");
        $nettobetrag    = $req->input("nettobetrag");
        $mwstbetrag     = $req->input("mwstbetrag");
        $rabatt         = $req->input("rabatt");
        $bruttobetrag   = $req->input("bruttobetrag");

        $pos = rechnungen::where("id", $id)->first();
        $pos->menge         = $menge;
        $pos->artnr         = $artnr;
        $pos->bezeichnung   = $bezeichnung;
        $pos->mwst          = str_replace("%", "", $mwst);
        $pos->nettobetrag   = str_replace("€", "", $nettobetrag);
        $pos->mwstbetrag    = str_replace("€", "", $mwstbetrag);
        $pos->rabatt        = str_replace("€", "", $rabatt);
        $pos->bruttobetrag  = str_replace("€", "", $bruttobetrag);
        $pos->save();

        return $pos;
    }

    public function bearbeitenRabattPos(Request $req) {
        $id             = $req->input("id");
        $menge          = $req->input("menge");
        $artnr          = $req->input("artnr");
        $bezeichnung    = $req->input("bezeichnung");
        $rabatt         = $req->input("rabatt");

        $pos = rechnungen::where("id", $id)->first();
        $old_rabatt = $pos->rabatt;
        $pos->menge         = $menge;
        $pos->artnr         = $artnr;
        $pos->bezeichnung   = $bezeichnung;
        $pos->rabatt        = str_replace(["€", "%"], "", $rabatt);
        $pos->bruttobetrag  = str_replace(["€", "%"], "", $rabatt);

        if(str_contains($bezeichnung, "Netto")) {
            $pos->rabatt_bn = "Netto";
        }
        if(str_contains($bezeichnung, "Brutto")) {
            $pos->rabatt_bn = "Brutto";
        }
        if(str_contains($rabatt, "%")) {
            $pos->rabatt_type = "prozent";
        }
        if(str_contains($rabatt, "€")) {
            $pos->rabatt_type = "euro";
        }
        $pos->save();
        $pos->old_rabatt = $old_rabatt;

        return $pos;
    }

    public function getPositions(Request $req, $id) {

        $positions = rechnungen::where("rechnungsnummer", $id)->get();

        return $positions;
    }

    public function neueZahlung(Request $req) {

        $date = new DateTime($req->input("zahlungsdatum"));
        $currentDate = new DateTime();
        if($date->format("m") < $currentDate->format("m") - 2) {
            if($req->input("dateCheck") == "yes") {
                    $rechnung = rechnungen::where("rechnungsnummer", $req->input("rechnungsnummer"))->first();
                    $konto = kundenkonto::where("kundenid", $rechnung->kundenid)->first();
                    $zahlung = new zahlungen();
                    $zahlung->process_id = $konto->process_id;
                    $zahlung->kundenid      = $rechnung->kundenid;
                    $zahlung->rechnungsnummer = $req->input("rechnungsnummer");
                    $zahlung->kontonummer = $rechnung->kontonummer;
                    $zahlung->transactionid = $req->input("transaktionsid");
                    $zahlung->zahlungsdatum = $req->input("zahlungsdatum");
                    $zahlung->zahlart = $req->input("zahlart");
                    $zahlung->betrag = $req->input("betrag");
                    $zahlung->bemerkung = $req->input("bemerkung");
                    $zahlung->save();

                    $überwachung = new überwachung();
                    $überwachung->employee = auth()->user()->id;
                    $überwachung->type = "Rechnung";
                    $überwachung->text = "Neue Zahlung würde weit in der vergangenheit gebucht";
                    $überwachung->save();



            } 
        } else {
            if($date->format("Y") == $currentDate->format("Y")) {
                $rechnung = rechnungen::where("rechnungsnummer", $req->input("rechnungsnummer"))->first();
                $konto = kundenkonto::where("kundenid", $rechnung->kundenid)->first();

                $zahlung = new zahlungen();
                $zahlung->process_id = $konto->process_id;
                $zahlung->kundenid      = $rechnung->kundenid;
                $zahlung->rechnungsnummer = $req->input("rechnungsnummer");
                $zahlung->kontonummer = $rechnung->kontonummer;
                $zahlung->transactionid = $req->input("transaktionsid");
                $zahlung->zahlungsdatum = $req->input("zahlungsdatum");
                $zahlung->zahlart = $req->input("zahlart");
                $zahlung->betrag = $req->input("betrag");
                $zahlung->bemerkung = $req->input("bemerkung");
                $zahlung->save();
    
                
            } else {
                
                if($req->input("dateCheck") == "yes") {
                    $rechnung = rechnungen::where("rechnungsnummer", $req->input("rechnungsnummer"))->first();
                    $konto = kundenkonto::where("kundenid", $rechnung->kundenid)->first();

                    $zahlung = new zahlungen();
                    $zahlung->process_id = $konto->process_id;
                    $zahlung->kundenid      = $rechnung->kundenid;
                    $zahlung->rechnungsnummer = $req->input("rechnungsnummer");
                    $zahlung->kontonummer = $rechnung->kontonummer;
                    $zahlung->transactionid = $req->input("transaktionsid");
                    $zahlung->zahlungsdatum = $req->input("zahlungsdatum");
                    $zahlung->zahlart = $req->input("zahlart");
                    $zahlung->betrag = $req->input("betrag");
                    $zahlung->bemerkung = $req->input("bemerkung");
                    $zahlung->save();
        
                  } 
        }
        }
        
        $rechnungen = rechnungen::where("rechnungsnummer", $req->input("rechnungsnummer"))->with("zahlungen")->get();
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

    public function zahlungBearbeiten(Request $req) {
        
        $id = $req->input("id");
        $datum = $req->input("zahlungsdatum");
        $betrag = $req->input("betrag");
        $zahlart = $req->input("zahlart");
        $bemerkung = $req->input("bemerkung");

        $zahlung = zahlungen::where("id", $id)->first();
        $zahlung->zahlungsdatum = $datum;
        $zahlung->betrag = $betrag;
        $zahlung->zahlart = $zahlart;
        $zahlung->bemerkung = $bemerkung;
        $zahlung->update();

        return $zahlung;
    }

    public function löschenRechnung(Request $req, $id) {

        $rechnungen = rechnungen::where("rechnungsnummer", $id)->get();
        foreach($rechnungen as $rechnung) {
            $rechnung->deleted = "deleted";
            $date = new DateTime();
            $rechnung->deleted_at = $date->format("d.m.Y"); 
            $rechnung->deleted_from = auth()->user()->name;
            $rechnung->update();
        }

        return redirect()->back();
    }

    public function mahnlaufStarten(Request $req, $id) {

        $mahneinstellung = mahneinstellungen::where("mahnstufe", "1")->first();
        $mahneinstellungnext = mahneinstellungen::where("mahnstufe", "2")->first();


        $mahnung = new mahnungen();

        $mahnung->rechnungsnummer = $id;
        $mahnung->mahnstufe = "1";
        $mahnung->employee = auth()->user()->id;
        $mahnung->save();

        $mahnung->date = $mahnung->created_at->format("d.m.Y");
        $mahneinstellung->nextlevel = $mahneinstellungnext->bezeichnung;
        $mahneinstellung->nextleveldate = $mahnung->created_at->modify("+" . $mahneinstellung->zahlungsfrist . " days")->format("d.m.Y");


        return [$mahnung, $mahneinstellung];
    }

    public function nextMahnLevel(Request $req, $id) {

        $oldMahnung = mahnungen::where("rechnungsnummer", $id)->latest()->first();

        if($oldMahnung->mahnstufe != "6") {
            $mahnung = new mahnungen();
            $mahnung->rechnungsnummer = $id;
            $mahnung->mahnstufe = $oldMahnung->mahnstufe + 1;
            $mahnung->save();

            $mahneinstellung = mahneinstellungen::where("mahnstufe", $mahnung->mahnstufe)->first();
            $mahneinstellungnext = mahneinstellungen::where("mahnstufe", $mahnung->mahnstufe + 1)->first();


            $mahnung->date = $mahnung->created_at->format("d.m.Y");
            $mahneinstellung->nextlevel = $mahneinstellungnext->bezeichnung;
            $mahneinstellung->nextleveldate = $mahnung->created_at->modify("+" . $mahneinstellung->zahlungsfrist . " days")->format("d.m.Y");

            return [$mahnung, $mahneinstellung];
        } else {
            return "error-max-level";
        }
    }

    public function startMahnsperre(Request $req, $id) {
        
        $oldMahnung = mahnungen::where("rechnungsnummer", $id)->latest()->first();

        $mahnung = new mahnungen();
        $mahnung->process_id = "sperre";
        $mahnung->rechnungsnummer = $id;
        $mahnung->mahnstufe = $oldMahnung->mahnstufe;
        $mahnung->employee = auth()->user()->id;
        $mahnung->save();

        $mahnung->datum = $mahnung->created_at->format("d.m.Y");
        $mahnung->mitarbeiter = auth()->user()->name;

        return $mahnung;
    }

    public function stopMahnsperre(Request $req, $id) {

        

        $mahnung = mahnungen::where("rechnungsnummer", $id)->where("process_id", "sperre")->first();
        $mahnung->delete();

        $mahnung = mahnungen::where("rechnungsnummer", $id)->latest()->first();
        $mahneinstellung = mahneinstellungen::where("mahnstufe", $mahnung->mahnstufe)->first();
        $mahneinstellungnext = mahneinstellungen::where("mahnstufe", $mahnung->mahnstufe + 1)->first();

        $mahnung->date = $mahnung->created_at->format("d.m.Y");
        $mahneinstellung->nextlevel = $mahneinstellungnext->bezeichnung;
        $mahneinstellung->nextleveldate = $mahnung->created_at->modify("+" . $mahneinstellung->zahlungsfrist . " days")->format("d.m.Y");

        return [$mahnung, $mahneinstellung];
    }

    public function getPdfAngebot($id) {
        $rechnung = rechnungen::where("rechnungsnummer", $id)->get();
        $mwst = 0;
        foreach($rechnung as $r) {
            if($r->mwst != "0") {
                $mwst = $r->mwst;
            }
        }

        $rechnungc = 1;
        $seiten = 1;
        $seitenow = 1;
        foreach($rechnung as $r) {
            if($rechnungc == 10) {
                $seiten++;
                $rechnungc = 1;
            } else {
                $rechnungc++;
            }
            
        }
        $pdf = new Fpdi(); 
        

        if($mwst == 0) {
            $pdf->setSourceFile(public_path("/"). "pdf/angebot_pdf.pdf");

         } else {
            $pdf->setSourceFile(public_path("/"). "pdf/angebot_mwst.pdf");

         }
        $currentsite = 0;
        for ($i=1; $i <= $seiten; $i++) {

            
            $pdf->AddPage();
            $tplId = $pdf->importPage(1);
            $pdf->useTemplate($tplId); 

            if($mwst == 0) {
                $order    = active_orders_person_data::where("process_id", $rechnung[0]->process_id)->first();
    
        
                $pdf->SetFont("Arial", "B");
                $pdf->setFontSize(7.5);
        
                //      Rechnungsnummer
                $pdf->SetXY(147.5, 59.8);
                $pdf->Cell(40, 3, $id, 0, 0, 'C');
    
                //      Rechnungsdatum
                $pdf->SetXY(148, 64.3);
                $pdf->Cell(39, 3, $rechnung[0]->created_at->format("d.m.Y"), 0, 0, "C");
        
                //      Auftragsnummer
                $pdf->SetXY(108.8, 73.8);
                $pdf->Cell(35, 3, $order->process_id, 0, 0, "C");
        
                //      Bestelldatum
                $pdf->SetXY(148, 73.8);
                $pdf->Cell(20, 3, $order->created_at->format("d.m.Y"), 0, 0, "C");
        
                //      Seite
                $pdf->SetXY(148, 82.5);
                $pdf->Cell(40, 3, $seitenow . " von " . $seiten, 0, 0, "C");
        
                //      Zahlungsart
                $zahlart = $rechnung->where("bezeichnung", "Nachnahme")->first();
                if($zahlart == null) {
                    $zahlart = $rechnung->where("bezeichnung", "Überweisung")->first();
                }
                if($zahlart == null) {
                    $zahlart = $rechnung->where("bezeichnung", "Bar")->first();
                }
        
                if($zahlart != null) {
                    $pdf->setXY(130, 87.3);
                    $pdf->Cell(60, 3, iconv("utf-8","Windows-1252", $zahlart->bezeichnung), 0, 0, "C");
                }
        
        
                $versandart = $rechnung->where("bezeichnung", "Standard")->first();
                if($versandart == null) {
                    $versandart = $rechnung->where("bezeichnung", "Express")->first();
                }
                if($versandart != null) {
                    //      Versandart
                    $pdf->setXY(130, 92);
                    $pdf->Cell(60, 3, $versandart->bezeichnung, 0, 0, "C");
                }
    
    
                //      Bestellt durch
                $pdf->SetXY(130, 96.8);
                $pdf->Cell(60, 3, $order->firstname . " " . $order->lastname, 0, 0, "C");
        
                //      Bearbeiter
                $mitarbeiter = User::where("id", $rechnung[0]->mitarbeiter)->first();
                $pdf->SetXY(130, 101.5);
                $pdf->Cell(60, 3, $mitarbeiter->name, 0, 0, "C");
        
                //      Bearbeiter Phone
                $pdf->SetXY(130, 106.2);
                $pdf->Cell(60, 3, $mitarbeiter->phone, 0, 0, "C");
    
                //      Bearbeiter Mail
                $pdf->SetXY(130, 111.25);
                $pdf->Cell(60, 3, $mitarbeiter->email, 0, 0, "C");
        
        
                $pdf->SetFont("Arial");
        
                //      Rechnungsadresse
                $pdf->setFontSize(7);
    
                if(isset($order->send_back_street)) {
                    if(isset($order->send_back_company_name)) {
                        $pdf->Text(25, 60, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname . " | " . $order->send_back_company_name);
        
                        $pdf->setFontSize(9);
                        $pdf->Text(40, 102.5,  $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname . " | " . $order->send_back_company_name);
                        $pdf->setFontSize(7);
                    } else {
                        $pdf->Text(25, 60, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname);
        
                        $pdf->setFontSize(9);
                        $pdf->Text(40, 102.5,  $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname );
                        $pdf->setFontSize(7);
                    }
        
                    $pdf->Text(25, 64, $order->send_back_street . " " . $order->send_back_street_number);
        
                    $pdf->Text(25, 68, $order->send_back_zipcode . " " . $order->send_back_city);
        
                    $pdf->setFontSize(9);
                    $pdf->Text(40, 105.5, $order->send_back_street . " " . $order->send_back_street_number);
                    $pdf->Text(40, 108.5, $order->send_back_zipcode . " " . $order->send_back_city);
                    $pdf->Text(40, 111.5, $order->send_back_country);
                    $pdf->setFontSize(7);
        
                } else {
                    if(isset($order->company_name)) {
                        $pdf->setFontSize(9);
                        $pdf->Text(25, 60, $order->gender . " " . $order->firstname . " " . $order->lastname . " | " . $order->company_name);
        
                        $pdf->setFontSize(7);
                        $pdf->Text(40, 102.5, $order->gender . " " . $order->firstname . " " . $order->lastname . " | " . $order->company_name);
                        $pdf->setFontSize(9);
                    } else {
                        $pdf->setFontSize(9);
                        $pdf->Text(25, 60, $order->gender . " " . $order->firstname . " " . $order->lastname);
        
                        $pdf->setFontSize(7);
                        $pdf->Text(40, 102.5, $order->gender . " " . $order->firstname . " " . $order->lastname);
                        $pdf->setFontSize(9);
                    }
                    $pdf->setFontSize(9);
                    $pdf->Text(25, 64.1, $order->home_street . " " . $order->home_street_number);
        
                    $pdf->Text(24.9, 68, $order->home_zipcode . " " . $order->home_city);
        
                    $pdf->setFontSize(7);
                    $pdf->Text(40, 105.5, $order->home_street . " " . $order->home_street_number);
                    $pdf->Text(40, 108.5, $order->home_zipcode . " " . $order->home_city);
                    $pdf->Text(40, 111.5, $order->home_country);
                    $pdf->setFontSize(9);
                }
        
        
                //      Rechnungspositionen
                $pdf->SetFontSize(8);
                $positionYMultiplyer = 3.7;
                $positionStartY = 130.5;
                $posCounter = 1;
                $endBruttoPreis = 0;
                $endNettoPreis = 0;
                $rechnungen = array();
                    try{
                        array_push($rechnungen, $rechnung[$currentsite]);
                    }catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 1]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 2]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 3]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 4]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 5]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 6]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 7]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 8]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 9]);
                    } catch(Exception $e) {
    
                    }
    
                $currentsite = $currentsite+ 10;
                            $rabatt = rechnungen::where("bezeichnung", "Rabatt")->where("rechnungsnummer", $rechnungen[0]->rechnungsnummer)->first();
;
                foreach($rechnungen as $r) {
                    if($r->deleted != "deleted") {
                        $pdf->Text(21, $positionStartY, $posCounter);
                        $pdf->Text(33, $positionStartY, $r->menge);
                        $pdf->Text(40, $positionStartY, $r->artnr);
                        $pdf->Text(59.5, $positionStartY, iconv('UTF-8', 'ISO-8859-1', $r->bezeichnung));
                        $pdf->setXY(116.5, $positionStartY- 6);
                        
                        
                        //E-Preis
                        $pdf->setXY(156.5, $positionStartY- 6);
                        $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", str_replace(".", ",", sprintf('%0.2f',  $r->epreis) . "")), 0, 0, "R");
    
    
                        $cut_rabatt = str_replace("€", "", $r->rabatt);
                        $cut_rabatt = str_replace("%", "", $cut_rabatt);
        
                        //Gesamt
                        $pdf->setXY(179.3, $positionStartY- 6);
                        $pdf->Cell(11.25, 10, iconv("utf-8","Windows-1252", str_replace(".", ",", sprintf('%0.2f',  $r->nettobetrag)  . "")), 0, 0, "R");
        
                        $positionStartY += $positionYMultiplyer;
                        $posCounter++;
                        if($r->bruttobetrag != null) 
{
                        $endBruttoPreis += str_replace(",", ".", $r->bruttobetrag);

}
    if($r->nettobetrag!= null) 
{
                        $endNettoPreis += str_replace(",", ".", $r->nettobetrag);

}                        
                    }
                }

                if($rabatt != null) {
                    $pdf->Text(21, $positionStartY, $posCounter);
                    $pdf->Text(33, $positionStartY, $r->menge);
                    $pdf->Text(40, $positionStartY, $r->artnr);
                    $pdf->Text(59.5, $positionStartY, iconv('UTF-8', 'ISO-8859-1', "Rabatt"));
                    $pdf->setXY(124.7, $positionStartY- 6);
                    //Nettobetrag
                    $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", "- " . str_replace(".", ",", sprintf('%0.2f',  $rabatt . ""))), 0, 0, "R");
    

                    //MWST                    
                    //E-Preis
                    $pdf->setXY(159.5, $positionStartY- 6);
                    $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", "- " . str_replace(".", ",", sprintf('%0.2f',  $rabatt) . "")), 0, 0, "R");


    
                    $positionStartY += $positionYMultiplyer;
                    $posCounter++;
            }


                $positionStartY = $positionStartY+0.5;
                $pdf->setXY(20, $positionStartY - 3.25);
                $pdf->Cell(170.5, 0.01, "", 1, 0, "C");
        
                if($seitenow == $seiten) {
                   
    
                    
                        
                    $pdf->setFont("Arial", "B");
    
                    $zahlungen = zahlungen::where("rechnungsnummer", $id)->get();
                    
                    if($zahlungen->isEmpty()) {
                        $positionStartY = $positionStartY+8;

                           $pdf->SetFont("Arial", "B");


                           

                        $pdf->text(135, $positionStartY + 5, iconv("utf-8","Windows-1252", "Gesamtpreis"));
                        $pdf->setXY(150.75, $positionStartY + 3.5);
                        $pdf->Cell(30.35, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', str_replace(",", ".", $endNettoPreis - $rabatt)), 2, ",", ".") . "€"), 0, 0, "R");
    
                        

                    } else {
                        $payedAmount = 0;
                    
                        $zahlungYMultiplyer = 4;
                        $zahlungYCounter = $positionStartY + 13.5;
                        foreach($zahlungen as $zahlung) {
                            $pdf->SetFont("Arial");
                        
                            $pdf->Text(95.3, $zahlungYCounter, iconv("utf-8","Windows-1252",  "Zahlung (" . $zahlung->zahlart . ") vom " . $zahlung->created_at->format("d.m.Y")));
    
                            $pdf->setXY(150.7, $zahlungYCounter - 5.8);
                            $pdf->Cell(30.35, 10, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', str_replace(",", ".", $zahlung->betrag)), 2, ",", ".") . "€"), 0, 0, "R");
    
                            $pdf->SetFont("Arial", "B");
                        
                            $zahlungYCounter += $zahlungYMultiplyer;
                            $payedAmount += str_replace(",", ".", $zahlung->betrag);
                        }
                        $restBruttoAmount = $endBruttoPreis - $payedAmount;
                        //Gesamtbrutto
                        $pdf->text(135, $positionStartY + 5, iconv("utf-8","Windows-1252", "Gesamtpreis"));
                        $pdf->setXY(151, $positionStartY + 3.5);
                        $pdf->Cell(30, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $restBruttoAmount - $rabatt), 2, ",", ".") . "€"), 0, 0, "R");
    
                        
    
                        $pdf->SetFont("Arial");
                        if(isset($zahlung[0]->zahlart)) {
                            $pdf->text(125, 154.2, iconv("utf-8","Windows-1252", "Zahlung (" . $zahlung[0]->zahlart . ")"));
                        }
                        $pdf->setXY(20, $zahlungYCounter - 2);
                        $pdf->Cell(170.5, 0.01, "", 1, 0, "C");
                    }
                    
                }
    
    
                // Rechnungstext
                $pdf->setFont("Arial");
                $pdf->setXY(20, $positionStartY + 10);
                $pdf->SetFillColor(201, 201, 201);
                $pdf->MultiCell(170, 50, "", 1, "T", true);
    
                $rechnungstext = rechnungstext::where("id", $rechnungen[0]->rechnungstext)->first();
    
                $pdf->setXY(23, $positionStartY + 13);
                $pdf->MultiCell(162, 5, iconv("utf-8","Windows-1252", $rechnungstext->text), 0, "L");
    
    
        
                $pdf->SetFontSize(10);
        
               /**
                *  if(isset($zahlart->bezeichnung)) {
                *    $pdf->Text(60, 196, iconv("utf-8","Windows-1252",$zahlart->bezeichnung));
                *}
                *if(isset($versandart->bezeichnung)) {
                *    $pdf->Text(60, 201.2, $versandart->bezeichnung);
                *}
                */
        
                $test = new BarcodeGeneratorJPG();
                file_put_contents('barcode.jpg', $test->getBarcode($order->process_id, $test::TYPE_CODE_128));
        
                $source = imagecreatefromjpeg('barcode.jpg');
                $rotate = imagerotate($source, 90, 0);
                imagejpeg($rotate, "barcode.jpg");
                $pdf->Image('barcode.jpg', 195, 110, 9);
                
        
                $test = new BarcodeGeneratorJPG();
                file_put_contents('rechnungsnummer.jpg', $test->getBarcode($id, $test::TYPE_CODE_128));
        
                $source = imagecreatefromjpeg('rechnungsnummer.jpg');
                $rotate = imagerotate($source, 90, 0);
                imagejpeg($rotate, "rechnungsnummer.jpg");
                $pdf->Image('rechnungsnummer.jpg', 195, 206.5, 9);
        
    
    
    
    
            } else {

    
                $order    = active_orders_person_data::where("process_id", $rechnung[0]->process_id)->first();
    
        
            $pdf->SetFont("Arial", "B");
            $pdf->setFontSize(7.5);
    
            //      Rechnungsnummer
            $pdf->SetXY(147.5, 59.8);
            $pdf->Cell(40, 3, $id, 0, 0, 'C');

            //      Rechnungsdatum
            $pdf->SetXY(148, 64.3);
            $pdf->Cell(39, 3, $rechnung[0]->created_at->format("d.m.Y"), 0, 0, "C");
    
            //      Auftragsnummer
            $pdf->SetXY(108.8, 73.8);
            $pdf->Cell(35, 3, $order->process_id, 0, 0, "C");
    
            //      Bestelldatum
            $pdf->SetXY(148, 73.8);
            $pdf->Cell(20, 3, $order->created_at->format("d.m.Y"), 0, 0, "C");
    
            //      Seite
            $pdf->SetXY(148, 82.5);
            $pdf->Cell(40, 3, $seitenow . " von " . $seiten, 0, 0, "C");
    
            //      Zahlungsart
            $zahlart = $rechnung->where("bezeichnung", "Nachnahme")->first();
            if($zahlart == null) {
                $zahlart = $rechnung->where("bezeichnung", "Überweisung")->first();
            }
            if($zahlart == null) {
                $zahlart = $rechnung->where("bezeichnung", "Bar")->first();
            }
    
            if($zahlart != null) {
                $pdf->setXY(130, 87.3);
                $pdf->Cell(60, 3, iconv("utf-8","Windows-1252", $zahlart->bezeichnung), 0, 0, "C");
            }
    
    
            $versandart = $rechnung->where("bezeichnung", "Standard")->first();
            if($versandart == null) {
                $versandart = $rechnung->where("bezeichnung", "Express")->first();
            }
            if($versandart != null) {
                //      Versandart
                $pdf->setXY(130, 92);
                $pdf->Cell(60, 3, $versandart->bezeichnung, 0, 0, "C");
            }


            //      Bestellt durch
            $pdf->SetXY(130, 96.8);
            $pdf->Cell(60, 3, $order->firstname . " " . $order->lastname, 0, 0, "C");
    
            //      Bearbeiter
            $mitarbeiter = User::where("id", $rechnung[0]->mitarbeiter)->first();
            $pdf->SetXY(130, 101.5);
            $pdf->Cell(60, 3, $mitarbeiter->name, 0, 0, "C");
    
            //      Bearbeiter Phone
            $pdf->SetXY(130, 106.2);
            $pdf->Cell(60, 3, $mitarbeiter->phone, 0, 0, "C");

            //      Bearbeiter Mail
            $pdf->SetXY(130, 111.25);
            $pdf->Cell(60, 3, $mitarbeiter->email, 0, 0, "C");
    
    
            $pdf->SetFont("Arial");
    
            //      Rechnungsadresse
            $pdf->setFontSize(7);

            if(isset($order->send_back_street)) {
                if(isset($order->send_back_company_name)) {
                    $pdf->Text(25, 60, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname . " | " . $order->send_back_company_name);
    
                    $pdf->setFontSize(9);
                    $pdf->Text(40, 102.5,  $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname . " | " . $order->send_back_company_name);
                    $pdf->setFontSize(7);
                } else {
                    $pdf->Text(25, 60, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname);
    
                    $pdf->setFontSize(9);
                    $pdf->Text(40, 102.5,  $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname );
                    $pdf->setFontSize(7);
                }
    
                $pdf->Text(25, 64, $order->send_back_street . " " . $order->send_back_street_number);
    
                $pdf->Text(25, 68, $order->send_back_zipcode . " " . $order->send_back_city);
    
                $pdf->setFontSize(9);
                $pdf->Text(40, 105.5, $order->send_back_street . " " . $order->send_back_street_number);
                $pdf->Text(40, 108.5, $order->send_back_zipcode . " " . $order->send_back_city);
                $pdf->Text(40, 111.5, $order->send_back_country);
                $pdf->setFontSize(7);
    
            } else {
                if(isset($order->company_name)) {
                    $pdf->setFontSize(9);
                    $pdf->Text(25, 60, $order->gender . " " . $order->firstname . " " . $order->lastname . " | " . $order->company_name);
    
                    $pdf->setFontSize(7);
                    $pdf->Text(40, 102.5, $order->gender . " " . $order->firstname . " " . $order->lastname . " | " . $order->company_name);
                    $pdf->setFontSize(9);
                } else {
                    $pdf->setFontSize(9);
                    $pdf->Text(25, 60, $order->gender . " " . $order->firstname . " " . $order->lastname);
    
                    $pdf->setFontSize(7);
                    $pdf->Text(40, 102.5, $order->gender . " " . $order->firstname . " " . $order->lastname);
                    $pdf->setFontSize(9);
                }
                $pdf->setFontSize(9);
                $pdf->Text(25, 64.1, $order->home_street . " " . $order->home_street_number);
    
                $pdf->Text(24.9, 68, $order->home_zipcode . " " . $order->home_city);
    
                $pdf->setFontSize(7);
                $pdf->Text(40, 105.5, $order->home_street . " " . $order->home_street_number);
                $pdf->Text(40, 108.5, $order->home_zipcode . " " . $order->home_city);
                $pdf->Text(40, 111.5, $order->home_country);
                $pdf->setFontSize(9);
            }
    
    
            //      Rechnungspositionen
            $pdf->SetFontSize(8);
            $positionYMultiplyer = 3.7;
            $positionStartY = 130.5;
            $posCounter = 1;
            $endBruttoPreis = 0;
            $endNettoPreis = 0;
            $rechnungen = array();
                try{
                    array_push($rechnungen, $rechnung[$currentsite]);
                }catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 1]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 2]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 3]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 4]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 5]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 6]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 7]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 8]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 9]);
                } catch(Exception $e) {

                }

            $currentsite = $currentsite+ 10;
                        $rabatt = rechnungen::where("bezeichnung", "Rabatt")->where("rechnungsnummer", $rechnungen[0]->rechnungsnummer)->first();

            foreach($rechnungen as $r) {
                if($r->deleted != "deleted") {
                    $pdf->Text(21, $positionStartY, $posCounter);
                    $pdf->Text(33, $positionStartY, $r->menge);
                    $pdf->Text(40, $positionStartY, $r->artnr);
                    $pdf->Text(59.5, $positionStartY, iconv('UTF-8', 'ISO-8859-1', $r->bezeichnung));
                    $pdf->setXY(126, $positionStartY- 6);
                    //Nettobetrag
                    $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", str_replace(".", ",", sprintf('%0.2f',  $r->nettobetrag) . "")), 0, 0, "R");
    
                    //MWST
                    $pdf->Text(146.2, $positionStartY, $r->mwst . "%");
                    
                    //E-Preis
                    $pdf->setXY(160, $positionStartY- 6);
                    $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", str_replace(".", ",", sprintf('%0.2f',  $r->epreis) . "")), 0, 0, "R");



    
                    //Bruttobetrag
                    $pdf->setXY(179.3, $positionStartY- 6);
                    $cut_rabatt = str_replace("€", "", $r->rabatt);
                    $cut_rabatt = str_replace("%", "", $cut_rabatt);

                    $pdf->Cell(11.25, 10, iconv("utf-8","Windows-1252", str_replace(".", ",", sprintf('%0.2f',  $r->nettobetrag + ($r->nettobetrag / 100 * $r->mwst))  . "")), 0, 0, "R");
    
                    $positionStartY += $positionYMultiplyer;
                    $posCounter++;
                    if($r->bruttobetrag != null) 
{
                        $endBruttoPreis += str_replace(",", ".", $r->bruttobetrag);

}
if($r->nettobetrag!= null) 
{
                        $endNettoPreis += str_replace(",", ".", $r->nettobetrag);

}                    
    
                }
            }

            if($rabatt != null) {
                $pdf->Text(21, $positionStartY, $posCounter);
                $pdf->Text(33, $positionStartY, $r->menge);
                $pdf->Text(40, $positionStartY, $r->artnr);
                $pdf->Text(59.5, $positionStartY, iconv('UTF-8', 'ISO-8859-1', "Rabatt"));
                $pdf->setXY(127.05, $positionStartY- 6);
                //Nettobetrag
                $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", "- " . str_replace(".", ",", sprintf('%0.2f',  $rabatt . ""))), 0, 0, "R");

                //MWST
                $pdf->Text(147.85, $positionStartY, $mwst . "%");
                
                //E-Preis
                $pdf->setXY(160.85, $positionStartY- 6);
                $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", str_replace(".", ",", sprintf('%0.2f',  $rabatt) . "")), 0, 0, "R");




                //Bruttobetrag
                $pdf->setXY(179.3, $positionStartY- 6);


                $pdf->Cell(11.25, 10, iconv("utf-8","Windows-1252", "- " . str_replace(".", ",", sprintf('%0.2f',  $rabatt / 100 * $mwst + $rabatt)  . "")), 0, 0, "R");

                $positionStartY += $positionYMultiplyer;
                $posCounter++;
        }


            $positionStartY = $positionStartY+0.5;
            $pdf->setXY(20, $positionStartY - 3.25);
            $pdf->Cell(170.5, 0.01, "", 1, 0, "C");
            $positionStartY = $positionStartY+8;

            if($seitenow == $seiten) {

                

                //Gesamtpreis
                $pdf->SetFont("Arial", "B");
                $pdf->SetFontSize(9);
                $pdf->text(118.35, $positionStartY + 0.5, iconv("utf-8","Windows-1252", "Gesamtpreis Netto"));

                $pdf->setXY(166, $positionStartY - 0.85);
                $pdf->Cell(15, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $endNettoPreis - $rabatt), 2, ",", ".") . "€"), 0, 0, "R");

                $pdf->SetFont("Arial");

                //Mwst
                $pdf->text(126.25, $positionStartY +5, iconv("utf-8","Windows-1252", "MwSt. ". number_format(sprintf('%0.2f', $mwst), 2, ",", ".")."%"));

                $mwst = $mwst;
                $mwstEndNetto = $endNettoPreis - $rabatt;
                $mwstNetto = $mwstEndNetto / 100 * $mwst;
                $pdf->setXY(158.15, $positionStartY + 3.5);
                $pdf->Cell(22.85, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $mwstNetto), 2, ",", "."). "€"), 0, 0, "R");

            
                    
                $pdf->setFont("Arial", "B");

                $zahlungen = zahlungen::where("rechnungsnummer", $id)->get();
                
                if($zahlungen->isEmpty()) {
                    $endNettoPreis = $endNettoPreis - $rabatt;
                    $netto = $endNettoPreis / 100 * $mwst;
                    $pdf->text(117, $positionStartY + 9.5, iconv("utf-8","Windows-1252", "Gesamtpreis Brutto"));
                    $pdf->setXY(150.75, $positionStartY + 8);
                    $pdf->Cell(30.35, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $netto + $endNettoPreis), 2, ",", ".") . "€"), 0, 0, "R");
                    $zahlungYCounter = $positionStartY + 13.5;
      
                } else {
                    $payedAmount = 0;
                
                    $zahlungYMultiplyer = 5;
                    $zahlungYCounter = $positionStartY + 14.5;
                    foreach($zahlungen as $zahlung) {
                        $pdf->SetFont("Arial");
                    
                        $pdf->Text(91.5, $zahlungYCounter, iconv("utf-8","Windows-1252",  "Zahlung (" . $zahlung->zahlart . ") vom " . $zahlung->created_at->format("d.m.Y")));

                        $pdf->setXY(150.7, $zahlungYCounter - 5.8);
                        $pdf->Cell(30.35, 10, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', str_replace(",", ".", $zahlung->betrag)), 2, ",", ".") . "€"), 0, 0, "R");

                        $pdf->SetFont("Arial", "B");
                    
                        $zahlungYCounter += $zahlungYMultiplyer;
                        $payedAmount += str_replace(",", ".", $zahlung->betrag);
                    }
                    $restBruttoAmount = $endBruttoPreis - $payedAmount;
                    //Gesamtbrutto
                    $endNettoPreis = $endNettoPreis - $rabatt;
                    $netto = $endNettoPreis / 100 * $mwst;
                    $pdf->text(117, $positionStartY + 9.5, iconv("utf-8","Windows-1252", "Gesamtpreis Brutto"));
                    $pdf->setXY(151, $positionStartY + 8);
                    $pdf->Cell(30, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $netto + $endNettoPreis - $payedAmount), 2, ",", ".") . "€"), 0, 0, "R");


                    $pdf->SetFont("Arial");
                    if(isset($zahlung[0]->zahlart)) {
                        $pdf->text(125, 154.2, iconv("utf-8","Windows-1252", "Zahlung (" . $zahlung[0]->zahlart . ")"));
                    }
                    $pdf->setXY(20, $zahlungYCounter - 2);
                    $pdf->Cell(170.5, 0.01, "", 1, 0, "C");
                }
                
            }


            // Rechnungstext
            $pdf->setFont("Arial");
            $pdf->setXY(20, $zahlungYCounter + 10);
            $pdf->SetFillColor(201, 201, 201);
            $pdf->MultiCell(170, 50, "", 1, "T", true);

            $rechnungstext = rechnungstext::where("id", $rechnungen[0]->rechnungstext)->first();

            $pdf->setXY(23, $zahlungYCounter + 13);
            $pdf->MultiCell(162, 5, iconv("utf-8","Windows-1252", $rechnungstext->text), 0, "L");


    
            $pdf->SetFontSize(10);
    
           /**
            *  if(isset($zahlart->bezeichnung)) {
            *    $pdf->Text(60, 196, iconv("utf-8","Windows-1252",$zahlart->bezeichnung));
            *}
            *if(isset($versandart->bezeichnung)) {
            *    $pdf->Text(60, 201.2, $versandart->bezeichnung);
            *}
            */
    
            $test = new BarcodeGeneratorJPG();
            file_put_contents('barcode.jpg', $test->getBarcode($order->process_id, $test::TYPE_CODE_128));
    
            $source = imagecreatefromjpeg('barcode.jpg');
            $rotate = imagerotate($source, 90, 0);
            imagejpeg($rotate, "barcode.jpg");
            $pdf->Image('barcode.jpg', 195, 110, 9);
            
    
            $test = new BarcodeGeneratorJPG();
            file_put_contents('rechnungsnummer.jpg', $test->getBarcode($id, $test::TYPE_CODE_128));
    
            $source = imagecreatefromjpeg('rechnungsnummer.jpg');
            $rotate = imagerotate($source, 90, 0);
            imagejpeg($rotate, "rechnungsnummer.jpg");
            $pdf->Image('rechnungsnummer.jpg', 195, 206.5, 9);
    
            }
            $seitenow++;
        }
        

        dd($pdf->Output());
    }

    public function getPdfGutschrift($id) {
        $rechnung = rechnungen::where("rechnungsnummer", $id)->get();
        $mwst = 0;
        foreach($rechnung as $r) {
            if($r->mwst != "0") {
                $mwst = $r->mwst;
            }
        }

        $rechnungc = 1;
        $seiten = 1;
        $seitenow = 1;
        foreach($rechnung as $r) {
            if($rechnungc == 10) {
                $seiten++;
                $rechnungc = 1;
            } else {
                $rechnungc++;
            }
            
        }
        $pdf = new Fpdi(); 
        

        if($mwst == 0) {
            $pdf->setSourceFile(public_path("/"). "pdf/gutschrift_pdf.pdf");

         } else {
            $pdf->setSourceFile(public_path("/"). "pdf/gutschrift_mwst.pdf");

         }
        $currentsite = 0;
        for ($i=1; $i <= $seiten; $i++) {

            
            $pdf->AddPage();
            $tplId = $pdf->importPage(1);
            $pdf->useTemplate($tplId); 

            if($mwst == 0) {
                $order    = active_orders_person_data::where("process_id", $rechnung[0]->process_id)->first();
    
        
                $pdf->SetFont("Arial", "B");
                $pdf->setFontSize(7.5);
        
                //      Rechnungsnummer
                $pdf->SetXY(147.5, 59.8);
                $pdf->Cell(40, 3, $id, 0, 0, 'C');
    
                //      Rechnungsdatum
                $pdf->SetXY(148, 64.3);
                $pdf->Cell(39, 3, $rechnung[0]->created_at->format("d.m.Y"), 0, 0, "C");
        
                //      Auftragsnummer
                $pdf->SetXY(108.8, 73.8);
                $pdf->Cell(35, 3, $order->process_id, 0, 0, "C");
        
                //      Bestelldatum
                $pdf->SetXY(148, 73.8);
                $pdf->Cell(20, 3, $order->created_at->format("d.m.Y"), 0, 0, "C");
        
                //      Seite
                $pdf->SetXY(148, 82.5);
                $pdf->Cell(40, 3, $seitenow . " von " . $seiten, 0, 0, "C");
        
                //      Zahlungsart
                $zahlart = $rechnung->where("bezeichnung", "Nachnahme")->first();
                if($zahlart == null) {
                    $zahlart = $rechnung->where("bezeichnung", "Überweisung")->first();
                }
                if($zahlart == null) {
                    $zahlart = $rechnung->where("bezeichnung", "Bar")->first();
                }
        
                if($zahlart != null) {
                    $pdf->setXY(130, 87.3);
                    $pdf->Cell(60, 3, iconv("utf-8","Windows-1252", $zahlart->bezeichnung), 0, 0, "C");
                }
        
        
                $versandart = $rechnung->where("bezeichnung", "Standard")->first();
                if($versandart == null) {
                    $versandart = $rechnung->where("bezeichnung", "Express")->first();
                }
                if($versandart != null) {
                    //      Versandart
                    $pdf->setXY(130, 92);
                    $pdf->Cell(60, 3, $versandart->bezeichnung, 0, 0, "C");
                }
    
    
                //      Bestellt durch
                $pdf->SetXY(130, 96.8);
                $pdf->Cell(60, 3, $order->firstname . " " . $order->lastname, 0, 0, "C");
        
                //      Bearbeiter
                $mitarbeiter = User::where("id", $rechnung[0]->mitarbeiter)->first();
                $pdf->SetXY(130, 101.5);
                $pdf->Cell(60, 3, $mitarbeiter->name, 0, 0, "C");
        
                //      Bearbeiter Phone
                $pdf->SetXY(130, 106.2);
                $pdf->Cell(60, 3, $mitarbeiter->phone, 0, 0, "C");
    
                //      Bearbeiter Mail
                $pdf->SetXY(130, 111.25);
                $pdf->Cell(60, 3, $mitarbeiter->email, 0, 0, "C");
        
        
                $pdf->SetFont("Arial");
        
                //      Rechnungsadresse
                $pdf->setFontSize(7);
    
                if(isset($order->send_back_street)) {
                    if(isset($order->send_back_company_name)) {
                        $pdf->Text(25, 60, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname . " | " . $order->send_back_company_name);
        
                        $pdf->setFontSize(9);
                        $pdf->Text(40, 102.5,  $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname . " | " . $order->send_back_company_name);
                        $pdf->setFontSize(7);
                    } else {
                        $pdf->Text(25, 60, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname);
        
                        $pdf->setFontSize(9);
                        $pdf->Text(40, 102.5,  $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname );
                        $pdf->setFontSize(7);
                    }
        
                    $pdf->Text(25, 64, $order->send_back_street . " " . $order->send_back_street_number);
        
                    $pdf->Text(25, 68, $order->send_back_zipcode . " " . $order->send_back_city);
        
                    $pdf->setFontSize(9);
                    $pdf->Text(40, 105.5, $order->send_back_street . " " . $order->send_back_street_number);
                    $pdf->Text(40, 108.5, $order->send_back_zipcode . " " . $order->send_back_city);
                    $pdf->Text(40, 111.5, $order->send_back_country);
                    $pdf->setFontSize(7);
        
                } else {
                    if(isset($order->company_name)) {
                        $pdf->setFontSize(9);
                        $pdf->Text(25, 60, $order->gender . " " . $order->firstname . " " . $order->lastname . " | " . $order->company_name);
        
                        $pdf->setFontSize(7);
                        $pdf->Text(40, 102.5, $order->gender . " " . $order->firstname . " " . $order->lastname . " | " . $order->company_name);
                        $pdf->setFontSize(9);
                    } else {
                        $pdf->setFontSize(9);
                        $pdf->Text(25, 60, $order->gender . " " . $order->firstname . " " . $order->lastname);
        
                        $pdf->setFontSize(7);
                        $pdf->Text(40, 102.5, $order->gender . " " . $order->firstname . " " . $order->lastname);
                        $pdf->setFontSize(9);
                    }
                    $pdf->setFontSize(9);
                    $pdf->Text(25, 64.1, $order->home_street . " " . $order->home_street_number);
        
                    $pdf->Text(24.9, 68, $order->home_zipcode . " " . $order->home_city);
        
                    $pdf->setFontSize(7);
                    $pdf->Text(40, 105.5, $order->home_street . " " . $order->home_street_number);
                    $pdf->Text(40, 108.5, $order->home_zipcode . " " . $order->home_city);
                    $pdf->Text(40, 111.5, $order->home_country);
                    $pdf->setFontSize(9);
                }
        
        
                //      Rechnungspositionen
                $pdf->SetFontSize(8);
                $positionYMultiplyer = 3.7;
                $positionStartY = 130.5;
                $posCounter = 1;
                $endBruttoPreis = 0;
                $endNettoPreis = 0;
                $rechnungen = array();
                    try{
                        array_push($rechnungen, $rechnung[$currentsite]);
                    }catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 1]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 2]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 3]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 4]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 5]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 6]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 7]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 8]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 9]);
                    } catch(Exception $e) {
    
                    }
    
                $currentsite = $currentsite+ 10;
                            $rabatt = rechnungen::where("bezeichnung", "Rabatt")->where("rechnungsnummer", $rechnungen[0]->rechnungsnummer)->first();
;
                foreach($rechnungen as $r) {
                    if($r->deleted != "deleted") {
                        $pdf->Text(21, $positionStartY, $posCounter);
                        $pdf->Text(33, $positionStartY, $r->menge);
                        $pdf->Text(40, $positionStartY, $r->artnr);
                        $pdf->Text(59.5, $positionStartY, iconv('UTF-8', 'ISO-8859-1', $r->bezeichnung));
                        $pdf->setXY(116.5, $positionStartY- 6);
                        
                        
                        //E-Preis
                        $pdf->setXY(156.5, $positionStartY- 6);
                        $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", "-" . str_replace(".", ",", sprintf('%0.2f',  $r->epreis) . "")), 0, 0, "R");
    
    
                        $cut_rabatt = str_replace("€", "", $r->rabatt);
                        $cut_rabatt = str_replace("%", "", $cut_rabatt);
        
                        //Gesamt
                        $pdf->setXY(179.3, $positionStartY- 6);
                        $pdf->Cell(11.25, 10, iconv("utf-8","Windows-1252", "-" . str_replace(".", ",", sprintf('%0.2f',  $r->nettobetrag)  . "")), 0, 0, "R");
        
                        $positionStartY += $positionYMultiplyer;
                        $posCounter++;
                        if($r->bruttobetrag != null) 
{
                        $endBruttoPreis += str_replace(",", ".", $r->bruttobetrag);

}
    if($r->nettobetrag!= null) 
{
                        $endNettoPreis += str_replace(",", ".", $r->nettobetrag);

}                        
                    }
                }


                $positionStartY = $positionStartY+0.5;
                $pdf->setXY(20, $positionStartY - 3.25);
                $pdf->Cell(170.5, 0.01, "", 1, 0, "C");
        
                if($seitenow == $seiten) {
                   
    
                    
                        
                    $pdf->setFont("Arial", "B");
    
                    $zahlungen = zahlungen::where("rechnungsnummer", $id)->get();
                    
                    $positionStartY  = $positionStartY + 5;

                    if($zahlungen->isEmpty()) {

                        

    
                        $pdf->text(135, $positionStartY + 5, iconv("utf-8","Windows-1252", "Gesamtpreis"));
                        $pdf->setXY(150.75, $positionStartY + 3.5);
                        $pdf->Cell(30.35, 1, iconv("utf-8","Windows-1252", "- " . number_format(sprintf('%0.2f', str_replace(",", ".", $endNettoPreis)), 2, ",", ".") . "€"), 0, 0, "R");
    

                    } else {
                        $payedAmount = 0;
                    
                        $zahlungYMultiplyer = 4;
                        $zahlungYCounter = $positionStartY + 13.5;
                        foreach($zahlungen as $zahlung) {
                            $pdf->SetFont("Arial");
                        
                            $pdf->Text(95.3, $zahlungYCounter, iconv("utf-8","Windows-1252",  "Zahlung (" . $zahlung->zahlart . ") vom " . $zahlung->created_at->format("d.m.Y")));
    
                            $pdf->setXY(150.7, $zahlungYCounter - 5.8);
                            $pdf->Cell(30.35, 10, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', str_replace(",", ".", $zahlung->betrag)), 2, ",", ".") . "€"), 0, 0, "R");
    
                            $pdf->SetFont("Arial", "B");
                        
                            $zahlungYCounter += $zahlungYMultiplyer;
                            $payedAmount += str_replace(",", ".", $zahlung->betrag);
                        }
                        $restBruttoAmount = $endBruttoPreis - $payedAmount;
                        //Gesamtbrutto
                        $pdf->text(135, $positionStartY + 5, iconv("utf-8","Windows-1252", "Gesamtpreis"));
                        $pdf->setXY(151, $positionStartY + 3.5);
                        $pdf->Cell(30, 1, iconv("utf-8","Windows-1252", "- " . number_format(sprintf('%0.2f', $endNettoPreis), 2, ",", ".") . "€"), 0, 0, "R");
    
                        
    
                        $pdf->SetFont("Arial");
                        if(isset($zahlung[0]->zahlart)) {
                            $pdf->text(125, 154.2, iconv("utf-8","Windows-1252", "Zahlung (" . $zahlung[0]->zahlart . ")"));
                        }
                        $pdf->setXY(20, $zahlungYCounter - 2);
                        $pdf->Cell(170.5, 0.01, "", 1, 0, "C");
                    }
                    
                }
    
    
                // Rechnungstext
                $pdf->setFont("Arial");
                $pdf->setXY(20, $positionStartY + 10);
                $pdf->SetFillColor(201, 201, 201);
                $pdf->MultiCell(170, 50, "", 1, "T", true);
    
                $rechnungstext = rechnungstext::where("id", $rechnungen[0]->rechnungstext)->first();
    
                $pdf->setXY(23, $positionStartY + 13);
                $pdf->MultiCell(162, 5, iconv("utf-8","Windows-1252", $rechnungstext->text), 0, "L");
    
    
        
                $pdf->SetFontSize(10);
        
               /**
                *  if(isset($zahlart->bezeichnung)) {
                *    $pdf->Text(60, 196, iconv("utf-8","Windows-1252",$zahlart->bezeichnung));
                *}
                *if(isset($versandart->bezeichnung)) {
                *    $pdf->Text(60, 201.2, $versandart->bezeichnung);
                *}
                */
        
                $test = new BarcodeGeneratorJPG();
                file_put_contents('barcode.jpg', $test->getBarcode($order->process_id, $test::TYPE_CODE_128));
        
                $source = imagecreatefromjpeg('barcode.jpg');
                $rotate = imagerotate($source, 90, 0);
                imagejpeg($rotate, "barcode.jpg");
                $pdf->Image('barcode.jpg', 195, 110, 9);
                
        
                $test = new BarcodeGeneratorJPG();
                file_put_contents('rechnungsnummer.jpg', $test->getBarcode($id, $test::TYPE_CODE_128));
        
                $source = imagecreatefromjpeg('rechnungsnummer.jpg');
                $rotate = imagerotate($source, 90, 0);
                imagejpeg($rotate, "rechnungsnummer.jpg");
                $pdf->Image('rechnungsnummer.jpg', 195, 206.5, 9);
        
    
    
    
    
            } else {

    
                $order    = active_orders_person_data::where("process_id", $rechnung[0]->process_id)->first();
    
        
            $pdf->SetFont("Arial", "B");
            $pdf->setFontSize(7.5);
    
            //      Rechnungsnummer
            $pdf->SetXY(147.5, 59.8);
            $pdf->Cell(40, 3, $id, 0, 0, 'C');

            //      Rechnungsdatum
            $pdf->SetXY(148, 64.3);
            $pdf->Cell(39, 3, $rechnung[0]->created_at->format("d.m.Y"), 0, 0, "C");
    
            //      Auftragsnummer
            $pdf->SetXY(108.8, 73.8);
            $pdf->Cell(35, 3, $order->process_id, 0, 0, "C");
    
            //      Bestelldatum
            $pdf->SetXY(148, 73.8);
            $pdf->Cell(20, 3, $order->created_at->format("d.m.Y"), 0, 0, "C");
    
            //      Seite
            $pdf->SetXY(148, 82.5);
            $pdf->Cell(40, 3, $seitenow . " von " . $seiten, 0, 0, "C");
    
            //      Zahlungsart
            $zahlart = $rechnung->where("bezeichnung", "Nachnahme")->first();
            if($zahlart == null) {
                $zahlart = $rechnung->where("bezeichnung", "Überweisung")->first();
            }
            if($zahlart == null) {
                $zahlart = $rechnung->where("bezeichnung", "Bar")->first();
            }
    
            if($zahlart != null) {
                $pdf->setXY(130, 87.3);
                $pdf->Cell(60, 3, iconv("utf-8","Windows-1252", $zahlart->bezeichnung), 0, 0, "C");
            }
    
    
            $versandart = $rechnung->where("bezeichnung", "Standard")->first();
            if($versandart == null) {
                $versandart = $rechnung->where("bezeichnung", "Express")->first();
            }
            if($versandart != null) {
                //      Versandart
                $pdf->setXY(130, 92);
                $pdf->Cell(60, 3, $versandart->bezeichnung, 0, 0, "C");
            }


            //      Bestellt durch
            $pdf->SetXY(130, 96.8);
            $pdf->Cell(60, 3, $order->firstname . " " . $order->lastname, 0, 0, "C");
    
            //      Bearbeiter
            $mitarbeiter = User::where("id", $rechnung[0]->mitarbeiter)->first();
            $pdf->SetXY(130, 101.5);
            $pdf->Cell(60, 3, $mitarbeiter->name, 0, 0, "C");
    
            //      Bearbeiter Phone
            $pdf->SetXY(130, 106.2);
            $pdf->Cell(60, 3, $mitarbeiter->phone, 0, 0, "C");

            //      Bearbeiter Mail
            $pdf->SetXY(130, 111.25);
            $pdf->Cell(60, 3, $mitarbeiter->email, 0, 0, "C");
    
    
            $pdf->SetFont("Arial");
    
            //      Rechnungsadresse
            $pdf->setFontSize(7);

            if(isset($order->send_back_street)) {
                if(isset($order->send_back_company_name)) {
                    $pdf->Text(25, 60, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname . " | " . $order->send_back_company_name);
    
                    $pdf->setFontSize(9);
                    $pdf->Text(40, 102.5,  $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname . " | " . $order->send_back_company_name);
                    $pdf->setFontSize(7);
                } else {
                    $pdf->Text(25, 60, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname);
    
                    $pdf->setFontSize(9);
                    $pdf->Text(40, 102.5,  $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname );
                    $pdf->setFontSize(7);
                }
    
                $pdf->Text(25, 64, $order->send_back_street . " " . $order->send_back_street_number);
    
                $pdf->Text(25, 68, $order->send_back_zipcode . " " . $order->send_back_city);
    
                $pdf->setFontSize(9);
                $pdf->Text(40, 105.5, $order->send_back_street . " " . $order->send_back_street_number);
                $pdf->Text(40, 108.5, $order->send_back_zipcode . " " . $order->send_back_city);
                $pdf->Text(40, 111.5, $order->send_back_country);
                $pdf->setFontSize(7);
    
            } else {
                if(isset($order->company_name)) {
                    $pdf->setFontSize(9);
                    $pdf->Text(25, 60, $order->gender . " " . $order->firstname . " " . $order->lastname . " | " . $order->company_name);
    
                    $pdf->setFontSize(7);
                    $pdf->Text(40, 102.5, $order->gender . " " . $order->firstname . " " . $order->lastname . " | " . $order->company_name);
                    $pdf->setFontSize(9);
                } else {
                    $pdf->setFontSize(9);
                    $pdf->Text(25, 60, $order->gender . " " . $order->firstname . " " . $order->lastname);
    
                    $pdf->setFontSize(7);
                    $pdf->Text(40, 102.5, $order->gender . " " . $order->firstname . " " . $order->lastname);
                    $pdf->setFontSize(9);
                }
                $pdf->setFontSize(9);
                $pdf->Text(25, 64.1, $order->home_street . " " . $order->home_street_number);
    
                $pdf->Text(24.9, 68, $order->home_zipcode . " " . $order->home_city);
    
                $pdf->setFontSize(7);
                $pdf->Text(40, 105.5, $order->home_street . " " . $order->home_street_number);
                $pdf->Text(40, 108.5, $order->home_zipcode . " " . $order->home_city);
                $pdf->Text(40, 111.5, $order->home_country);
                $pdf->setFontSize(9);
            }
    
    
            //      Rechnungspositionen
            $pdf->SetFontSize(8);
            $positionYMultiplyer = 3.7;
            $positionStartY = 130.5;
            $posCounter = 1;
            $endBruttoPreis = 0;
            $endNettoPreis = 0;
            $rechnungen = array();
                try{
                    array_push($rechnungen, $rechnung[$currentsite]);
                }catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 1]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 2]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 3]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 4]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 5]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 6]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 7]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 8]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 9]);
                } catch(Exception $e) {

                }

            $currentsite = $currentsite+ 10;
                        $rabatt = rechnungen::where("bezeichnung", "Rabatt")->where("rechnungsnummer", $rechnungen[0]->rechnungsnummer)->first();

            foreach($rechnungen as $r) {
                if($r->deleted != "deleted") {
                    $pdf->Text(21, $positionStartY, $posCounter);
                    $pdf->Text(33, $positionStartY, $r->menge);
                    $pdf->Text(40, $positionStartY, $r->artnr);
                    $pdf->Text(59.5, $positionStartY, iconv('UTF-8', 'ISO-8859-1', $r->bezeichnung));
                    $pdf->setXY(127.05, $positionStartY- 6);
                    //Nettobetrag
                    $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", "-" .str_replace(".", ",", sprintf('%0.2f',  $r->nettobetrag) . "")), 0, 0, "R");
    
                    //MWST
                    $pdf->Text(146.2, $positionStartY, $r->mwst . "%");
                    
                    //E-Preis
                    $pdf->setXY(159.5, $positionStartY- 6);
                    $pdf->Cell(11, 10, iconv("utf-8","Windows-1252","-" . str_replace(".", ",", sprintf('%0.2f',  $r->epreis) . "")), 0, 0, "R");



    
                    //Bruttobetrag
                    $pdf->setXY(179.3, $positionStartY- 6);
                    $cut_rabatt = str_replace("€", "", $r->rabatt);
                    $cut_rabatt = str_replace("%", "", $cut_rabatt);

                    $pdf->Cell(11.25, 10, iconv("utf-8","Windows-1252", "-" . str_replace(".", ",", sprintf('%0.2f',  $r->nettobetrag + ($r->nettobetrag / 100 * $r->mwst))  . "")), 0, 0, "R");
    
                    $positionStartY += $positionYMultiplyer;
                    $posCounter++;
                    if($r->bruttobetrag != null) 
{
                        $endBruttoPreis += str_replace(",", ".", $r->bruttobetrag);

}
if($r->nettobetrag!= null) 
{
                        $endNettoPreis += str_replace(",", ".", $r->nettobetrag);

}                    
    
                }
            }

            $positionStartY = $positionStartY+0.5;
            $pdf->setXY(20, $positionStartY - 3.25);
            $pdf->Cell(170.5, 0.01, "", 1, 0, "C");
            $positionStartY = $positionStartY +5;
            if($seitenow == $seiten) {

               


                //Gesamtpreis
                $pdf->SetFont("Arial", "B");
                $pdf->SetFontSize(9);
                $pdf->text(118.35, $positionStartY + 0.5, iconv("utf-8","Windows-1252", "Gesamtpreis Netto"));

                $pdf->setXY(166, $positionStartY - 0.85);
                $pdf->Cell(15, 1, iconv("utf-8","Windows-1252", "- " .  number_format(sprintf('%0.2f', $endNettoPreis + $rabatt), 2, ",", ".") . "€"), 0, 0, "R");

                $pdf->SetFont("Arial");

                //Mwst
                $pdf->text(126.25, $positionStartY +5, iconv("utf-8","Windows-1252", "MwSt. ". number_format(sprintf('%0.2f', $mwst), 2, ",", ".")."%"));

                $mwst = $mwst;
                $pdf->setXY(158.15, $positionStartY + 3.5);
                $pdf->Cell(22.85, 1, iconv("utf-8","Windows-1252", "- " . number_format(sprintf('%0.2f', $endNettoPreis / 100 * $mwst), 2, ",", "."). "€"), 0, 0, "R");

                
                    
                $pdf->setFont("Arial", "B");

                $zahlungen = zahlungen::where("rechnungsnummer", $id)->get();
                
                if($zahlungen->isEmpty()) {

                    $pdf->text(117, $positionStartY + 9.5, iconv("utf-8","Windows-1252", "Gesamtpreis Brutto"));
                    $pdf->setXY(150.75, $positionStartY + 8);
                    $pdf->Cell(30.35, 1, iconv("utf-8","Windows-1252", "- " .  number_format(sprintf('%0.2f',  $endNettoPreis / 100 * $mwst + $endNettoPreis), 2, ",", ".") . "€"), 0, 0, "R");
                    $zahlungYCounter = $positionStartY + 13.5;
      
                } else {
                    $payedAmount = 0;
                
                    $zahlungYMultiplyer = 5;
                    $zahlungYCounter = $positionStartY + 14.5;
                    foreach($zahlungen as $zahlung) {
                        $pdf->SetFont("Arial");
                    
                        $pdf->Text(91.5, $zahlungYCounter, iconv("utf-8","Windows-1252",  "Zahlung (" . $zahlung->zahlart . ") vom " . $zahlung->created_at->format("d.m.Y")));

                        $pdf->setXY(150.7, $zahlungYCounter - 5.8);
                        $pdf->Cell(30.35, 10, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', str_replace(",", ".", $zahlung->betrag)), 2, ",", ".") . "€"), 0, 0, "R");

                        $pdf->SetFont("Arial", "B");
                    
                        $zahlungYCounter += $zahlungYMultiplyer;
                        $payedAmount += str_replace(",", ".", $zahlung->betrag);
                    }
                    $restBruttoAmount = $endBruttoPreis - $payedAmount;
                    //Gesamtbrutto
                    $pdf->text(117, $positionStartY + 9.5, iconv("utf-8","Windows-1252", "Gesamtpreis Brutto"));
                    $pdf->setXY(151, $positionStartY + 8);
                    $pdf->Cell(30, 1, iconv("utf-8","Windows-1252", "- " .  number_format(sprintf('%0.2f', $endNettoPreis / 100 * $mwst + $endNettoPreis), 2, ",", ".") . "€"), 0, 0, "R");


                    $pdf->SetFont("Arial");
                    if(isset($zahlung[0]->zahlart)) {
                        $pdf->text(125, 154.2, iconv("utf-8","Windows-1252", "Zahlung (" . $zahlung[0]->zahlart . ")"));
                    }
                    $pdf->setXY(20, $zahlungYCounter - 2);
                    $pdf->Cell(170.5, 0.01, "", 1, 0, "C");
                }
                
            }


            // Rechnungstext
            $pdf->setFont("Arial");
            $pdf->setXY(20, $zahlungYCounter + 10);
            $pdf->SetFillColor(201, 201, 201);
            $pdf->MultiCell(170, 50, "", 1, "T", true);

            $rechnungstext = rechnungstext::where("id", $rechnungen[0]->rechnungstext)->first();

            $pdf->setXY(23, $zahlungYCounter + 13);
            $pdf->MultiCell(162, 5, iconv("utf-8","Windows-1252", $rechnungstext->text), 0, "L");


    
            $pdf->SetFontSize(10);
    
           /**
            *  if(isset($zahlart->bezeichnung)) {
            *    $pdf->Text(60, 196, iconv("utf-8","Windows-1252",$zahlart->bezeichnung));
            *}
            *if(isset($versandart->bezeichnung)) {
            *    $pdf->Text(60, 201.2, $versandart->bezeichnung);
            *}
            */
    
            $test = new BarcodeGeneratorJPG();
            file_put_contents('barcode.jpg', $test->getBarcode($order->process_id, $test::TYPE_CODE_128));
    
            $source = imagecreatefromjpeg('barcode.jpg');
            $rotate = imagerotate($source, 90, 0);
            imagejpeg($rotate, "barcode.jpg");
            $pdf->Image('barcode.jpg', 195, 110, 9);
            
    
            $test = new BarcodeGeneratorJPG();
            file_put_contents('rechnungsnummer.jpg', $test->getBarcode($id, $test::TYPE_CODE_128));
    
            $source = imagecreatefromjpeg('rechnungsnummer.jpg');
            $rotate = imagerotate($source, 90, 0);
            imagejpeg($rotate, "rechnungsnummer.jpg");
            $pdf->Image('rechnungsnummer.jpg', 195, 206.5, 9);
    
            }
            $seitenow++;
        }
        

        dd($pdf->Output());
    }

    public function getPdfRechnung(Request $req, $id, $send = false) {

        if(str_contains($id, "A")) {
            $this->getPdfAngebot($id);
        }
        if(str_contains($id, "G")) {
            $this->getPdfGutschrift($id);
        }

        $rechnung = rechnungen::where("rechnungsnummer", $id)->get();
        if($rechnung[0]->mwst == "no"){
            $mwst = 0;
            
        } else {
            $mwst = 19;
        }
        $rechnungc = 1;
        $seiten = 1;
        $seitenow = 1;
        foreach($rechnung as $r) {
            $r->mwst = $mwst;
            if($rechnungc == 10) {
                $seiten++;
                $rechnungc = 1;
            } else {
                $rechnungc++;
            }
            
        }
        $pdf = new Fpdi(); 

        if($mwst == 0) {
            $pdf->setSourceFile(public_path("/"). "pdf/rechnung_pdf.pdf");

         } else {
            $pdf->setSourceFile(public_path("/"). "pdf/rechnung_mwst_pdf.pdf");

         }


        $currentsite = 0;
        for ($i=1; $i <= $seiten; $i++) {

            
            $pdf->AddPage();
            $tplId = $pdf->importPage(1);
            $pdf->useTemplate($tplId); 
            if($mwst == 0) {
                $order    = active_orders_person_data::where("process_id", $rechnung[0]->process_id)->first();
    
        
                $pdf->SetFont("Arial", "B");
                $pdf->setFontSize(7.5);
        
                //      Rechnungsnummer
                $pdf->SetXY(147.5, 59.8);
                $pdf->Cell(40, 3, $id, 0, 0, 'C');
    
                //      Rechnungsdatum
                $pdf->SetXY(148, 64.3);
                $pdf->Cell(39, 3, $rechnung[0]->created_at->format("d.m.Y"), 0, 0, "C");
        
                //      Auftragsnummer
                $pdf->SetXY(108.8, 73.8);
                $pdf->Cell(35, 3, $order->process_id, 0, 0, "C");
        
                //      Bestelldatum
                $pdf->SetXY(148, 73.8);
                $pdf->Cell(20, 3, $order->created_at->format("d.m.Y"), 0, 0, "C");
        
                //      Seite
                $pdf->SetXY(148, 82.5);
                $pdf->Cell(40, 3, $seitenow . " von " . $seiten, 0, 0, "C");
        
                //      Zahlungsart
                $zahlart = $rechnung->where("bezeichnung", "Nachnahme")->first();
                if($zahlart == null) {
                    $zahlart = $rechnung->where("bezeichnung", "Überweisung")->first();
                }
                if($zahlart == null) {
                    $zahlart = $rechnung->where("bezeichnung", "Bar")->first();
                }
        
                if($zahlart != null) {
                    $pdf->setXY(130, 87.3);
                    $pdf->Cell(60, 3, iconv("utf-8","Windows-1252", $zahlart->bezeichnung), 0, 0, "C");
                }
        
        
                $versandart = $rechnung->where("bezeichnung", "Standard")->first();
                if($versandart == null) {
                    $versandart = $rechnung->where("bezeichnung", "Express")->first();
                }
                if($versandart != null) {
                    //      Versandart
                    $pdf->setXY(130, 92);
                    $pdf->Cell(60, 3, $versandart->bezeichnung, 0, 0, "C");
                }
    
    
                //      Bestellt durch
                $pdf->SetXY(130, 96.8);
                $pdf->Cell(60, 3, "Vertrieb", 0, 0, "C");
        
                //      Bearbeiter
                $mitarbeiter = User::where("id", $rechnung[0]->mitarbeiter)->first();
                $pdf->SetXY(130, 101.5);
                $pdf->Cell(60, 3, $mitarbeiter->name, 0, 0, "C");
        
                //      Bearbeiter Phone
                $pdf->SetXY(130, 106.2);
                $pdf->Cell(60, 3, $mitarbeiter->phone, 0, 0, "C");
    
                //      Bearbeiter Mail
                $pdf->SetXY(130, 111.25);
                $pdf->Cell(60, 3, $mitarbeiter->email, 0, 0, "C");
        
        
                $pdf->SetFont("Arial");
        
                //      Rechnungsadresse
                $pdf->setFontSize(7);
    
                if(isset($order->send_back_street)) {
                  
                    $pdf->setFontSize(9);
                    $firstAdY = 60;
                    if(strlen($order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname) > 35) {
                        $pdf->setXY(24.3, 56);
                        $pdf->MultiCell(70, 4.5, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname, 0, "L");
                        $firstAdY = 68.1;
                    } else {
                        $pdf->Text(25.35, $firstAdY, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname, 0, "L");
                        $firstAdY = 64.1;
                    }
                
                $pdf->setFontSize(9);
                $pdf->Text(25, $firstAdY, $order->send_back_street . " " . $order->send_back_street_number);
                $firstAdY += 4;
    
                $pdf->Text(24.9, $firstAdY, $order->send_back_zipcode . " " . $order->send_back_city);
    

                $pdf->setFontSize(7);

                $firstAdY = 105.5;
                if(strlen($order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname) > 35) {
                    $pdf->setXY(39, 100.4);
                    $pdf->MultiCell(70, 3, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname, 0, "L");
                    $firstAdY += 65;
                } else {
                    $pdf->Text(40, 101.6, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname);

                }

               
                $pdf->Text(40, $firstAdY, $order->send_back_street . " " . $order->send_back_street_number);
                $pdf->Text(40, $firstAdY += 3, $order->send_back_zipcode . " " . $order->send_back_city);
                $pdf->Text(40, $firstAdY += 3, $order->send_back_country);
                $pdf->setFontSize(9);
        
                } else {
                    

                        $pdf->setFontSize(9);
                        $firstAdY = 60;
                        if(strlen($order->gender . " " . $order->firstname . " " . $order->lastname) > 35) {
                            $pdf->setXY(24.3, 56);
                            $pdf->MultiCell(70, 4.5, $order->gender . " " . $order->firstname . " " . $order->lastname, 0, "L");
                            $firstAdY = 68.1;
                        } else {
                            $pdf->Text(25.35, $firstAdY, $order->gender . " " . $order->firstname . " " . $order->lastname, 0, "L");
                            $firstAdY = 64.1;
                        }
                    
                    $pdf->setFontSize(9);
                    $pdf->Text(25, $firstAdY, $order->home_street . " " . $order->home_street_number);
                    $firstAdY += 4;
        
                    $pdf->Text(24.9, $firstAdY, $order->home_zipcode . " " . $order->home_city);
        

                    $pdf->setFontSize(7);

                    $firstAdY = 105.5;
                    if(strlen($order->gender . " " . $order->firstname . " " . $order->lastname) > 35) {
                        $pdf->setXY(39, 100.4);
                        $pdf->MultiCell(70, 3, $order->gender . " " . $order->firstname . " " . $order->lastname, 0, "L");
                        $firstAdY += 3.45;
                    } else {
                        $pdf->Text(40, 102.6, $order->gender . " " . $order->firstname . " " . $order->lastname);

                    }

                   
                    $pdf->Text(40, $firstAdY, $order->home_street . " " . $order->home_street_number);
                    $pdf->Text(40, $firstAdY += 3, $order->home_zipcode . " " . $order->home_city);
                    $pdf->Text(40, $firstAdY += 3, $order->home_country);
                    $pdf->setFontSize(9);
                }
        
        
                //      Rechnungspositionen
                $pdf->SetFontSize(8);
                $positionYMultiplyer = 3.7;
                $positionStartY = 130.5;
                $posCounter = 1;
                $endBruttoPreis = 0;
                $endNettoPreis = 0;
                $rechnungen = array();
                    try{
                        array_push($rechnungen, $rechnung[$currentsite]);
                    }catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 1]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 2]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 3]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 4]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 5]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 6]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 7]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 8]);
                    } catch(Exception $e) {
    
                    }
                    try{
                        array_push($rechnungen, $rechnung[$currentsite + 9]);
                    } catch(Exception $e) {
    
                    }
    
                $currentsite = $currentsite+ 10;
                            $rabatt = rechnungen::where("bezeichnung", "Rabatt")->where("rechnungsnummer", $rechnungen[0]->rechnungsnummer)->first();
;
                foreach($rechnungen as $r) {
                    if($r->deleted != "deleted") {
                       if($r->bezeichnung != "Rabatt") {
                        $pdf->Text(21, $positionStartY, $posCounter);
                        $pdf->Text(33, $positionStartY, $r->menge);
                        $pdf->Text(40, $positionStartY, $r->artnr);
                        $pdf->Text(59.5, $positionStartY, iconv('UTF-8', 'ISO-8859-1', $r->bezeichnung));
                        $pdf->setXY(116.5, $positionStartY- 6);
                        
                        
                        //E-Preis
                        $pdf->setXY(156.5, $positionStartY- 6);
                        $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", str_replace(".", ",", sprintf('%0.2f',  $r->epreis) . "")), 0, 0, "R");
    
    
                        $cut_rabatt = str_replace("€", "", $r->rabatt);
                        $cut_rabatt = str_replace("%", "", $cut_rabatt);
        
                        //Gesamt
                        $pdf->setXY(179.3, $positionStartY- 6);
                        $pdf->Cell(11.25, 10, iconv("utf-8","Windows-1252", str_replace(".", ",", sprintf('%0.2f',  $r->nettobetrag)  . "")), 0, 0, "R");
        
                        $positionStartY += $positionYMultiplyer;
                        $posCounter++;
                        if($r->bruttobetrag != null) 
{
                        $endBruttoPreis += str_replace(",", ".", $r->bruttobetrag);

}
    if($r->nettobetrag!= null) 
{
                        $endNettoPreis += str_replace(",", ".", $r->nettobetrag);

}                        
                       }
                    }
                }

                if($rabatt != null) {

                    $pdf->Text(21, $positionStartY, $posCounter);
                    $pdf->Text(33, $positionStartY, $r->menge);
                    $pdf->Text(40, $positionStartY, $r->artnr);
                    $pdf->Text(59.5, $positionStartY, iconv('UTF-8', 'ISO-8859-1', "Rabatt"));
                    $pdf->setXY(124.7, $positionStartY- 6);

                    //MWST
                    
                    //E-Preis
                    $pdf->setXY(156.5, $positionStartY- 6);
                    if($rabatt->rabatt_type == "euro") {
                        $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", "- " . str_replace(".", ",", sprintf('%0.2f',  $rabatt->rabatt) . "")), 0, 0, "R");
                    } else {
                        $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", "- " . str_replace(".", ",", sprintf('%0.2f',  $rabatt->rabatt) . "%")), 0, 0, "R");
                    }



    
                    //Bruttobetrag
                    $pdf->setXY(179.3, $positionStartY- 6);
                    $cut_rabatt = str_replace("€", "", $r->rabatt);
                    $cut_rabatt = str_replace("%", "", $cut_rabatt);

                    if($rabatt->rabatt_type == "euro") {
                        $pdf->Cell(11.25, 10, iconv("utf-8","Windows-1252", str_replace(".", ",", sprintf('%0.2f',  $rabatt->rabatt)  . "")), 0, 0, "R");
                    } else {
                        $pdf->Cell(11.25, 10, iconv("utf-8","Windows-1252", str_replace(".", ",", sprintf('%0.2f',  $rabatt->rabatt)  . "%")), 0, 0, "R");
                    }

                    if($rabatt->rabatt_bn == "Netto") {
                        if($rabatt->rabatt_type == "euro") {
                            $endNettoPreis -= str_replace(",", ".", $rabatt->rabatt);
                        } else {
                            $onePercent = $endNettoPreis/100;
                            $newRabatt = str_replace(",", ".", $onePercent)*str_replace(",", ".", $rabatt->rabatt);
                            $endNettoPreis -= str_replace(",", ".", $newRabatt);
                        }
                    }
                    if($rabatt->rabatt_bn == "Brutto") {
                        if($rabatt->rabatt_type == "euro") {
                            $endNettoPreis -= str_replace(",", ".", $rabatt->rabatt);
                        } else {
                            $onePercent = $endNettoPreis/100;
                            $newRabatt = str_replace(",", ".", $onePercent)*str_replace(",", ".", $rabatt->rabatt);
                            $endNettoPreis -= str_replace(",", ".", $newRabatt);
                        }
                    }
                    $positionStartY += $positionYMultiplyer;
                    $posCounter++;
            }

                $positionStartY = $positionStartY+0.5;
                $pdf->setXY(20, $positionStartY - 3.25);
                $pdf->Cell(170.5, 0.01, "", 1, 0, "C");
        
                if($seitenow == $seiten) {
                   
    
                   
                        
                    $pdf->setFont("Arial", "B");
    
                    $zahlungen = zahlungen::where("rechnungsnummer", $id)->get();
                    

                    

                    if($zahlungen->isEmpty()) {

                        if($rabatt != null) {
                            $pdf->SetFont("Arial");
                            $pdf->SetFontSize(9);
                            $pdf->text(136.65, $positionStartY + 5.5 , iconv("utf-8","Windows-1252", "Rabatt"));
                                        
                            $pdf->setXY(166, $positionStartY + 4 );
                            
                            if($rabatt->rabatt_type == "euro") {
                                $pdf->Cell(15, 1, iconv("utf-8","Windows-1252", "- " . number_format(sprintf('%0.2f', $rabatt->rabatt ), 2, ",", ".") . "€"), 0, 0, "R");
                            } else {
                                $pdf->Cell(15, 1, iconv("utf-8","Windows-1252", "- " . number_format(sprintf('%0.2f', $rabatt->rabatt ), 2, ",", ".") . "%"), 0, 0, "R");
                            }
                        }
    
                        $pdf->text(127.2, $positionStartY + 9.5, iconv("utf-8","Windows-1252", "Gesamtpreis"));
                        $pdf->setXY(150.75, $positionStartY + 8);
                        $pdf->Cell(30.35, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', str_replace(",", ".", $endNettoPreis)), 2, ",", ".") . "€"), 0, 0, "R");
    
                        $pdf->setXY(20, $positionStartY + 11.6);
                        $pdf->Cell(170.1, 0.01, "", 1, 0, "C");
                        $zahlungYCounter = $positionStartY + 25;
    
                        $pdf->text(125, $positionStartY + 16, iconv("utf-8","Windows-1252", "offener Betrag"));
                        $pdf->setXY(151, $positionStartY + 14.8);
                        $pdf->Cell(30, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $endNettoPreis ), 2, ",", ".") . "€"), 0, 0, "R");
                    } else {
                        $payedAmount = 0;
                    
                        $zahlungYMultiplyer = 4;
                        $zahlungYCounter = $positionStartY + 14;

                     

                        foreach($zahlungen as $zahlung) {
                            $pdf->SetFont("Arial");
                        
                            $pdf->Text(95.25, $zahlungYCounter, iconv("utf-8","Windows-1252",  "Zahlung (" . $zahlung->zahlart . ") vom " . $zahlung->created_at->format("d.m.Y")));
    
                            $pdf->setXY(150.7, $zahlungYCounter - 5.8);
                            $pdf->Cell(30.35, 10, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', str_replace(",", ".", $zahlung->betrag)), 2, ",", ".") . "€"), 0, 0, "R");
    
                            $pdf->SetFont("Arial", "B");
                        
                            $zahlungYCounter += $zahlungYMultiplyer;
                            $payedAmount += str_replace(",", ".", $zahlung->betrag);
                        }
                        $restBruttoAmount = $endBruttoPreis - $payedAmount;
                        //Gesamtbrutto
                        $pdf->text(127.2, $positionStartY + 9.5, iconv("utf-8","Windows-1252", "Gesamtpreis"));
                        $pdf->setXY(150.75, $positionStartY + 8);
                        $pdf->Cell(30, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $endNettoPreis), 2, ",", ".") . "€"), 0, 0, "R");
    
                        $pdf->text(125, $zahlungYCounter + 2, iconv("utf-8","Windows-1252", "offener Betrag"));
                        $pdf->setXY(151, $zahlungYCounter + 1);
                        $pdf->Cell(30, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $endNettoPreis - $payedAmount), 2, ",", ".") . "€"), 0, 0, "R");
    
                        $pdf->SetFont("Arial");
                        if(isset($zahlung[0]->zahlart)) {
                            $pdf->text(125, 154.2, iconv("utf-8","Windows-1252", "Zahlung (" . $zahlung[0]->zahlart . ")"));
                        }
                        $pdf->setXY(20, $zahlungYCounter - 2);
                        $pdf->Cell(170.5, 0.01, "", 1, 0, "C");
                    }
                    
                }
    
    
                // Rechnungstext
                $pdf->setFont("Arial");
                $pdf->setXY(20, $zahlungYCounter + 10);
                $pdf->SetFillColor(201, 201, 201);
                $pdf->MultiCell(170, 50, "", 1, "T", true);
    
                $rechnungstext = rechnungstext::where("id", $rechnungen[0]->rechnungstext)->first();
    
                $pdf->setXY(23, $zahlungYCounter + 13);
                $pdf->MultiCell(162, 5, iconv("utf-8","Windows-1252", $rechnungstext->text), 0, "L");
    
    
        
                $pdf->SetFontSize(10);
        
               /**
                *  if(isset($zahlart->bezeichnung)) {
                *    $pdf->Text(60, 196, iconv("utf-8","Windows-1252",$zahlart->bezeichnung));
                *}
                *if(isset($versandart->bezeichnung)) {
                *    $pdf->Text(60, 201.2, $versandart->bezeichnung);
                *}
                */
        
                $test = new BarcodeGeneratorJPG();
                file_put_contents('barcode.jpg', $test->getBarcode($order->process_id, $test::TYPE_CODE_128));
        
                $source = imagecreatefromjpeg('barcode.jpg');
                $rotate = imagerotate($source, 90, 0);
                imagejpeg($rotate, "barcode.jpg");
                $pdf->Image('barcode.jpg', 195, 110, 9);
                
        
                $test = new BarcodeGeneratorJPG();
                file_put_contents('rechnungsnummer.jpg', $test->getBarcode($id, $test::TYPE_CODE_128));
        
                $source = imagecreatefromjpeg('rechnungsnummer.jpg');
                $rotate = imagerotate($source, 90, 0);
                imagejpeg($rotate, "rechnungsnummer.jpg");
                $pdf->Image('rechnungsnummer.jpg', 195, 206.5, 9);
        
    
    
    
    
            } else {

                $konto = kundenkonto::where("kundenid", $rechnung[0]->kundenid)->first();
                $order    = active_orders_person_data::where("process_id", $rechnung[0]->process_id)->first();
                
        
            $pdf->SetFont("Arial", "B");
            $pdf->setFontSize(7.5);
    
            //      Rechnungsnummer
            $pdf->SetXY(147.5, 59.8);
            $pdf->Cell(40, 3, $id, 0, 0, 'C');

            //      Rechnungsdatum
            $pdf->SetXY(148, 64.3);
            $pdf->Cell(39, 3, $rechnung[0]->created_at->format("d.m.Y"), 0, 0, "C");
    
            //      Auftragsnummer
            $pdf->SetXY(108.8, 73.8);
            $pdf->Cell(35, 3, $order->process_id, 0, 0, "C");
    
            //      Bestelldatum
            $pdf->SetXY(148, 73.8);
            $pdf->Cell(20, 3, $order->created_at->format("d.m.Y"), 0, 0, "C");
    
            //      Seite
            $pdf->SetXY(148, 82.5);
            $pdf->Cell(40, 3, $seitenow . " von " . $seiten, 0, 0, "C");
    
            //      Zahlungsart
            $zahlart = $rechnung->where("bezeichnung", "Nachnahme")->first();
            if($zahlart == null) {
                $zahlart = $rechnung->where("bezeichnung", "Überweisung")->first();
            }
            if($zahlart == null) {
                $zahlart = $rechnung->where("bezeichnung", "Bar")->first();
            }
    
            if($zahlart != null) {
                $pdf->setXY(130, 87.3);
                $pdf->Cell(60, 3, iconv("utf-8","Windows-1252", $zahlart->bezeichnung), 0, 0, "C");
            }
    
    
            $versandart = $rechnung->where("bezeichnung", "Standard")->first();
            if($versandart == null) {
                $versandart = $rechnung->where("bezeichnung", "Express")->first();
            }
            if($versandart != null) {
                //      Versandart
                $pdf->setXY(130, 92);
                $pdf->Cell(60, 3, $versandart->bezeichnung, 0, 0, "C");
            }


            //      Bestellt durch
            $pdf->SetXY(130, 96.8);
            $pdf->Cell(60, 3, "Vertrieb", 0, 0, "C");
    
            //      Bearbeiter
            $mitarbeiter = User::where("id", $rechnung[0]->mitarbeiter)->first();
            $pdf->SetXY(130, 101.5);
            $pdf->Cell(60, 3, $mitarbeiter->name, 0, 0, "C");
    
            //      Bearbeiter Phone
            $pdf->SetXY(130, 106.2);
            $pdf->Cell(60, 3, $mitarbeiter->phone, 0, 0, "C");

            //      Bearbeiter Mail
            $pdf->SetXY(130, 111.25);
            $pdf->Cell(60, 3, $mitarbeiter->email, 0, 0, "C");
    
    
            $pdf->SetFont("Arial");
            //      Rechnungsadresse
            $pdf->setFontSize(7);
            if(isset($order->send_back_street)) {
                if(isset($order->send_back_company_name)) {
                    $pdf->setXY(25, 60);
                    $pdf->Cell(25, 60, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname . " | " . $order->send_back_company_name);
    
                    $pdf->setFontSize(9);
                    $pdf->Text(40, 102.5,  $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname . " | " . $order->send_back_company_name);
                    $pdf->setFontSize(7);
                } else {
                    $pdf->Text(25, 60, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname);
    
                    $pdf->setFontSize(9);
                    $pdf->Text(40, 102.5,  $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname );
                    $pdf->setFontSize(7);
                }
    
                $pdf->Text(25, 64, $order->send_back_street . " " . $order->send_back_street_number);
    
                $pdf->Text(25, 68, $order->send_back_zipcode . " " . $order->send_back_city);
    
                $pdf->setFontSize(9);
                $pdf->Text(40, 105.5, $order->send_back_street . " " . $order->send_back_street_number);
                $pdf->Text(40, 108.5, $order->send_back_zipcode . " " . $order->send_back_city);
                $pdf->Text(40, 111.5, $order->send_back_country);
                $pdf->setFontSize(7);
    
            } else {
                if(isset($order->company_name)) {
                    $pdf->setFontSize(9);
                    $pdf->Text(25, 60, $order->company_name);
                    $pdf->setXY(24, 58);
                    $pdf->MultiCell(80, 10, $order->gender . " " . $order->firstname . " " . $order->lastname);
                    if(strlen($order->gender . " " . $order->firstname . " " . $order->lastname) < 47) {
                        $textY = 72.1;
                    } else {
                        $textY = 68.1;
                    }
                    $pdf->setFontSize(7);
                    $pdf->Text(40, 102.5, $order->company_name);
                    $pdf->Text(40, 105.5, $order->gender . " " . $order->firstname . " " . $order->lastname);
                    $pdf->setFontSize(9);

                    $pdf->setFontSize(9);
                    $pdf->Text(25, $textY, $order->home_street . " " . $order->home_street_number);
                    $textY += 4;
                    $pdf->Text(24.9, $textY, $order->home_zipcode . " " . $order->home_city);
        
                    $pdf->setFontSize(7);
                    $pdf->Text(40, 108.5, $order->home_street . " " . $order->home_street_number);
                    $pdf->Text(40, 111.5, $order->home_zipcode . " " . $order->home_city);
                    $pdf->Text(40, 114.5, $order->home_country);
                    $pdf->setFontSize(9);
                } else {
                    $pdf->setFontSize(9);
                    $pdf->Text(25, 60, $order->gender . " " . $order->firstname . " " . $order->lastname);
    
                    $pdf->setFontSize(7);
                    $pdf->Text(40, 102.5, $order->gender . " " . $order->firstname . " " . $order->lastname);
                    $pdf->setFontSize(9);

                    $pdf->setFontSize(9);
                    $pdf->Text(25, 64.1, $order->home_street . " " . $order->home_street_number);
        
                    $pdf->Text(24.9, 68, $order->home_zipcode . " " . $order->home_city);
        
                    $pdf->setFontSize(7);
                    $pdf->Text(40, 105.5, $order->home_street . " " . $order->home_street_number);
                    $pdf->Text(40, 108.5, $order->home_zipcode . " " . $order->home_city);
                    $pdf->Text(40, 111.5, $order->home_country);
                    $pdf->setFontSize(9);
                }
               
            }
    
    
            //      Rechnungspositionen
            $pdf->SetFontSize(8);
            $positionYMultiplyer = 3.7;
            $positionStartY = 130.5;
            $posCounter = 1;
            $endBruttoPreis = 0;
            $endNettoPreis = 0;
            $rechnungen = array();
                try{
                    array_push($rechnungen, $rechnung[$currentsite]);
                }catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 1]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 2]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 3]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 4]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 5]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 6]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 7]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 8]);
                } catch(Exception $e) {

                }
                try{
                    array_push($rechnungen, $rechnung[$currentsite + 9]);
                } catch(Exception $e) {

                }

            $currentsite = $currentsite+ 10;
            $rabatt = rechnungen::where("bezeichnung", "Rabatt (Netto)")->where("rechnungsnummer", $rechnungen[0]->rechnungsnummer)->first();
            if($rabatt == null) {
                $rabatt = rechnungen::where("bezeichnung", "Rabatt (Brutto)")->where("rechnungsnummer", $rechnungen[0]->rechnungsnummer)->first();
            }
            if($rabatt == null) {
                $rabatt = new rechnungen();
                $rabatt->rabatt = 0;
            }
            foreach($rechnungen as $r) {
                if($r->deleted != "deleted") {
                    if($r->bezeichnung != "Rabatt (Netto)" && $r->bezeichnung != "Rabatt (Brutto)") {

                        $pdf->Text(21, $positionStartY, $posCounter);
                    $pdf->Text(33, $positionStartY, $r->menge);
                    $pdf->Text(40, $positionStartY, $r->artnr);
                    $pdf->Text(59.5, $positionStartY, iconv('UTF-8', 'ISO-8859-1', $r->bezeichnung));
                    $pdf->setXY(123, $positionStartY- 6);
                    //Nettobetrag
                    $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", str_replace(".", ",", sprintf('%0.2f',  $r->nettobetrag) . "")), 0, 0, "R");
    
                    //MWST
                    $pdf->Text(144, $positionStartY, $r->mwst . "%");
                    
                    //E-Preis
                    $pdf->setXY(159.5, $positionStartY- 6);
                    $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", str_replace(".", ",", sprintf('%0.2f',  $r->epreis) . "")), 0, 0, "R");



    
                    //Bruttobetrag
                    $pdf->setXY(179.3, $positionStartY- 6);
                    $cut_rabatt = str_replace("€", "", $r->rabatt);
                    $cut_rabatt = str_replace("%", "", $cut_rabatt);

                    $brutto = $r->nettobetrag + ($r->nettobetrag / 100 * $r->mwst);

                    $pdf->Cell(11.25, 10, iconv("utf-8","Windows-1252", str_replace(".", ",", sprintf('%0.2f',  $brutto)  . "")), 0, 0, "R");
    
                    $positionStartY += $positionYMultiplyer;
                    $posCounter++;

                    if($r->bruttobetrag != null) 
{
                        $endBruttoPreis += $brutto;

}
if($r->nettobetrag!= null) 
{
                        $endNettoPreis += str_replace(",", ".", $r->nettobetrag);

}                 
                    }   
    
                }
            }

            if($rabatt->rabatt != 0) {
                    $pdf->Text(21, $positionStartY, $posCounter);
                    $pdf->Text(33, $positionStartY, $r->menge);
                    $pdf->Text(40, $positionStartY, $r->artnr);
                    $pdf->Text(59.5, $positionStartY, iconv('UTF-8', 'ISO-8859-1', $rabatt->bezeichnung));
                    $pdf->setXY(124.7, $positionStartY- 6);

                    //Nettobetrag

                    if($rabatt->rabatt_type == "euro") {
                        $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", "- " . str_replace(".", ",", sprintf('%0.2f',  $rabatt->rabatt ))), 0, 0, "R");
                    } else {
                        $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", "- " . str_replace(".", ",", sprintf('%0.2f',  $rabatt->rabatt ). "%")), 0, 0, "R");
                    }
    
                    
                    //E-Preis
                    $pdf->setXY(159.5, $positionStartY- 6);
                    if($rabatt->rabatt_type == "euro") {
                        $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", "- " . str_replace(".", ",", sprintf('%0.2f',  $rabatt->rabatt) . "")), 0, 0, "R");
                    } else {
                        $pdf->Cell(11, 10, iconv("utf-8","Windows-1252", "- " . str_replace(".", ",", sprintf('%0.2f',  $rabatt->rabatt) . "%")), 0, 0, "R");
                    }
    
    
                    //Bruttobetrag
                    $pdf->setXY(179.3, $positionStartY- 6);
                    $cut_rabatt = str_replace("€", "", $r->rabatt);
                    $cut_rabatt = str_replace("%", "", $cut_rabatt);

                    if($rabatt->rabatt_type == "euro") {
                        $pdf->Cell(11.25, 10, iconv("utf-8","Windows-1252", "- " . str_replace(".", ",", sprintf('%0.2f',  $rabatt->rabatt)  . "")), 0, 0, "R");
                    } else {
                        $pdf->Cell(11.25, 10, iconv("utf-8","Windows-1252", "- " . str_replace(".", ",", sprintf('%0.2f',  $rabatt->rabatt)  . "%")), 0, 0, "R");
                    }
    
                    $positionStartY += $positionYMultiplyer;
                    $posCounter++;
                    if($rabatt->rabatt_bn == "Netto") {
                        if($rabatt->rabatt_type == "euro") {
                            $endNettoPreis -= sprintf('%0.2f',  $rabatt->rabatt);
                        } else {
                            $onePercent = $endNettoPreis / 100;
                            $sec = $onePercent*$rabatt->rabatt;
                            $endNettoPreis -= sprintf('%0.2f',  $sec);
                        }
                    }


                    if($rabatt->rabatt_bn == "Brutto") {
                        if($rabatt->rabatt_type == "euro") {
                            $endBruttoPreis -= sprintf('%0.2f',  $rabatt->rabatt);
                        } else {
                            $onePercent = $endBruttoPreis / 100;
                            $sec = $onePercent*$rabatt->rabatt;
                            $endBruttoPreis -= sprintf('%0.2f',  $sec);
                        }
                    }
            }

      

            $positionStartY = $positionStartY+0.5;
            $pdf->setXY(20, $positionStartY - 3.25);
            $pdf->Cell(170.5, 0.01, "", 1, 0, "C");
            $positionStartY = $positionStartY+8;

            if($seitenow == $seiten) {

                //Gesamtpreis
             


                $zahlungen = zahlungen::where("rechnungsnummer", $id)->get();
                $pdf->setFont("Arial", "B");
                $pdf->SetFontSize(9);

                if($zahlungen->isEmpty()) {
                    
                    $pdf->text(117, $positionStartY + 9.5, iconv("utf-8","Windows-1252", "Gesamtpreis Brutto"));
                    $pdf->setXY(166, $positionStartY + 8);
                    $pdf->Cell(15, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $endBruttoPreis), 2, ",", ".") . "€"), 0, 0, "R");

                    $endNettoPreis = ($endBruttoPreis/($mwst+100))*100;
                    $netto = 0;

                    if($rabatt->rabatt != 0) {
                        if($rabatt->rabatt_bn == "Netto") {
                            $pdf->Cell(30.35, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $netto + $endNettoPreis), 2, ",", ".") . "€"), 0, 0, "R");
                        } else {
    
                                if($rabatt->rabatt_type == "euro") {
                                    $endBruttoPreis = $netto + $endNettoPreis;
                                } else {   
                                    $endBruttoPreis = $netto + $endNettoPreis;
                                    $onePercent = $endBruttoPreis/100;
                                    $newRabatt = str_replace(",", ".", $onePercent)*str_replace(",", ".", $rabatt->rabatt);
                                    $endBruttoPreis -= str_replace(",", ".", $newRabatt);
                                }
                           
                            $pdf->Cell(30.35, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $endBruttoPreis), 2, ",", ".") . "€"), 0, 0, "R");
                        }
                        if($rabatt->rabatt_bn == "Netto") {
                            $pdf->Cell(30, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $netto + $endNettoPreis), 2, ",", ".") . "€"), 0, 0, "R");
                        } else {
                            $pdf->Cell(30, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $endBruttoPreis), 2, ",", ".") . "€"), 0, 0, "R");
                        }
                    }

                    $pdf->setXY(20, $positionStartY + 11.6);
                    $pdf->Cell(170.1, 0.01, "", 1, 0, "C");
                    $zahlungYCounter = $positionStartY + 25;



                    $pdf->text(125, $positionStartY + 16, iconv("utf-8","Windows-1252", "offener Betrag"));
                    $pdf->setXY(166, $positionStartY + 14.8);
                     $pdf->Cell(15, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $endBruttoPreis), 2, ",", ".") . "€"), 0, 0, "R");

                  


                //Gesamtpreis
                $pdf->SetFont("Arial", "B");
                $pdf->SetFontSize(9);
                $pdf->text(118.35, $positionStartY + 0.5, iconv("utf-8","Windows-1252", "Gesamtpreis Netto"));

                $pdf->setXY(166, $positionStartY - 0.85);
                $pdf->Cell(15, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $endNettoPreis), 2, ",", ".") . "€"), 0, 0, "R");

             
               


                $pdf->SetFont("Arial");

                //Mwst
                $pdf->text(126.25, $positionStartY +5, iconv("utf-8","Windows-1252", "MwSt. ". number_format(sprintf('%0.2f', $mwst), 2, ",", ".")."%"));

                $pdf->setXY(158.15, $positionStartY + 3.5);
                $mwstEndNetto = $endNettoPreis;
                $mwstNetto = ($mwstEndNetto / 100) * $mwst;
                $pdf->Cell(22.85, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $mwstNetto), 2, ",", "."). "€"), 0, 0, "R");

                
                    
                $pdf->setFont("Arial", "B");


                } else {
                    $payedAmount = 0;
                
                    $zahlungYMultiplyer = 5;
                    $zahlungYCounter = $positionStartY + 14.5;
                    foreach($zahlungen as $zahlung) {
                        $pdf->SetFont("Arial");
                    
                        $pdf->Text(91.5, $zahlungYCounter, iconv("utf-8","Windows-1252",  "Zahlung (" . $zahlung->zahlart . ") vom " . $zahlung->created_at->format("d.m.Y")));

                        $pdf->setXY(150.7, $zahlungYCounter - 5.8);
                        $pdf->Cell(30.35, 10, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', str_replace(",", ".", $zahlung->betrag)), 2, ",", ".") . "€"), 0, 0, "R");

                        $pdf->SetFont("Arial", "B");
                    
                        $zahlungYCounter += $zahlungYMultiplyer;
                        $payedAmount += str_replace(",", ".", $zahlung->betrag);
                    }


                    $netto = 0;


                    $endNettoPreis = ($endBruttoPreis/($mwst+100))*100;

                    //Gesamtpreis
                $pdf->SetFont("Arial", "B");
                $pdf->SetFontSize(9);
                $pdf->text(118.35, $positionStartY + 0.5, iconv("utf-8","Windows-1252", "Gesamtpreis Netto"));

                $pdf->setXY(166, $positionStartY - 0.85);
                $pdf->Cell(15, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $endNettoPreis), 2, ",", ".") . "€"), 0, 0, "R");

             
               


                $pdf->SetFont("Arial");
                //Mwst
                $pdf->text(126.25, $positionStartY +5, iconv("utf-8","Windows-1252", "MwSt. ". number_format(sprintf('%0.2f', $mwst), 2, ",", ".")."%"));

                $pdf->setXY(158.15, $positionStartY + 3.5);
                $mwstEndNetto = $endNettoPreis;
                $mwstNetto = ($mwstEndNetto / 100) * $mwst;
                $pdf->Cell(22.85, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f', $mwstNetto), 2, ",", "."). "€"), 0, 0, "R");

                    //Gesamtbrutto
                    $pdf->text(119, $positionStartY + 9.5, iconv("utf-8","Windows-1252", "Gesamtpreis Brutto"));
                    $pdf->setXY(151, $positionStartY + 8);

                    if($rabatt->rabatt != 0) {
                        if($rabatt->rabatt_bn == "Netto") {
                            $pdf->Cell(30, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f',  $endBruttoPreis ), 2, ",", ".") . "€"), 0, 0, "R");
                        } else {
                            $endBruttoPreis = $netto + $endNettoPreis;
                            $onePercent = $endBruttoPreis/100;
                            $newRabatt = str_replace(",", ".", $onePercent)*str_replace(",", ".", $rabatt->rabatt);
                            $endBruttoPreis -= str_replace(",", ".", $newRabatt);
                            $pdf->Cell(30, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f',  $endBruttoPreis ), 2, ",", ".") . "€"), 0, 0, "R");
                        }
                    } else {
                        $pdf->Cell(30, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f',  $endBruttoPreis ), 2, ",", ".") . "€"), 0, 0, "R");

                    }


                    $brutto = $endNettoPreis / 100 * $mwst;
                    $brutto = $brutto - $payedAmount;

                    $pdf->text(125, $zahlungYCounter + 2, iconv("utf-8","Windows-1252", "offener Betrag"));
                    $pdf->setXY(151, $zahlungYCounter + .8);

                        $pdf->Cell(30, 1, iconv("utf-8","Windows-1252", number_format(sprintf('%0.2f',  $endBruttoPreis - $payedAmount), 2, ",", ".") . "€"), 0, 0, "R");

                    $pdf->SetFont("Arial");
                    if(isset($zahlung[0]->zahlart)) {
                        $pdf->text(125, 154.2, iconv("utf-8","Windows-1252", "Zahlung (" . $zahlung[0]->zahlart . ")"));
                    }
                    $pdf->setXY(20, $zahlungYCounter - 2);
                    $pdf->Cell(170.5, 0.01, "", 1, 0, "C");
                }
                
            }


            // Rechnungstext
            $pdf->setFont("Arial");
            $pdf->setXY(20, $zahlungYCounter + 10);
            $pdf->SetFillColor(201, 201, 201);
            $pdf->MultiCell(170, 50, "", 1, "T", true);

            $rechnungstext = rechnungstext::where("id", $rechnungen[0]->rechnungstext)->first();

            $pdf->setXY(23, $zahlungYCounter + 13);
            $pdf->MultiCell(162, 5, iconv("utf-8","Windows-1252", $rechnungstext->text), 0, "L");


    
            $pdf->SetFontSize(10);
    
           /**
            *  if(isset($zahlart->bezeichnung)) {
            *    $pdf->Text(60, 196, iconv("utf-8","Windows-1252",$zahlart->bezeichnung));
            *}
            *if(isset($versandart->bezeichnung)) {
            *    $pdf->Text(60, 201.2, $versandart->bezeichnung);
            *}
            */
    
            $test = new BarcodeGeneratorJPG();
            file_put_contents('barcode.jpg', $test->getBarcode($order->process_id, $test::TYPE_CODE_128));
    
            $source = imagecreatefromjpeg('barcode.jpg');
            $rotate = imagerotate($source, 90, 0);
            imagejpeg($rotate, "barcode.jpg");
            $pdf->Image('barcode.jpg', 195, 110, 9);
            
    
            $test = new BarcodeGeneratorJPG();
            file_put_contents('rechnungsnummer.jpg', $test->getBarcode($id, $test::TYPE_CODE_128));
    
            $source = imagecreatefromjpeg('rechnungsnummer.jpg');
            $rotate = imagerotate($source, 90, 0);
            imagejpeg($rotate, "rechnungsnummer.jpg");
            $pdf->Image('rechnungsnummer.jpg', 195, 206.5, 9);
    
            }
            $seitenow++;
        }
        
        $pdf->Output(public_path() . "/rechnungspdfs/" . "rechnung-". $id . ".pdf", "F");

        if($send == false) {
            return $pdf->Output();
        } else {
            return "";
        }

    }

    public function getMahnungPdf(Request $req, $stufe, $id, $send = false) {

        $pdf = new Fpdi(); 
        $pdf->setSourceFile(public_path("/"). "pdf/Mahnung_leer_". $stufe .".pdf");
        $pdf->AddPage();
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId); 

        $rechnung = rechnungen::where("rechnungsnummer", $id)->first();
        $order    = active_orders_person_data::where("process_id", $rechnung->process_id)->first(); 
            
        $pdf->SetFont("Arial", "B");
        $pdf->setFontSize(7.5);

        //      Rechnungsnummer
        $pdf->SetXY(147.5, 59.8);
        $pdf->Cell(40, 3, str_replace("F", "M", $id) . "-" . $stufe , 0, 0, 'C');


        //      Rechnungsdatum
        $pdf->SetXY(148, 64.3);
        $pdf->Cell(39, 3, $rechnung->created_at->format("d.m.Y"), 0, 0, "C");

        //      Auftragsnummer
        $pdf->SetXY(108.8, 73.8);
        $pdf->Cell(35, 3, $order->process_id, 0, 0, "C");

        //      Bestelldatum
        $pdf->SetXY(148, 73.8);
        $pdf->Cell(20, 3, $order->created_at->format("d.m.Y"), 0, 0, "C");

        //      Seite
        $pdf->SetXY(148, 82.5);
        $pdf->Cell(40, 3, "1 von 1", 0, 0, "C");

        //      Zahlungsart
        $zahlart = $rechnung->where("bezeichnung", "Nachnahme")->first();
        if($zahlart == null) {
            $zahlart = $rechnung->where("bezeichnung", "Überweisung")->first();
        }
        if($zahlart == null) {
            $zahlart = $rechnung->where("bezeichnung", "Bar")->first();
        }

        if($zahlart != null) {
            $pdf->setXY(130, 87.3);
            $pdf->Cell(60, 3, iconv("utf-8","Windows-1252", $zahlart->bezeichnung), 0, 0, "C");
        }


        $versandart = $rechnung->where("bezeichnung", "Standard")->first();
        if($versandart == null) {
            $versandart = $rechnung->where("bezeichnung", "Express")->first();
        }
        if($versandart != null) {
            //      Versandart
            $pdf->setXY(130, 92);
            $pdf->Cell(60, 3, $versandart->bezeichnung, 0, 0, "C");
        }


        //      Bestellt durch
        $pdf->SetXY(130, 96.8);
        $pdf->Cell(60, 3, $order->firstname . " " . $order->lastname, 0, 0, "C");

        //      Bearbeiter
        $mitarbeiter = User::where("id", $rechnung->mitarbeiter)->first();
        $pdf->SetXY(130, 101.5);
        $pdf->Cell(60, 3, $mitarbeiter->name, 0, 0, "C");

        //      Bearbeiter Phone
        $pdf->SetXY(130, 106.2);
        $pdf->Cell(60, 3, $mitarbeiter->phone, 0, 0, "C");

        //      Bearbeiter Mail
        $pdf->SetXY(130, 111);
        $pdf->Cell(60, 3, $mitarbeiter->email, 0, 0, "C");


        $pdf->SetFont("Arial");

        //      Rechnungsadresse
        if(isset($order->send_back_street)) {
            if(isset($order->send_back_company_name)) {
                if(strlen($order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname . " | " . $order->send_back_company_name) >= 25) {
                    $pdf->Text(25, 60, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname);
                    $pdf->Text(25, 65, $order->send_back_company_name);

                } else {
                    $pdf->Text(25, 60, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname . " | " . $order->send_back_company_name);
                }

                $pdf->SetFontSize(8);
                $pdf->Text(40, 103.5,  $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname . " | " . $order->send_back_company_name);
                $pdf->setFontSize(9);
            } else {
                $pdf->Text(25, 60, $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname);

                $pdf->SetFontSize(8);
                $pdf->Text(40, 103.5,  $order->send_back_gender . " " . $order->send_back_firstname . " " . $order->send_back_lastname );
                $pdf->setFontSize(9);
            }

            $pdf->Text(25, 65, $order->send_back_street . " " . $order->send_back_street_number);

            $pdf->Text(25, 70, $order->send_back_zipcode . " " . $order->send_back_city);

            $pdf->SetFontSize(8);
            $pdf->Text(40, 106.5, $order->send_back_street . " " . $order->send_back_street_number);
            $pdf->Text(40, 109.5, $order->send_back_zipcode . " " . $order->send_back_city);
            $pdf->Text(40, 112.5, $order->send_back_country);
            $pdf->setFontSize(9);

        } else {
            if(isset($order->company_name)) {
                $pdf->Text(25, 60, $order->gender . " " . $order->firstname . " " . $order->lastname . " | " . $order->company_name);

                $pdf->SetFontSize(8);
                $pdf->Text(40, 103.5, $order->gender . " " . $order->firstname . " " . $order->lastname . " | " . $order->company_name);
                $pdf->setFontSize(9);
            } else {
                $pdf->Text(25, 60, $order->gender . " " . $order->firstname . " " . $order->lastname);

                $pdf->SetFontSize(8);
                $pdf->Text(40, 103.5, $order->gender . " " . $order->firstname . " " . $order->lastname);
                $pdf->setFontSize(9);
            }

            $pdf->Text(25, 65, $order->home_street . " " . $order->home_street_number);

            $pdf->Text(25, 70, $order->home_zipcode . " " . $order->home_city);

            $pdf->SetFontSize(8);
            $pdf->Text(40, 106.5, $order->home_street . " " . $order->home_street_number);
            $pdf->Text(40, 109.5, $order->home_zipcode . " " . $order->home_city);
            $pdf->Text(40, 112.5, $order->home_country);
            $pdf->setFontSize(9);
        }
        $mahneinstellunge = mahneinstellungen::where("mahnstufe", $stufe)->first();

        $mahntext = mahnungstext::where("title", $mahneinstellunge->bezeichnung)->first();

        $html = new Html2Text();

        $pdf->SetFontSize(11);
        $pdf->setXY(20, 135);

        if($order->gender == "Frau") {
            $gender = "geehrte";
        } else {
            $gender = "geehrter";

        }

        $pdf->MultiCell(170,4, iconv("utf-8","Windows-1252", str_replace(["[name]", "[gender]"], [$order->lastname, $gender], $html->convert($mahntext->text))), 0, 'T');

        
        $test = new BarcodeGeneratorJPG();
        file_put_contents('barcode.jpg', $test->getBarcode($order->process_id, $test::TYPE_CODE_128));

        $source = imagecreatefromjpeg('barcode.jpg');
        $rotate = imagerotate($source, 90, 0);
        imagejpeg($rotate, "barcode.jpg");
        $pdf->Image('barcode.jpg', 195, 110, 9);
        

        $test = new BarcodeGeneratorJPG();
        file_put_contents('rechnungsnummer.jpg', $test->getBarcode($id, $test::TYPE_CODE_128));

        $source = imagecreatefromjpeg('rechnungsnummer.jpg');
        $rotate = imagerotate($source, 90, 0);
        imagejpeg($rotate, "rechnungsnummer.jpg");
        $pdf->Image('rechnungsnummer.jpg', 195, 206.5, 9);

        $pdf->Output(public_path() . "/rechnungspdfs/" . "mahnung-". $id . ".pdf", "F");

        if($send == false) {
            return $pdf->Output();
        } else {
            return "";
        }

    }

    public function sendMahnung(Request $req, $id) {

        $rechnung = $this->getPdfRechnung($req, $id, true);
        $mahnung = mahnungen::where("rechnungsnummer", $id)->latest()->first();
        $r = rechnungen::where("rechnungsnummer", $id)->first();
        $order = active_orders_person_data::where("process_id", $r->process_id)->first();
        if($order == null) {
            $order = archive_orders_person::where("process_id", $r->process_id);
        }
        $mahnung = $this->getMahnungPdf($req, $mahnung->mahnstufe , $id, true);
        
        Mail::to($order->email)->send(new mahnung($id, $order));

    }

    public function deletePos(Request $req, $id) {

        $rechnung = rechnungen::where("id", $id)->first();
        $rechnung->delete();

        return $rechnung;

    }

    public function getAudioFileData(Request $req, $id) {

        $audio = audiofiles::where("rechnungsnummer", $id)->first();

        if($audio == null) {
            return null;
        } else {
            return $audio;
        }
    }
    
    public function changeAudioFileData(Request $req) {

        $id = $req->input("rechnungsnummer");
        $tophone = $req->input("tophone");
        $acceptone = $req->input("acceptone");
        $talkaccept = $req->input("talkaccept");
        $talkname = $req->input("talkname");
        $shipafterpay = $req->input("shipafterpay");
        $priceok = $req->input("priceok");
        $takebacktalk = $req->input("takebacktalk");
        $birthday = $req->input("birthday");
        $status = $req->input("status");
        $audiofile = $req->file("audiofile");
        $firstname = $req->input("firstname");
        $lastname = $req->input("lastname");
        $street = $req->input("street");
        $streetno = $req->input("streetno");
        $zipcode = $req->input("zipcode");
        $city = $req->input("city");
        $country = $req->input("country");
        $worktime = $req->input("worktime");
        $worktype = $req->input("worktype");

        $audio = audiofiles::where("rechnungsnummer", $id)->first();
        if($audio == null) {
            $audio = new audiofiles();
            $audio->rechnungsnummer = $id;
            $audio->tophone = $tophone;
            $audio->acceptone = $acceptone;
            $audio->speakaccept = $talkaccept;
            $audio->talkname = $talkname;
            $audio->shipafterpay = $shipafterpay;
            $audio->priceok = $priceok;
            $audio->takebacktalk = $takebacktalk;
            $audio->birthday = $birthday;
            $audio->status = $status;
            $audio->firstname = $firstname;
            $audio->lastname = $lastname;
            $audio->street = $street;
            $audio->streetno = $streetno;
            $audio->zipcode = $zipcode;
            $audio->city = $city;
            $audio->country = $country;
            $audio->worktype = $worktype;
            $audio->worktime = $worktime;
            $audio->file = "yes";
            $audio->save();

        } else {
            $audio->rechnungsnummer = $id;
            $audio->tophone = $tophone;
            $audio->acceptone = $acceptone;
            $audio->speakaccept = $talkaccept;
            $audio->talkname = $talkname;
            $audio->shipafterpay = $shipafterpay;
            $audio->priceok = $priceok;
            $audio->takebacktalk = $takebacktalk;
            $audio->birthday = $birthday;
            $audio->status = $status;
            $audio->firstname = $firstname;
            $audio->lastname = $lastname;
            $audio->worktype = $worktype;
            $audio->worktime = $worktime;
            $audio->street = $street;
            $audio->streetno = $streetno;
            $audio->zipcode = $zipcode;
            $audio->city = $city;
            $audio->country = $country;
            $audio->file = "yes";
            $audio->update();
        }

        if($audiofile != null) {
            $audiofile->move(public_path() . "/audiofiles/", $id . ".mp3");
        }

       return redirect()->back();

    }

    public function neueRabattPosition(Request $req) {

        $rechnungsnummer    = $req->input("id");
        $rabatt             = $req->input("rabatt");
        $rabattbn           = $req->input("bn");
        $rabatttype         = $req->input("type");

        $rechnung = rechnungen::where("rechnungsnummer", $rechnungsnummer)->where("bezeichnung", "Rabatt")->first();

        if($rechnung == null) {

            $rechnung                   = new rechnungen();
            $rechnung->rechnungsnummer  = $rechnungsnummer;
            $rechnung->pos              = "1";
            $rechnung->menge            = "1";
            $rechnung->artnr            = "Rabatt";
            $rechnung->bezeichnung      = "Rabatt ($rabattbn)";
            $rechnung->rabatt           = $rabatt;
            $rechnung->rabatt_type      = $rabatttype;
            $rechnung->rabatt_bn        = $rabattbn;
            $rechnung->mitarbeiter      = auth()->user()->id;
            $rechnung->save();

            return $rechnung;
        } else {
            return "rabatt-already-set";
        }
    }

    public function setBezahlt(Request $req, $id) {

        $rechnungen = rechnungen::where("rechnungsnummer", $id)->get();
        foreach($rechnungen as $r) {
            if($r->bezahlt == "true") {
                $r->bezahlt = "false";
            } else {
                $r->bezahlt = "true";
                $date = new DateTime();
                $r->bezahlt_at = $date->format("d.m.Y (H:i)");
                $r->bezahlt_from = auth()->user()->username;
            }
            $r->save();
        }

        $rechnungen = rechnungen::where("rechnungsnummer", $id)->with("zahlungen")->get();

        return view("includes.rechnungen.zahlungen")->with("rechnungen", $rechnungen);

    }
    
}