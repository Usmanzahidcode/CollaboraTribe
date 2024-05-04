<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Sign Up! | CollaboraTribe</title>
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
            <h1 class="text-center serif">Sign Up!</h1>
            <p class="text-center">
                Create your account and embrace the collaboration journey
            </p>
            <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group flex-nowrap ">
							<span class="input-group-text" id="addon-wrapping"><i
                                    class="bi bi-person-fill"></i></span>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                           placeholder="Full name"
                           aria-label="Username"
                           aria-describedby="addon-wrapping" value="{{ old('name') }}">
                </div>
                <p class="form-text text-white  mb-3">@error('name') {{$message}} @enderror</p>

                <div class="input-group">
                    <input name="email"
                           type="text"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="User's email"
                           aria-label="User's email"
                           aria-describedby="basic-addon2" value="{{ old('email') }}"/>
                    {{--                    <span class="input-group-text" id="basic-addon2">@gmail.com</span>--}}
                </div>
                <p class="form-text text-white  mb-3">@error('email') {{$message}} @enderror</p>

                <div class="input-group">
                    <span class="input-group-text">Bio</span>
                    <textarea name="bio" class="form-control @error('bio') is-invalid @enderror"
                              aria-label="With textarea"
                              placeholder="Hello World! A Laravel Developer with a keen interest in fullstack side of web development."
                              rows="3">{{ old('bio') }}</textarea>
                </div>
                <p class="form-text text-white  mb-3">@error('bio') {{$message}} @enderror</p>

                <div class="input-group flex-nowrap ">
                    <input name="github"
                           type="text"
                           class="form-control @error('github') is-invalid @enderror"
                           placeholder="Github Link"/>
                </div>
                <p class="form-text text-white  mb-3">@error('github') {{$message}} @enderror</p>


                <div class="input-group flex-nowrap ">
							<span class="input-group-text" id="addon-wrapping"><i
                                    class="bi bi-shield-lock-fill"></i></span>
                    <input name="password"
                           type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="8+ length with capital and small letters"
                           aria-label="Password"
                           aria-describedby="addon-wrapping"/>
                </div>
                <p class="form-text text-white  mb-3">@error('password') {{$message}} @enderror</p>

                <div class="input-group flex-nowrap ">
							<span class="input-group-text" id="addon-wrapping"><i
                                    class="bi bi-shield-lock-fill"></i></span>
                    <input name="password_confirmation"
                           type="password"
                           class="form-control @error('password_confirmation') is-invalid @enderror"
                           placeholder="Confirm Password"
                           aria-label="Confirm Password"
                           aria-describedby="addon-wrapping"/>
                </div>
                <p class="form-text text-white  mb-3">@error('password_confirmation') {{$message}} @enderror</p>

                <div class="input-group flex-nowrap">
                    <input name="profile_picture"
                           type="file"
                           class="form-control @error('profile_picture') is-invalid @enderror"/>
                </div>
                <p class="form-text text-white  mb-3">@error('profile_picture') {{$message}} @enderror</p>

                <div class="w-100 d-flex justify-content-center mb-3">
                    <input
                        class="btn btn-light w-100"
                        type="submit"
                        name="submit"
                        value="Submit"
                        id="submit"/>
                </div>
                <a class="text-white" href="{{ route('users.signin') }}">I already have an account!</a>
            </form>
        </div>
    </div>
</div>
@include('components.footer')
</body>
</html>
