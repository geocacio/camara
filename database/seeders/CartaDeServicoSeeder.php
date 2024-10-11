<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CartaDeServicoSeeder extends Seeder
{
    public function run()
    {
        
        $mainCategory = Category::firstOrCreate([
            'name' => 'Carta de serviços ao cidadão',
            'slug' => Str::slug('Carta de serviços ao cidadão'),
            'parent_id' => null, 
        ]);

        
        $subcategories = [
            'COMUNICAÇÃO',
            'INSTITUCIONAL',
            'LRF',
            'TRANSPARÊNCIA',
            'LAI',
            'MUNICIPAL',
            'SERVIÇOS',
        ];

        foreach ($subcategories as $subcategory) {
            Category::firstOrCreate([
                'name' => $subcategory,
                'slug' => Str::slug($subcategory),
                'parent_id' => $mainCategory->id, 
            ]);
        }
    }
}
