<?php

namespace App\Http\Controllers;

use App\ToDoList;
use App\Facades\Hashid;
use Illuminate\Http\Request;
use App\Http\Requests\ToDoListRequest;
use App\Http\Resources\TodoListResource;

class ToDoListController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ToDoListRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ToDoListRequest $request)
    {
        ToDoList::create([
            'name' => $request->input('name'),
            'user_id' => $request->user()->id
        ]);

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  string
     * @return \Illuminate\Http\Response
     */
    public function show($hashid)
    {
        $list = TodoList::findByHashidOrFail($hashid);

        return Inertia::render('List')
            ->with('todoLists', new TodoListResource($list));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ToDoListRequest  $request
     * @param  string $hashid
     * @return \Illuminate\Http\Response
     */
    public function update(ToDoListRequest $request, $hashid)
    {
        $list = $request->user()->lists()->find(Hashid::decode($hashid));

        if (!$list) {
            abort(404);
        }

        $list->name = $request->input('name');
        $list->save();

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  string $hashid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $hashid)
    {
        $list = $request->user()->lists()->find(Hashid::decode($hashid));

        if (!$list) {
            abort(404);
        }

        $list->delete();

        return redirect()->route('home')->with('success', "List: '{$list->name}' removed.");
    }
}
