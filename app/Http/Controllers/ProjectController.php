<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /* Display a listing of the resource. */
    public function index()
    {
        $data_project = Project::select([
            'id', 'public_id', 'name', 'client', 'address', 'description', 'project_value', 'date_start', 'date_deadline', 'date_end', 'status'
        ])->orderBy('name')->paginate(10);

        return Inertia::render('project/ProjectPage', [
            'data_project' => $data_project
        ]);
    }

    /* Show the form for creating a new resource. */
    public function create()
    {
        return Inertia::render('project/ProjectCreatePage');
    }

    /* Store a newly created resource in storage. */
    public function store(StoreProjectRequest $request)
    {
        dd($request);
        $validated = $request->validated();

        try {
            $project = Project::create($validated);

            Session::flash('success', $this->messages['save_success']);
            return to_route('project.show', $project->id);
        } catch (\Exception $e) {
            Log::error('Failed to save project data: ' . $e->getMessage(), [
                'input_data' => $validated
            ]);
            Session::flash('error', $this->messages['save_failed']);
            return back()->withInput();
        }
    }

    /* Display the specified resource. */
    public function show(Project $project)
    {
        // return Inertia::render('project/ProjectDetailsPage', ['data_project' => $project->only('id', 'public_id', 'name', 'client', 'address', 'description', 'project_value', 'date_start', 'date_deadline', 'date_end', 'status')]);
    }

    /* Show the form for editing the specified resource. */
    public function edit(Project $project)
    {
        //
    }

    /* Update the specified resource in storage. */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //
    }

    /* Remove the specified resource from storage. */
    public function destroy(Project $project)
    {
        //
    }
}
