<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TypesSeeder::class);
        $this->call(ColorsSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(ColumnTypesSeeder::class);
        $this->call(AlignmentTypesSeeder::class);
        $this->call(ShapesSeeder::class);
        $this->call(InputTypesSeeder::class);
        $this->call(EventCategoriesSeeder::class);
        $this->call(ProjectCategoriesSeeder::class);
        $this->call(ExternalCategoriesSeeder::class);
        $this->call(LogoSeeder::class);
                
    }
}
