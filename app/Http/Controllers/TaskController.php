<?php

namespace App\Http\Controllers;


use App\Models\Task;
use App\Validation\TaskValidation;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = (new Task)->fill($request->toArray());

        $TaskValidation = new TaskValidation();
        $TaskValidation->assert($task, $request);

        if ($TaskValidation->getErrors()) {
            return response()->json($TaskValidation->getErrors(), 422);
        }

        $task->save();

        return response()->json($task->toArray(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $task = Task::findOrFail($id);

        } catch (\Exception $e) {
            return response()->json('', 404);
        }

        return response()->json($task, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

        } catch (\Exception $e) {
            return response()->json('', 404);
        }

        $task->fill($request->toArray());

        $TaskValidation = new TaskValidation('update');
        $TaskValidation->assert($task, $request);

        if ($TaskValidation->getErrors()) {
            return response()->json($TaskValidation->getErrors(), 422);
        }

        $task->save();

        return response()->json($task->toArray(), 200);
    }

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
        } catch (\Exception $e) {
            return response()->json('', 404);
        }

        return response()->json('', 204);
    }
}
