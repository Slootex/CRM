<?php

namespace App\Http\Controllers;

use App\Models\active_orders_person_data;
use App\Models\new_leads_person_data;
use Illuminate\Http\Request;

class kunde extends Controller
{
    
    public function createCustomId() {

        $q = random_int(1,9);
        $w = random_int(1,9);
        $e = random_int(1,9);
        $r = random_int(1,9);

        $id = $q.$w.$e.$r;

        $auftrag = new_leads_person_data::where("kunden_id", $id)->first();
        if($auftrag == null) {
            $auftrag = new_leads_person_data::where("kunden_id", $id)->first();
        }
        if($auftrag == null) {
            return $id;
        } else {
            $this->createCustomId();
        }
    } 

    public function getAuftragById(Request $req) {

        $id = $req->input("kunden_id");

        $auftrag = active_orders_person_data::where("kunden_id", $id)->first();

        if($auftrag != null) {
            return $auftrag;
        } else {
            return "empty";
        }
    }
    

    public function getInteressentById(Request $req) {
            $id = $req->input("kunden_id");

            $auftrag = new_leads_person_data::where("kunden_id", $id)->first();
    
            if($auftrag != null) {
                return $auftrag;
            } else {
                return "empty";
            }
    }

}
