<?php

namespace App\Http\Controllers;

class googleAPI
{
    public function translate($targetLanguageCode, $text, $source)
    {
        $apiKey = 'AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg';
        $url = 'https://www.googleapis.com/language/translate/v2/languages?key='.$apiKey;

        $url = 'https://www.googleapis.com/language/translate/v2?key='.$apiKey.'&q='.rawurlencode($text).'&source='.$source.'&target='.$targetLanguageCode;

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handle);
        $responseDecoded = json_decode($response, true);
        curl_close($handle);
        return $responseDecoded['data']['translations'][0]['translatedText'];
    }

    public function verifyAdress($countryCode, $city, $zipcode, $street, $streetno) {
        #Adress Validation
        $APIUrl = 'https://addressvalidation.googleapis.com/v1:validateAddress?key=AIzaSyAcgKBVnLbf61C8RjyfBJSa62EIUifrpMg';

        $Params = '{  "address": {    "regionCode": "'.$countryCode.'",    "locality": "'.$city.'",    "postalCode": "'.$zipcode.'",    "addressLines": ["'.$street. ' ' . $streetno .'"]  },  "enableUspsCass": false}';

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
        $checkAddresses = null;
        foreach($response->result->address->addressComponents as $rs) {
            $status = $rs->confirmationLevel;

            if($status == "CONFIRMED") {
                
            } else {
                if($checkAddresses != "CORRECTED") {
                    if($status == "UNCONFIRMED_BUT_PLAUSIBLE") {
                        $checkAddresses = "ERROR";
                    } else {
                        $checkAddresses = "ERROR";
                    }
                }
            }
            if(isset($rs->spellCorrected)) {
                if($rs->spellCorrected == true) {
                    $checkAddresses = "CORRECTED";
                }
            }
            if(isset($rs->replaced)) {
                if($rs->replaced == true) {
                    $checkAddresses = "CORRECTED";
                }
            }
            
        }

        if($checkAddresses == null) {
            return "ok";
        } else {
            return [$checkAddresses, $response->result->address->addressComponents];
        }
    }
}
