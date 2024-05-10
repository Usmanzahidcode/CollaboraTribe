<link
    href="{{ asset('assets/css/bootstrap/css/bootstrap.min.css') }}"
    rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('assets/css/stylesheet/app.css') }}"/>

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>


<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">


{{--  Pusher receiver  --}}

@if(Auth::check() && Auth::user()->role == 'admin')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">


    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('47d330654fc0f6c17829', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('admin-channel');
        channel.bind('new-user-event', function (data) {
            Toastify({
                text: "New User: " + data.name,
                duration: 6000,
                destination: data.link,
                newWindow: true,
                close: true,
                gravity: "bottom",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #ff6666, #ffcc66)",
                },
                onClick: function () {
                }
            }).showToast();
        });
        channel.bind('new-project-event', function (data) {
            Toastify({
                text: "New project: " + data.title,
                duration: 6000,
                destination: data.link,
                newWindow: true,
                close: true,
                gravity: "bottom",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                onClick: function () {
                }
            }).showToast();
        });
    </script>
@endif

