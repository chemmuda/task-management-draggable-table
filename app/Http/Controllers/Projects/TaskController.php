<?php

namespace App\Http\Controllers\Projects;

use App\Models\Logs;
use App\Models\Task;
use App\Models\Projects;
use App\Models\ViewTasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Task List',
            'projects' => Projects::where('deleted', 0)->get(),
            'tasks' => ViewTasks::all(),
        ];
        return view('tasks/index', $data);
    }

    public function create()
    {
        $validator = Validator::make(request()->all(),[
            'name' =>'required|string|max:255',
            'project_id' =>'required|integer',
        ]);
        if ($validator->fails()) {
            $response = array('msg' =>  $validator->errors());
            echo json_encode($response);
            die();
        }
        $project = request()->input('project_id');
        $priority = DB::select("SELECT MAX(position)  AS max_position FROM task where project_id =  $project and deleted = 0");
        $position = $priority[0]->max_position + 1;

        try {
            $task = Task::create([
                'name' => request()->input('name'),
                'position' => $position,
                'project_id' => request()->input('project_id'),
                'created_by' => auth()->user()->id
            ]);
            $id = base64_encode(request()->input('project_id'));
            $response = array('msg' =>  'YES', 'url' => env('APP_URL').'/v1/projects/tasks/'.$id);
            echo json_encode($response);
            die();
        } catch (\Throwable $th) {
            $response = array('msg' => $th->getMessage());
            echo json_encode($response);
            die();
        }
    }

    public function edit($id)
    {
        $url = env('APP_URL')."/v1/tasks";
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
        $url = env('APP_URL')."/v1/tasks";
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

    public function reOrder()
    {
        try {
            $id = request()->input('order');
            $order = explode(',',request()->input('order'));

        foreach ($order as $position => $id) {
            $id = str_replace('task_', '', $id);
            $sql = DB::update("UPDATE task SET position = $position + 1 WHERE id = $id");
            Logs::create([
                'user_id' => auth()->user()->id,
                'description' => 'Reordered tasks',
                'data' => json_encode($order)
            ]);
            echo json_encode($sql);
        }
            $response = array('msg' =>  'YES');
            echo json_encode($response);
            die();
        } catch (\Throwable $th) {
            $response = array('msg' => $th->getMessage());
            echo json_encode($response);
            die();
        }
    }
}
