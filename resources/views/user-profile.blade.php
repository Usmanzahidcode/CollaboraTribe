<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title>{{ $user->name }} - Account | CollaboraTribe</title>
    @include('components.head')
    {{--        <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"--}}
    {{--                integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D"--}}
    {{--                crossorigin="anonymous"--}}
    {{--                async></script>--}}
</head>

<body class="vh-100 d-flex flex-column justify-content-between">
@include('components.header')

<div class="container mx-auto my-5">
    <div class="row">
        <div class="col-lg-4 col-sm-6 mx-auto">
            <div class="card hovercard rounded-3">
                <div class="cardheader">

                </div>
                <div class="px-4">
                    <div
                        class="profile-avatar mb-0">
                        <img alt="user profile picture" width="90"
                             src="{{ asset('storage/userData/profile_pictures') }}/{{ $user->profile_picture }}">
                    </div>
                    <div class="info">
                        @if($user->role == 'admin')
                            <div class="desc text-bg-warning rounded-5 w-25 mx-auto mb-1">{{ $user->role }}</div>
                        @endif
                        @if($user->status == 'banned')
                            <div class="desc text-bg-danger rounded-5 w-50 mx-auto mt-1 mb-1">User is Banned</div>
                        @endif
                        <div class="title">
                            <h3>{{ $user->name }}</h3>
                        </div>
                        <div class="desc mt-3">Joined: {{ $user->created_at }}</div>
                        <div class="desc text-bg-dark rounded-5 w-50 mx-auto mt-1 mb-1">Collab
                            Points: {{ $user->cp }}</div>
                        <div class="desc"><a class="text-decoration-none text-black"
                                             href="mailto:{{ $user->email }}">{{ $user->email }}</a></div>
                        <div class="desc py-4">{{ $user->bio }}</div>
                    </div>
                    <div class="bottom">
                        <a class="btn btn-profile-card text-bg-dark btn-twitter btn-sm" target="_blank"
                           href="{{ $user->github }}">
                            <i class="bi bi-github"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>


<!--</div>-->


@include('components.footer')

</body>
<style>
    .profile-avatar {
        display: inline-block;
        width: 100px;
        height: 100px;
        overflow: hidden;
        margin: auto;
        margin-top: -50px;
        border: solid 5px rgba(255, 255, 255, 0.85);
        border-radius: 1000px;
    }

    .card {
        padding-top: 20px;
        margin: 10px 0 20px 0;
        background-color: rgba(214, 224, 226, 0.2);
        border-top-width: 0;
        border-bottom-width: 2px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .card .card-heading {
        padding: 0 20px;
        margin: 0;
    }

    .card .card-heading.simple {
        font-size: 20px;
        font-weight: 300;
        color: #777;
        border-bottom: 1px solid #e5e5e5;
    }

    .card .card-heading.image img {
        display: inline-block;
        width: 46px;
        height: 46px;
        margin-right: 15px;
        vertical-align: top;
        border: 0;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
    }

    .card .card-heading.image .card-heading-header {
        display: inline-block;
        vertical-align: top;
    }

    .card .card-heading.image .card-heading-header h3 {
        margin: 0;
        font-size: 14px;
        line-height: 16px;
        color: #262626;
    }

    .card .card-heading.image .card-heading-header span {
        font-size: 12px;
        color: #999999;
    }

    .card .card-body {
        padding: 0 20px;
        margin-top: 20px;
    }

    .card .card-media {
        padding: 0 20px;
        margin: 0 -14px;
    }

    .card .card-media img {
        max-width: 100%;
        max-height: 100%;
    }

    .card .card-actions {
        min-height: 30px;
        padding: 0 20px 20px 20px;
        margin: 20px 0 0 0;
    }

    .card .card-comments {
        padding: 20px;
        margin: 0;
        background-color: #f8f8f8;
    }

    .card .card-comments .comments-collapse-toggle {
        padding: 0;
        margin: 0 20px 12px 20px;
    }

    .card .card-comments .comments-collapse-toggle a,
    .card .card-comments .comments-collapse-toggle span {
        padding-right: 5px;
        overflow: hidden;
        font-size: 12px;
        color: #999;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .card-comments .media-heading {
        font-size: 13px;
        font-weight: bold;
    }

    .card.people {
        position: relative;
        display: inline-block;
        width: 170px;
        height: 300px;
        padding-top: 0;
        margin-left: 20px;
        overflow: hidden;
        vertical-align: top;
    }

    .card.people:first-child {
        margin-left: 0;
    }

    .card.people .card-top {
        position: absolute;
        top: 0;
        left: 0;
        display: inline-block;
        width: 170px;
        height: 150px;
        background-color: #ffffff;
    }

    .card.people .card-top.green {
        background-color: #53a93f;
    }

    .card.people .card-top.blue {
        background-color: #427fed;
    }

    .card.people .card-info {
        position: absolute;
        top: 150px;
        display: inline-block;
        width: 100%;
        height: 101px;
        overflow: hidden;
        background: #ffffff;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .card.people .card-info .title {
        display: block;
        margin: 8px 14px 0 14px;
        overflow: hidden;
        font-size: 16px;
        font-weight: bold;
        line-height: 18px;
        color: #404040;
    }

    .card.people .card-info .desc {
        display: block;
        margin: 8px 14px 0 14px;
        overflow: hidden;
        font-size: 12px;
        line-height: 16px;
        color: #737373;
        text-overflow: ellipsis;
    }

    .card.people .card-bottom {
        position: absolute;
        bottom: 0;
        left: 0;
        display: inline-block;
        width: 100%;
        padding: 10px 20px;
        line-height: 29px;
        text-align: center;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .card.hovercard {
        position: relative;
        padding-top: 0;
        overflow: hidden;
        text-align: center;
        background-color: rgba(214, 224, 226, 0.2);
    }

    .card.hovercard .cardheader {
        background: url("https://source.unsplash.com/random/400x250/?jungle,tree");
        background-size: cover;
        height: 135px;
    }

    .card.hovercard .info {
        padding: 4px 8px 10px;
    }

    .card.hovercard .info .title {
        margin-bottom: 4px;
        font-size: 24px;
        line-height: 1;
        color: #262626;
        vertical-align: middle;
    }

    .card.hovercard .info .desc {
        overflow: hidden;
        font-size: 12px;
        line-height: 20px;
        color: #737373;
        text-overflow: ellipsis;
    }

    .card.hovercard .bottom {
        padding: 0 20px;
        margin-bottom: 17px;
    }

    .btn-profile-card {
        border-radius: 50%;
        width: 32px;
        height: 32px;
        line-height: 18px;
    }

</style>
</html>
