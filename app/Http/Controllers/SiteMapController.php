<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteMapController extends Controller
{
    public function page(){
        return view('pages.site-map.index');
    }
}
