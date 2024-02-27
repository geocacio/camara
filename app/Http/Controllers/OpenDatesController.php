<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\LRF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;
use App\Models\Contract;
use App\Models\Daily;
use App\Models\Decrees;
use App\Models\Employee;
use App\Models\Ordinance;
use App\Models\Publication;
use App\Models\Vehicle;

class OpenDatesController extends Controller
{
    public function index(){
        return view('pages.open-data.index');
    }

    public function getDatas(Request $request, $type)
    {
        if ($type == 'lrf') {
            $data = LRF::select('title', 'date', 'details')->get();
            if($data->count() > 0){
                return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }else {
                return response()->json('Sem dados');
            }
        }

        if ($type == 'licitacoes') {
            $data = Bidding::select('number', 'opening_date', 'status', 'estimated_value', 'description', 'address', 'city', 'state', 'country')->get();
            if($data->count() > 0){
                return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }else {
                return response()->json('Sem dados');
            }
        }

        if ($type == 'contratos') {
            $data = Contract::select('number', 'start_date', 'end_date', 'total_value', 'description', 'company_id')
            ->with(['company' => function ($query) {
                $query->select( 'id','name', 'cnpj', 'address', 'city', 'state', 'country');
            }])->get();

            if($data->count() > 0){
                return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }else {
                return response()->json('Sem dados');
            }
        }

        if ($type == 'diarias') {
            $data = Daily::select('name')->get();

            return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        if ($type == 'veiculos') {
            $data = Vehicle::select('situation', 'model', 'brand', 'plate', 'year', 'donation', 'type', 'purpose_vehicle', 'description', 'period')->get();
            
            if($data->count() > 0){
                return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }else {
                return response()->json('Sem dados');
            }
        }

        if ($type == 'decretos-municipais') {
            $data = Decrees::select('number', 'date', 'description', 'exercicy_id')->with('exercicy_id')->get();
            
            if($data->count() > 0){
                return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }else {
                return response()->json('Sem dados');
            }
        }

        if ($type == 'publicacoes') {
            $data = Publication::select('title', 'number', 'description', 'exercicy_id')->with('exercicy_id')->get();
            
            if($data->count() > 0){
                return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }else {
                return response()->json('Sem dados');
            }
        }

        if ($type == 'portarias') {
            $data = Ordinance::select('number', 'date', 'agent', 'detail')->with('exercicy_id')->get();

            if($data->count() > 0){
                return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }else {
                return response()->json('Sem dados');
            }
        }
    }

    public function csvGenerate(Request $request, $type)
    {
        if ($type == 'lrf') {
            $data = LRF::select('title', 'date', 'details')->get()->toArray();
        } elseif ($type == 'licitacoes') {
            $data = Bidding::select('number', 'opening_date', 'status', 'estimated_value', 'description', 'address', 'city', 'state', 'country')->get()->toArray();
        } elseif ($type == 'contratos') {
            $data = Contract::select('number', 'start_date', 'end_date', 'total_value', 'description', 'company_id')
            ->with(['company' => function ($query) {
                $query->select('id', 'name');
            }])->get()->toArray();

            foreach ($data as &$contract) {
                $contract['company_name'] = $contract['company']['name'];
                unset($contract['company']);
            }            
        } elseif ($type == 'veiculos') {
            $data = Vehicle::select('situation', 'model', 'brand', 'plate', 'year', 'donation', 'type', 'purpose_vehicle', 'description', 'period')->get()->toArray();
        } elseif ($type == 'decretos-municipais') {
            $data = Decrees::select('number', 'date', 'description', 'exercicy_id')->with('exercicy_id')->get()->toArray();
        } elseif ($type == 'publicacoes') {
            $data = Publication::select('title', 'number', 'description', 'exercicy_id')->with('exercicy_id')->get()->toArray();
        } elseif ($type == 'portarias') {
            $data = Ordinance::select('number', 'date', 'agent', 'detail')->with('exercicy_id')->get()->toArray();
        }

        $filename = $type . '_cidelandia.xlsx';

        return Excel::download(new DataExport($data, $type), $filename);

    }

}
