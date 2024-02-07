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
        $tasks = Task::orderByRaw('status ASC, priority ASC, deadline ASC')
            ->get();
    
        $filteredTasks = $tasks->filter(function ($task) {

            if (Auth::user()->user_role == 'commissioner') {
                return $task->type == 'commissioner';
            } else {
                return in_array(Auth::user()->circle, json_decode($task->circle));
            }

        });
    
        $perPage = 100;
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $currentPageTasks = $filteredTasks->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedTasks = new \Illuminate\Pagination\LengthAwarePaginator($currentPageTasks, count($filteredTasks), $perPage, $currentPage);
    
        // Use withPath to specify the base path for pagination links
        $paginatedTasks->withPath(route(Auth::user()->user_role . '.task.index'));
    
        return view(Auth::user()->user_role . '.task.index', [
            'tasks' => $paginatedTasks,
            'title' => 'Forward Dairy'
        ])->withQueryString(['page']);
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
            $validatedData['circle'] = json_encode([Auth::user()->circle]);
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
