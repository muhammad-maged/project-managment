@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Task : {{$task->name}}
                        <div class="float-right"><strong>Project Plan</strong></div>
                    </div>
                    @if(session()->has('message'))
                        <div class="alert alert-success col-md-4" style="text-align: center; align-self: center;  margin: 10px;">
                            {{ session()->get('message') }}
                        </div>
                        @elseif(session()->has('error'))
                        <div class="alert alert-danger col-md-4" style="text-align: center; align-self: center;  margin: 10px;">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <div class="card-body col-md-12">
                        <div class="form-group row col-md-12">
                            <form method="post" action="{{route('updateTask')}}">
                                {{csrf_field()}}
                                <div class="form-group row">
                                    <label for="project_name" class="col-md-5 col-form-label text-md">{{ __('Name') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control " value="{{$task->name}}" name="name" required autocomplete="false" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="project_name" class="col-md-5 col-form-label text-md">{{ __('Actual Duration') }}</label>
                                    <div class="col-md-6">
                                        <input id="days" type="number" class="form-control " value="{{$task->actual_duration}}" name="actual_duration" required >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="project_name" class="col-md-5 col-form-label text-md">{{ __('Status') }}</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="status">
                                            <option @if($task->status == 0 ) selected @endif  value="0">Idle</option>
                                            <option @if($task->status == 1 ) selected @endif  value="1">Running</option>
                                            <option @if($task->status == 2 ) selected @endif  value="2">Done</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="estimated_duration" class="col-md-5 col-form-label text-md">{{ __('Estimated Duration') }}</label>
                                    <div class="col-md-6">
                                        <input type="number" id="estimated_duration" min="1" value="{{$task->estimated_duration}}" class="form-control" name="estimated_duration">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="workers"  class="col-md-5 col-form-label text-md">{{ __('Assign To ') }}</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="workers" name="worker_id">
                                            <option value="" disabled selected>Workers</option>
                                            @forelse($workers as $worker)
                                                <option value="{{$worker->id}}" @if($task->worker_id == $worker->id) selected @endif>{{$worker->name}}</option>
                                            @empty
                                                <option value="" disabled selected>No Workers</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="project_name" class="col-md-5 col-form-label text-md">{{ __('Type') }}</label>
                                    <div class="col-md-6">
                                        <input id="task-type" type="text" value="{{$task->type}}" class="form-control " name="task-type">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label text-md">{{ __('Description') }}</label>
                                    <div class="col-md-8">
                                        <textarea id="description"  class="form-control"  name="description">{{$task->description}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <input type="submit" class="btn btn-primary" value="Save changes">
                                    </div>
                                    <div class="col-md-4">
                                    <a class="btn btn-danger float-right" style="color: white"
                                    href="{{route('deleteTask', $task->id)}}"
                                       onclick="return confirm('Delete Task ?')"
                                    >Delete</a>
                                    </div>
                                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                                        Add Sub Task
                                    </button>
                                </div>
                                <input type="hidden" name="task_id" value="{{$task->id}}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="exampleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Sub Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form  id="taskForm" method="post" action="{{route('createTask')}}">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="project_name" class="col-md-4 col-form-label text-md">{{ __('Name') }}</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control " name="name" required autocomplete="false" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md">{{ __('Description') }}</label>
                                <div class="col-md-8">
                                    <textarea id="description"  class="form-control" name="description"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md">{{ __('Estimated Duration') }}</label>
                                <div class="col-md-8">
                                    <input type="number" id="estimated_duration" min="1" class="form-control" name="estimated_duration">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="project_name" class="col-md-4 col-form-label text-md">{{ __('Type') }}</label>
                                <div class="col-md-8">
                                    <input id="task-type" type="text" class="form-control " name="task-type">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="workers"  class="col-md-4 col-form-label text-md">{{ __('Assign To ') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control" id="workers" name="worker_id">
                                        <option value="" disabled selected>Workers</option>
                                        @forelse($workers as $worker)
                                            <option value="{{$worker->id}}">{{$worker->name}}</option>
                                        @empty
                                            <option value="" disabled selected>No Workers</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="parent_id" value="{{$task->id}}">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="submitForm()">Create</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
@section('scripts')
    <script>
        function submitForm() {
            document.getElementById('taskForm').submit();
        }
    </script>
@endsection
