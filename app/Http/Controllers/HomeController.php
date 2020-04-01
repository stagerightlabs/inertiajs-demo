<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\TodoListResource;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $todoLists = $request->user()->lists;

        // dd(<TodoListResource::colle></TodoListResource::colle>ction($todoLists));

        return Inertia::render('Home', [
            'todoLists' => function() use ($todoLists) {
                return TodoListResource::collection($todoLists);
            },
        ]);
    }
}
