<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Legislature;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\Video;
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
        // dd($currentLegislature->legislatureRelations[0]->legislatureable);
        
        $posts = Post::with('categories', 'files')->get();
        $videos = Video::with('categories', 'files')->get();
        $banners = Banner::all();

        return view('pages.home.index', compact('services', 'sections', 'posts', 'videos', 'currentLegislature', 'banners'));
    }
}
