<?php

namespace App\Policies;

use App\Models\ReadingList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReadingListPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ReadingList  $readingList
     * @return mixed
     */
    public function view(User $user, ReadingList $readingList)
    {
        return $user->id === $readingList->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ReadingList  $readingList
     * @return mixed
     */
    public function update(User $user, ReadingList $readingList)
    {
        return $user->id === $readingList->user_id;
    }
}
