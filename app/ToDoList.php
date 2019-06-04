<?php

namespace App;

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
}
