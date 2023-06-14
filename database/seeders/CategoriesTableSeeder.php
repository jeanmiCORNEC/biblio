<?php

namespace Database\Seeders;

use App\Models\Category;
use DB;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            Category::create([
                'name' => $faker->word
            ]);
        }
    }
}
