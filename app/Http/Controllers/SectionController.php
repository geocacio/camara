<?php

namespace App\Http\Controllers;

use App\Helpers\GenerateStyles;
use App\Models\Page;
use App\Models\Section;
use App\Models\Style;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $visibility = $request->visibility ? $request->visibility : 'disabled';

        $section = Section::find($request->section_id);
        $section->update(['visibility' => $visibility]);

        $styleData = $request->except(['_token', 'page_id', 'section_id', 'visibility', 'classes']);
        $classes = $request->classes;

        foreach ($classes as $class) {
            $style = Style::where('styleable_type', 'section')
                ->where('styleable_id', $request->section_id)
                ->where('classes', $class)
                ->first();

            if ($style) {
                $existingAttributes = $style->getAttributes();
                $updatedFields = [];

                foreach ($existingAttributes as $attribute => $value) {
                    if ($value !== null && isset($styleData[$attribute])) {
                        $updatedFields[$attribute] = $styleData[$attribute];
                    }
                }

                foreach ($updatedFields as $attribute => $value) {
                    if (isset($styleData[$attribute])) {
                        $updatedFields[$attribute] = $styleData[$attribute];
                    }
                }
                $style->update($updatedFields);
            }
        }

        GenerateStyles::generate();

        return redirect()->route('section.show', $section->slug)->with('success', 'Section atualizada com Sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        $section['styles'] = $section->styles;

        return view('panel.configurations.pages.style', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        if ($section->update($validatedData)) {
            session()->flash('success', 'Section atualizada com sucesso!');
            return redirect()->route('pages.index')->with('success', 'Section atualizada com sucesso!');
        }

        return redirect()->route('pages.index')->with('success', 'Section atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        //
    }

    public function visibility(Request $request)
    {
        $section = Section::find($request->id);
        if (!$section->update(['visibility' => $request->visibility])) {

            return response()->json(['error' => true, 'message' => 'Erro, Por favor tente novamente!']);
        }


        return response()->json(['success' => true, 'message' => $request->visibility == 'enabled' ? 'Seção ativada com sucesso' : 'Seção desativada com sucesso']);
    }
}
