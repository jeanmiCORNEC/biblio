<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Comment;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;


class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        $books = Book::all();
        $users = User::all();

        foreach ($books as $book) {
            foreach ($users as $user) {
                if (rand(0, 1)) { // 50% chance to leave a comment
                    $comment = Comment::create([
                        'user_id' => $user->id,
                        'book_id' => $book->id,
                        'content' => $faker->text(),
                        'title' => $faker->sentence,
                    ]);

                    // 10% chance to leave a reply
                    if (rand(0, 9) == 0) {
                        Comment::create([
                            'user_id' => $user->id,
                            'book_id' => $book->id,
                            'parent_id' => $comment->id,
                            'title' => $faker->sentence,
                            'content' => $faker->text(),
                        ]);
                    }
                }
            }
        }
    }
}
