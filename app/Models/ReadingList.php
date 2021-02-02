<?php

namespace App\Models;

use App\Traits\IsOrderable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingList extends Model
{
    use HasFactory, IsOrderable;

    function books()
    {
        return $this->belongsToMany(Book::class)
            ->using(BookReadingList::class)
            ->withTimestamps()
            ->withPivot('id', 'finished_at', 'order');
    }
}
