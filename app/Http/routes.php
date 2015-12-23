<?php

use App\Task;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    /**
     * Show task dashboard
     */
    Route::get('/', function() {
        $tasks = Task::orderBy('created_at', 'asc')->get();

        return view('tasks', compact('tasks'));
    });

    /**
     * Add new task
     */
    Route::post('/task', function(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/')->withInput()
                ->withErrors($validator);
        }

        $task = new Task;
        $task->name = $request->name;
        $task->save();

        return redirect('/');
    });

    /**
     * Delete task
     */
    Route::delete('/task/{task}', function(Task $task) {
        $task->delete();

        return redirect('/');
    });
});
