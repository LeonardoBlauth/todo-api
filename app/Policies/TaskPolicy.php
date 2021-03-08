<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Task;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(?User $user, ?Task $task = null) {
        return Task::where('completed', false)->count() < 5;
    }

    public function update(?User $user, ?Task $task = null) {
        return $task->completed == false;
    }

    public function toogle(?User $user, ?Task $task) {
        return true;
    }

    public function destroy(?User $user, ?Task $task = null) {
        return $task->completed == true;
    }
}
