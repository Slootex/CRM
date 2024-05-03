<?php 

/* Converts umlauts into words that are written out */
function converter($name){

    $search  = array('&auml;', '&uuml;', '&ouml;');
    $replace = array('%E4', 'ue', 'oe');
    $name = str_replace($search,$replace,$name);

    return $name;
}

?>