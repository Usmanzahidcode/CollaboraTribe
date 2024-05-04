<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Manage Users | CollaboraTribe</title>
    @include('components.head')
</head>

<body class="vh-100 d-flex flex-column justify-content-between">
@include('components.header')
<div class="container-fluid py-5 px-5">

    <table class="table table-striped table-hover" vertical-align="center">
        <thead>
        <tr class="table-primary">
            <td>ID</td>
            <td>Profile Pic</td>
            <td>Name</td>
            <td>Email</td>
            <td>Creation</td>
            <td>Last Updated</td>
            <td>Actions</td>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            @if($user->role != 'admin')
                <tr class="data-row">
                    <td>{{ $user->id }}</td>
                    <td>
                        <div class="img-square rounded-5" style="width: 50px; height: 50px; overflow: hidden;">
                            <img src="{{ asset('storage/userData/profile_pictures') }}/{{$user->profile_picture}}"
                                 class="rounded-5"
                                 width="50"
                                 alt="User profile picture">
                        </div>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>
                        @if($user->status == 'active')
                            <form method="post" action="{{route('users.ban', ['user' => $user->id ])}}">
                                @csrf
                                <a href="{{ route('users.show', ['user' => $user->id]) }}"
                                   class="btn btn-primary btn-sm">Details</a>
                                <input type="submit" name="submit" value="Ban" class="btn btn-danger btn-sm">
                            </form>
                        @elseif($user->status == 'banned')
                            <form method="post" action="{{route('users.ban', ['user' => $user->id ])}}">
                                @csrf
                                <a href="{{ route('users.show', ['user' => $user->id]) }}"
                                   class="btn btn-primary btn-sm">Details</a>
                                <input type="submit" name="submit" value="Unban" class="btn btn-warning btn-sm">
                            </form>
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>

    </table>

</div>
@include('components.footer')

</body>
<style>
    .data-row td {
        vertical-align: middle;
    }
</style>
</html>
