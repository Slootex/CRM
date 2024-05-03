<?php

namespace App\Http\Controllers;

class booking extends Controller
{

    public $brutto;
    public $netto;
    public $mwst;
    public $process_id;
    
    public function __construct($process_id, $brutto, $mwst) {
        $this->brutto = $brutto;
        $this->mwst = $mwst;
        $this->process_id = $process_id;
    }
    
    public function new() {
        
    }


}
