<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Type;
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

        Category::create([
            'name' => 'CONCORRÊNCIA',
            'parent_id' => 3,
            'slug' => 'concorrencia',
        ]);

        Category::create([
            'name' => 'TOMADA DE PREÇOS',
            'parent_id' => 3,
            'slug' => 'tomada-de-precos',
        ]);

        Category::create([
            'name' => 'CONVITE',
            'parent_id' => 3,
            'slug' => 'convite',
        ]);

        Category::create([
            'name' => 'CONCURSO',
            'parent_id' => 3,
            'slug' => 'concurso',
        ]);

        Category::create([
            'name' => 'LEILÃO',
            'parent_id' => 3,
            'slug' => 'leilao',
        ]);

        Category::create([
            'name' => 'PREGÃO',
            'parent_id' => 3,
            'slug' => 'pregao',
        ]);

        Category::create([
            'name' => 'CHAMADA PÚBLICA',
            'parent_id' => 3,
            'slug' => 'chamada-publica',
        ]);

        Category::create([
            'name' => 'ADESÃO A ATA DE REGISTRO DE PREÇOS',
            'parent_id' => 3,
            'slug' => 'adesao-a-ata-de-registro-de-precos',
        ]);

        # Tipos de licitação

        Type::create([
            'name' => 'INIDONEIDADE',
            'parent_id' => 3,
            'slug' => 'inidoneidade',
        ]);

        Type::create([
            'name' => 'SUSPENSÃO',
            'parent_id' => 3,
            'slug' => 'suspensao',
        ]);

        
    }
}
