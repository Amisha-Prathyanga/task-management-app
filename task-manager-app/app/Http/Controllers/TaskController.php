<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;



use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\User;



class TaskController extends Controller
{
     /**
     * Display a listing of the tasks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Task::query();

        
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        
        $query->orderBy('due_date');

        $tasks = $query->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show form for creating a new task.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'priority' => 'required|in:high,medium,low',
        ]);

        $task = new Task();
        $task->user_id = Auth::id();
        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->due_date = $validated['due_date'];
        $task->priority = $validated['priority'];
        $task->save();

        Alert::success('Success', 'Task created successfully.');
        return redirect()->route('tasks.index');
    }

    /**
     * Show form for editing the specified task.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'priority' => 'required|in:high,medium,low',
        ]);

        $task = Task::findOrFail($id);
        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->due_date = $validated['due_date'];
        $task->priority = $validated['priority'];
        $task->save();

        Alert::success('Success', 'Task updated successfully.');
        return redirect()->route('tasks.index');
    }

    /**
     * Mark a task as completed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markComplete($id)
    {
        $task = Task::findOrFail($id);
        $task->is_completed = true;
        $task->save();

        // Here you would trigger the email notification
        // event(new TaskCompletedEvent($task));

        Alert::success('Success', 'Task marked as completed.');
        return redirect()->back();
    }

    /**
     * Mark a task as paid (for premium tasks).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markPaid($id)
    {
        $task = Task::findOrFail($id);
        $task->is_paid = true;
        $task->save();

        Alert::success('Success', 'Task marked as paid.');
        return redirect()->back();
    }

    /**
     * Soft delete the specified task.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        Alert::success('Success', 'Task deleted successfully.');
        return redirect()->route('tasks.index');
    }
}
