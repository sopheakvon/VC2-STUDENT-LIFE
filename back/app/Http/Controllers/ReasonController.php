<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReasonController extends Controller
{
    public function getReason(){
        $reasonsPath = storage_path('/reasons/reason.json');
        $reasons = json_decode(file_get_contents($reasonsPath), true);
        
        return $reasons;
    }
}
