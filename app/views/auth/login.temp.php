<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo asset('CSS/plugins/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('CSS/global.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('CSS/auth/auth.css'); ?>">

    <!-- JS -->

    <script src="<?php echo asset('JS/plugins/jquery.js'); ?>"></script>
    <script src="<?php echo asset('JS/plugins/bootstrap.js'); ?>"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="<?php echo route('/'); ?>">
            <img src="<?php echo asset('images/logo.png'); ?>" alt="" class="img-fluid">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo route('/'); ?>">Home</a>
                </li>
                <li class="nav-item dropdown"><?php if (isAuth("admin" ?? null)): ?>
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo auth("name"); ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo route('/profile'); ?>">Profile</a></li>
                        <li><a class="dropdown-item" href="<?php echo route('/auth/register'); ?>">Create New Admin</a></li>
                        <li><a class="dropdown-item" href="<?php echo route('/auth/logout'); ?>">Logout</a></li>
                    </ul><?php elseif (isAuth("customer" ?? null)): ?>
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo auth("name"); ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo route('/profile'); ?>">Profile</a></li>
                        <li><a class="dropdown-item" href="<?php echo route('/auth/logout'); ?>">Logout</a></li>
                    </ul><?php else: ?>
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Account
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo route('/auth/login'); ?>">Login</a></li>
                        <li><a class="dropdown-item" href="<?php echo route('/auth/register'); ?>">Register</a></li>
                    </ul><?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <section id="Login">
        <div class="container my-5">
            <form class="w-25 m-auto" method="POST" action="<?php echo route('/auth/login'); ?>">
                <h1 class="text-center mb-4 text-success">Login</h1>
                <?php echo getSessionMsg('_invalid', 'danger'); ?>
                <div class="mb-3">
                    <label for="Email" class="form-label">Email :</label>
                    <input type="email" class="form-control" id="Email" name="email" value="<?php echo old('email'); ?>">
                    <?php echo getError('email'); ?>
                </div>
                <div class="mb-3">
                    <label for="Password" class="form-label">Password :</label>
                    <input type="password" class="form-control" id="Password" name="password" value="<?php echo old('password'); ?>">
                    <?php echo getError('password'); ?>
                </div>
                <button type="submit" class="btn btn-success w-100">Login</button>
            </form>
        </div>
    </section>

</body>

</html>