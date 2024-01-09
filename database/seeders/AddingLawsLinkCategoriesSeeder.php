<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Link;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddingLawsLinkCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::where('name', 'Leis')->with('children')->first();
        if ($categories) {
            foreach ($categories->children as $category) {
                Link::firstOrCreate([
                    'name' => $category->name,
                    'route' => 'leis.category',
                    'slug' => Str::slug($category->name)
                ]);
            }
        }
    }
}
