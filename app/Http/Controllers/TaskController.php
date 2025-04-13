<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    // Get all tasks
    public function index()
    {
        return response()->json(Auth::user()->tasks()->latest()->get());
    }

    // Create new task
    public function store(Request $request)
    {
        // Using Validator facade instead of $request->validate()
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        // Return validation errors if fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity
        }

        // Create task for the authenticated user
        $task = Auth::user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => false,
        ]);

        return response()->json($task, 201); // 201 Created
    }

    // Get a single task
    public function show(Task $task)
    {
        $this->authorizeTask($task);
        return response()->json($task);
    }

    // Update task
    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        // Using Validator for validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|boolean',
        ]);

        // Return validation errors if fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity
        }

        // Update task
        $task->update($request->only(['title', 'description', 'due_date', 'status']));

        return response()->json($task);
    }

    // Delete task
    public function destroy(Task $task)
    {
        $this->authorizeTask($task);

        // Delete the task
        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }

    // Authorize task ownership
    private function authorizeTask(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
