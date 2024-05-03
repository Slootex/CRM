<?php

namespace App\Http\Controllers;

use App\Models\maindata;
use App\Models\tracking_history;
use App\Models\ups_statuscodes;
use App\Models\warenausgang_history;

class UPS
{
    public function createPickup($shippingData)
    {
        $data_string = $shippingData;

        $headers = [];
        $headers[] = 'Authorization: Bearer '.$this->Auth()->access_token;
        $headers[] = 'Accept: application/json';
        $headers[] = 'grant_type=client_credentials';
        $headers[] = 'x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $ch = curl_init('https://onlinetools.ups.com/api/pickupcreation/v1/pickup?additionaladdressvalidation=street');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);

        return $response;
    }

    public function getTracking($label)
    {
        
            return 'error';

    }

    public function Auth()
    {
        //https://wwwcie.ups.com/webservices/Pickup/PickupCreationRequest
        $maindata = maindata::where('company_id', '1')->first();

        $data = [];
        $data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

        $clientID = base64_encode('WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX:hUt8JugAfbixJ0iFL5g5LOM26bogHxelFoyjxas4AwvcfKxCV2Vm0eCJM5vlRP2s');

        $headers = [];
        $headers[] = 'Authorization: Basic V3dXclkyQmNNY1dBS3hmWE80WkFDb254VEQzNGxzbWk4eGRIZ3k4VEFFZ1NJTlJYOmhVdDhKdWdBZmJpeEowaUZMNWc1TE9NMjZib2dIeGVsRm95anhhczRBd3ZjZkt4Q1YyVm0wZUNKTTV2bFJQMnM=';
        $headers[] = 'Accept: application/json';
        $headers[] = 'grant_type=client_credentials';
        $headers[] = 'x-merchant-id: WwWrY2BcMcWAKxfXO4ZAConxTD34lsmi8xdHgy8TAEgSINRX';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $ch = curl_init('https://onlinetools.ups.com/security/v1/oauth/token');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);

        return $response;
    }

    public function updateTrackingStatus()
    {
        $ausgänge = warenausgang_history::all();

        foreach ($ausgänge as $ausgang) {
            $label = $ausgang->label;

            if ($label != null) {
                $tracking = tracking_history::where('label', $label)->latest()->first();
                if(isset($tracking->code)) {
                    if($tracking->code != "FS" && $tracking->code != "9E") {
                        $tracking = $this->getTracking($label);
    
                        if ($tracking != 'error') {
                            foreach ($tracking as $status) {
                                $trackingHistory = tracking_history::where('process_id', $ausgang->process_id)->where('label', $label)->where('date', $status->date)->where('status', $status->status->description)->first();
                                if ($trackingHistory == null) {
                                    $trackingHistory = new tracking_history();
                                    $trackingHistory->process_id = $ausgang->process_id;
                                    $trackingHistory->label = $label;
                                    $trackingHistory->date = $status->date;
                                    $trackingHistory->status = $status->status->description;
                                    $trackingHistory->save(); 
                                }
                            }
                        }
                    }
                } else {
                    $tracking = $this->getTracking($label);
    
                        if ($tracking != 'error') {
                            foreach ($tracking as $status) {
                                $trackingHistory = tracking_history::where('process_id', $ausgang->process_id)->where('label', $label)->where('date', $status->date)->where('status', $status->status->description)->first();
                                if ($trackingHistory == null) {
                                    $trackingHistory = new tracking_history();
                                    $trackingHistory->process_id = $ausgang->process_id;
                                    $trackingHistory->label = $label;
                                    $trackingHistory->date = $status->date;
                                    $trackingHistory->status = $status->status->description;
                                    $trackingHistory->save(); 
                                }
                            }
                        }
                }
            }
        }
    }
}
