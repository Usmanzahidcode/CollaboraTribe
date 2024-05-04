@php use Illuminate\Support\Facades\Auth; @endphp
<div>
    @if(Auth::check() && Auth::user()->status == 'banned')
        <div class="banner text-bg-danger text-center py-2">

            The user <span class="badge">{{ Auth::user()->name }}</span> has been permanently banned.

        </div>
    @endif
    @if(Auth::check() && Auth::user()->email_verified_at == null)
        <div class="banner text-bg-danger text-center py-2">
            <p>Verify you email address to keep using the application: <a class="badge text-bg-primary text-decoration-none"
                    href="{{ route('verify.email',['token'=>Auth::user()->email_verification_token]) }}">Verify</a>
            </p>
            <a class="btn btn-warning btn-sm mt-2" href="{{ route('regenerate.emailtoken', ['user'=>Auth::user()->id]) }}">Resend email</a>
        </div>
    @endif


    <nav
        class="navbar navbar-expand-md pt-3 pb-3 text-bg-dark"
        data-bs-theme="dark">
        <div class="container-sm align-items-center">
            <a class="navbar-brand" href="/"
            ><img src="{{ asset('assets/images/logo_header.png') }}" width="150px"
                /></a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div
                class="offcanvas offcanvas-end d-flex flex-column
			flex-md-row my-md-0 w-50 align-items-center justify-content-start justify-content-md-between
			px-5 px-md-0 pt-5 pt-md-0 w-auto"
                id="navbarSupportedContent">
                <ul class="fs-6 navbar-nav mb-lg-0 align-items-center mx-auto fs-5 gap-0 gap-lg-5 mb-3 mb-md-0">
                    <li class="nav-item">
                        @if(Auth::check() && Auth::user()->role == 'admin')
                            <a class="nav-link" aria-current="page"
                               href="{{ route('projects.manage') }}">Manage Projects</a>
                        @else
                            <a class="nav-link" aria-current="page"
                               href="/">Home</a>
                        @endif

                    </li>
                    @if(Auth::check() && Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ route('users.index') }}">Manage Users!</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('projects.index') }}">Project Catalog</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if(Auth::check())
                                @php
                                    $arr = explode(' ', trim(Auth::user()->name));
                                    $name = $arr[0];

                                    if (isset($arr[1])) {
                                        $name .= ' ' . $arr[1];
                                    }
                                @endphp
                                {{ $name }}
                            @else
                                Guest User
                            @endif
                        </a>

                        @if(Auth::check())
                            <ul class="dropdown-menu fade">
                                <li><a class="dropdown-item" href="{{ route('user.manage') }}">Profile</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider"/>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('projects.create') }}">Post Project</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider"/>
                                </li>
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">Sign Out
                                    </button>
                                </li>

                            </ul>
                        @else
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('users.create') }}">Sign Up!</a></li>
                                <li>
                                    <hr class="dropdown-divider"/>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('users.signin') }}">Sign In!!</a></li>

                            </ul>
                        @endif
                    </li>
                    @if(Auth::check())
                        <div class="img-square rounded-5" style="width: 50px; height: 50px; overflow: hidden;">
                            <img
                                src="{{ asset('storage/userData/profile_pictures') }}/{{ Auth::user()->profile_picture }}"
                                class="rounded-5"
                                width="50"
                                alt="User profile picture">
                        </div>
                    @endif
                </ul>
                <a
                    class="btn btn-outline-success"
                    href="https://github.com/Usmanzahidcode/collabora-tribe"
                    type="button" target="_blank">
                    Contribute to Platform
                </a>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Logout Confirmation!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to log out of this account? Logging out will end your current session
                        and
                        you
                        will need to log back in to access your information and continue using this site.
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('users.signout') }}" type="button" class="btn btn-danger">Confirm
                            Logout!</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
