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
        if( Auth::user()->user_role == 'commissioner' )
        {
            $tasks = Task::where('type', 'commissioner')
            // ->orWhere(function ($query) {
            //     $query->whereIn('circle', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22]);
            // })
            ->orderByRaw('status ASC, priority ASC, deadline ASC')
            ->paginate(100);
        }else{
            $tasks = Task::whereIn('circle', [Auth::user()->circle])            
            ->orderByRaw('status ASC, priority ASC, deadline ASC')
            ->paginate(100);
        }        

        return view(Auth::user()->user_role.'.task.index', [
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

        //Add Type and Priority By User Role
        if( Auth::user()->user_role == 'commissioner' )
        {
            $validatedData['type'] = 'commissioner'; 
            $validatedData['priority'] = 1; 
        }
        elseif( Auth::user()->user_role == 'range' )
        {
            $validatedData['type'] = 'range'; 
            $validatedData['priority'] = 2; 
        }
        elseif( Auth::user()->user_role == 'technical' )
        {
            $validatedData['type'] = 'technical'; 
            $validatedData['priority'] = 1; 
        }
        else
        {
            $validatedData['type'] = 'Note'; 
            $validatedData['priority'] = 3; 
        }

        //Circle Name 
        if( Auth::user()->user_role == 'circle' )
        {
            $validatedData['circle'] = Auth::user()->circle;
        }
        else
        {
            $validatedData['circle'] = json_encode(($request->circle));
        }

        Toastr::success('Task Added Successful', 'success');

        Task::createTask($validatedData);

        return redirect()->route(Auth::user()->user_role.'.task.index');
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
