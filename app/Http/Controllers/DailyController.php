<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Daily;
use App\Models\File;
use App\Models\Office;
use App\Models\Page;
use App\Models\Secretary;
use App\Models\TransparencyGroup;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DailyController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }


    public function page()
    {
        $page_daily = Page::where('name', 'Diárias')->first();
        $groups = TransparencyGroup::all();
        return view('panel.transparency.dailies.page.edit', compact('page_daily', 'groups'));
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

        $page_daily = Page::where('name', 'Diárias')->first();

        if ($page_daily->update($validateData)) {
            $page_daily->groupContents()->delete();
            $page_daily->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('dailies.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('dailies.page')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dailies = Daily::all();
        return view('panel.transparency.dailies.index', compact('dailies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offices = Office::all();

        $secretaries = Secretary::all();
        return view('panel.transparency.dailies.create', compact('offices', 'secretaries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'secretary_id' => 'required',
            'number' => 'required',
            'ordinance_date' => 'nullable',
            'agent' => 'nullable',
            'office_id' => 'nullable',
            'organization_company' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'trip_start' => 'required',
            'trip_end' => 'required',
            'payment_date' => 'nullable',
            'unit_price' => 'required',
            'quantity' => 'required',
            'amount' => 'nullable',
            'justification' => 'nullable',
            'historic' => 'nullable',
            'information' => 'nullable',
        ]);
        $validateData['unit_price'] = floatval(str_replace(['R$', ','], ['', '.'], $request->unit_price));
        $validateData['amount'] = floatval(str_replace(['R$', ','], ['', '.'], $request->amount));
        $validateData['slug'] = Str::slug($request->number);

        $daily = Daily::create($validateData);
        if ($daily) {

            $transparency = Category::where('slug', 'transparencia')->first();
            if ($transparency) {
                $daily->categories()->create([
                    'category_id' => $transparency->id,
                ]);
            }

            if ($request->secretary) {
                $daily->secretaries()->attach($request->secretary);
            }

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $key => $file) {
                    $url = $this->fileUploadService->upload($file, 'transparencia/daily');

                    //get fileName
                    $fileName = isset($request->custom_names[$key]) ? $request->custom_names[$key] : '';
                    $newFile = File::create(['name' => $fileName !== '' ? $fileName : $file->getClientOriginalName(), 'url' => $url]);
                    $daily->files()->create(['file_id' => $newFile->id]);
                }
            }


            return redirect()->route('dailies.index')->with('success', 'Diária cadastrada com sucesso!');
        }

        return redirect()->route('dailies.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $page_daily = Page::where('name', 'Diárias')->first();
        
        $searchData = $request->only(['number', 'trip_start', 'agent']);

        $query = Daily::query();

        if($request->filled('number')){
            $query->where('number', 'LIKE', '%' . $request->input('number') . '%');
        }
        if($request->filled('trip_start')){
            $query->whereDate('trip_start', '=', date("Y-m-d", strtotime($request->input('trip_start'))));
        }
        if($request->filled('agent')){
            $query->where('agent', 'LIKE', '%' . $request->input('agent') . '%');
        }

        $diaries = $query->select(['id', 'trip_start as Data', 'number as Número', 'agent as Beneficiário', 'unit_price as Valor unit.', 'quantity as Quantidade', 'amount as Total'])->orderBy('id', 'desc')->paginate(10);
        return view('pages.dailies.index', compact('page_daily', 'searchData', 'diaries'));
    }

    public function single(Daily $daily){
        return view('pages.dailies.single', compact('daily'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Daily $daily)
    {
        $files = $daily->files;
        $dailyCategories = $daily->categories->pluck('category');
        $offices = Office::all();
        $secretaries = Secretary::all();

        return view('panel.transparency.dailies.edit', compact('daily', 'files', 'dailyCategories', 'offices', 'secretaries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Daily $daily)
    {
        $validateData = $request->validate([
            'secretary_id' => 'required',
            'number' => 'required',
            'ordinance_date' => 'nullable',
            'agent' => 'nullable',
            'office_id' => 'nullable',
            'organization_company' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'trip_start' => 'required',
            'trip_end' => 'required',
            'payment_date' => 'nullable',
            'unit_price' => 'required',
            'quantity' => 'required',
            'amount' => 'nullable',
            'justification' => 'nullable',
            'historic' => 'nullable',
            'information' => 'nullable',
        ]);

        $validateData['unit_price'] = floatval(str_replace(['R$', ','], ['', '.'], $request->unit_price));
        $validateData['amount'] = floatval(str_replace(['R$', ','], ['', '.'], $request->amount));

        $updated = $daily->update($validateData);

        if ($request->hasFile('files')) {

            foreach ($request->file('files') as $key => $file) {
                $url = $this->fileUploadService->upload($file, 'transparencia/dailies');
                //get fileName
                $fileName = isset($request->custom_names[$key]) ? $request->custom_names[$key] : '';
                $newFile = File::create(['name' => $fileName !== '' ? $fileName : $file->getClientOriginalName(), 'url' => $url]);
                $daily->files()->create(['file_id' => $newFile->id]);
            }
        }

        if ($updated) {
            return redirect()->route('dailies.index')->with('success', 'Diária atualizada com sucesso!');
        }

        return redirect()->route('dailies.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Daily $daily)
    {
        if ($daily->files->count() > 0) {
            foreach ($daily->files as $currentFile) {
                $this->fileUploadService->deleteFile($currentFile->file->id);
            }
        }

        $daily->categories()->delete();
        $daily->secretaries()->detach();
        $daily->delete();

        return redirect()->route('dailies.index')->with('success', 'Diária excluído com sucesso!');
    }
}
