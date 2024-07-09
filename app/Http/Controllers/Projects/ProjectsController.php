<?php

namespace App\Http\Controllers\Projects;

use App\Models\Logs;
use App\Models\Task;
use App\Models\Projects;
use App\Models\ViewTasks;
use App\Models\ViewProjects;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Projects',
            'projects' => ViewProjects::all()
        ];
        return view('projects/index', $data);
    }

    public function create()
    {
        $validator = Validator::make(request()->all(),[
            'title' =>'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $response = array('msg' =>  $validator->errors());
            echo json_encode($response);
            die();
        }

        $description = request()->input('description');

        try {

            $projects = Projects::create([
                'name' => request()->input('title'),
                'description' => !empty($description) ? $description : NULL,
                'created_by' => auth()->user()->id,
            ]);

            // project id to base64 for security protection
            $id = base64_encode($projects->id);
            $response = array('msg' =>  'YES', 'url' => env('APP_URL').'/v1/projects/tasks/'.$id);
            echo json_encode($response);
            die();

        } catch (\Throwable $th) {
            $response = array('msg' =>  $th->getMessage());
            echo json_encode($response);
            die();
        }
    }

    public function tasks($ids)
    {
        $id = base64_decode($ids);
        $project = Projects::find($id);
        $tasks = ViewTasks::where('projectID', $project->id)->get();
        $data = [
            'title' => 'Task List - '. $project->name,
            'project' => $project,
            'tasks' => $tasks
        ];
        return view('projects.tasks', $data);
    }

    public function editTask($id)
    {
        $url = env('APP_URL')."/v1/projects/tasks/$id";
        $id = request()->input('task_id');
        $name = request()->input('name');
        $task = Task::find($id);

        $logs =  Logs::create([
            'user_id' => auth()->user()->id,
                'description' => 'Task Data before edit',
                'data' => json_encode($task)
        ]);
        try {
            $task->name = $name;
            $task->updated_by = auth()->user()->id;
            $task->save();

            echo "<script>alert('Task Updated Successfully') </script>";
            echo "<script>window.location = '$url'</script>";
        } catch (\Throwable $th) {
            echo "<script>alert('Task Updated Successfully') </script>";
            echo "<script>window.location = '$url'</script>";
        }
    }

    public function removeTask($id)
    {
        $url = env('APP_URL')."/v1/projects/tasks/$id";

        $id = request()->input('task_id');
        $task = Task::find($id);
        $logs =  Logs::create([
            'user_id' => auth()->user()->id,
                'description' => 'Deleting Task ',
                'data' => json_encode($task)
        ]);
        try {

            $task->deleted = 1;
            $task->updated_by = auth()->user()->id;
            $task->save();

            echo "<script>alert('Task Updated Successfully') </script>";
            echo "<script>window.location = '$url'</script>";
        } catch (\Throwable $th) {
            echo "<script>alert('Task Updated Successfully') </script>";
            echo "<script>window.location = '$url'</script>";
        }
    }

}
