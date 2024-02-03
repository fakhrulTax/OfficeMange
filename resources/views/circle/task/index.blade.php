@extends('app')

@section('title','Tasks')
@push('css')
   
@endpush


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tasks</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <section class="content">

        <div class="card">
            <div class="card-body">
                <form class="form" method="POST" action="{{ route('circle.task.store') }}" autocomplete="off">
                    @csrf
                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control" id="deadline" name="deadline" placeholder="dd-mm-yyyy" required>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Add Task</button>
                        </div>

                    </div>
                            
                </form>  
            </div>
        </div>


        <div class="card">

             @if( count($tasks) < 1  )

                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
                
             @else

            <!-- /.card-header -->
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Deadline</th>
                            <th>Staus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
                            <td style="{{ ($task->priority == 1) ? 'color:blue' : '' }}">@if ($task->status) <del>{{ $task->type }}</del> @else{{ $task->type }}@endif</td>
                            <td style="{{ ($task->priority == 1) ? 'color:blue' : '' }}">@if ($task->status) <del>{!! $task->description !!}</del> @else {!! $task->description !!}@endif</td>
                            <td style="@if ($task->deadline <= now()) color: red; @endif">{{ date('d-m-Y', strtotime($task->deadline)) }}</td>
                            <td>
                                @if($task->type != 'commissioner' && $task->type != 'rage' && $task->type != 'technical')
                                    @if (!$task->status)
                                        <form method="POST" action="{{ route('circle.task.updateStatus', $task->id) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">Done</button>
                                        </form>
                                    @else
                                    <form method="POST" action="{{ route('circle.task.destroy', $task->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')                              
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <ul class="pagination pagination-sm m-0 float-right">
                {{ $tasks->links("pagination::bootstrap-4") }}
              </ul>
            </div>

            @endif

        </div>
        <!-- /.card -->

    </section>


    
@endsection



@push('js')
    <script>     



    </script>
@endpush