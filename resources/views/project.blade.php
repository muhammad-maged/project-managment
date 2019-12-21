@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Project : {{$project->name}}
                        <div class="float-right"><a href="{{route('projectPlan', $project->id)}}" class="btn btn-primary" style="color: white;">Project Plan</a></div>
                    </div>
                    @if(session()->has('message'))
                        <div class="alert alert-success col-md-4" style="text-align: center; align-self: center;  margin: 10px;">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <form  method="post" action="{{route('editProject-post',$project->id)}}">
                        {{csrf_field()}}
                        <div class="card-body col-md-9" id="project_info">
                            <div class="form-group row">
                                <label for="project_name" class="col-md-5 col-form-label text-md">{{ __('Project Name') }}</label>
                                <div class="col-md-7">
                                    <input id="project_name" type="text" class="form-control " name="project_name" value="{{$project->name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="start_date" class="col-md-5 col-form-label text-md">{{ __('Start Date') }}</label>
                                <div class="col-md-7">
                                    <input id="Start_date" type="date" class="form-control " name="start_date" value="{{$project->start_date}}" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="due_date" class="col-md-5 col-form-label text-md">{{ __('Due Date') }}</label>
                                <div class="col-md-7">
                                    <input id="due_date" type="date" class="form-control " name="due_date" value="{{$project->end_date}}" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cost" class="col-md-5 col-form-label text-md">{{ __('Estimate Cost') }}</label>
                                <div class="col-md-7">
                                    <input id="cost" type="text" class="form-control" name="cost" value="{{$project->cost}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cost" class="col-md-5 col-form-label text-md">{{ __('Week Start') }}</label>
                                <div class="col-md-7" >
                                    <select class="form-control" name="week_start">
                                            <option value="sunday" @if($project->configuration->week_start == "sunday") selected @endif>Sunday</option>
                                            <option value="monday" @if($project->configuration->week_start == "monday") selected @endif>Monday</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cost" class="col-md-5 col-form-label text-md">{{ __('Total Hours Per Day') }}</label>
                                <div class="col-md-7">
                                    <input id="hours_per_day" type="text" class="form-control" name="hours_per_day" value="{{$project->configuration->hours_per_day}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cost" class="col-md-5 col-form-label text-md">{{ __('Expected Deliverable') }}</label>
                                <div class="col-md-7">
                                    <textarea id="deliverable"  class="form-control" name="deliverable"
                                    >{{$project->configuration->expected_deliverable}}</textarea>
                                </div>

                            </div>
                            <div class="form-group row" >
                                <label for="cost" class="col-md-5 col-form-label text-md">{{ __('Team Members') }}</label>
                                <div class="col-md-7">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Tasks</th>
                                            <th scope="col">Hours/Day</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($project->worker as $index => $worker)
                                            <tr>
                                                <th scope="row">{{$index+1}}</th>
                                                <td>{{$worker->name}}</td>
                                                <td>{{$worker->title}}</td>
                                                <td>{{$worker->current_tasks}}</td>
                                                <td>{{$worker->hours_per_day}}</td>
                                            </tr>
                                        @empty
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
