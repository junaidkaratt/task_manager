<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::where('user_id', auth()->id());

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', "%{$request->search}%")
                    ->orWhere('status', 'LIKE', "%{$request->search}%");
            });
        }

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Always use pagination
        $tasks = $query->orderBy('created_at', 'DESC')->paginate(5);

        if ($request->ajax()) {
            return view('tasks.ajax-list', compact('tasks'))->render();
        }

        return view('tasks.index', compact('tasks'));
    }



    public function store(StoreTaskRequest $request)
    {


        $task = Task::create([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => 'pending',
            'user_id'     => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }


    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task->update($validated);

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }


    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'success' => true
        ]);
    }
    
    public function apiTasks(Request $request)
    {
        $tasks = Task::where('user_id', auth()->id())
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'success' => true,
            'tasks' => $tasks
        ]);
    }
    public function toggleStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,in-progress',
        ]);

        $task->status = $request->status;
        $task->save();

        return response()->json(['success' => true, 'status' => $task->status]);
    }
}
