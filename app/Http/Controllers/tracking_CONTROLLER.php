<?php

namespace App\Http\Controllers;

use App\Models\carrier;
use App\Models\tracking;
use App\Models\versand_statuscode;

class tracking_CONTROLLER extends Controller
{


    public function updateTrackings($trackingnumber) {
        
        $data = array(
            "trackingNumber" => $trackingnumber,
        );
        $body = json_encode($data);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer apik_ghnlEaZHh39YYeF7ag8ndriKOGgdjT';


        $ch = curl_init('https://api.ship24.com/public/v1/trackers/track');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);
        $trackingHead = $response->data->trackings[0];
        $trackings = $response->data->trackings[0]->events;
        
        foreach($trackings as $tracking) {
            $translator = new googleAPI();
            $translated = $translator->translate("DE", $tracking->status, "EN");

            $t = tracking::where("status", $translated)->first();
            if($t == null) {
                $t = new tracking();
                $t->trackerid = $trackingHead->tracker->trackerId;
                $t->trackingnumber = $trackingHead->tracker->trackingNumber;
                $t->est_delivery_date = $trackingHead->shipment->delivery->estimatedDeliveryDate;
                $t->service = $trackingHead->shipment->delivery->service;
                $t->signedby = $trackingHead->shipment->delivery->signedBy;
                $t->eventid = $tracking->eventId;
                $t->status = substr($translated,0,50);
                $t->event_date = $tracking->occurrenceDatetime;
                $t->carrier = strtoupper($tracking->courierCode);
                $t->statuscode = $tracking->statusCode;
                $t->save();
            }

            $carrier = carrier::where("carrier", $tracking->courierCode)->first();
            if($carrier == null) {
                $carrier = new carrier();
                $carrier->carrier = $tracking->courierCode;
                $carrier->save();
            }

            $status = versand_statuscode::where("status", $translated)->where("carrier", $tracking->courierCode)->first();
            if($status == null) {
                $translator = new googleAPI();
                $translated = $translator->translate("DE", $tracking->status, "EN");

                $status = new versand_statuscode();
                $status->carrier = $tracking->courierCode;
                $status->bezeichnung = "Unterwegs";
                $status->icon = "truck";
                $status->status = substr($translated,0,50);
                $status->save();
            }
        }
        return "ok";
        }


}

?>