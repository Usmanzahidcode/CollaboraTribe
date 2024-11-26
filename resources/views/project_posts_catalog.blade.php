<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Project catalog | CollaboraTribe</title>
    @include('components.head')
</head>

<body>

@include('components.header')

<div class="container-fluid py-5">
    <div class="container-sm mt-2">
        <h1 class="serif display-5">Latest Projects</h1>

        @if ($projects->count() == 0)
            <p>No projects Yet.</p>
        @endif

        <div class="col-md-12">
            @foreach($projects as $project)
                <div
                    class="row g-0 gap-4 border rounded overflow-hidden flex-md-row-reverse mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static gap-2 align-items-start">
                        <strong class="d-inline-block mb-0 text-success fs-6">{{ $project->category }}</strong>
                        <h3 class="mb-0 fs-1 serif fw-bold">{{ $project->title }}</h3>
                        <p class="fs-5 mb-2">
                            {{ $project->excerpt }}</p>

                        <a href="{{ route('projects.show', ['project'=>$project->id]) }}"
                           class="stretched-link text-decoration-none fw-medium btn btn-success">See details</a>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $projects->links() }}
    </div>
</div>

@include('components.footer')
</body>
</html>
