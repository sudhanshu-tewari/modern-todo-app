<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();
        return view('todos.index', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date'
        ]);

        Todo::create($request->all());                
        return redirect()->route('todos.index')->with('success', 'Todo created successfully!');
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date'
        ]);

        $todo->update($request->all());
        return redirect()->route('todos.index')->with('success', 'Todo updated successfully!');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->route('todos.index')->with('success', 'Todo deleted successfully!');
    }

    public function toggle(Todo $todo)
    {
        $todo->update(['completed' => !$todo->completed]);
        return redirect()->route('todos.index');
    }
}
