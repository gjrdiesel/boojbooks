<?php

namespace App\Http\Controllers;

use App\Models\ReadingList;
use Illuminate\Http\Request;

/**
 * Class ListController
 * @package App\Http\Controllers
 */
class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user()->readingLists()->withCount('books')->orderBy('order')->paginate();
    }

    /**
     * Display the specified resource.
     *
     * @param ReadingList $list
     * @return array
     */
    public function show(Request $request, ReadingList $list)
    {
        if ($request->user()->cannot('view', $list)) {
            abort(403);
        }

        return [
            'list' => $list,
            'books' => $list->books()->orderByPivot('order')->with('author')->paginate()
        ];
    }

    public function move(Request $request, ReadingList $list)
    {
        dd($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ReadingList $list
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReadingList $list)
    {
        $fields = $request->validate([
            'book_id' => 'integer|exists:books,id',
            'finished' => 'boolean',
            'attach' => 'boolean',
            'detach' => 'boolean',
            'old_order' => 'integer',
            'new_order' => 'integer',
        ]);

        if ($request->user()->cannot('update', $list)) {
            abort(403);
        }

        if ($fields['attach'] ?? false) {
            $list->books()->syncWithoutDetaching($fields['book_id']);
        }

        if ($fields['detach'] ?? false) {
            $list->books()->detach($fields['book_id']);
        }

        if ($fields['finished'] ?? false) {
            $book = $list->books()->find($fields['book_id']);
            $book->pivot->finished_at = now();
            $book->pivot->save();
        }

        if ($fields['old_order'] ?? false) {

            // Move book to new spot
            $old = $list->books()->wherePivot('order', $fields['old_order'])->first();
            $new = $list->books()->wherePivot('order', $fields['new_order'])->first();

            $old->pivot->order = $fields['new_order'];
            $old->pivot->save();

            // Move book in old spot to old spot
            $new->pivot->order = $fields['old_order'];
            $new->pivot->save();
        }
    }
}
