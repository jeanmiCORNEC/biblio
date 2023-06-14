<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Faker\Factory as Faker;
use App\Models\BookCategories;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtenez tous les livres et toutes les catégories
        $books = Book::all();
        $categories = Category::all();

        // pour chaque livre, on a 90% de chance qu'il ait une catégorie
        foreach ($books as $book) {
            if (rand(1, 100) <= 90) {
                // on récupère une catégorie au hasard
                $category = $categories->random();

                // on vérifie que le livre n'a pas déjà cette catégorie
                $bookCategory = BookCategories::where('book_id', $book->id)
                    ->where('category_id', $category->id)
                    ->first();

                // si le livre n'a pas déjà cette catégorie, on l'ajoute
                if (!$bookCategory) {
                    BookCategories::create([
                        'book_id' => $book->id,
                        'category_id' => $category->id,
                    ]);
                }
            }
        }
    }
}
