<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
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
        $videos = Video::all();
        return view('panel.videos.index', compact('videos'));
    }

    public function allVideos(Request $request){

        // $page_commission = Page::where('name', 'Comissões')->first();
        $query = Video::query();

        if($request->filled('title')){
            $query->where('title', 'LIKE', '%' . $request->input('title') . '%');
        }
        
        $videos = $query->paginate(10);
        $searchData = $request->only(['title']);
        return view('pages.videos.index', compact('videos', 'searchData'));

        // $videos = Video::all();
        // return view('pages.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('slug', 'videos')->with('children')->get();
        return view('panel.videos.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (empty($request->url) && empty($request->file)) {
            return redirect()->back()->withInput()->withErrors(['name' => 'Pelo menos o vídeo ou o link do vídeo devem ser inseridos.']);
        }

        $validatedData = $request->validate([
            'title' => 'nullable',
            'category' => 'required',
            'description' => 'nullable',
            'duration' => 'nullable',
            'thumbnail' => "nullable|max:{$this->fileUploadService->getMaxSize()}",
            'url' => 'nullable',
            'video_source' => 'required',
            'file' => "nullable|max:{$this->fileUploadService->getMaxSize()}",
        ],[
            'category.required' => 'O campo categoria é obrigatório',
            'video_source.required' => 'O campo vídeo é obrigatório',
            'file.max' => 'Este arquivo é muito grande. O tamanho máximo permitido é :max kilobytes.',
        ]);
        $validatedData['slug'] = Str::slug($request->title);

        if ($request->hasFile('file')) {
            $url = $this->fileUploadService->upload($request->file('file'), 'videos');
            $file = File::create(['url' => $url]);
        }

        $video = Video::create($validatedData);
        if ($video) {
            if ($request->hasFile('file') && $file) {
                $video->files()->create(['file_id' => $file->id]);
            }

            $category = Category::where('id', $request->category)->first();
            if ($category) {
                $video->categories()->create([
                    'category_id' => $category->id,
                ]);
            }

            if ($request->hasFile('thumbnail')) {
                $url = $this->fileUploadService->upload($request->file('thumbnail'), 'videos/thumbnails');
                $thumbnail = File::create(['url' => $url]);
                $video->files()->create(['file_id' => $thumbnail->id]);
            }

            return redirect()->route('videos.index')->with('success', 'Vídeo cadastrado com sucesso!');
        }

        return redirect()->route('videos.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return view('pages.videos.single', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        $categories = Category::where('slug', 'videos')->with('children')->get();
        $myVideo = null;
        $myThumbnail = null;
        foreach ($video->files as $currentFile) {
            $myVideo = in_array(pathinfo($currentFile->file->url, PATHINFO_EXTENSION), ['mp4', 'avi', 'mkv', 'mov', 'wmv', 'mpeg', 'flv']) ? $currentFile : $myVideo;
            $myThumbnail = in_array(pathinfo($currentFile->file->url, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif', 'webp']) ? $currentFile : $myThumbnail;
        }
        return view('panel.videos.edit', compact('video', 'categories', 'myVideo', 'myThumbnail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $validatedData = $request->validate([
            'title' => 'nullable',
            'description' => 'nullable',
            'duration' => 'nullable',
            'thumbnail' => "nullable|max:{$this->fileUploadService->getMaxSize()}",
            'url' => 'nullable',
            'video_source' => 'required',
            'file' => "nullable|max:{$this->fileUploadService->getMaxSize()}",
        ]);

        if (($request->video_source == 'internal')) {
            unset($validatedData['url']);
            if ($request->hasFile('file')) {
                if ($video->files->count() > 0) {
                    foreach ($video->files as $currentFile) {
                        $extension = pathinfo($currentFile->file->url, PATHINFO_EXTENSION);
                        $videoExtensions = ['mp4', 'avi', 'mkv', 'mov', 'wmv', 'mpeg', 'flv'];
                        $imageExtensions = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
                        if (in_array($extension, $videoExtensions)) {
                            Storage::delete('public/' . $currentFile->file->url);
                            $this->fileUploadService->deleteFile($currentFile->file->id);
                        }
                    }
                }
                $url = $this->fileUploadService->upload($request->file('file'), 'videos');
                $file = File::create(['url' => $url]);
                $video->files()->create(['file_id' => $file->id]);
            }

            if ($request->hasFile('thumbnail')) {
                if ($video->files->count() > 0) {
                    foreach ($video->files as $currentFile) {
                        $extension = pathinfo($currentFile->file->url, PATHINFO_EXTENSION);
                        $imageExtensions = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
                        if (in_array($extension, $imageExtensions)) {
                            Storage::delete('public/' . $currentFile->file->url);
                            $this->fileUploadService->deleteFile($currentFile->file->id);
                        }
                    }
                }
                $url = $this->fileUploadService->upload($request->file('thumbnail'), 'videos/thumbnails');
                $thumbnail = File::create(['url' => $url]);
                $video->files()->create(['file_id' => $thumbnail->id]);
            }
        } else {
            if ($video->files->count() > 0) {
                foreach ($video->files as $currentFile) {
                    Storage::delete('public/' . $currentFile->file->url);
                    $this->fileUploadService->deleteFile($currentFile->file->id);
                }
            }
        }

        $video->categories()->delete();
        $category = Category::where('id', $request->category)->first();
        if ($category) {
            $video->categories()->create([
                'category_id' => $category->id,
            ]);
        }

        if ($video->update($validatedData)) {

            return redirect()->route('videos.index')->with('success', 'Vídeo atualizado com sucesso!');
        }

        return redirect()->route('videos.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        if ($video->files->count() > 0) {
            $this->fileUploadService->deleteFile($video->files[0]->file->id);
        }

        $video->categories()->delete();
        $video->delete();

        return redirect()->route('videos.index')->with('success', 'Secretaria excluído com sucesso!');
    }
}
