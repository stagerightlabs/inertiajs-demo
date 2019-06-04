<?php

namespace App\Http\Controllers;

use App\ToDoList;
use App\Facades\Hashid;
use Illuminate\Http\Request;
use App\Http\Requests\ToDoListRequest;

class ToDoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ToDoListRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ToDoListRequest $request)
    {
        $list = ToDoList::create([
            'name' => $request->input('name'),
            'user_id' => $request->user()->id
        ]);

        return response()->json($list);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function show(ToDoList $toDoList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function edit(ToDoList $toDoList)
    {
        //
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

        return response()->json($list);
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

        return response()->json([]);
    }
}
