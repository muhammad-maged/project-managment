<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Project;
use App\Task;
use App\Worker;
use Illuminate\Http\Request;
use DateTime;
use PhpParser\Node\Stmt\DeclareDeclare;

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
        foreach ($data['member-name'] as $index => $member) {
            $worker = new Worker();
            $worker->name = $data['member-name'][$index];
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
        return view('all_projects', ['projects' => Project::all()]);
    }

    public function viewProject($id)
    {
        return view('project', ['project' => Project::find($id)]);
    }

    public function editProject(Request $request, $id)
    {
        $data = $request->all();
        $project = Project::find($id);
        $config = Configuration::query()->where('project_id', $id)->first();
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
                'cost' => $data['cost'], 'duration' => $interval->days
            ]);

        return redirect()->back()->with('message', ' Project Updated Successfully');

    }

    public function projectPlan($id)
    {
        $project = Project::find($id);
        $tasks = Task::query()->where(['project_id' => $project->id])->get();
        $workers = Worker::all();
        $days = $project->total_hours / $project->configuration->hours_per_day;

        return view('project_plan', ['project' => $project, 'tasks' => $tasks, 'workers' => $workers, 'days' => $days]);
    }

    public function createTask(Request $request)
    {
        $data = $request->all();
        $task = new Task();

        if (isset($data['parent_id']))
        {
            $parentTask = Task::find($data['parent_id']);
            $parentDuration = $parentTask->estimated_duration ;
            $subTasks =  Task::query()->where('parent_id',$parentTask->id)->get();
            if (count($subTasks) != 0)
            {
                $oldDurations = 0;
                foreach ($subTasks as $subTask) {
                    $oldDurations += $subTask->estimated_duration;
                }
                $oldDurations+= $data['estimated_duration'];
                if ($oldDurations > $parentTask->estimated_duration)
                {
                    return redirect()->back()->with('error', 'SubTask Durations Exceeded the Parent Task');
                }
            }
            $task->name = $data['name'];
            $task->description = $data['description'];
            $task->estimated_duration = $data['estimated_duration'];
            $task->start_date = $parentTask->start_date;
            $task->end_date = $parentTask->end_date;
            $task->worker_id = $data['worker_id'];
            $task->type = $data['task-type'];
            $task->project_id = $parentTask->project_id;
            $task->parent_id =  $data['parent_id'] ;
            $task->status = 0;

        }else{
            $task->name = $data['name'];
            $task->description = $data['description'];
            $task->estimated_duration = $data['estimated_duration'];
            $task->start_date = $data['start_date'];
            $task->end_date = $data['end_date'];
            $task->worker_id = $data['worker_id'];
            $task->type = $data['task-type'];
            $task->project_id = $data['project_id'];
            $task->parent_id = isset($data['parent_id']) ? $data['parent_id'] : null;
            $task->status = 0;
            $task->dependent_tasks = $data['dependent_tasks'];

        }

        $task->save();

        return redirect()->back()->with('message', 'Created Successfully');

    }

    public function postProjectHours(Request $request, $id)
    {
        $project = Project::find($id);
        $projectConfig = Configuration::query()->where('project_id', $project->id)->get()->first();
        $project->total_hours = $request->days * $projectConfig->hours_per_day ;
        $project->save();
        return redirect()->back()->with('message', 'Updated Successfully');

    }

    public function editTask($id)
    {
        $task = Task::find($id);
        $workers = Worker::all();
       return view('task', ['task' => $task, 'workers' => $workers]);
    }

    public function updateTask(Request $request)
    {
        $data = $request->all();
        $task = Task::find($data['task_id']);

        $task->name = $data['name'];
        $task->actual_duration = $data['actual_duration'];
        $task->estimated_duration = $data['estimated_duration'];
        $task->description = $data['description'];
        $task->worker_id = $data['worker_id'];
        $task->type = $data['task-type'];
        $task->parent_id = isset($data['parent_id']) ? $data['parent_id'] : null;
        $task->status = $data['status'];

        $task->save();
        return redirect()->back()->with('message', 'Updated Successfully');

    }

    public function deleteTask($id)
    {
        $task = Task::find($id);
        $project_id = $task->project_id ;
        $task->delete();
        return redirect()->to(route('projectPlan', $project_id));
    }


}
