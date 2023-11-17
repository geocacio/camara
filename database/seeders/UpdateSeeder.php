<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $expedients = Category::create([
            'name' => 'Expedientes',
            'slug' => Str::slug('Expedientes')
        ]);
        $expedientes = ['Ordem do dia', 'Pequeno expediente', 'Grande expediente'];
        foreach ($expedientes as $item) {
            Category::create([
                'name' => $item,
                'parent_id' => $expedients->id,
                'slug' => Str::slug($item)
            ]);
        }
    }
}
