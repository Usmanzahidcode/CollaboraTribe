<div class="container-fluid text-bg-dark py-3 m-0">
    <div class="container">
        <footer
            class="d-flex flex-wrap justify-content-between align-items-center">
            <p class="col-md-4 mb-0">© 2024 CollaboraTribe, Inc</p>
            <a
                href="/"
                class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <img class="bi me-2" width="100" src="{{ asset('assets/images/logo_header.png') }}"/>
            </a>

            <ul class="nav col-md-4 justify-content-end text-light">
                <li class="nav-item">
                    <a href="/" class="nav-link px-2 text-light">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.manage') }}" class="nav-link px-2 text-light">Account</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('projects.archive') }}" class="nav-link px-2 text-light">Archive</a>
                </li>
            </ul>
        </footer>
    </div>
</div>

<!-- bootstrap js -->
<script
    src="{{ asset('assets/css/bootstrap/js/bootstrap.bundle.js') }}">
</script>
