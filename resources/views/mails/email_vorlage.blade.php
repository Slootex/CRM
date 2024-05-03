<!DOCTYPE html>
<html lang="en">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    @php
        $text         = str_replace("[gender]", $lead->gender, $body);
        $text         = str_replace("[order_number]", $lead->process_id, $text);
        $text         = str_replace("[status_number]", $lead->process_id, $text);
        $text         = str_replace("[status]", $status->name, $text);
        $text         = str_replace("[date]", date("d.m.Y"), $text);
        $text         = str_replace("[machine]", $car->car_company, $text);
        $text         = str_replace("[model]", $car->car_model, $text);
        $text         = str_replace("[constructionyear]", $car->production_year, $text);
        $text         = str_replace("[carid]", $car->car_identification_number, $text);
        $text         = str_replace("[kw]", $car->car_power, $text);
        $text         = str_replace("[mileage]", $car->mileage, $text);
        $text         = str_replace("[mechanism]", $car->transmission, $text);
        $text         = str_replace("[fuel]", $car->fuel_type, $text);
        $text         = str_replace("[circuit]", $car->transmission, $text);
        $text         = str_replace("[companyname]", $lead->company_name, $text);
        $text         = str_replace("[firstname]", $lead->firstname, $text);
        $text         = str_replace("[lastname]", $lead->lastname, $text);
        $text         = str_replace("[street]", $lead->home_street, $text);
        $text         = str_replace("[streetno]", $lead->home_street_number, $text);
        $text         = str_replace("[zipcode]", $lead->home_zipcode, $text);
        $text         = str_replace("[city]", $lead->home_city, $text);
        $text         = str_replace("[country]", $lead->home_country, $text);
        $text         = str_replace("[phonenumber]", $lead->phonenumber, $text);
        $text         = str_replace("[mobilnumber]", $lead->mobilnumber, $text);
        $text         = str_replace("[differing_companyname]", $lead->send_back_company_name, $text);
        $text         = str_replace("[differing_firstname]", $lead->send_back_firstname, $text);
        $text         = str_replace("[differing_lastname]", $lead->send_back_lastname, $text);
        $text         = str_replace("[differing_street]", $lead->send_back_street, $text);
        $text         = str_replace("[differing_streetno]", $lead->send_back_street_number, $text);
        $text         = str_replace("[differing_zipcode]", $lead->send_back_zipcode, $text);
        $text         = str_replace("[differing_city]", $lead->send_back_city, $text);
        $text         = str_replace("[differing_country]", $lead->send_back_country, $text);


        

        echo "<p>". $text . "</p>";
    @endphp

<img src="http://45.145.224.202:8000/kunde/emailcheck/{{$lead->process_id}}/{{$pixelUUID}}">
</body>
</html>