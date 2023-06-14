<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\PaperLink;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PaperLinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        $books = Book::all();

        foreach ($books as $book) {
            for ($i = 0; $i < rand(1, 5); $i++) { // create between 1 and 5 links for each book
                PaperLink::create([
                    'book_id' => $book->id,
                    'link' => $faker->url,
                ]);
            }
        }
    }
}
