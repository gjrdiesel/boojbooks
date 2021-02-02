<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\ReadingList;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private Collection $books;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Author::factory(30)->create()->each(function ($author) {
            Book::factory(10)->create(['author_id' => $author->id]);
        });

        $users = User::factory(5)->create();

        $users[] = User::factory()->create([
            'email' => 'demo@demo.com',
            'password' => bcrypt('password123')
        ]);

        $users->each(function ($user) {
            ReadingList::factory(6)->create(['user_id' => $user->id])->each(function ($list) {

                // Attach random amount of books to this list
                $list->books()->attach(
                    Book::all()->random()->pluck('id')
                );


            });
        });
    }
}
