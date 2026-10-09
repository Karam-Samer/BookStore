<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('CSS/plugins/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/plugins/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/style.css') }}">


    <!-- JS -->

    <script src="{{ asset('JS/plugins/jquery.js') }}"></script>
    <script src="{{ asset('JS/plugins/bootstrap.js') }}"></script>
</head>

<body>
    <x-Navbar />


    <section id="Login">
        <div class="container my-5">
            <form class="m-auto" method="POST" action="{{ route('/auth/login') }}">
                <h1 class="text-center mb-4 mainTitle">Login</h1>
                {{ getSessionMsg('_invalid', 'danger') }}
                <div class="mb-3">
                    <label for="Email" class="form-label">Email :</label>
                    <input type="email" class="form-control" id="Email" name="email" value="{{ old('email') }}">
                    {{ getError('email') }}
                </div>
                <div class="mb-3">
                    <label for="Password" class="form-label">Password :</label>
                    <input type="password" class="form-control" id="Password" name="password" value="{{ old('password') }}">
                    {{ getError('password') }}
                </div>
                <button type="submit" class="btn mainButton w-100">Login</button>
            </form>
        </div>
    </section>

</body>

</html>