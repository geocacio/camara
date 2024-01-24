<?php

namespace Database\Seeders;

use App\Models\TransparencyGroup;
use App\Models\TransparencyPortal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AtriconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transparencyPortal = TransparencyPortal::first();

        TransparencyGroup::create([
            'transparency_id' => $transparencyPortal->id,
            'title' => 'Atricon',
            'description' => 'Radar Nacional da Transparência Pública',
            'slug' => Str::slug('Portal da Transparência')
        ]);

    }
}
