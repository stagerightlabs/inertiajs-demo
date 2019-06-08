<?php

namespace App\Events;

use App\ToDoList;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class DeletingList
{
    use Dispatchable, SerializesModels;

    /**
     * @var ToDoList
     */
    public $todoList;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ToDoList $todoList)
    {
        $this->todoList = $todoList;
    }
}
