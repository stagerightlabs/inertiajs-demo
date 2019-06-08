<?php

namespace App;

use App\ToDoList;
use Illuminate\Support\Carbon;
use App\Concerns\HashidAttributes;
use Illuminate\Database\Eloquent\Model;

class ToDoItem extends Model
{
    use HashidAttributes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'completed_at',
        'archived_at'
    ];

    /**
     * The list that owns this item
     *
     * @return void
     */
    public function list()
    {
        return $this->belongsTo(ToDoList::class, 'list_id');
    }

    /**
     * Mark this item as complete
     *
     * @param Carbon|null $timestamp
     * @return void
     */
    public function complete($timestamp = null)
    {
        if (!$timestamp) {
            $timestamp = Carbon::now();
        }

        $this->completed_at = $timestamp;
        $this->save();
    }

    /**
     * Mark this item as incomplete
     *
     * @return void
     */
    public function incomplete()
    {
        $this->completed_at = null;
        $this->save();
    }

    /**
     * Has this item been completed?
     *
     * @return boolean
     */
    public function completed()
    {
        return !is_null($this->completed_at);
    }

    /**
     * Archive this item
     *
     * @param Carbon|null $timestamp
     * @return void
     */
    public function archive($timestamp = null)
    {
        if (!$timestamp) {
            $timestamp = Carbon::now();
        }

        $this->archived_at = $timestamp;
        $this->save();
    }

    /**
     * Remove archive status from this item
     *
     * @return void
     */
    public function unarchive()
    {
        $this->archived_at = null;
        $this->save();
    }

    /**
     * Has this item been archived?
     *
     * @return boolean
     */
    public function archived()
    {
        return !is_null($this->archived_at);
    }
}
