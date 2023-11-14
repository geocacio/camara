<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Page;
use App\Models\Setting;
use App\Models\TransparencyGroup;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function page()
    {
        $page_setting = Page::where('name', 'A Câmara')->first();
        $groups = TransparencyGroup::all();
        return view('panel.settings.page.edit', compact('page_setting', 'groups'));
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

        $page_setting = Page::where('name', 'A Câmara')->first();

        if ($page_setting->update($validateData)) {
            $page_setting->groupContents()->delete();
            $page_setting->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('settings.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('settings.page')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::first();
        if ($settings) {
            $logo = '';
            $favicon = '';
            $logo_footer = '';
            
            if ($settings->files->count() > 0) {
                foreach ($settings->files as $files) {
                    if ($files->file->name == 'Logo') {
                        $logo = $files->file;
                    }
                    if ($files->file->name == 'Favicon') {
                        $favicon = $files->file;
                    }
                    if ($files->file->name == 'Logo Footer') {
                        $logo_footer = $files->file;
                    }
                }
            }
            return view('panel.settings.edit', compact('settings', 'logo', 'favicon', 'logo_footer'));
        }

        return view('panel.settings.create');
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
        $validatedData = $request->validate([
            'system_name' => 'required',
            'plenary' => 'required',
            'phone' => 'required',
            'email' => 'nullable',
            'cnpj' => 'required',
            'cep' => 'required',
            'address' => 'required',
            'number' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'opening_hours' => 'nullable',
            'state' => 'required',
            'logo' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'logo_footer' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'favicon' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ],[
            'system_name.required' => 'O campo Nome do sistema é obrigatório.',
            'phone.required' => 'O campo Telefone é obrigatório.',
            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'address.required' => 'O campo Endereço é obrigatório.',
            'number.required' => 'O campo Número é obrigatório.',
            'neighborhood.required' => 'O campo Bairro é obrigatório.',
            'city.required' => 'O campo Cidade é obrigatório.',
            'state.required' => 'O campo Estado é obrigatório.',
        ]);

        $settings = Setting::create($validatedData);
        if ($settings) {
            if ($request->hasFile('logo')) {
                $url = $this->fileUploadService->upload($request->file('logo'), 'settings');
                $file = File::create(['name' => 'Logo', 'description' => 'Logo do sistema', 'url' => $url]);
                $settings->files()->create(['file_id' => $file->id]);
            }
            if ($request->hasFile('favicon')) {
                $url = $this->fileUploadService->upload($request->file('favicon'), 'settings');
                $file = File::create(['name' => 'Favicon', 'url' => $url]);
                $settings->files()->create(['file_id' => $file->id]);
            }
            if ($request->hasFile('logo_footer')) {
                $url = $this->fileUploadService->upload($request->file('logo_footer'), 'settings');
                $file = File::create(['name' => 'Logo Footer', 'url' => $url]);
                $settings->files()->create(['file_id' => $file->id]);
            }
            return redirect()->route('settings.index')->with('success', 'Configurações cadastradas com sucesso!');
        }
        return redirect()->route('settings.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        
        $validatedData = $request->validate([
            'system_name' => 'required',
            'phone' => 'required',
            'cnpj' => 'required',
            'cep' => 'required',
            'address' => 'required',
            'number' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required',
            'logo' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'logo_footer' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'favicon' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ],[
            'system_name.required' => 'O campo Nome do sistema é obrigatório.',
            'phone.required' => 'O campo Telefone é obrigatório.',
            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'address.required' => 'O campo Endereço é obrigatório.',
            'number.required' => 'O campo Número é obrigatório.',
            'neighborhood.required' => 'O campo Bairro é obrigatório.',
            'city.required' => 'O campo Cidade é obrigatório.',
            'state.required' => 'O campo Estado é obrigatório.',
        ]);

        if ($setting->update($validatedData)) {
            if ($request->hasFile('logo')) {

                foreach ($setting->files as $fileRelation) {
                    if ($fileRelation->file->name === 'Logo') {
                        $this->fileUploadService->deleteFile($fileRelation->file->id);
                        break;
                    }
                }

                $url = $this->fileUploadService->upload($request->file('logo'), 'settings');
                $file = File::create(['name' => 'Logo', 'description' => 'Logo do sistema', 'url' => $url]);
                $setting->files()->create(['file_id' => $file->id]);
            }
            if ($request->hasFile('favicon')) {
                foreach ($setting->files as $fileRelation) {
                    if ($fileRelation->file->name === 'Favicon') {
                        $this->fileUploadService->deleteFile($fileRelation->file->id);
                        break;
                    }
                }
                $url = $this->fileUploadService->upload($request->file('favicon'), 'settings');
                $file = File::create(['name' => 'Favicon', 'url' => $url]);
                $setting->files()->create(['file_id' => $file->id]);
            }
            if ($request->hasFile('logo_footer')) {
                foreach ($setting->files as $fileRelation) {
                    if ($fileRelation->file->name === 'logo_footer') {
                        $this->fileUploadService->deleteFile($fileRelation->file->id);
                        break;
                    }
                }
                $url = $this->fileUploadService->upload($request->file('logo_footer'), 'settings');
                $file = File::create(['name' => 'Logo Footer', 'url' => $url]);
                $setting->files()->create(['file_id' => $file->id]);
            }
            return redirect()->route('settings.index')->with('success', 'Configurações atualizadas com sucesso!');
        }
        return redirect()->route('settings.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
