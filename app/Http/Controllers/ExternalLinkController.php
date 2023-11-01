<?php

namespace App\Http\Controllers;

use App\Models\ExternalLink;
use App\Models\TransparencyGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExternalLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('perPage', 10);
        $query = ExternalLink::query();
        if($search){
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        $externalLink = $query->paginate($perPage)->appends(['search' => $search, 'perPage' => $perPage]);
        return view('panel.transparency.links.index', compact('externalLink', 'perPage', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = TransparencyGroup::all();
        return view('panel.transparency.links.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'title' => 'nullable',
            'url' => 'required',
            'description' => 'nullable',
            'icon' => 'nullable',
            'visibility' => 'nullable',
        ], [
            'transparency_id.required' => 'O campo Transparência é obrigatório',
            'category_id.required' => 'O campo Categoria é obrigatório',
            'law_id.required' => 'O campo Léi é obrigatório',
        ]);
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';
        
        $validateData['slug'] = Str::slug($request->title);
        if(ExternalLink::where('slug', $validateData['slug'])->exists()){
            $nextId = ExternalLink::max('id') + 1;
            $validateData['slug'] = $validateData['slug'].'-'.$nextId;
        }

        $externalLink = ExternalLink::create($validateData);
        if ($externalLink) {
            $externalLink->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('external-links.index')->with('success', 'Link cadastrado com sucesso!');
        }
        return redirect()->route('external-links.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExternalLink $external_link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExternalLink $external_link)
    {
        $groups = TransparencyGroup::all();
        return view('panel.transparency.links.edit', compact('external_link', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExternalLink $external_link)
    {
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'title' => 'nullable',
            'url' => 'required',
            'description' => 'nullable',
            'icon' => 'nullable',
            'visibility' => 'nullable',
        ], [
            'transparency_id.required' => 'O campo Transparência é obrigatório',
            'url.required' => 'O campo URL é obrigatório',
        ]);
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        if ($external_link->update($validateData)) {
            $external_link->groupContents()->delete();
            $external_link->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('external-links.index')->with('success', 'Link cadastrado com sucesso!');
        }
        return redirect()->route('external-links.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExternalLink $external_link)
    {
        $external_link->delete();
        return redirect()->route('external-links.index')->with('success', 'Link excluído com sucesso!');
    }
}
