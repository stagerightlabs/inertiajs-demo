<?php

namespace App\Http\Controllers;

use App\ToDoList;
use App\Facades\Hashid;
use Illuminate\Http\Request;

class ToDoItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $hashid
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $hashid)
    {
        $request->validate([
            'description' => 'required'
        ]);

        $list = ToDoList::findByHashidOrFail($hashid);

        $list->addItem($request->input('description'));

        return redirect()->route('lists.show', $list->hashid);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $hashid
     * @param  string $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $hashid, $item)
    {
        $request->validate([
            'description' => 'required'
        ]);

        $list = ToDoList::findByHashidOrFail($hashid);
        $item = $list->items()->findOrFail(Hashid::decode($item));

        $item->description = $request->input('description');
        $item->save();

        return redirect()->route('lists.show', $hashid);
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

        $item->delete();

        return redirect()->route('lists.show', $hashid);
    }
}
