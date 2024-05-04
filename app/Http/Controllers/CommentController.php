<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Mail\SomeoneCommented;
use App\Models\Comment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $project_id)
    {
        $comment = new Comment();

        $comment->comment = $request->input('comment');
        $comment->author_id = Auth::user()->id;
        $comment->project_id = $project_id;

        $comment->save();

        //Increase CP points of the user
        $user = User::find(Auth::user()->id);
        $user->cp = $user->cp + 2;
        $user->save();

        $project = Project::find($project_id);
        $proj_author = User::find($project->author->id);

        $data = [
            'to' => $proj_author->name,
            'commenter' => $user->name,
            'comment' => $comment->comment,
            'project' => $project->title,
            'link' => route('projects.show', ['project' => $project->id]),
        ];

        Mail::to($proj_author->email)->send(new SomeoneCommented($data));

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comment = Comment::find($id);
        if (Auth::user()->id == $comment->author_id) {
            return view('editcomment', ['comment' => $comment]);
        }
        return view('components.forbidden');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::find($id);
//        dd($comment);
        $comment->comment = $request->comment;
        $comment->save();

        return redirect()->back()->with('comment_updated', 'true');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
