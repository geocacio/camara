<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index(){
        return view('panel.model.index');
    }

    public function create(){
        return view('panel.model.create');
    }
}
