@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Create New Project</div>
                    @if(session()->has('message'))
                        <div class="alert alert-success col-md-4" style="text-align: center; align-self: center;  margin: 10px;">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <form  method="post" action="{{route('create-project')}}">
                        {{csrf_field()}}
                    <div class="card-body col-md-9" id="project_info">
                        <div class="form-group row">
                            <label for="project_name" class="col-md-5 col-form-label text-md">{{ __('Project Name') }}</label>
                            <div class="col-md-7">
                                <input id="project_name" type="text" class="form-control " name="project_name" required autocomplete="false" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start_date" class="col-md-5 col-form-label text-md">{{ __('Start Date') }}</label>
                            <div class="col-md-7">
                                <input id="Start_date" type="date" class="form-control " name="start_date" required >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="due_date" class="col-md-5 col-form-label text-md">{{ __('Due Date') }}</label>
                            <div class="col-md-7">
                                <input id="due_date" type="date" class="form-control " name="due_date" required >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cost" class="col-md-5 col-form-label text-md">{{ __('Estimate Cost') }}</label>
                            <div class="col-md-7">
                                <input id="cost" type="text" class="form-control" name="cost">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cost" class="col-md-5 col-form-label text-md">{{ __('Expected Deliverable') }}</label>
                            <div class="col-md-7">
                                <textarea id="deliverable"  class="form-control" name="deliverable"></textarea>
                                <p>Clarify Project Deliverable Separate using <strong>commas </strong></p>
                            </div>

                        </div>
                        <div class="form-group row" id="team-member-field">
                            <label for="cost" class="col-md-5 col-form-label text-md">{{ __('Team Members') }}</label>
                            <div class="col-md-2">
                                <input id="member-name" type="text" class="form-control" placeholder="Name" name="member-name[]" required>
                            </div>
                            <div class="col-md-2">
                                <input id="member-title" type="text" class="form-control" placeholder="Title" name="member-title[]" required>
                            </div>
                            <div class="col-md-2">
                                <input id="member-hours" type="text" class="form-control" placeholder="Hrs/Day" name="member-hours[]" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" onclick="addMoreFields()" class="btn btn-light">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function addMoreFields() {

        var parent_Div = document.createElement('div');
        var subDiv1= document.createElement('div');
        var subDiv2= document.createElement('div');
        var subDiv3= document.createElement('div');
        var label = document.createElement('label');
        var main = document.getElementById("project_info");

        parent_Div.classList.add("form-group");
        parent_Div.classList.add("row");

        subDiv1.classList.add("col-md-2");
        subDiv2.classList.add("col-md-2");
        subDiv3.classList.add("col-md-2");
        label.classList.add("col-md-5");

        label.setAttribute('type','hidden');
        var name = document.createElement('input');
        name.classList.add("form-control");
        name.name = 'member-name[]';
        name.placeholder = "Name";

        var title = document.createElement('input');
        title.classList.add("form-control");
        title.name = 'member-title[]';
        title.placeholder = "Title";

        var hours = document.createElement('input');
        hours.classList.add("form-control");
        hours.name = 'member-hours[]';
        hours.placeholder = "Hrs/Day";

        subDiv1.appendChild(name);
        subDiv2.appendChild(title);
        subDiv3.appendChild(hours);

        parent_Div.appendChild(label);
        parent_Div.appendChild(subDiv1);
        parent_Div.appendChild(subDiv2);
        parent_Div.appendChild(subDiv3);

        main.appendChild(parent_Div);
    }
    </script>
