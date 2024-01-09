<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddingCategoryLawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::create([
            'name' => 'Leis',
            'slug' => Str::slug('Leis'),
        ]);

        Category::create([
            'name' => 'Lei orgânica',
            'parent_id' => $category->id,
            'slug' => Str::slug('Lei orgânica'),
        ]);

        Category::create([
            'name' => 'Regime interno',
            'parent_id' => $category->id,
            'slug' => Str::slug('Regime interno'),
        ]);
    }
}
