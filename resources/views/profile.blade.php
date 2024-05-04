<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    @php
        $arr = explode(' ', trim(Auth::user()->name));
        $name = $arr[0];

        if (isset($arr[1])) {
            $name .= ' ' . $arr[1];
        }
    @endphp
    <title>{{ $name }} - Account | CollaboraTribe</title>
    @include('components.head')


    {{--        <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"--}}
    {{--                integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D"--}}
    {{--                crossorigin="anonymous"--}}
    {{--                async></script>--}}
</head>

<body class="vh-100 d-flex flex-column justify-content-between">
@include('components.header')
<div class="container-fluid py-5">

    <div class="container-sm">
        <div class="col-12 col-md-10 mx-auto">
            <h1 class="serif mb-4">Account settings</h1>
            @if(session('email_status') != null)
                @if(session('email_status') == 'expired')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Token Expired</strong> The email verification Link has been expired! Resend the link for verification.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @else
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('email_status') }}</strong> Now you may start using the platform!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endif


            @if(session('password_change_failed') != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please Retry!</strong> Old password is not right.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('password_change_success') != null)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Password changed!</strong> You may use your new password now.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="d-flex flex-row gap-3 align-items-start">
                <div class="nav nav-tabs d-flex flex-column gap-2 border-bottom-0 w-auto tab-cont"
                     id="nav-tab"
                     role="tablist">
                    <button class=" btn btn-outline-success active border-2 fs-5 py-2 px-5 rounded-1"
                            id="nav-home-tab"
                            data-bs-toggle="tab" data-bs-target="#nav-profile-info" type="button"
                            role="tab"
                            aria-controls="nav-profile-info"
                            aria-selected="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor" class="a-icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Profile Info
                    </button>
                    <button class="btn btn-outline-success border-2 fs-5 py-2 px-5 rounded-1"
                            id="nav-Info-tab"
                            data-bs-toggle="tab" data-bs-target="#nav-projects" type="button"
                            role="tab" aria-controls="nav-tab-stats"
                            aria-selected="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor" class="a-icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
                        </svg>
                        Your Projects
                    </button>
                    @if(Auth::user()->status != 'banned')
                        <button class="btn btn-outline-success  border-2 fs-5 py-2 px-5 rounded-1"
                                id="nav-profile-tab"
                                data-bs-toggle="tab" data-bs-target="#nav-stats" type="button"
                                role="tab" aria-controls="nav-stats"
                                aria-selected="false">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor" class="a-icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                            </svg>

                            Update info
                        </button>
                        <button class=" btn btn-outline-success  border-2 fs-5 py-2 px-5 rounded-1"
                                id="nav-password-tab"
                                data-bs-toggle="tab" data-bs-target="#nav-unknown" type="button"
                                role="tab" aria-controls="nav-i"
                                aria-selected="false">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor" class="a-icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Password
                        </button>
                    @endif

                </div>
                <div class="tab-content w-75 ps-2" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-profile-info" role="tabpanel"
                         aria-labelledby="nav-tab-home">
                        <p class="badge text-bg-primary">{{ $user->role }}</p>
                        <h1>{{ $user->name }}</h1>
                        <p class="fst-italic">Created on: <span>{{ $user->created_at }}</span><span
                                class="badge text-bg-warning ms-3"
                                data-bs-toggle="popover" data-bs-placement="top"
                                data-bs-trigger="focus" tabindex="0"
                                data-bs-title="Collaboration points"
                                data-bs-custom-class="custom-popover" data-bs-content="This shows you activity on CollaboraTribe.
										The more acctive you are on the platform, the more points you have!">CP: {{ $user->cp }}</span>
                        </p>
                        <p class="fst-italic">Last Updated: {{ $user->updated_at }}</p>
                        <p class=" fs-5">
                            {{ $user->bio }}
                        </p>
                        <div class="row ">
                            <div class="col">
                                <div class="card text-center">
                                    <div class="card-header text-bg-success">
                                        Projects Posted!
                                    </div>
                                    <div class="card-body">
                                        <h1>{{ $user->authoredProjects->count() }}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card text-center">
                                    <div class="card-header text-bg-success">
                                        Applied on!
                                    </div>
                                    <div class="card-body">
                                        <h1>{{ $user->authoredComments->count() }}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card text-center">
                                    <div class="card-header text-bg-success">
                                        Completed project
                                    </div>
                                    <div class="card-body">
                                        <h1>{{ $user->authoredProjects()->where('status', 'complete')->count() }}</h1>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    @if(Auth::user()->status != 'banned')
                        <div class="tab-pane fade show" id="nav-stats" role="tabpanel"
                             aria-labelledby="nav-tab-stats">
                            <h1>Update Profile Info</h1>
                            <form action="{{ route('users.update', ['user'=>$user->id]) }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <p class="form-text">Fill the fields needed to update and leave other as it is.</p>
                                <div class="input-group flex-nowrap mb-3">
							<span class="input-group-text" id="addon-wrapping"><i
                                    class="bi bi-person-fill"></i></span>
                                    <input name="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Full name"
                                           aria-label="name"
                                           aria-describedby="addon-wrapping" value="{{ $user->name }}">
                                </div>
                                <p class="form-text text-danger  mb-3">@error('name') {{$message}} @enderror</p>
                                <div class="input-group mb-3">
                                    <input name="email"
                                           type="text"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="User's email"
                                           aria-label="User's email"
                                           aria-describedby="basic-addon2"
                                           value="{{ $user->email }}"/>
                                </div>
                                <p class="form-text text-danger  mb-3">@error('email') {{$message}} @enderror</p>
                                <div class="input-group flex-nowrap ">
                                    <input name="github" value="{{ $user->github }}"
                                           type="text"
                                           class="form-control @error('github') is-invalid @enderror"
                                           placeholder="Github Link"/>
                                </div>
                                <p class="form-text text-danger  mb-3">@error('github') {{$message}} @enderror</p>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Bio</span>
                                    <textarea name="bio" class="form-control @error('bio') is-invalid @enderror"
                                              aria-label="With textarea"
                                              placeholder="Hello World! A Laravel Developer with a keen interest in fullstack side of web development."
                                              rows="3">{{ $user->bio }}</textarea>
                                </div>
                                <p class="form-text text-danger  mb-3">@error('bio') {{$message}} @enderror</p>
                                <p class="form-text text-success">Change Profile Picture if needed!</p>
                                <div class="input-group flex-nowrap mb-3">
                                    <input name="profile_picture"
                                           type="file"
                                           class="form-control"/>
                                </div>
                                <p class="form-text text-danger  mb-3">@error('profile_picture') {{$message}} @enderror</p>
                                <div class="w-100 d-flex justify-content-center mb-3">
                                    <input
                                        class="btn btn-outline-primary w-100"
                                        type="submit"
                                        name="submit"
                                        value="Submit"
                                        id="submit"/>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade show" id="nav-unknown" role="tabpanel"
                             aria-labelledby="nav-tab-">
                            <h1 class="serif">Update Password</h1>
                            <form class="form" action="{{ route('user.changepassword') }}" method="POST">
                                @csrf
                                <input type="password"
                                       class="form-control mt-3 @error('old_password') is-invalid @enderror"
                                       name="old_password" id="old_password"
                                       placeholder="Older Password">
                                <p class="form-text">@error('old_password') {{ $message }} @enderror</p>
                                <input type="password"
                                       class="form-control mt-3 @error('new_password') is-invalid @enderror"
                                       name="new_password" id="new_password"
                                       placeholder="New Password">
                                <p class="form-text">@error('new_password') {{ $message }} @enderror</p>
                                <input type="password"
                                       class="form-control mt-3 @error('new_password_confirmation') is-invalid @enderror"
                                       name="new_password_confirmation" id="password_confirmation"
                                       placeholder="Confirm Password">
                                <p class="form-text">@error('new_password_confirmation') {{ $message }} @enderror</p>
                                <input class="form-control mt-3 btn btn-success" name="submit" id="submit"
                                       type="submit">
                            </form>
                        </div>
                    @endif
                    <div class="tab-pane fade show" id="nav-projects" role="tabpanel"
                         aria-labelledby="nav-tab-">
                        <h1>Your projects so far</h1>
                        <p>
                            Here are all of your projects.
                        <div class="row d-flex">
                            @foreach( $user->authoredProjects->reverse() as $project )
                                <div class="col-sm-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">

                                            @if($project->status == 'complete')
                                                <h6 class="badge text-bg-success">Completed</h6>
                                            @elseif($project->status == 'aborted')
                                                <h6 class="badge text-bg-danger">Aborted</h6>
                                            @elseif($project->status == 'active')
                                                <h6 class="badge text-bg-primary">Active</h6>
                                            @elseif($project->status == 'inactive')
                                                <h6 class="badge text-bg-warning">In-Active</h6>
                                            @endif
                                            <h5 class="card-title m-0">{{$project->title}}
                                            </h5>
                                            <div class="my-2"><a
                                                    href="{{route('projects.show', ['project'=>$project->id])}}"
                                                    class="text-decoration-none text-decoration-underline text-dark py-5 fst-italic">See
                                                    Project
                                                    >></a>
                                            </div>
                                            @if($project->status == 'active')
                                                <form
                                                    action="{{ route('project.changestatus', ['project'=>$project->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden"
                                                           value="{{ $project->status }}" name="status">
                                                    <input type="submit" class="btn btn-success"
                                                           value="complete" name="new_status">
                                                    <input type="submit" class="btn btn-danger"
                                                           value="aborted" name="new_status">
                                                </form>

                                            @endif
                                            @if($project->status == 'active' )
                                                <a class="btn btn-primary btn-sm d-flex align-items-center gap-2 mt-3"
                                                   href="{{ route('projects.edit', ['project' => $project->id]) }}">
                                                    <svg width="20px" height="20px" viewBox="0 0 24 24"
                                                         fill="#000000"
                                                         x="128" y="128"
                                                         role="img"
                                                         style="display:inline-block;vertical-align:middle"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <g fill="black">
                                                            <g fill="none" stroke="currentColor"
                                                               stroke-linecap="round"
                                                               stroke-linejoin="round"
                                                               stroke-width="2">
                                                                <path
                                                                    d="m16.474 5.408l2.118 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621Z"/>
                                                                <path
                                                                    d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3"/>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                    <p>Edit Project</p>
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>


                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

<!--</div>-->


@include('components.footer')
<script>
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
</script>


<style>
    .popover-arrow {
        display: none !important;
    }

    .popover {
        /*border-color: #279863;*/
    }

    .popover-header {
        color: white !important;
        background-color: #279863 !important;
    }

    .popover-body {
    }
</style>
@if(session('tab') != null && session('tab') == 'pass' || $errors->any())
    <script>
        const element = document.getElementById('nav-password-tab');
        element.click();
    </script>
@endif

</body>

</html>
