<?php

namespace Database\Seeders;

use App\Models\LoginScreen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoginScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LoginScreen::create([
            'background' => '#d9d9d9',
            'card_color' => '#ffffff',
            'button_color' => '#1c3992',
            'button_hover' => '#0d256e',
            'card_position' => 'center',
            'modal' => 1,
            'style_modal' => 'solid',
            'show_logo' => '0',
        ]);
    }
}
