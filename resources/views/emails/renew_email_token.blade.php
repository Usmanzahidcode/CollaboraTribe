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
    <title>Welcome Email | CollaboraTribe</title>
</head>
<body class="secondary">
<div class="container-fluid" style="padding: 20px">
    <img src="https://i.ibb.co/85tsGxL/logo-header.png" alt="CollaboraTribe Logo" width="300">
    <h6>This email was generate by <strong>{{ $mailData['name'] }}</strong> for regenerating email verification link.
    </h6>
    <p>Here is your newly generated verification link.</p>
    <p>Just one step left, and that is to verify your email. Sorry for this blockade, we just want to make sure that you
        are using your own email address for using the platform!</p>
    <p>This email was intended for account {{ $mailData['email']}}. Verify the email using the newly generated link below!</p>

    <a href="{{ $mailData['link'] }}"><button>Verify Email!</button></a>
    <br>
    <em>Please Ignore this email if you did not sign up on the platform!</em>

</div>
</body>
</html>

