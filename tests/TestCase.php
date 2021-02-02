<?php

namespace Tests;

use App\Models\Author;
use App\Models\Book;
use App\Models\ReadingList;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    function setupSingleUser(): User
    {
        $user = User::factory()->create();
        ReadingList::factory()->create(['user_id' => $user->id]);

        return $user;
    }

    function setupSingleBook($book = [])
    {
        $author = Author::factory()->create();
        return Book::factory()->create(array_merge(['author_id' => $author->id], $book));
    }
}
