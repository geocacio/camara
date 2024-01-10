<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BiddingModalitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Category::create([
            'name' => 'DISPENSA',
            'parent_id' => 3,
            'slug' => 'dispensa',
        ]);

        Category::create([
            'name' => 'INEXIGIBILIDADE',
            'parent_id' => 3,
            'slug' => 'inexigibilidade',
        ]);
        
    }
}
