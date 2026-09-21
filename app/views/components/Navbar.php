<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="" class="img-fluid">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('/') }}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Account
                    </a>
                    <ul class="dropdown-menu">
                        @if (isAuth())
                        <li><a class="dropdown-item" href="{{ route('/profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('/auth/logout') }}">Logout</a></li>
                        @else
                        <li><a class="dropdown-item" href="{{ route('/auth/login') }}">Login</a></li>
                        <li><a class="dropdown-item" href="{{ route('/auth/register') }}">Register</a></li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>