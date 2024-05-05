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
    <title>Reset Password | CollaboraTribe</title>
</head>
<body class="secondary">
<div class="container-fluid" style="padding: 20px">
    <img src="https://i.ibb.co/85tsGxL/logo-header.png" alt="CollaboraTribe Logo" width="300">
    <h6>Password reset for {{ $data['email']}}
    </h6>
    <p>Here is your newly generated verification link.</p>
    <p>This email was intended for account {{ $data['email']}}. Reset your password using the following link:</p>
    <strong>You only have one hour for using this link!</strong>

    <a href="{{ $data['link'] }}">
        <button>Reset Password</button>
    </a>
    <br>
    <em>Please Ignore this email if you did not opt into resetting password!</em>

</div>
</body>
</html>

