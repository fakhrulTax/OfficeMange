<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Toastr;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::orderByRaw('status ASC, deadline ASC') 
            ->where('circle', Auth::user()->circle)           
            ->paginate(100);
    
        return view('circle.task.index', [
            'tasks' => $tasks,
            'title' => 'Forward Dairy'
        ]);
    }
    
    //Store Data
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string',
            'deadline' => 'required|date_format:d-m-Y',
        ]);

        
        $validatedData['type'] = 'Note'; 
        $validatedData['priority'] = 3; 
        $validatedData['circle'] = Auth::user()->circle;        

        Task::createTask($validatedData);
        Toastr::success('Task Added Successful', 'success');
        return redirect()->route('circle.task.index');
    }

    //Change Status
    public function updateStatus($id)
    {
        $task = Task::findOrFail($id);

        $task->update([
            'status' => true,
        ]);

        Toastr::success('Task Status Updated', 'success');
        return redirect()->route(Auth::user()->user_role.'.task.index');
    }

    //Delete Task
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route(Auth::user()->user_role.'.task.index');
    }


}
