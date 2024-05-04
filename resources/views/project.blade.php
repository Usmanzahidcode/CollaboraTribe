<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>
        {{ $project->title }}
    </title>
    @include('components.head')
</head>

<body>
@include('components.header')

<div class="container-md my-3">
    @if($project->status == 'inactive')
        <div class="alert alert-warning" role="alert">
            This project is inactive, and is only visible ot the admin. It can either be approved or rejected!
        </div>
        @if(Auth::user()->role == 'admin')
            <div class="admin-actions text-bg-success rounded-3 p-3 mb-3">
                <p>Admin Actions: </p>
                <form action="{{ route('project.adminapproval', ['project'=>$project->id]) }}" method="post"
                      class="my-3">
                    @csrf
                    <input type="submit" class="btn btn-primary"
                           value="Approve" name="new_status">
                    <input type="submit" class="btn btn-danger"
                           value="Reject" name="new_status">
                </form>
            </div>
        @endif
    @endif
    @if($project->status == 'active')
        @if(Auth::user()->role == 'admin')
            <div class="admin-actions text-bg-success rounded-3 p-3 mb-3">
                <p>Admin Actions: </p>
                <form action="{{ route('project.adminapproval', ['project'=>$project->id]) }}" method="post"
                      class="my-3">
                    @csrf
                    <input type="submit" class="btn btn-danger"
                           value="Remove" name="new_status">
                </form>
            </div>
        @endif
    @endif
    @if($project->status == 'complete')
        <div class="alert alert-success" role="alert">
            This project is in archive because it was marked as completed by the Author of the project!
        </div>
    @endif
    @if($project->status == 'aborted')
        <div class="alert alert-danger" role="alert">
            This project is in archive because it was marked as aborted, either by the Author of the project, or by
            admins!
        </div>
    @endif
    <div class=" border rounded p-4">
        <div class="d-flex gap-3 align-items-center">
            <h4>
                <span class="badge text-bg-success m-0">{{ $project->category }}</span>
            </h4>
            @if($project->author_id == Auth::user()->id)
                <a class="btn btn-primary btn-sm d-flex align-items-center gap-2"
                   href="{{ route('projects.edit', ['project' => $project->id]) }}">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="#000000" x="128" y="128"
                         role="img" style="display:inline-block;vertical-align:middle"
                         xmlns="http://www.w3.org/2000/svg">
                        <g fill="black">
                            <g fill="none" stroke="currentColor" stroke-linecap="round"
                               stroke-linejoin="round"
                               stroke-width="2">
                                <path
                                    d="m16.474 5.408l2.118 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621Z"/>
                                <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3"/>
                            </g>
                        </g>
                    </svg>
                    <p>Edit Project</p>
                </a>
            @endif
        </div>
        <h1 class="serif display-6 fw-bold my-3">
            {{ $project->title }}
        </h1>

        <p class="m-0"><strong>Author: </strong><span class="fst-italic">
                <a href="{{ route('users.show', ['user' => $project->author->id]) }}">{{ $project->author->name }}</a>
				</span></p>
        <p class="fst-italic mt-0">Posted on:
            {{ $project->created_at }}
        </p>
        <div class="desc">
            {!! $project->description !!}
        </div>
        @if($project->attachment != null)
            <div class="attachment">
                <a class="attachment-button btn btn-outline-primary"
                   href="{{asset('storage/projects/attachments')}}/{{ $project->attachment }}">
                    <svg width="10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                        <path
                            d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128z"/>
                    </svg>
                    Download Attachments
                </a>
            </div>
        @endif
    </div>
    <h2 class="mt-3">Recent comments</h2>
    @if($project->status == 'active')
        @if (!$project->comments()->where('author_id', Auth::user()->id)->exists())
            <div class="row">
                <div class="col-12">
                    <div class="border rounded p-4">
                        <form action="{{ route('comments.store', ['project'=>$project->id]) }}" method="post"
                              class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-start align-items-md-center">
                            @csrf
                            <div class="input-group">
                                <span class="input-group-text d-none d-sm-block">Your comment</span>
                                <textarea name="comment" class="form-control rounded-end"
                                          aria-label="With textarea"
                                          placeholder="Explain how you can be helpful in this project"
                                          rows="3"></textarea>
                            </div>
                            <input type="submit" value="Submit" class="btn btn-success">
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                You have already applied on this project. You may edit your comment from your activity.
            </div>
        @endif
        {{--    @elseif($project->status == 'inactive')--}}
        {{--            <div class="alert alert-warning" role="alert">--}}
        {{--                Comments can be posted after the project is accepted.--}}
        {{--            </div>--}}
    @endif

    @if($project->comments->count() == 0)
        <p>No comments yet, be the first to comment!</p>
    @endif

    <div class="row">
        @foreach($project->comments->reverse() as $comment)
            <div class="col-12 col-md-6 mt-4">
                <div class="border rounded p-4 d-flex flex-column align-items-start"><a
                        href="{{ route('users.show', ['user' => $comment->author->id]) }}"
                        style="text-decoration: none; color: inherit">
                        <p class="fw-bold fs-5 m-0">{{ $comment->author->name }}</p></a>
                    {{--                    <p class="badge text-bg-success mb-2"><strong>Email: </strong><span><a--}}
                    {{--                                href="mailto:{{ $comment->author->email }}"--}}
                    {{--                                class="text-decoration-none fw-medium text-white">{{ $comment->author->email }}</a></span>--}}
                    {{--                    </p>--}}
                    <p class="fs-5 m-0">{{ $comment->comment }}</p>
                    @if($comment->author_id == Auth::user()->id)
                        <a class="btn btn-primary btn-sm d-flex align-items-center gap-2 mt-3"
                           href="{{ route('comments.edit', ['comment' => $comment->id]) }}">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="#000000" x="128" y="128"
                                 role="img" style="display:inline-block;vertical-align:middle"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g fill="black">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round"
                                       stroke-linejoin="round"
                                       stroke-width="2">
                                        <path
                                            d="m16.474 5.408l2.118 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621Z"/>
                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3"/>
                                    </g>
                                </g>
                            </svg>
                            <p>Edit comment</p>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</div>


@include('components.footer')
<style>
    svg {
        fill: blue;
    }

    .attachment-button:hover svg {
        fill: white;
    }
</style>

</body>

</html>
