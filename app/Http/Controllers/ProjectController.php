<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create(){
        $clients=Client::latest()->get();
        $statuses = Project::STATUSES;
        $taskStatuses=Task::STATUSES;
        $taskPriority=Task::PRIORITY;
        return view('projects.create',[
            'clients'=>$clients,
            'staffs'=>User::latest()->get(),
            'statuses'=>$statuses,
            'taskStatuses'=>$taskStatuses,
            'taskPriority'=>$taskPriority
        ]);
    }

    public function store(Request $request){
        return $request;
    }
}
