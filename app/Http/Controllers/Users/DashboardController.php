<?php

namespace App\Http\Controllers\Users;

use App\Models\Task;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        return view('dashboard/index',$data);
    }

    public function dashDetails()
    {
        $tasks = Task::where('deleted', 0)->count();
        $projects = Projects::where('deleted', 0)->count();

        $data = [
            'tasks' => $tasks,
            'projects' => $projects
        ];

        echo json_encode($data);
    }
}
