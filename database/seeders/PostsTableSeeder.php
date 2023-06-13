<?php

namespace Database\Seeders;

use App\Models\Post;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 25; $i++) {
            $title = $faker->sentence;
            $slug = Str::replace('\'', ' ', $title);
            Post::create(
                [
                    'title' => $title,
                    'slug' => Str::slug($slug, '_', 'fr'),
                    'sommaire' => $faker->paragraph,
                    'content' => $faker->paragraph,
                    'image' => $faker->imageUrl(),
                    'FAQ' => $faker->paragraph
                ]
            );
        }
    }
}
