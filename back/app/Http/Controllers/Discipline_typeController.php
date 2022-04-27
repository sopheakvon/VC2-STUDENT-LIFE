<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Discipline_typeController extends Controller
{
    public function getDiscipline(){
        $disciplinePath = storage_path('/disciplines/disciplines.json');
        $disciplines = json_decode(file_get_contents($disciplinePath), true);
        
        return $disciplines;
    }
}
