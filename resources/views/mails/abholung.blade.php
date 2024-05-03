<!DOCTYPE html>
<html lang="en">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
  <div>
    @php
    $text = $email->body;

    $text         = str_replace("[gender]", $info->gender, $mail->body);
        $text         = str_replace("[order_number]", $info->process_id, $text);
        $text         = str_replace("[status_number]", $info->process_id, $text);
        $text         = str_replace("[status]", $info->process_id, $text);
        $text         = str_replace("[date]", date("d.m.Y"), $text);
        $text         = str_replace("[machine]", $info->info_company, $text);
        $text         = str_replace("[model]", $info->info_model, $text);
        $text         = str_replace("[constructionyear]", $info->production_year, $text);
        $text         = str_replace("[infoid]", $info->info_identification_number, $text);
        $text         = str_replace("[kw]", $info->info_power, $text);
        $text         = str_replace("[mileage]", $info->mileage, $text);
        $text         = str_replace("[mechanism]", $info->transmission, $text);
        $text         = str_replace("[fuel]", $info->fuel_type, $text);
        $text         = str_replace("[circuit]", $info->transmission, $text);
        $text         = str_replace("[companyname]", $info->company_name, $text);
        $text         = str_replace("[firstname]", $info->firstname, $text);
        $text         = str_replace("[lastname]", $info->lastname, $text);
        $text         = str_replace("[street]", $info->home_street, $text);
        $text         = str_replace("[streetno]", $info->home_street_number, $text);
        $text         = str_replace("[zipcode]", $info->home_zipcode, $text);
        $text         = str_replace("[city]", $info->home_city, $text);
        $text         = str_replace("[country]", $info->home_country, $text);
        $text         = str_replace("[phonenumber]", $info->phonenumber, $text);
        $text         = str_replace("[mobilnumber]", $info->mobilnumber, $text);
        $text         = str_replace("[differing_companyname]", $info->send_back_company_name, $text);
        $text         = str_replace("[differing_firstname]", $info->send_back_firstname, $text);
        $text         = str_replace("[differing_lastname]", $info->send_back_lastname, $text);
        $text         = str_replace("[differing_street]", $info->send_back_street, $text);
        $text         = str_replace("[differing_streetno]", $info->send_back_street_number, $text);
        $text         = str_replace("[differing_zipcode]", $info->send_back_zipcode, $text);
        $text         = str_replace("[differing_city]", $info->send_back_city, $text);
        $text         = str_replace("[differing_country]", $info->send_back_country, $text);
    echo $text;

@endphp

  </div>

  
    
</body>
</html>







