<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>
        Edit comment | collaboratribe
    </title>
    @include('components.head')
</head>

<body>
@include('components.header')

<div class="container-md my-3">
    <form method="post" action="{{ route('comments.update', ['comment' => $comment->id]) }}"
          class="w-50 mx-auto d-flex gap-3 flex-column align-items-center">
        @csrf
        @method('PUT')
        <h1 class="serif">Edit you Comment!</h1>
        @if(session('comment_updated') != null)
            <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                <strong>Comment edited successfully!</strong> ...
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="input-group">
            <span class="input-group-text d-none d-sm-block">Your comment</span>
            <textarea name="comment" class="form-control rounded-end"
                      aria-label="With textarea"
                      placeholder="Explain how you can be helpful in this project"
                      rows="3">{{ $comment->comment }}</textarea>
        </div>
        <input type="submit" value="Submit" class="btn btn-success">
    </form>
</div>
@include('components.footer')
</body>
</html>
