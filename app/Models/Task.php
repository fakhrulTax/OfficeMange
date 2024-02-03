<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 'priority', 'description', 'deadline', 'circle', 'status',
    ];

    //Create Task
    public static function createTask($data)
    {
        return self::create([
            'type' => $data['type'],
            'priority' => $data['priority'],
            'description' => $data['description'],
            'deadline' => date('Y-m-d',strtotime($data['deadline'])),
            'circle' => $data['circle'],
            'status' => false,
        ]);
    }

    //Add or Update Task
    public static function addOrUpdateTaskFromNotice($notice, $description, $deadline)
    {
        // Check if a task with the same description and deadline exists
         $existingTask = self::where('description', $description)->where('deadline',$deadline)
         ->first();
         if ($existingTask) {
             // Update the existing task's type by appending the new type
             if( !str_contains( $existingTask->type, $notice) )
             {
                $existingTask->update([
                    'type' => $existingTask->type . ', ' . $notice
                ]);
             }
             
         } else {
             // Create a new task with the hearing_date as deadline
             self::create([
                 'type' => $notice,
                 'priority' => 3,
                 'description' => $description,
                 'deadline' => date('Y-m-d',strtotime($deadline)),
                 'circle' => Auth::user()->circle,
                 'status' => false,
             ]);
         }
    }
}
