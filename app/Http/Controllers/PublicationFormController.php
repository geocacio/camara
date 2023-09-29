<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\PublicationForm;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicationFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Bidding $bidding)
    {
        $publications = PublicationForm::all();
        return view('panel.biddings.publications.index', compact('bidding', 'publications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Bidding $bidding)
    {
        $types = Type::where('slug', 'biddings')->first()->children;
        $employees = $bidding->secretary->getAllEmployees();

        return view('panel.biddings.publications.create', compact('bidding', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Bidding $bidding)
    {
        $validateData = $request->validate([
            'date' => 'required',
            'type' => 'required',
            'description' => 'nullable',
        ]);
        $validateData['slug'] = Str::slug($request->date.'-'.$request->type);
        
        $publication = $bidding->publicationForms()->create($validateData);
        if($publication){
            return redirect()->route('biddings.publications.index', $bidding->slug)->with('success', 'Forma de publicação cadastrado com sucesso!');
        }
        return redirect()->route('biddings.publications.index', $bidding->slug)->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PublicationForm $publicationForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidding $bidding, PublicationForm $publicationForm)
    {
        $publication = $publicationForm;
        return view('panel.biddings.publications.edit', compact('bidding', 'publication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PublicationForm $publicationForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidding $bidding, PublicationForm $publicationForm)
    {
        $publicationForm->delete();
        return redirect()->back()->with('success', 'Forma de publicação Excluída com sucesso!');
    }
}
