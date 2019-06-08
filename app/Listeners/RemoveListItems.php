<?php

namespace App\Listeners;

use App\Events\DeletingList;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveListItems
{
    /**
     * Handle the event.
     *
     * @param  DeletingList  $event
     * @return void
     */
    public function handle(DeletingList $event)
    {
        $event->todoList->items()->delete();
    }
}
