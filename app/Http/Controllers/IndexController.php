<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;

class IndexController extends Controller
{
    public function getIndex() {
        return view ('index', array('proyectos'=>Proyecto::all()));
    }
}
