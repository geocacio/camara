<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChangeDataRouteLRFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $page = \App\Models\Page::where('name', 'Lei de responsabilidade fiscal')->first();
        if($page) {
            $page->update([
                'route' => 'lrf.page'
            ]);
        }
    }
}
