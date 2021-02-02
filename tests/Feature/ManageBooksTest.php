<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageBooksTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_remove_book()
    {
        // Easier to get test feedback
        $this->withoutExceptionHandling();

        $user = $this->setupSingleUser();

        $this->actingAs($user);

        $list = $user->readingLists()->first();

        // Assert we're starting in the right state
        $this->assertEquals(0, $list->books()->where('finished_at', '!=', null)->count());

        $book = $this->setupSingleBook();

        // Add the book to this list
        $this->patchJson("/api/list/{$list->id}", [
            'book_id' => $book->id,
            'attach' => true,
            'finished' => true,
        ])->assertOk();

        // Make sure we can't add it twice
        $this->patchJson("/api/list/{$list->id}", [
            'book_id' => $book->id,
            'attach' => true,
            'finished' => true,
        ])->assertOk();

        // Assertion to check there is truly only 1
        $this->assertEquals(1, $list->books()->where('finished_at', '!=', null)->count());

        // Remove the book
        $this->patchJson("/api/list/{$list->id}", [
            'book_id' => $book->id,
            'detach' => true,
        ])->assertOk();

        // Assert it's removed
        $this->assertEquals(0, $list->books()->where('finished_at', '!=', null)->count());
    }

    public function test_reorder_books()
    {
        $this->withoutExceptionHandling();

        $user = $this->setupSingleUser();

        $this->actingAs($user);

        $list = $user->readingLists()->first();

        $list->books()->attach([
            $id = $this->setupSingleBook(['title' => 'Test 1'])->id,
            $this->setupSingleBook(['title' => 'Test 2'])->id,
            $this->setupSingleBook(['title' => 'Test 3'])->id,
        ]);

        // Grab the titles from the paginated results
        $titles = collect(($this->getJson("/api/list/{$list->id}")->json('books.data')))->pluck('title');

        $this->assertEquals([
            'Test 1',
            'Test 2',
            'Test 3',
        ], $titles->toArray());

        // Update the order
        $this->patchJson("/api/list/{$list->id}", [
            'book_id' => $id,
            'order' => 99,
        ])->assertOk();

        // Verify the new order moved $book_1 to the end
        $titles = collect($this->getJson("/api/list/{$list->id}")->json('books.data'))->pluck('title');
        $this->assertEquals([
            'Test 2',
            'Test 3',
            'Test 1',
        ], $titles->toArray());
    }
}
