<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\CommissionCouncilor;
use App\Models\Page;
use App\Models\TransparencyGroup;
use App\Models\Type;
use App\Models\TypeContent;
use Illuminate\Http\Request;

class CommissionController extends Controller
{

    public function page()
    {
        $page_commission = Page::where('name', 'Comissões')->first();
        $groups = TransparencyGroup::all();
        return view('panel.commission.page.edit', compact('page_commission', 'groups'));
    }

    public function pageUpdate(Request $request)
    {
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório'
        ]);
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $page_commission = Page::where('name', 'Comissões')->first();

        if ($page_commission->update($validateData)) {
            $page_commission->groupContents()->delete();
            $page_commission->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('commissions.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('commissions.page')->with('error', 'Por favor tente novamente!');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commissions = Commission::all();
        return view('panel.commission.index', compact('commissions'));
    }

    public function allCommissions(Request $request){

        $page_commission = Page::where('name', 'Comissões')->first();
        $query = Commission::query();
        
        $commissions = $query->paginate(10);
        return view('pages.commissions.index', compact('commissions', 'page_commission'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getType = Type::where('slug', 'commissions')->first();
        $types = $getType ? $getType->children : [];
        
        return view('panel.commission.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'description' => 'required',
            'type_id' => 'required',
            'information' => 'nullable',
            'more_info' => 'nullable',
        ],[
            'description.required' => 'O campo descrição é obrigatório',
            'type_id.required' => 'O campo tipo é obrigatório',
        ]);

        $validateData['slug'] = Commission::uniqSlug($validateData['description']);

        $commission = Commission::create($validateData);

        if ($commission){
            TypeContent::create([
                'type_id' => $validateData['type_id'],
                'typeable_id' => $commission->id,
                'typeable_type' => 'Commission',
            ]);

            return redirect()->route('commissions.index')->with('success', 'Comissão cadastrada com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Commission $commission)
    {
        $materials = [];
        $progress = [];

        foreach ($commission->commissionMaterials as $commissionMaterial) {
            $material = $commissionMaterial->material;
            $materials[] = $material;
            $progress = $material->progress;
        }

        $members = CommissionCouncilor::where('commission_id', $commission->id)->whereDate('end_date', '<', now())->get();

        return view('pages.commissions.show', compact('commission', 'materials', 'progress', 'members'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commission $commission)
    {
        $getType = Type::where('slug', 'commissions')->first();
        $types = $getType ? $getType->children : [];
        return view('panel.commission.edit', compact('commission', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commission $commission)
    {
        $validateData = $request->validate([
            'description' => 'required',
            'type_id' => 'required',
            'information' => 'nullable',
            'more_info' => 'nullable',
        ],[
            'description.required' => 'O campo descrição é obrigatório',
            'type_id.required' => 'O campo tipo é obrigatório',
        ]);

        if ($commission->update($validateData)){
            $typeContent = TypeContent::where('typeable_id', $commission->id)->where('typeable_type', 'Commission')->first();
            $typeContent->update(['type_id' => $validateData['type_id']]);

            return redirect()->route('commissions.index')->with('success', 'Comissão atualizada com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commission $commission)
    {
        $typeContent = TypeContent::where('typeable_id', $commission->id)->where('typeable_type', 'Commission')->first();
        if ($typeContent) {
            $typeContent->delete();
        }

        if ($commission->delete()){
            return redirect()->route('commissions.index')->with('success', 'Comissão removida com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }
}
