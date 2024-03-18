<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\Category;
use App\Models\File;
use App\Models\RegisterPrice;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterPriceController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function formatSize($bytes)
    {
        $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = intval(floor(log($bytes, 1024)));
        return round($bytes / (1024 ** $i), 2) . ' ' . $sizes[$i];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $atas = RegisterPrice::all();

        return view('panel.register-price.index', compact('atas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $biddings = Bidding::with('company')->get();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();

        return view('panel.register-price.create', compact('biddings', 'exercicies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'signature_date' => 'required|string',
            'expiry_date' => 'required|string',
            'bidding_process' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'exercicio_id' => 'required',
        ], [
            'signature_date.required' => 'O campo data de assinatura é obrigatório.',
            'signature_date.date' => 'O campo data de assinatura deve ser uma data válida.',
            'expiry_date.required' => 'O campo data de expiração é obrigatório.',
            'expiry_date.date' => 'O campo data de expiração deve ser uma data válida.',
            'bidding_process.required' => 'O campo processo de licitação é obrigatório.',
            'company_id.required' => 'O campo empresa é obrigatório.',
            'exercicio_id.required' => 'O campo exercicio é obrigatório.',
            // 'company_id.exists' => 'A empresa selecionada não existe.',
        ]);

        if($request->bidding_process != ''){
            $bidding = Bidding::find($request->bidding_process);

            $validatedData['title'] = $bidding->number . ' ARP/' . $request->exercice;
            $validatedData['title'] = $bidding->number . ' ARP/' . $request->exercice;
        }

        $validatedData['slug'] = Str::slug('ata' . $validatedData['title']);

        if($register_price = RegisterPrice::create($validatedData)){

            if ($request->hasFile('file')) {

                $file = $request->file;
                $url = $this->fileUploadService->upload($file, 'atas');
                $name = ucwords(str_replace('-', ' ', $validatedData['title']));
                $size = $this->formatSize($file->getSize());
                $format = $file->getClientOriginalExtension();
                $newFile = File::create(['name' => $name, 'url' => $url, 'size' => $size, 'format' => $format]);
                $register_price->files()->create(['file_id' => $newFile->id]);
            }

            return redirect()->route('register-price.index')->with('success', 'Ata de Registro atualizada com sucesso!');
        }

        return redirect()->route('register-price.index')->with('error', 'Erro ao tentar atualizar ATA!');
    }

    /**
     * Display the specified resource.
     */
    public function show(RegisterPrice $register_price)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegisterPrice $register_price)
    {
        $biddings = Bidding::all();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();

        return view('panel.register-price.edit', compact('register_price', 'biddings', 'exercicies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegisterPrice $register_price)
    {
        $validatedData = $request->validate([
            'signature_date' => 'required',
            'expiry_date' => 'required',
            'bidding_process' => 'required|string',
            'company_id' => 'required|exists:companies,id',
        ], [
            'signature_date.required' => 'O campo data de assinatura é obrigatório.',
            'signature_date.date' => 'O campo data de assinatura deve ser uma data válida.',
            'expiry_date.required' => 'O campo data de expiração é obrigatório.',
            'expiry_date.date' => 'O campo data de expiração deve ser uma data válida.',
            'bidding_process.required' => 'O campo processo de licitação é obrigatório.',
            'company_id.required' => 'O campo ID da empresa é obrigatório.',
            'company_id.exists' => 'A empresa selecionada não existe.',
        ]);

        if($request->bidding_process != ''){
            $bidding = Bidding::find($request->bidding_process);

            $validatedData['title'] = $bidding->number . ' ARP/' . $request->exercice;
        }

        $validatedData['slug'] = Str::slug('ata' . $validatedData['title']);

        if($register_price->update($validatedData)){

            if ($request->hasFile('file')) {
                // Verificar se há um arquivo antigo associado
                if ($register_price->files) {
                    // Remover o arquivo antigo e a associação
                    $oldFile = $register_price->files->file;
                    Storage::disk('public')->delete($oldFile->url);
                    $oldFile->delete();
                }
            
                $file = $request->file('file');
                $url = $this->fileUploadService->upload($file, 'atas');
                $name = ucwords(str_replace('-', ' ', $validatedData['title']));
                $size = $this->formatSize($file->getSize());
                $format = $file->getClientOriginalExtension();
            
                $newFile = File::create(['name' => $name, 'url' => $url, 'size' => $size, 'format' => $format]);
            
                $register_price->files()->create(['file_id' => $newFile->id]);
            }

            return redirect()->route('register-price.index')->with('success', 'Ata de Registro atualizada com sucesso!');
        }
        
        return redirect()->route('register-price.index')->with('error', 'Erro ao tentar atualizar ATA!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegisterPrice $register_price)
    {
        if( $register_price->delete()){
            return redirect()->route('register-price.index')->with('success', 'Ata de Registro excluida com sucesso!');
        }
    
        return redirect()->route('register-price.index')->with('error', 'Erro ao tentar excluir ATA!');
    }
}
