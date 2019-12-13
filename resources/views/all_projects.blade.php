@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">All Projects</div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Cost</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($projects as $index => $project)
                            <tr>
                                <th scope="row">{{$index+1}}</th>
                                <td><a href="{{route('editProject',$project->id)}}">{{$project->name}}</a></td>
                                <td>{{$project->start_date}}</td>
                                <td>{{$project->end_date}}</td>
                                <td>{{$project->duration}}</td>
                                <td>{{$project->cost}}</td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
