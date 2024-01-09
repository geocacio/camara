<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\File;
use App\Models\Link;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();
        return view('panel.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $links = Link::where('visibility', 'enabled')->get();
        return view('panel.banners.create', compact('links'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'link_id' => 'nullable',
            'type' => 'nullable',
            'external_url' => 'nullable',
            'color' => 'nullable',
            'image' => "nullable|image|mimes:jpeg,png,jpg,gif|max:{$this->fileUploadService->getMaxSize()}",
        ],
        [
            'image.max' => "O campo imagem do perfil não pode ter mais de {$this->fileUploadService->getMaxSize()} bytes.",
        ]);
        $validateData['color'] = $request->with_color == 'sim' ? $validateData['color'] : 'none';
        //Esta linha aqui é por que eu não posso trocar os campo
        $validateData['type'] = $validateData['type'] == 'externo' ? 'link' : $validateData['type'];

        $banner = Banner::create($validateData);

        if($banner){
            if ($request->hasFile('image')) {
                $url = $this->fileUploadService->upload($request->file('image'), 'banners');
                $file = File::create(['url' => $url]);
                $banner->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('banners.index')->with('success', 'Banner cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        $links = Link::where('visibility', 'enabled')->get();
        return view('panel.banners.edit', compact('banner', 'links'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $validateData = $request->validate([
            'link_id' => 'nullable',
            'external_url' => 'nullable',
            'type' => 'nullable',
            'color' => 'nullable',
            'image' => "nullable|image|mimes:jpeg,png,jpg,gif|max:{$this->fileUploadService->getMaxSize()}",
        ],
        [
            'image.max' => "O campo imagem do perfil não pode ter mais de {$this->fileUploadService->getMaxSize()} bytes.",
        ]);
        $validateData['color'] = $request->with_color == 'sim' ? $validateData['color'] : 'none';
        //Esta linha aqui é por que eu não posso trocar os campo
        $validateData['type'] = $validateData['type'] == 'externo' ? 'link' : $validateData['type'];

        if($banner->update($validateData)){
            if ($request->hasFile('image')) {
                $url = $this->fileUploadService->upload($request->file('image'), 'banners');
                $file = File::create(['url' => $url]);
                $banner->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('banners.index')->with('success', 'Banner atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {        
        if ($banner->files->count() > 0) {
            Storage::disk('public')->delete($banner->files[0]->file->url);
        }

        if ($banner->delete()) {
            return redirect()->back()->with('success', 'Banner removido com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro ao remover Banner, Por favor tente novamente!');
    }
}
