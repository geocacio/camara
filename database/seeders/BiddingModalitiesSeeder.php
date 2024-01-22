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
        Category::firstOrCreate([
            'name' => 'DISPENSA',
            'parent_id' => 3,
            'slug' => 'dispensa',
        ]);

        Category::firstOrCreate([
            'name' => 'INEXIGIBILIDADE',
            'parent_id' => 3,
            'slug' => 'inexigibilidade',
        ]);

        // Category::firstOrCreate([
        //     'name' => 'CONCORRÊNCIA',
        //     'parent_id' => 3,
        //     'slug' => 'concorrencia',
        // ]);

        Category::firstOrCreate([
            'name' => 'TOMADA DE PREÇOS',
            'parent_id' => 3,
            'slug' => 'tomada-de-precos',
        ]);

        Category::firstOrCreate([
            'name' => 'CONVITE',
            'parent_id' => 3,
            'slug' => 'convite',
        ]);

        Category::firstOrCreate([
            'name' => 'CONCURSO',
            'parent_id' => 3,
            'slug' => 'concurso',
        ]);

        Category::firstOrCreate([
            'name' => 'LEILÃO',
            'parent_id' => 3,
            'slug' => 'leilao',
        ]);

        Category::firstOrCreate([
            'name' => 'PREGÃO',
            'parent_id' => 3,
            'slug' => 'pregao',
        ]);

        Category::firstOrCreate([
            'name' => 'CHAMADA PÚBLICA',
            'parent_id' => 3,
            'slug' => 'chamada-publica',
        ]);

        Category::firstOrCreate([
            'name' => 'ADESÃO A ATA DE REGISTRO DE PREÇOS',
            'parent_id' => 3,
            'slug' => 'adesao-a-ata-de-registro-de-precos',
        ]);

        # Tipos de licitação

        Type::firstOrCreate([
            'name' => 'INIDONEIDADE',
            'parent_id' => 3,
            'slug' => 'inidoneidade',
        ]);

        Type::firstOrCreate([
            'name' => 'SUSPENSÃO',
            'parent_id' => 3,
            'slug' => 'suspensao',
        ]);

    }
}
