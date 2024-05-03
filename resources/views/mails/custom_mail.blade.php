<!DOCTYPE html>
<html lang="en">
<head><title>CRM P+</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    @php
        $gender_replace         = str_replace("[geschlecht]", $lead->gender, $body);
        $firstname_replace      = str_replace("[vorname]", $lead->firstname, $gender_replace);
        $lastname_replace       = str_replace("[nachname]", $lead->lastname, $firstname_replace);
        if(isset($lead->process_id)) {
            $id_replace             = str_replace("[auftragsnummer]", $lead->process_id, $lastname_replace);
        } else {
            $id_replace     = $lastname_replace;
        }
        $datum                  = str_replace("[datum]", $lead->created_at, $id_replace);


        if(isset($lead->datum)) {
            $id_replace             = str_replace("[datum]", $lead->created_at, $id_replace);
        } else {
            $datum     = $id_replace;
        }

        #Fahrzeug daten

        if(isset($lead->car_company)) {
            $automarke             = str_replace("[automarke]", $lead->car_company, $datum);
        } else {
            $automarke     = $datum;
        }

        if(isset($lead->car_model)) {
            $automodel             = str_replace("[automodel]", $lead->car_model, $automarke);
        } else {
            $automodel     = $automarke;
        }

        if(isset($lead->production_year)) {
            $baujahr             = str_replace("[baujahr]", $lead->production_year, $automodel);
        } else {
            $baujahr     = $automodel;
        }

        if(isset($lead->car_identification_number)) {
            $fin             = str_replace("[fin]", $lead->car_identification_number, $baujahr);
        } else {
            $fin     = $baujahr;
        }

        if(isset($lead->car_company)) {
            $leistung             = str_replace("[leistung]", $lead->car_power, $fin);
        } else {
            $leistung     = $datum;
        }

        echo "<p>". $leistung . "</p>";
    @endphp

</body>
</html>