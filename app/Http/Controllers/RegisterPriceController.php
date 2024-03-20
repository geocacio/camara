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
    public function create($licitacao)
    {
        $bidding = Bidding::where('slug', $licitacao)->first();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();

        return view('panel.register-price.create', compact('bidding', 'exercicies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $biddings)
    {
        $bidding = Bidding::where('slug', $biddings)->first();

        if(!$bidding){
            return redirect()->back()->with('error', 'Licitação não encontrada!');
        }

        $validatedData = $request->validate([
            'signature_date' => 'required|string',
            'expiry_date' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'exercicio_id' => 'required',
            'object' => 'required',
        ], [
            'signature_date.required' => 'O campo data de assinatura é obrigatório.',
            'signature_date.date' => 'O campo data de assinatura deve ser uma data válida.',
            'expiry_date.required' => 'O campo data de expiração é obrigatório.',
            'expiry_date.date' => 'O campo data de expiração deve ser uma data válida.',
            'company_id.required' => 'O campo empresa é obrigatório.',
            'exercicio_id.required' => 'O campo exercicio é obrigatório.',
            'object.required' => 'O campo objeto é obrigatório.',
        ]);

        $exercice = Category::where('id', $request->exercicio_id)->first();

        if($bidding){
            $validatedData['title'] = $bidding->number . ' ARP/' . $exercice->name;
            $validatedData['slug'] = RegisterPrice::uniqSlug($validatedData['title']);

            $validatedData['bidding_process'] = $bidding->id;
        }

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
    public function show($register_price)
    {
        $registerPrice = RegisterPrice::where('slug', $register_price)->first();
        return view('pages.biddings.price-registration.show', compact('registerPrice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegisterPrice $register_price)
    {
        $bidding = Bidding::where('id', $register_price->bidding_process)->first();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();

        return view('panel.register-price.edit', compact('register_price', 'bidding', 'exercicies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegisterPrice $register_price)
    {
        $bidding = Bidding::where('id', $register_price->bidding_process)->first();

        $validatedData = $request->validate([
            'signature_date' => 'required',
            'expiry_date' => 'required',
            'company_id' => 'required|exists:companies,id',
            'object' => 'required',
        ], [
            'signature_date.required' => 'O campo data de assinatura é obrigatório.',
            'signature_date.date' => 'O campo data de assinatura deve ser uma data válida.',
            'expiry_date.required' => 'O campo data de expiração é obrigatório.',
            'expiry_date.date' => 'O campo data de expiração deve ser uma data válida.',
            'company_id.required' => 'O campo ID da empresa é obrigatório.',
            'object.required' => 'O campo objeto é obrigatório.',
            'company_id.exists' => 'A empresa selecionada não existe.',
        ]);

        $exercice = Category::where('id', $request->exercicio_id)->first();

        if($bidding){
            $validatedData['title'] = $bidding->number . ' ARP/' . $exercice->name;
        }

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
