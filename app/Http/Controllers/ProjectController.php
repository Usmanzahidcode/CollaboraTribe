<?php

namespace App\Http\Controllers;

use App\Events\NewProjectEvent;
use App\Events\NewUserEvent;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Utils;

use Faker\Factory as FakerFactory;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $projects = Project::where('status', 'active')->simplePaginate(5);

        return view('catalog', ['projects' => $projects]);
    }

    public function archive()
    {
        $projects = Project::where('status', 'complete')->orWhere('status', 'aborted')->get();
        return view('admin.manageprojects', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $today = now()->startOfDay();
        $tomorrow = now()->addDay()->startOfDay();

        $projectsCount = $user->authoredProjects()
            ->whereBetween('created_at', [$today, $tomorrow->endOfDay()])
            ->count();

//        dd($projectsCount);

        return view('create_project', compact('projectsCount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $today = now()->startOfDay();
        $tomorrow = now()->addDay()->startOfDay();

        $projectsCount = $user->authoredProjects()
            ->whereBetween('created_at', [$today, $tomorrow])
            ->count();

        if ($projectsCount > 1) {
            return redirect()->route('projects.create');
        }

        $validatedData = $request->validate([
            'title' => 'required|string',
            'excerpt' => 'required|string|min:250|max:500',
            'description' => 'required|string',
            'category' => 'required|string',
            'attachment' => 'nullable|file|max:20480',
        ]);

        $name = time() . '_project_attachment_' . $request->attachment->getClientOriginalName();
        $request->file('attachment')->storeAs('public/projects/attachments/', $name);


        // Create a new project
        $project = new Project();
        $project->title = $validatedData['title'];
        $project->excerpt = $validatedData['excerpt'];
        $project->description = $validatedData['description'];
        $project->category = $validatedData['category'];
        $project->author_id = Auth::user()->id;
        $project->attachment = $name;
        $project->save();

        event(new NewProjectEvent($project->title, route('projects.show', ['project' => $project->id])));


        // Redirect or return a response
        return redirect()->route('projects.create')->with('project_posted_success', 'Project created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::find($id);
        if ($project == null) {
            abort(404);
        }
        return view('project', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);

        if (Auth::user()->id == $project->author_id) {
            return view('editproject', ['project' => $project]);
        }
        return view('components.forbidden');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $project = Project::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string',
            'excerpt' => 'required|string|min:250|max:500',
            'description' => 'required|string',
            'category' => 'required|string',
            'attachment' => 'nullable|file|max:20480',
        ]);

        // Create a new project

        if ($request->hasFile('attachment')) {
            $name = time() . '_project_attachment_' . $request->attachment->getClientOriginalName();
            $request->file('attachment')->storeAs('public/projects/attachments/', $name);
            Storage::delete('public/projects/attachments/' . $user->profile_picture);

        } else {
            $name = $project->attachment;
        }

        $project->title = $validatedData['title'];
        $project->excerpt = $validatedData['excerpt'];
        $project->description = $validatedData['description'];
        $project->category = $validatedData['category'];
        $project->attachment = $name;
        $project->save();

        // Redirect or return a response
        return redirect()->route('projects.edit', ['project' => $project->id])->with('project_updated_success', 'Project created successfully.');
    }

    public function changeStatus(Request $request, string $id)
    {
        $project = Project::find($id);
        $current_status = $request->input('status');

        if ($current_status == 'active') {
            $project->status = $request->input('new_status');
        } else {
            $project->status = $current_status;
        }

        $project->save();

        //Increase CP points of the user
        if ($project->status == 'complete') {
            $user = User::find($project->author->id);
            $user->cp = $user->cp + 3;
            $user->save();
        }

        return redirect()->route('user.manage');
    }

    public function changeStatusByAdmin(Request $request, string $id)
    {

        $project = Project::find($id);

        if ($project->status == 'inactive') {
            if ($request->input('new_status') == 'Approve') {
                $project->status = 'active';
            } elseif ($request->input('new_status') == 'Reject') {
                $project->status = 'aborted';
            }
        }
        if ($project->status == 'active') {
            if ($request->input('new_status') == 'Remove') {
                $project->status = 'aborted';
            }
        }

        $project->save();

        //Increase CP points of the user
        if ($project->status == 'active') {
            $user = User::find($project->author->id);
            $user->cp = $user->cp + 5;
            $user->save();
        }

        return redirect()->back();
    }

    public function manageProjects()
    {
        $projects = Project::where('status', 'inactive')->orWhere('status', 'active')->get();
        return view('admin.manageprojects', ['projects' => $projects]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
