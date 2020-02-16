<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;

class HomeController extends Controller
{
    public function getIndex() {
        return view ('home', array('proyectos'=>Proyecto::all()));
    }
}
