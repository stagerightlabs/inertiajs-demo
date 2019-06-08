<?php

namespace App;

use App\Events\DeletingList;
use App\Concerns\HashidAttributes;
use Illuminate\Database\Eloquent\Model;

class ToDoList extends Model
{
    use HashidAttributes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(ToDoItem::class, 'list_id');
    }

    /**
     * Add a new item to this list
     *
     * @return ToDoItem
     */
    public function addItem($description)
    {
        return $this->items()->create(['description' => $description]);
    }

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'deleting' => DeletingList::class,
    ];
}
