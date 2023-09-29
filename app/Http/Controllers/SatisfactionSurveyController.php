<?php

namespace App\Http\Controllers;

use App\Models\SatisfactionSurvey;
use Illuminate\Http\Request;

class SatisfactionSurveyController extends Controller
{
    public function store(Request $request){

        $satisfactionSurvey = SatisfactionSurvey::create($request->all());
        if($satisfactionSurvey){
            return redirect()->back()->with('success', 'Feedback enviado com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }
}
