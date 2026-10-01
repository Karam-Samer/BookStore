<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('CSS/plugins/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/global.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/auth/auth.css') }}">

    <!-- JS -->

    <script src="{{ asset('JS/plugins/jquery.js') }}"></script>
    <script src="{{ asset('JS/plugins/bootstrap.js') }}"></script>
</head>

<body>
    <x-Navbar />


    <section id="Register">
        <div class="container my-5">
            <form class="w-25 m-auto" method="POST" action="{{ route('/auth/register') }}">
                <h1 class="text-center mb-4 text-success">Register</h1>
                {{ getSessionMsg('_errorMsg', 'danger') }}
                <div class="mb-3">
                    <label for="Role" class="form-label">Role :</label>
                    <select name="role" id="Role" class="form-select">
                        @if (isAuth("admin"))
                        <option value="admin" {{oldSelect('role', 'admin', true)}}>Admin</option>
                        @else
                        <option value="customer" {{oldSelect('role', 'customer', true)}} selected>Customer</option>
                        @endif

                    </select>
                    {{ getError('role') }}
                </div>
                <div class="mb-3">
                    <label for="Name" class="form-label">Name :</label>
                    <input type="text" class="form-control" id="Name" name="name" value="{{ old('name') }}">
                    {{ getError('name') }}
                </div>
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
                <div class="mb-3">
                    <label for="Phone" class="form-label">Phone :</label>
                    <input type="text" class="form-control" id="Phone" name="phone" value="{{ old('phone') }}">
                    {{ getError('phone') }}
                </div>
                <div class="mb-3">
                    <label for="Gender" class="form-label">Gender :</label>
                    <select name="gender" id="Gender" class="form-select">
                        <option value="" {{oldSelect('gender', '')}} hidden></option>
                        <option value="male" {{oldSelect('gender', 'male')}}>Male</option>
                        <option value="female" {{oldSelect('gender', 'female', true)}}>Female</option>
                    </select>
                    {{ getError('gender') }}
                </div>
                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>
        </div>
    </section>

</body>

</html>