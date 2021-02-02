<?php

namespace App\Models;

use App\Traits\IsOrderable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookReadingList extends Pivot
{
    use IsOrderable;
}
