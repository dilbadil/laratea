<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Todo;
use JWTAuth;

class TodosController extends Controller
{
    /**
     * Instance new controller.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => 'index']);
    }

    /**
     * Get all todos belongs to authentecated user.
     *
     * @return \Response
     */
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $todos = Todo::where('owner_id', $user->id)->get();

        return $todos;
    }

    /**
     * Store a new todo belongs to authentecated user.
     *
     * @param Request $request
     * @return Todo
     */
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $newTodo = $request->all();
        $newTodo['owner_id'] = $user->id;

        return Todo::create($newTodo);
    }

    /**
     * Update existing todo belongs to authentecated user.
     *
     * @param Request $request
     * @param int $id
     * @return \Response
     */
    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $todo = Todo::where('owner_id', $user->id)->where('id', $id)->first();

        if (! $todo) {
            return response('unauthorized', 403);
        }

        $todo->is_done = $request->is_done;
        $todo->save();

        return $todo;
    }

    /**
     * Destroy an existing todo.
     *
     * @param int $id
     * @return \Response
     */
    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $todo = Todo::where('owner_id', $user->id)->where('id', $id)->first();

        if (! $todo) {
            return response('unauthorized', 403);
        }

        $todo->delete();

        return response('success', 200);
    }
}
