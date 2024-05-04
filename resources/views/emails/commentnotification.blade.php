<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"
    />
    <meta name="color-scheme" content="dark"/>
    <title>Comment Notification | CollaboraTribe</title>
</head>
<body class="secondary">
<div class="container-fluid" style="padding: 20px">
    <img src="https://i.ibb.co/85tsGxL/logo-header.png" alt="CollaboraTribe Logo" width="300">
    <h6>Hurrah! <strong>{{ $data['to'] }}</strong> You just got an application on the project: {{ $data['project'] }}
    </h6>
    <p>{{ $data['commenter'] }} just commented on your project:</p>
    <blockquote>
        {{ $data['comment'] }}
        <footer>
            <cite>-{{ $data['commenter'] }}</cite>
        </footer>
    </blockquote>

    <a href="{{ $data['link'] }}"><button>See your project!</button></a>

</div>
</body>
</html>
