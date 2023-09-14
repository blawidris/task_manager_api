<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TasksResource;
use App\Models\Tasks;
use App\Traits\HttpResponses;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return TasksResource::collection(Tasks::where('user_id', auth()->user()->id)->get());
    }

    public function store(StoreTaskRequest $request)
    {
        $request->validated($request->all());

        $task = Tasks::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority
        ]);

        if (!$task) {
            return $this->error(null, '');
        }

        return TasksResource::make($task);
    }

    public function show(Tasks $task)
    {
        return $this->isNotAuthorized($task) ?
            $this->isNotAuthorized($task)
            : new TasksResource($task);
    }

    public function update(Request $request, Tasks $task)
    {
        // validate authorization
        $this->isNotAuthorized($task);

        // update task
        $task->update($request->all());

        return new TasksResource($task);
    }

    public function destroy(Tasks $task)
    {
        return $this->isNotAuthorized($task);

        $task->delete();

        return response(null, 204);
    }

    private function isNotAuthorized($task)
    {
        if (Auth::user()->id !== $task->user_id) {
            return $this->error(null, 'You are not authorized', 403);
        }
    }
}
