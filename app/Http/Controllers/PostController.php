<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Image;
use App\Models\Link;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\FileUploadService;

class PostController extends Controller
{
    protected $user;
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $posts = Post::with('users', 'files.file', 'categories')->get();
        // $categories = Category::where('slug', 'posts')->with('children')->get();
        $search = $request->query('search');
        $perPage = $request->query('perPage', 10);
        $query = Post::query();
        if($search){
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        $posts = $query->paginate($perPage)->appends(['search' => $search, 'perPage' => $perPage]);
        return view('panel.posts.index', compact('posts', 'perPage', 'search'));
    }

    public function getPosts(Request $request)
    {
        $page_post = Page::where('name', 'Posts')->first();
        $query = Post::query();

        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($categoryQuery) use ($request) {
                $categoryQuery->where('category_id', $request->input('category_id'));
            });
        }

        if($request->filled('title')){
            $query->where('title', 'LIKE', '%' . $request->input('title') . '%');
        }
        
        $posts = $query->paginate(10);
        $categories = Category::where('slug', 'posts')->first()->children;
        $searchData = $request->only(['title', 'category_id']);
        return view('pages.posts.index', compact( 'posts', 'page_post', 'searchData', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('slug', 'posts')->first()->children;
        return view('panel.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'nullable',
            'content' => 'required',
        ],[
            'title.required' => 'O campo título é obrigatório',
            'category.required' => 'O campo categoria é obrigatório',
            'content.required' => 'O campo conteúdo é obrigatório',
        ]);
        $validatedData['content'] = str_replace('<img src="../../images/', '<img src="/images/', $validatedData['content']);

        $validatedData['user_id'] = $this->user->id;
        $validatedData['slug'] = Str::slug($request->title);

        $post = Post::create($validatedData);
        if ($post) {

            $category = Category::find($request->category);
            if ($category) {
                $post->categories()->create([
                    'category_id' => $category->id,
                ]);
            }

            $childCategory = Category::find($request->child_category);
            if ($childCategory) {
                $post->categories()->create([
                    'category_id' => $childCategory->id,
                ]);
            }

            Link::create([
                'name' => $post->title,
                'target_id' => $post->id,
                'target_type' => 'post',
                'slug' => Str::slug($post->title)
            ]);

            if ($request->hasFile('featured_image')) {
                $url = $this->fileUploadService->upload($request->file('featured_image'), 'files/posts');
                $file = File::create(['url' => $url]);
                $post->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('posts.index')->with('success', 'Post criado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro, por favor tente novamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

        $post->update(['views' => ($post->views + 1)]);
        $image = !$post->files->isEmpty() ? $post->files[0]->file : [];
        $generalPosts['mostViewedPosts'] = Post::orderByDesc('views')->take(4)->get();
        $generalPosts['recentsPosts'] = Post::orderByDesc('created_at')->take(4)->get();
        $generalPosts['categories'] = Category::where('slug', 'posts')
        ->with(['children' => function ($query) {
            $query->withCount(['categoryContents as post_count' => function ($q) {
                $q->where('categoryable_type', 'post');
            }]);
        }])
        ->first()
        ->children;

        return view('pages.posts.single', compact('post', 'image', 'generalPosts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $files = $post->files;
        $category = $post->categories[0]->category;
        $categories = Category::where('slug', 'posts')->first()->children;
        return view('panel.posts.edit', compact('post', 'categories', 'category', 'files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'nullable',
            'content' => 'required',
        ],[
            'title.required' => 'O campo título é obrigatório',
            'category.required' => 'O campo categoria é obrigatório',
            'content.required' => 'O campo conteúdo é obrigatório',
        ]);

        $validatedData['content'] = str_replace('<img src="../../images/', '<img src="/images/', $validatedData['content']);

        if ($request->hasFile('featured_image')) {
            $files = $post->files;
            if ($files->count() > 0) {
                Storage::delete('public/' . $files[0]->file->url);
                $this->fileUploadService->deleteFile($files[0]->file->id);
            }

            $url = $this->fileUploadService->upload($request->file('featured_image'), 'files/posts');
            $file = File::create(['url' => $url]);
            $post->files()->create(['file_id' => $file->id]);
        }

        if (!$post->update($validatedData)) {
            return redirect()->route('posts.index')->with('error', 'Por favor tente novamente');
        }

        $post->categories()->delete();

        $category = Category::find($request->category);
        if ($category) {
            $post->categories()->create([
                'category_id' => $category->id,
            ]);
        }

        return redirect()->route('posts.index')->with('success', 'Post atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $menus = $post->links[0]->menus;
        if ($menus) {
            foreach ($menus as $menu) {
                $menu->links()->detach($post->links[0]->id);
            }
        }
        $post->links()->delete();
        $post->categories()->delete();

        if ($post->files->count() > 0) {
            $this->fileUploadService->deleteFile($post->files[0]->file->id);
        }

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post removido com sucesso!');
    }
}
