<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('priority')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $task = new Task();
        $task->name = $request->input('name');
        $task->priority = Task::count() + 1;
        $task->save();

        return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $task->name = $request->input('name');
        $task->save();

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        // Update priorities
        $this->updatePriorities();

        return redirect()->route('tasks.index');
    }

    public function updatePriorities(Request $request)
    {
        $taskIds = $request->input('taskIds');
        foreach ($taskIds as $key => $taskId) {
            $task = Task::find($taskId);
            if ($task) {
                $task->priority = $key + 1;
                $task->save();
            }
        }

        return response()->json(['message' => 'Priorities updated successfully']);
    }
}
