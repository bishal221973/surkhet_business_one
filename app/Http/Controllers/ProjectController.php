<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
       $projects = Project::where('organization_id', organization()->id)->with(['client','tasks'])->latest()->get();
        return view('projects.list',[
            'projects'=>$projects,
        ]);
    }


    public function create()
    {
        $clients = Client::latest()->get();
        $statuses = Project::STATUSES;
        $taskStatuses = Task::STATUSES;
        $taskPriority = Task::PRIORITY;
        return view('projects.create', [
            'clients' => $clients,
            'staffs' => User::latest()->get(),
            'statuses' => $statuses,
            'taskStatuses' => $taskStatuses,
            'taskPriority' => $taskPriority,
            'project' => new Project(),
        ]);
    }

    public function store(Request $request){
        $data= $request->validate([
            // Project fields
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'project_name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'status' => ['required'],

            // Tasks array
            'tasks' => ['required', 'array', 'min:1'],
            'tasks.*.title' => ['required', 'string', 'max:255'],
            'tasks.*.priority' => ['required'],
            'tasks.*.deadline' => ['required', 'date'],
            'tasks.*.assigned_to' => ['required'],
            'tasks.*.status' => ['required'],
            'tasks.*.remarks' => ['nullable', 'string'],
        ]);

        // return $data;
        $project=Project::create([
            'client_id'=>$data['client_id'],
            'project_name'=>$data['project_name'],
            'start_date' => $data['start_date'],
            'status' => $data['status'],
        ]);

        if ($request->has('tasks')) {
            foreach ($data['tasks'] as $task) {
                // Make sure $task['assigned_to'] is an array
                $assignedTo = $task['assigned_to'];

                // If it's a JSON string (from hidden input), decode it
                if (is_string($assignedTo)) {
                    $assignedTo = json_decode($assignedTo, true);
                }

                // Ensure we have an array
                if (!is_array($assignedTo)) {
                    $assignedTo = [];
                }

                Task::create([
                    'project_id' => $project->id,
                    'title' => $task['title'],
                    'assigned_to' => $assignedTo, // store array directly, Laravel handles JSON
                    'priority' => $task['priority'],
                    'deadline' => $task['deadline'],
                    'status' => $task['status'],
                    'description' => $task['remarks'] ?? null,
                ]);
            }
        }

        return redirect()->route('project.create')->with('success', 'Project created successfully.');
    }

    public function edit($id)
    {
        $project=Project::findOrFail($id);
        $clients = Client::latest()->get();
        $statuses = Project::STATUSES;
        $taskStatuses = Task::STATUSES;
        $taskPriority = Task::PRIORITY;
        return view('projects.create', [
            'clients' => $clients,
            'staffs' => User::latest()->get(),
            'statuses' => $statuses,
            'taskStatuses' => $taskStatuses,
            'taskPriority' => $taskPriority,
            'project' => $project->load('tasks'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            // Project
            'client_id' => ['required', 'exists:clients,id'],
            'project_name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'status' => ['required'],

            // Tasks
            'tasks' => ['required', 'array', 'min:1'],
            'tasks.*.id' => ['nullable', 'exists:tasks,id'],
            'tasks.*.title' => ['required', 'string', 'max:255'],
            'tasks.*.priority' => ['required'],
            'tasks.*.deadline' => ['required', 'date'],
            'tasks.*.assigned_to' => ['required'],
            'tasks.*.status' => ['required'],
            'tasks.*.remarks' => ['nullable', 'string'],
        ]);

        // Update project
        $project = Project::findOrFail($id);
        $project->update([
            'client_id' => $data['client_id'],
            'project_name' => $data['project_name'],
            'start_date' => $data['start_date'],
            'status' => $data['status'],
        ]);

        $existingTaskIds = $project->tasks()->pluck('id')->toArray();
        $submittedTaskIds = [];

        foreach ($data['tasks'] as $task) {

            // Normalize assigned_to
            $assignedTo = $task['assigned_to'];

            if (is_string($assignedTo)) {
                $assignedTo = json_decode($assignedTo, true);
            }

            if (!is_array($assignedTo)) {
                $assignedTo = [];
            }

            // Update or create task
            if (!empty($task['id'])) {

                $taskModel = Task::findOrFail($task['id']);
                $taskModel->update([
                    'title' => $task['title'],
                    'assigned_to' => array_values($assignedTo),
                    'priority' => $task['priority'],
                    'deadline' => $task['deadline'],
                    'status' => $task['status'],
                    'description' => $task['remarks'] ?? null,
                ]);

                $submittedTaskIds[] = $taskModel->id;

            } else {

                $newTask = Task::create([
                    'project_id' => $project->id,
                    'title' => $task['title'],
                    'assigned_to' => array_values($assignedTo),
                    'priority' => $task['priority'],
                    'deadline' => $task['deadline'],
                    'status' => $task['status'],
                    'description' => $task['remarks'] ?? null,
                ]);

                $submittedTaskIds[] = $newTask->id;
            }
        }

        // 🗑 Delete removed tasks
        $tasksToDelete = array_diff($existingTaskIds, $submittedTaskIds);
        Task::whereIn('id', $tasksToDelete)->delete();

        return redirect()
            ->route('project.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        Task::where('project_id', $id)->delete();
        Project::find($id)->delete();
        return redirect()->route('project.index')->with('success', 'Project has been deleted successfully');
    }
}
