<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1"/>
    <title>Sign In! | CollaboraTribe</title>
    @include('components.head')
</head>
<body class = "d-flex flex-column vh-100 justify-content-between">

@include('components.header')
<div class = "container py-4">
    <div class = "w-100 d-flex justify-content-center align-items-center">
        <img src = "{{ asset('assets/images/logo_full_color.png') }}" class = "me-3 pb-3" width = "300px" alt = ""/>
    </div>

    <div class = "row px-0">
        <div class = "col-11 col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto p-4 text-bg-success rounded">
            <h1 class = "text-center serif">Sign In!</h1>
            <p class = "text-center">
                Sign into your account to start collaborating.
            </p>
            <form action = "{{ route('users.signin_submit') }}" method = "post">
                @csrf

                @if(session('signin-error') != null)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Sign Failed!</strong> Please recheck your credentials and try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('signout-success') != null)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Logged out Successfully!</strong> .
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class = "input-group">
                    <input name = "email"
                           type = "text"
                           class = "form-control @error('email') is-invalid @enderror"
                           placeholder = "User's email"
                           aria-label = "User's email"
                           aria-describedby = "basic-addon2"  value="{{ old('email') }}"/>
{{--                    <span class = "input-group-text" id = "basic-addon2">@gmail.com</span>--}}
                </div>
                <p class="form-text text-white  mb-3">@error('email') {{$message}} @enderror</p>

                <div class = "input-group flex-nowrap">
							<span class = "input-group-text" id = "addon-wrapping"><i
                                    class = "bi bi-shield-lock-fill"></i></span>
                    <input name = "password"
                           type = "password"
                           class = "form-control @error('password') is-invalid @enderror"
                           placeholder = "Password"
                           aria-label = "Password"
                           aria-describedby = "addon-wrapping"/>
                </div>
                <p class="form-text text-white mb-3">@error('password') {{$message}} @enderror</p>

                <div class = "form-check mb-3">
                    <input class = "form-check-input" type = "radio" name = "remember"
                           id = "flexRadioDefault1">
                    <label class = "form-check-label" for = "flexRadioDefault1">
                        Remember Me!
                    </label>
                </div>

                <div class = "w-100 d-flex justify-content-center mb-3">
                    <input
                        class = "btn btn-light w-100"
                        type = "submit"
                        name = "submit"
                        value = "Submit"
                        id = "submit"/>
                </div>

                <a class="text-white" href="{{ route('users.create') }}">I don't have an account!</a>
            </form>
        </div>
    </div>
</div>

@include('components.footer')

</body>
</html>
