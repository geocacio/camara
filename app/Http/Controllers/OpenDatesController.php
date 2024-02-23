<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\LRF;
use Illuminate\Http\Request;

class OpenDatesController extends Controller
{
    public function index(){
        return view('pages.open-data.index');
    }

    public function getDatas(Request $request, $type)
    {
        if ($type == 'lrf') {
            $data = LRF::select('title', 'date', 'details')->get(); 
            return response()->json($data, 200, [], JSON_PRETTY_PRINT);
        }

        if ($type == 'licitacoes') {
            $data = Bidding::select('number', 'opening_date', 'status', 'estimated_value', 'description', 'address', 'city', 'state', 'country')->get();
            return response()->json($data, 200, [], JSON_PRETTY_PRINT);
        }
    }
}
