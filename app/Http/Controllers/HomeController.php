<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\CategoriesPostsHighlighted;
use App\Models\Category;
use App\Models\CategoryContent;
use App\Models\Law;
use App\Models\Legislature;
use App\Models\LRF;
use App\Models\Maintenance;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $services = Service::all();
        $page = Page::where('name', 'Home')->with(['sections' => function ($query) {
            $query->orderBy('position');
        }, 'sections.styles'])->first();

        $sections = [];
        if ($page !== null) {
            foreach ($page->sections as $section) {
                $sections[$section->component] = $section;
            }
        }

        $legislature = new Legislature;
        $currentLegislature = $legislature->getCurrentLegislature();

        $getCategoryFilter = CategoriesPostsHighlighted::pluck('category_id');

        $categories = Category::whereIn('id', $getCategoryFilter)->get();

        $numberOfCategoryIDPerFilter = 3;

        $selectedCategoryIDs = [];

        foreach ($getCategoryFilter as $filter) {
            $categoryIDs = CategoryContent::where('category_id', $filter)
                ->limit($numberOfCategoryIDPerFilter)
                ->pluck('category_id');

            $selectedCategoryIDs = array_merge($selectedCategoryIDs, $categoryIDs->toArray());
        }

       // Obter os 3 posts mais recentes independentemente da categoria
        $recentPostsGeral = Post::with('categories', 'files')
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();

        // Inicializar o array $postsPorCategoria
        $postsPorCategoria = [];

        // Adicionar os 3 posts mais recentes no geral ao array
        $postsPorCategoria[0] = $recentPostsGeral;

        // Adicionar os 3 posts mais recentes para cada categoria
        foreach ($selectedCategoryIDs as $categoriaID) {
            // Obter os 3 posts mais recentes para cada categoria
            $postsPorCategoria[$categoriaID] = Post::with('categories', 'files')
                ->whereHas('categories', function ($query) use ($categoriaID) {
                    $query->where('category_id', $categoriaID);
                })
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
        }

        // Certifique-se de limitar o array combinado para 3 elementos, se necessário
        foreach ($postsPorCategoria as &$posts) {
            $posts = $posts->take(3);
        }

        // old
        $videos = Video::with('categories', 'files')->limit('2')->get();
        $banners = Banner::all();
        $leis = Law::limit('3')->get();
        $lrfs = LRF::limit('3')->get();
        $today = Carbon::today();

        return view('pages.home.index', compact('services', 'sections', 'videos', 'currentLegislature', 'banners', 'leis', 'lrfs', 'postsPorCategoria', 'getCategoryFilter', 'categories'));
    }
    
}
