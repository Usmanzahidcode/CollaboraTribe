<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Projects | CollaboraTribe</title>
    @include('components.head')
</head>

<body class="vh-100 d-flex flex-column justify-content-between">
@include('components.header')
<div class="container-fluid py-5">
    <h1 class="serif display-5">Manage Projects</h1>
    @if ($projects->count() == 0)
        <p>No projects Yet.</p>
    @else

        <table class="table table-striped table-hover">
            <thead>
            <tr class="table-primary">
                <td>ID</td>
                <td>Title</td>
                <td>Category</td>
                <td>Author</td>
                <td>Creation</td>
                <td>Last Updated</td>
                <td>Status</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr class="data-row">
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->category }}</td>
                    <td>{{ $project->author_id }}</td>
                    <td>{{ $project->created_at }}</td>
                    <td>{{ $project->updated_at }}</td>
                    <td>{{ $project->status }}</td>
                    <td>
                        <a href="{{ route('projects.show', ['project' => $project->id]) }}"
                           class="btn btn-primary btn-sm mb-2">Details</a>
                        @if(Auth::user()->role == 'admin')
                            @if($project->status == 'inactive')
                                <form method="post"
                                      action="{{route('project.adminapproval', ['project' => $project->id ])}}">
                                    @csrf
                                    <input type="submit" name="new_status" value="Approve"
                                           class="btn btn-success btn-sm">
                                    <input type="submit" name="new_status" value="Reject" class="btn btn-danger btn-sm">
                                </form>
                            @elseif($project->status == 'active')
                                <form method="post"
                                      action="{{route('project.adminapproval', ['project' => $project->id ])}}">
                                    @csrf

                                    <input type="submit" name="new_status" value="Remove" class="btn btn-danger btn-sm">
                                </form>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    @endif

</div>
@include('components.footer')

</body>
<style>
    .data-row td {
        vertical-align: middle;
    }
</style>
</html>
