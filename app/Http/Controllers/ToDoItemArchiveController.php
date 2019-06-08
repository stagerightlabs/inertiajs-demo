<?php

namespace App\Http\Controllers;

use App\ToDoList;
use App\Facades\Hashid;
use Illuminate\Http\Request;

class ToDoItemArchiveController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $hashid
     * @param  string $item
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $hashid, $item)
    {
        $list = ToDoList::findByHashidOrFail($hashid);
        $item = $list->items()->findOrFail(Hashid::decode($item));

        $item->archive();

        return redirect()->route('lists.show', $list->hashid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $hashid
     * @param  string $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($hashid, $item)
    {
        $list = ToDoList::findByHashidOrFail($hashid);
        $item = $list->items()->findOrFail(Hashid::decode($item));

        $item->unarchive();

        return redirect()->route('lists.show', $hashid);
    }
}
