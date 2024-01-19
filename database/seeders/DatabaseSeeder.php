<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Symfony\Component\Process\Process;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(SiteContentSeeder::class);
        $this->call(GenerateStyleSCSSSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TransparencySeeder::class);
        $this->call(OfficialDiarySeeder::class);
        $this->call(PageNormativeSeeder::class);
        $this->call(PublicationsSeeders::class);
        $this->call(VehicleSeeder::class);
        $this->call(TraineePageSeeder::class);
        $this->call(AddingCategoryLawSeeder::class);
        $this->call(LaiPageSeeder::class);
    }
}
