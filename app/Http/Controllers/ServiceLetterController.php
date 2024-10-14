<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Page;
use App\Models\PageServiceLetter;
use App\Models\Secretary;
use App\Models\ServiceLetter;
use App\Models\Setting;
use App\Models\TransparencyGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $search = $request->query('search');
        $perPage = $request->query('perPage', 10);
        $query = ServiceLetter::query(); //select * from `laws`
        if($search){
            $query->where('title', 'LIKE', '%' . $search . '%'); //"select * from `laws` where `number` LIKE ?"
        }

        $serviceLetter = $query->paginate($perPage)->appends(['search' => $search, 'perPage' => $perPage]);
        return view('panel.service-letters.index', compact('serviceLetter', 'perPage', 'search'));
    }

    public function page(Request $request)
    {
        $pageServiceLetter = Page::where('name', 'Cartas de Serviços')->first();
        $query = ServiceLetter::query();

        // Verifica se o campo de título foi preenchido
        if ($request->filled('title')) {
            $query->where('title', 'LIKE', '%' . $request->input('title') . '%');
        }

        // Verifica se o campo de categoria foi selecionado
        if ($request->filled('category_id') && $request->input('category_id') !== 'Todas') {
            $query->where('category_id', $request->input('category_id'));
        }

        // Verifica se o campo de descrição foi preenchido
        if ($request->filled('description')) {
            $query->where('description', 'LIKE', '%' . $request->input('description') . '%');
        }

        // Realiza a busca com os filtros aplicados
        $serviceLetter = $query->paginate(10);
        // Recupere os dados buscados para retorná-los juntamente com a paginação
        $searchData = $request->only(['title', 'category_id', 'description']);
        $categories = Category::where('slug', 'cartas-de-servicos')->with('children')->first();
        return view('pages.service-letters.index', compact('pageServiceLetter', 'serviceLetter', 'categories', 'searchData'));
    }

    public function indexPage(){
        $pageServiceLetter = Page::where('name', 'Cartas de Serviços')->first();
        $groups = TransparencyGroup::all();
        return view('panel.service-letters.page.edit', compact('pageServiceLetter', 'groups'));
    }

    public function pageUpdate(Request $request){
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

        $pageServiceLetter = Page::where('name', 'Cartas de Serviços')->first();

        if ($pageServiceLetter->update($validateData)) {
            $pageServiceLetter->groupContents()->delete();
            $pageServiceLetter->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->back()->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $secretaries = '';
        if ($user->employee && $user->employee->responsible) {
            $secretary_id = $user->employee->responsible->responsibleable_id;
        }
        $categories = Category::where('slug', 'cartas-de-servicos')->with('children')->first();
        return view('panel.service-letters.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate(
            [
                'category_id' => 'required',
                'title' => 'required',
                'description' => 'nullable',
                'service_letters' => 'nullable',
                'main_steps' => 'nullable',
                'requirements' => 'nullable',
                'completion_forecast' => 'nullable',
                'opening_hours' => 'nullable',
                'costs' => 'nullable',
                'opening_hours' => 'nullable',
                'service_delivery_methods' => 'nullable',
                'additional_information' => 'nullable',
                'views' => 'nullable',
            ],
            [
                'category_id.required' => 'O campo Categoria é obrigatótio',
                'title.required' => 'O campo Título é obrigatótio',
            ]
        );
        $validateData['slug'] = Str::slug($validateData['title']);

        $serviceLetter = ServiceLetter::create($validateData);

        if ($serviceLetter) {
            $pdf = $this->pdfGenerate($serviceLetter);
            $serviceLetter->categories()->create(['category_id' => $validateData['category_id']]);
            return redirect()->route('serviceLetter.index')->with('success', 'Carta de Serviço cadastrada com sucesso!');
        }
        return redirect()->route('serviceLetter.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceLetter $serviceLetter)
    {
        // Incrementar o contador de visualizações
        $serviceLetter->views = $serviceLetter->views + 1;
        $serviceLetter->save();
        return view('pages.service-letters.show', compact('serviceLetter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceLetter $serviceLetter)
    {
        $user = Auth::user();
        $secretaries = '';
        if ($user->employee && $user->employee->responsible) {
            $secretary_id = $user->employee->responsible->responsibleable_id;
        }

        $categories = Category::where('slug', 'cartas-de-servicos')->with('children')->first();
        return view('panel.service-letters.edit', compact('serviceLetter', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceLetter $serviceLetter)
    {
        $validateData = $request->validate(
            [
                'category_id' => 'required',
                'title' => 'required',
                'description' => 'nullable',
                'service_letters' => 'nullable',
                'main_steps' => 'nullable',
                'requirements' => 'nullable',
                'completion_forecast' => 'nullable',
                'opening_hours' => 'nullable',
                'costs' => 'nullable',
                'opening_hours' => 'nullable',
                'service_delivery_methods' => 'nullable',
                'additional_information' => 'nullable',
                'views' => 'nullable',
            ],
            [
                'category_id.required' => 'O campo Categoria é obrigatótio',
                'title.required' => 'O campo Título é obrigatótio',
            ]
        );

        if ($serviceLetter->update($validateData)) {
            $pdf = $this->pdfGenerate($serviceLetter);
            $serviceLetter->categories()->delete();
            $serviceLetter->categories()->create(['category_id' => $validateData['category_id']]);

            return redirect()->route('serviceLetter.index')->with('success', 'Carta de Serviço atualizada com sucesso!');
        }
        return redirect()->route('serviceLetter.index')->with('error', 'Erro, por favor tente novamente!');
    }

    public function pdfGenerate($serviceLetter)
    {
        if (!empty($serviceLetter->files)) {
            foreach ($serviceLetter->files as $pdf) {
                Storage::disk('public')->delete($pdf->file->url);
                $pdf->delete();
                $pdf->file->delete();
            }
        }

        $settings = Setting::first();
        $logo = File::where('name', 'logo')->first();
        $html = view('pdf.serviceLetter', compact('serviceLetter', 'settings', 'logo'))->render();
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadHTML($html);

        $fileName = 'carta' . '_' . uniqid() . '.pdf';
        $filePath = 'servicos-cartas/' . $fileName;

        // Salvar o PDF no armazenamento (storage)
        Storage::disk('public')->put($filePath, $pdf->output());

        // Armazenar o endereço do PDF no banco de dados
        $newFile = File::create(['name' => $serviceLetter->title, 'description' => 'Carta de Serviço', 'url' => $filePath]);
        $serviceLetter->files()->create(['file_id' => $newFile->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceLetter $serviceLetter)
    {
        if (!empty($serviceLetter->files)) {
            foreach ($serviceLetter->files as $pdf) {
                Storage::disk('public')->delete($pdf->file->url);
                $pdf->delete();
                $pdf->file->delete();
            }
        }
        
        $serviceLetter->categories()->delete();
        if ($serviceLetter->delete()) {
            return redirect()->route('serviceLetter.index')->with('success', 'Carta de Serviço apagada com sucesso!');
        }
        return redirect()->route('serviceLetter.index')->with('error', 'Erro, por favor tente novamente!');
    }
}
