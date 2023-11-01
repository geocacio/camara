<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('links')->get();
        return view('panel.configurations.menus.index', compact('menus'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        $menu->load(['links', 'links.target']);
        $getLinks = Link::where('visibility', 'enabled')->get();
        $links = $getLinks->diff($menu->links);
        return view('panel.configurations.menus.show', compact('menu', 'links'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $positions = $request->input('positions', []);
        $menu->links()->detach();

        foreach ($positions as $position) {
            $link = Link::find($position['link_id']);
            $menu->links()->attach($link, ['position' => $position['position']]);
        }

        session()->flash('success', 'Ordem do menu atualizado com sucesso!');
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
