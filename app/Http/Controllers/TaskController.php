<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Suport\Carbon;
use Request as Input;
use Validator;
use Response;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdateRequest;
use App;

class TaskController extends Controller
{
    public function index()
    {
        return Task::orderBy('created_at', 'DESC')->get();
    }

    public function store()
    {
        App::make(StorePostRequest::class);
        $this->authorize('create', Task::class);
        return Task::create(Input::all());
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
            // Ou o Texto tem a substring (EDIT) ou a task esta incompleta
                App::make(UpdateRequest::class);
            $task = Task::findOrFail($id);
        $this->authorize('update', $task);
        return $task->update(Input::all());

        //$existingTask = Task::findOrFail($id);
        //$existingTask->update(Input::all());

        //return $existingTask;
    }

    public function toogle(Request $request, $id)
    {
        // Ou o Texto tem a substring (EDIT) ou a task esta incompleta
        $task = Task::findOrFail($id);
        $task->completed = !$task->completed;
        $this->authorize('toogle', $task);
        $task->save();
        return $task;

        //$existingTask = Task::findOrFail($id);
        //$existingTask->update(Input::all());

        //return $existingTask;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // A task tem que estar completa
        $task = Task::findOrFail($id);
        $this->authorize('destroy', $task);
        $task->delete();
        return $task;
    }
}