@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Project : {{$project->name}}
                        <div class="float-right"><strong>Project Plan</strong></div>
                    </div>
                    @if(session()->has('message'))
                        <div class="alert alert-success col-md-4" style="text-align: center; align-self: center;  margin: 10px;">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <div class="card-body col-md-12" id="project_plan">
                        <div class="form-group row col-md-12">
                            <form method="post" action="{{route('postProjectHours',$project->id)}}">
                                {{csrf_field()}}
                                <div class="form-group row">
                                    <label for="project_name" class="col-md-3 col-form-label text-md">{{ __('Working Days') }}</label>
                                    <div class="col-md-6">
                                        <input id="days" type="number" class="form-control " value="{{$days}}" name="days" required >
                                    </div>
                                    <div class="col-md-3">
                                        <input type="submit"  class="btn btn-info float-right" value="Save Changes">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="form-group row col-md-12">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                                    New Task
                                </button>
                            </div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Estimated Duration</th>
                                <th scope="col">Actual Duration</th>
                                <th scope="col">Worker</th>
                                <th scope="col">Status</th>
                                <th scope="col">Final Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($tasks as $index => $task)
                                <tr>
                                    <th scope="row">{{$index+1}}</th>
                                    <td><a href="{{route('editTask',$task->id)}}">{{$task->name}}</a></td>
                                    <td>{{$task->start_date}}</td>
                                    <td>{{$task->end_date}}</td>
                                    <td>{{$task->estimated_duration}} hrs</td>
                                    <td>{{$task->actual_duration == null ? '---' : $task->actual_duration . '   hrs'}}</td>
                                    <td>{{$task->worker->name}} / {{$task->worker->title}} </td>
                                    <td>{{$task->castStatus($task->status) }} </td>
                                    <td>{{$task->evaluate() }} </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="41" class="text-center">No records were found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="exampleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Task</h5>
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
                                    <label for="description" class="col-md-4 col-form-label text-md">{{ __('Start') }}</label>
                                    <div class="col-md-8">
                                        <input type="date" id="start_date" min="1" class="form-control" name="start_date">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label text-md">{{ __('End') }}</label>
                                    <div class="col-md-8">
                                        <input type="date" id="end_date" min="1" class="form-control" name="end_date">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="project_name" class="col-md-4 col-form-label text-md">{{ __('Type') }}</label>
                                    <div class="col-md-8">
                                        <input id="task-type" type="text" class="form-control " name="task-type">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dependent_tasks" class="col-md-4 col-form-label text-md">{{ __('Dependent Tasks') }}</label>
                                    <div class="col-md-3">
                                        <select class="form-control" id="taskList" onchange="insertTask()">
                                            <option value="" disabled selected>Task</option>
                                            @forelse($tasks as $task)
                                                <option value="{{$task->id}}">{{$task->name}}</option>
                                                @empty
                                                <option value="" disabled selected>No Tasks</option>
                                            @endforelse
                                        </select>
                                    </div>
                                        <div class="col-md-5">
                                            <input id="dependent_tasks" type="text" class="form-control" value="" name="dependent_tasks">
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
                                <input type="hidden" name="project_id" value="{{$project->id}}">
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
        function insertTask() {
            let task = document.getElementById('taskList').value;
            let taskInput = document.getElementById('dependent_tasks');
            taskInput.value += task+', ';
            console.log(task);
        }
        function submitForm() {
            document.getElementById('taskForm').submit();
        }
    </script>
    @endsection
