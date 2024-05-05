<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Reset Password! | CollaboraTribe</title>
    @include('components.head')
</head>
<body class="d-flex flex-column vh-100 justify-content-between">

@include('components.header')
<div class="container py-4">
    <div class="w-100 d-flex justify-content-center align-items-center">
        <img src="{{ asset('assets/images/logo_full_color.png') }}" class="me-3 pb-3" width="300px" alt=""/>
    </div>

    <div class="row px-0">
        <div class="col-11 col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto p-4 text-bg-success rounded">
            <h1 class="text-center serif">Reset Password</h1>
            <p class="text-center">
                Input Your email with which you made your account!
            </p>
            <form action="{{ route('reset.submitted',['email' => $email]) }}" method="post">
                @csrf
                <div class="input-group flex-nowrap">
							<span class="input-group-text" id="addon-wrapping"><i
                                    class="bi bi-shield-lock-fill"></i></span>
                    <input name="password"
                           type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password"
                           aria-label="Password"
                           aria-describedby="addon-wrapping"/>
                </div>
                <p class="form-text text-white mb-3">@error('password') {{$message}} @enderror</p>

                <div class="input-group flex-nowrap">
							<span class="input-group-text" id="addon-wrapping"><i
                                    class="bi bi-shield-lock-fill"></i></span>
                    <input name="password_confirmation"
                           type="password"
                           class="form-control @error('confirm_password') is-invalid @enderror"
                           placeholder="Confirm Password"
                           aria-label="Password"
                           aria-describedby="addon-wrapping"/>
                </div>
                <p class="form-text text-white mb-3">@error('confirm_password') {{$message}} @enderror</p>

                <div class="w-100 d-flex justify-content-center my-3">
                    <input
                        class="btn btn-warning w-100"
                        type="submit"
                        name="submit"
                        value="Submit"
                        id="submit"/>
                </div>
            </form>
        </div>
    </div>
</div>

@include('components.footer')

</body>
</html>
