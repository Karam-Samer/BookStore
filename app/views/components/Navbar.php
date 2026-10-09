<nav class="navbar navbar-expand-lg ">
    <div class="container">
        <a class="navbar-brand" href="{{ route('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="" class="img-fluid">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('/') }}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    @auth("admin")

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth("name") }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('/profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('/auth/register') }}">Create New Admin</a></li>
                        <li><a class="dropdown-item" href="{{ route('/auth/logout') }}">Logout</a></li>
                    </ul>
                    @elseauth("customer")

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth("name") }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('/profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('/auth/logout') }}">Logout</a></li>
                    </ul>
                    @else
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Account
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('/auth/login') }}">Login</a></li>
                        <li><a class="dropdown-item" href="{{ route('/auth/register') }}">Register</a></li>
                    </ul>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>