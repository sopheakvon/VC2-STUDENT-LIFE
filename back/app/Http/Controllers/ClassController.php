<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function getClass(){
        $classPath = storage_path('/class/class.json');
        $classes = json_decode(file_get_contents($classPath), true);

        return $classes;
    }
}
