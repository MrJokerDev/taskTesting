<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(): TaskCollection
    {
        return new TaskCollection(Task::all());
    }

    public function search(Request $request): TaskResource
    {
        $query = Task::query();

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('deadline')) {
            $query->whereDate('deadline', $request->input('deadline'));
        }

        $tasks = $query->get();

        return new TaskResource($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Task successfully created',
            'data' => new TaskResource($task)
        ], 201);
    }

    public function show(string $id)
    {
        $task = Task::findOrFail($id);
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, string $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Task successfully update',
            'data' => new TaskResource($task)
        ], 201);
    }

    public function destroy(string $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        try{
            $task->delete();

            return response()->json([
                'status' => true,
                'message' => 'Task successfully delete'
            ], 204);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        
    }
}
