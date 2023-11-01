<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = Link::all();
        return view('panel.configurations.menus.links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $links = Link::getOnlyLinks();
        $menus = Menu::all();
        return view('panel.configurations.menus.links.create', compact('links', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (empty($request->name) && empty($request->icon)) {
            return redirect()->back()->withInput()->withErrors(['name' => 'Pelo menos o nome ou o ícone devem ser preenchidos.']);
        }
        
        $dropdownLinks = $request->type == 'dropdown' ? $request->parent : [];

        $validatedData = $request->validate([
            'name' => 'nullable',
            'icon' => 'nullable',
            'url' => $request->type == 'link' ? 'required' : 'nullable',
            'type' => 'required',
            'parent' => $request->type == 'dropdown' ? 'required' : 'nullable',
        ]);
        unset($validatedData['parent']);

        $links = Link::all();

        $validatedData['position'] = $links->count() + 1;
        $validatedData['slug'] = Str::slug($request->name ? $request->name : $request->icon);
        $validatedData['visibility'] = 'enabled';

        $link = Link::create($validatedData);
        if ($link) {
            foreach ($dropdownLinks as $id) {
                $setParent = Link::find($id);
                $setParent->setGroup()->associate($link);
                $setParent->save();
            }

            //Verificar se existe menus...
            if ($request->menus) {
                foreach ($request->menus as $id) {
                    $menu = Menu::find($id);
                    if ($menu) {
                        $position = $menu->links()->count() + 1;
                        $menu->links()->attach($link, ['position' => $position]);
                    }
                }
            }

            return redirect()->route('links.index')->with('success', 'Link criado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro, por favor tente novamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        
        $links = $link->getGroupAndLinksDisponiveis();

        $dropdown = [];
        foreach ($link->group as $values) {
            $dropdown[] = $values->id;
        }
        $menus = Menu::with('links')->get();
        
        return view('panel.configurations.menus.links.edit', compact('link', 'links', 'dropdown', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {
        if (empty($request->name) && empty($request->icon)) {
            return redirect()->back()->withInput()->withErrors(['name' => 'Pelo menos o nome ou o ícone devem ser preenchidos.']);
        }
        $status = $request->visibility ? $request->visibility : 'disabled';
        $dropdownLinks = $request->type == 'dropdown' ? $request->parent : [];

        $validatedData = $request->validate([
            'name' => 'nullable',
            'icon' => 'nullable',
            'url' => $request->type == 'link' ? 'required' : 'nullable',
            'type' => 'required',
            'parent' => $request->type == 'dropdown' ? 'required' : 'nullable',
        ]);
        $validatedData['type'] = $validatedData['type'] == 'page' ? 'link' : $validatedData['type'];
        unset($validatedData['parent']);

        if ($link->group()->exists()) {
            $link->group()->update(['parent_id' => null]);
        }

        $links = Link::all();

        $validatedData['visibility'] = $status;
        $validatedData['position'] = $links->count() + 1;
        if ($link->update($validatedData)) {
            Link::where('parent_id', $link->id)->update(['parent_id' => null]);

            foreach ($dropdownLinks as $id) {
                $setParent = Link::find($id);
                $setParent->setGroup()->associate($link);
                $setParent->save();
            }

            //Verificar se existe menus...
            if ($request->menus) {
                $link->menus()->detach();

                foreach ($request->menus as $id) {
                    $menu = Menu::find($id);
                    
                    if ($menu) {
                        $position = $menu->links()->count() + 1;
                        $menu->links()->attach($link, ['position' => $position]);
                    }
                }
            }

            return redirect()->route('links.index')->with('success', 'Link atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro, por favor tente novamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        $link->menus()->detach();

        if ($link->group()->exists()) {
            $link->group()->update(['parent_id' => null]);
        }

        if (!$link->delete()) {
            return redirect()->route('links.index')->with('error', 'Por favor tente novamente!');
        }
        return redirect()->route('links.index')->with('success', 'Link removido com sucesso!');
    }

    public function visibility(Request $request)
    {

        $link = Link::find($request->id);
        if (!$link->update(['visibility' => $request->visibility])) {

            return response()->json(['error' => true, 'message' => 'Erro, Por favor tente novamente!']);
        }

        return response()->json(['success' => true, 'message' => $request->visibility == 'enabled' ? 'Link ativado com sucesso' : 'Link desativado com sucesso']);
    }
}
