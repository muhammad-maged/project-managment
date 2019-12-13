<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Project;
use App\Worker;
use Illuminate\Http\Request;
use DateTime;

class ProjectController extends Controller
{
    public function __construct()
    {
    }

    public function createProjectForm()
    {
        return view('create_project');
    }

    public function createProject(Request $request)
    {
        $data = $request->all();
        $project = new Project();

        $fdate = $request->start_date;
        $tdate = $request->due_date;
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        $interval = $datetime1->diff($datetime2);

        $project->name = $data['project_name'];
        $project->duration = $interval->days;
        $project->cost = $data['cost'];
        $project->start_date = $fdate;
        $project->end_date = $tdate;

        $project->save();
        $project->refresh();

        // create workers
    foreach ($data['member-name'] as $index => $member)
    {
        $worker = new Worker();
        $worker->name=$data['member-name'][$index];
        $worker->title = $data['member-title'][$index];
        $worker->current_project = $project->id;
        $worker->hours_per_day = $data['member-hours'][$index];
        $worker->save();

    }

    $confg = new Configuration();
    $confg->project_id = $project->id;
    $confg->expected_deliverable = $data['deliverable'];
    $confg->save();

        return redirect()->back()->with('message', ' Project Created Successfully');
    }

    public function viewProjects()
    {
        return view('all_projects',['projects' => Project::all()]);
    }

    public function viewProject($id)
    {
        return view('project',['project' =>Project::find($id) ]);
    }

    public function editProject(Request $request, $id)
    {
        $data = $request->all();
        $project = Project::find($id);
        $config  = Configuration::query()->where('project_id',$id)->first();
        $fdate = $request->start_date;
        $tdate = $request->due_date;
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        $interval = $datetime1->diff($datetime2);


        $config->update(['week_start' => $data['week_start'], 'hours_per_day' => $data['hours_per_day'],
            'expected_deliverable' => $data['deliverable']
            ]);

        $project->update(
            [
            'name' => $data['project_name'], 'start_date' => $data['start_date'], 'end_date' => $data['due_date'],
             'cost' => $data['cost'],  'duration' => $interval->days
        ]);

        return redirect()->back()->with('message', ' Project Updated Successfully');

    }


}
