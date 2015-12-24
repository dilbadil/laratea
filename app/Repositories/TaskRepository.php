<?php 

namespace App\Repositories;

use App\User;
use App\Task;

class TaskRepository
{
    /**
     * @var Task
     */
    protected $task;

    /**
     * Instance new repository.
     *
     * @param Task
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get all of the tasks for a given user.
     *
     * @param User $user
     * @return \Collection
     */
    public function forUser(User $user)
    {
        return $this->task->where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
