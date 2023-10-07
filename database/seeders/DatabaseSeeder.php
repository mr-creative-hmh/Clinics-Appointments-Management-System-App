<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Clinic\Category;
use App\Models\Common\Role;
use Illuminate\Database\Seeder;

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


        // Roles Seed

        Role::factory()->create([
            'name' => 'Admin',
        ]);
        Role::factory()->create([
            'name' => 'Secretary',
        ]);
        Role::factory()->create([
            'name' => 'Doctor',
        ]);
        Role::factory()->create([
            'name' => 'Patient',
        ]);

        //Categories Seed

        Category::factory()->create([
            'name' => 'Ear Noose Throat',
        ]);
        Category::factory()->create([
            'name' => 'Ophthalmology',
        ]);
        Category::factory()->create([
            'name' => ' Gastrology' ,
        ]);
        Category::factory()->create([
            'name' => ' Respiration' ,
        ]);
        Category::factory()->create([
            'name' => ' Endocrine' ,
        ]);
        Category::factory()->create([
            'name' => ' Neurology' ,
        ]);
        Category::factory()->create([
            'name' => ' Genecology' ,
        ]);
        Category::factory()->create([
            'name' => ' Dermatology' ,
        ]);
        Category::factory()->create([
            'name' => ' Nephrology' ,
        ]);
        Category::factory()->create([
            'name' => ' Cardiology' ,
        ]);
        Category::factory()->create([
            'name' => ' Physical Treatment' ,
        ]);
        Category::factory()->create([
            'name' => ' Oncology' ,
        ]);
        Category::factory()->create([
            'name' => ' Psychiatry' ,
        ]);
        Category::factory()->create([
            'name' => ' Urology' ,
        ]);
        Category::factory()->create([
            'name' => ' Dental' ,
        ]);

    }
}
