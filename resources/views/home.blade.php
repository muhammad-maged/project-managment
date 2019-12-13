@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                @if(session()->has('message'))
                    <div class="alert alert-success col-md-3" style="text-align: center; align-self: center;  margin: 10px;">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="card-body col-md-8">
                    <a href="{{route('create-project-form')}}" class="btn btn-primary col-md-3">Create New Project </a>
                    <a href="{{route('viewProjects')}}" class="btn btn-primary col-md-3 float-right">View Projects </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
