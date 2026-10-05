<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | <?php echo auth('role'); ?></title>
    <link rel="stylesheet" href="<?php echo asset('CSS/plugins/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('CSS/plugins/all.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('CSS/style.css'); ?>">

    <script src="<?php echo asset('JS/plugins/jquery.js'); ?>"></script>
    <script src="<?php echo asset('JS/plugins/alert.js'); ?>"></script>
    <script src="<?php echo asset('JS/plugins/bootstrap.js'); ?>"></script>
    <script src="<?php echo asset('JS/profile/functions.js'); ?>"></script><?php if (isAuth("customer" ?? null)): ?>
    <script src="<?php echo asset('JS/profile/customer/cart.js'); ?>"></script>
    <script src="<?php echo asset('JS/profile/customer/orders.js'); ?>"></script><?php elseif (isAuth("admin" ?? null)): ?>
    <script src="<?php echo asset('JS/profile/admin/admin.js'); ?>"></script><?php endif; ?>
    <script src="<?php echo asset('JS/profile/profile.js'); ?>"></script>
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
    <section id="Dashboard" class="py-4 px-2">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card text-center rounded-4 py-3 px-2 border-0">
                        <img src="<?php echo asset('images/default.png'); ?>" class="card-img-top m-auto" alt="" style="width: 100px;">

                        <div class="card-body">
                            <h5 class="card-title mb-3 d-flex align-items-center justify-content-center gap-2">
                                <i class="fa-regular fa-pen-to-square edit text-info" role="button"
                                    data-bs-toggle="modal" data-bs-target="#userEditModal" onclick="editUser(`Name`,`<?php echo auth('name'); ?>`)"></i>
                                <span data-type="name"><?php echo auth("name"); ?></span>
                            </h5>

                            <div class="row mb-3">
                                <div class="col-4 d-flex">
                                    <i class="fa-regular fa-pen-to-square edit text-info" role="button"
                                        data-bs-toggle="modal" data-bs-target="#userEditModal" onclick="editUser(`Email`,`<?php echo auth('email'); ?>`)"></i>
                                    <h6 class="mb-0" style="white-space: nowrap;">Email :</h6>
                                </div>
                                <div class="col-8">
                                    <div class="item text-start">
                                        <h6 class="mb-0 text-muted" data-type="email"><?php echo auth("email"); ?></h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4 d-flex">
                                    <i class="fa-regular fa-pen-to-square edit text-info" role="button"
                                        data-bs-toggle="modal" data-bs-target="#userEditModal" onclick="editUser(`Gender`,`<?php echo auth('gender'); ?>`)"></i>
                                    <h6 class="mb-0" style="white-space: nowrap;">Gender :</h6>
                                </div>
                                <div class="col-8">
                                    <div class="item text-start">
                                        <h6 class="mb-0 text-muted" data-type="gender"><?php echo auth("gender"); ?></h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4 d-flex">
                                    <i class="fa-regular fa-pen-to-square edit text-info" role="button"
                                        data-bs-toggle="modal" data-bs-target="#userEditModal" onclick="editUser(`Phone`, `<?php echo auth('phone'); ?>`)"></i>
                                    <h6 class="mb-0" style="white-space: nowrap;">Phone :</h6>
                                </div>
                                <div class="col-8">
                                    <div class="item text-start">
                                        <h6 class="mb-0 text-muted" data-type="phone"><?php echo auth("phone"); ?></h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4 d-flex">
                                    <i class="fa-regular fa-pen-to-square edit text-info" role="button"
                                        data-bs-toggle="modal" data-bs-target="#userEditModal" onclick="editUser(`password`, '')"></i>
                                    <h6 class="mb-0" style="white-space: nowrap;">Password :</h6>
                                </div>
                                <div class="col-8">
                                    <div class="item text-start">
                                        <h6 class="mb-0 text-muted">••••••••</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 bg-body rounded-5 p-4">
                    <div class="container">

                        <ul class="nav nav-tabs position-relative " id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="statistics-tab" data-bs-toggle="tab"
                                    data-bs-target="#statistics-tab-pane" type="button" role="tab"
                                    aria-controls="statistics-tab-pane" aria-selected="true">
                                    Statistics
                                </button>
                            </li><?php if (isAuth("admin" ?? null)): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="admins-tab" data-bs-toggle="tab"
                                    data-bs-target="#admins-tab-pane" type="button" role="tab"
                                    aria-controls="admins-tab-pane" aria-selected="false">
                                    Admins
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="customers-tab" data-bs-toggle="tab"
                                    data-bs-target="#customers-tab-pane" type="button" role="tab"
                                    aria-controls="customers-tab-pane" aria-selected="false">
                                    Customers
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="authors-tab" data-bs-toggle="tab"
                                    data-bs-target="#authors-tab-pane" type="button" role="tab"
                                    aria-controls="authors-tab-pane" aria-selected="false">
                                    Authors
                                </button>
                            </li><?php endif; ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="books-tab" data-bs-toggle="tab"
                                    data-bs-target="#books-tab-pane" type="button" role="tab"
                                    aria-controls="books-tab-pane" aria-selected="false">
                                    Books
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle nav-link" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Orders
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" id="orders_ordered-tab" data-bs-toggle="tab"
                                                data-bs-target="#orders_ordered-tab-pane" type="button" role="tab"
                                                aria-controls="orders_ordered-tab-pane" aria-selected="false">Ordered</a></li>
                                        <li><a class="dropdown-item" id="orders_canceled-tab" data-bs-toggle="tab"
                                                data-bs-target="#orders_canceled-tab-pane" type="button" role="tab"
                                                aria-controls="orders_canceled-tab-pane" aria-selected="false">Canceled</a></li>
                                        <li><a class="dropdown-item" id="orders_done-tab" data-bs-toggle="tab"
                                                data-bs-target="#orders_done-tab-pane" type="button" role="tab"
                                                aria-controls="orders_done-tab-pane" aria-selected="false">Done</a></li>
                                    </ul>
                                </div>
                            </li><?php if (isAuth("customer" ?? null)): ?>
                            <button type="button" class="btn bg-primary-subtle text-primary-emphasis position-absolute top-0 end-0 " onclick="getCartItems()">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount">
                                    <?= $total['totalCartItems'] ; ?>
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </button><?php endif; ?>
                        </ul>

                        <div class="tab-content mt-3" id="myTabContent">

                            <div class="tab-pane fade show active" id="statistics-tab-pane" role="tabpanel"
                                aria-labelledby="statistics-tab" tabindex="0">
                                <div class="row">
    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 bg-primary-subtle text-primary-emphasis">
                <i class="fa-solid fa-book m-auto"></i>
                <h6 class="my-3">Total Books</h6>
                <p class="text-success mb-0 fw-bolder"><?= $total['books'] ; ?></p>
            </div>
        </div>
    </div><?php if (isAuth("admin" ?? null)): ?>
    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 bg-primary-subtle text-primary-emphasis">
                <i class="fa-solid fa-user-group m-auto"></i>
                <h6 class="my-3">Total Authors</h6>
                <p class="text-success mb-0 fw-bolder"><?= $total['authors'] ; ?></p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 bg-primary-subtle text-primary-emphasis">
                <i class="fa-solid fa-users m-auto"></i>
                <h6 class="my-3">Total Customers</h6>
                <p class="text-success mb-0 fw-bolder"><?= $total['customers'] ; ?></p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 bg-primary-subtle text-primary-emphasis">
                <i class="fa-solid fa-user-gear m-auto"></i>
                <h6 class="my-3">Total Admins</h6>
                <p class="text-success mb-0 fw-bolder"><?= $total['admins'] ; ?></p>
            </div>
        </div>
    </div><?php elseif (isAuth("customer" ?? null)): ?>
    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 bg-primary-subtle text-primary-emphasis">
                <i class="fa-solid fa-book m-auto"></i>
                <h6 class="my-3">Total Bought Books</h6>
                <p class="text-success mb-0 fw-bolder"><?= $total['boughtBooks'] ; ?></p>
            </div>
        </div>
    </div><?php endif; ?>
    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 bg-primary-subtle text-primary-emphasis">
                <i class="fa-solid fa-circle-pause m-auto"></i>
                <h6 class="my-3">Total Ordered Orders</h6>
                <p class="text-success mb-0 fw-bolder"><?= $total['orders']['ordered'] ; ?></p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 bg-primary-subtle text-primary-emphasis">
                <i class="fa-solid fa-ban m-auto"></i>
                <h6 class="my-3">Total Cancelled Orders</h6>
                <p class="text-success mb-0 fw-bolder"><?= $total['orders']['canceled'] ; ?></p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 bg-primary-subtle text-primary-emphasis">
                <i class="fa-solid fa-circle-check m-auto"></i>
                <h6 class="my-3">Total Done Orders</h6>
                <p class="text-success mb-0 fw-bolder"><?= $total['orders']['done'] ; ?></p>
            </div>
        </div>
    </div>
</div>
                            </div><?php if (isAuth("admin" ?? null)): ?>
                            <div class="tab-pane fade" id="admins-tab-pane" role="tabpanel"
                                aria-labelledby="admins-tab" tabindex="0">
                                <?php if (empty($admins['data'])): ?>
<div class="alert alert-warning text-center w-75 m-auto" role="alert">
    No admins found.
</div><?php else: ?>
<div class="row"><?php foreach ($admins['data'] as $admin): ?>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis position-relative"><?php if ($admin['is_banned']): ?>
            <span class="badge text-bg-danger position-absolute top-0 end-0 m-3">
                Banned
            </span><?php endif; ?>
            <img
                src="<?php echo asset('images/admin.png'); ?>"
                class="card-img-top m-auto"
                alt="Admin"
                style="width: 100px;"><?php if ($admin['gender'] === 'female'): ?>
            <i class="fa-solid fa-venus position-absolute top-0 start-0 m-3 fs-4" style="color:darkmagenta;"></i><?php else: ?>
            <i class="fa-solid fa-mars position-absolute top-0 start-0 m-3 fs-4" style="color:blue;"></i><?php endif; ?>
            <div class="card-body d-flex flex-column">

                <h5 class="card-title fw-bold mb-3">
                    <?= $admin['name'] ; ?>
                </h5>

                <div class="border-top border-bottom py-3 mb-3 text-start">
                    <h6 class="mb-2">
                        <?php echo strlen($admin['email']) > 20 ? substr($admin['email'], 0, 20) . '...' : $admin['email']; ?>
                    </h6>

                    <h6 class="mb-0"><?= $admin['phone'] ; ?></h6>

                </div>

                <div class="buttons mt-auto"><?php if ($admin['is_banned']): ?>
                    <button
                        class="btn btn-success w-100"
                        onclick="banUser(this, `<?= $admin['id'] ; ?>`, 'unban')">
                        Unban
                    </button><?php else: ?>
                    <button
                        class="btn btn-danger w-100"
                        onclick="banUser(this, `<?= $admin['id'] ; ?>`, 'ban')">
                        Ban
                    </button><?php endif; ?>
                </div>

            </div>
        </div>
    </div><?php endforeach; ?>
</div><?php endif; ?>
<?php echo preparePagination($admins['totalPages'], $admins['currentPage'], 'admins'); ?>
                            </div>

                            <div class="tab-pane fade" id="customers-tab-pane" role="tabpanel"
                                aria-labelledby="customers-tab" tabindex="0">
                                <?php if (empty($customers['data'])): ?>
<div class="alert alert-warning text-center w-75 m-auto" role="alert">
    No customers found.
</div><?php else: ?>
<div class="row"><?php foreach ($customers['data'] as $customer): ?>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis position-relative"><?php if ($customer['is_banned']): ?>
            <span class="badge text-bg-danger position-absolute top-0 end-0 m-3">
                Banned
            </span><?php endif; ?>
            <img
                src="<?php echo asset('images/customer.png'); ?>"
                class="card-img-top m-auto"
                alt="Customer"
                style="width: 100px;"><?php if ($customer['gender'] === 'female'): ?>
            <i class="fa-solid fa-venus position-absolute top-0 start-0 m-3 fs-4"
                style="color:darkmagenta;"></i><?php else: ?>
            <i class="fa-solid fa-mars position-absolute top-0 start-0 m-3 fs-4"
                style="color:blue;"></i><?php endif; ?>
            <div class="card-body d-flex flex-column">

                <h5 class="card-title fw-bold mb-3">
                    <?= $customer['name'] ; ?>
                </h5>

                <div class="border-top border-bottom py-3 mb-3 text-start">

                    <h6 class="mb-2">
                        <?php echo strlen($customer['email']) > 20 ? substr($customer['email'], 0, 20) . '...' : $customer['email']; ?>
                    </h6>

                    <h6 class="mb-0">
                        <?= $customer['phone'] ; ?>
                    </h6>

                </div>

                <div class="buttons mt-auto"><?php if ($customer['is_banned']): ?>
                    <button
                        class="btn btn-success w-100"
                        onclick="banUser(this, `<?= $customer['id'] ; ?>`, 'unban')">
                        Unban
                    </button><?php else: ?>
                    <button
                        class="btn btn-danger w-100"
                        onclick="banUser(this, `<?= $customer['id'] ; ?>`, 'ban')">
                        Ban
                    </button><?php endif; ?>
                </div>

            </div>
        </div>
    </div><?php endforeach; ?>
</div><?php endif; ?>
<?php echo preparePagination($customers['totalPages'], $customers['currentPage'], 'customers'); ?>
                            </div>
                            <div class="tab-pane fade" id="authors-tab-pane" role="tabpanel"
                                aria-labelledby="authors-tab" tabindex="0">
                                <?php if (empty($authors['data'])): ?>
<div class="alert alert-warning text-center" role="alert">
    No authors found.
</div><?php else: ?>
<button class="btn btn-success w-100 mb-3"
    data-bs-toggle="modal" data-bs-target="#addAuthorModal">Add Author</button>

<div class="row"><?php foreach ($authors['data'] as $author): ?>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card text-center rounded-4 p-3 border-0 bg-primary-subtle text-primary-emphasis h-100">
            <img src="<?php echo asset('images/author.png'); ?>" class="card-img-top m-auto" alt="" style="width: 100px;">
            <div class="card-body d-flex flex-column p-2">
                <h5 class="card-title fw-bold mb-3"><?= $author['name'] ; ?></h5>
                <div class="border-top border-bottom py-3 mb-3 text-start">
                    <h6 class="mb-1">Bio :</h6>
                    <div class="item text-start"><?php if ($author['bio']): ?>
                        <p class="mb-0"><?php echo authorBio($author['bio']); ?></p><?php else: ?>
                        <p class="text-warning mb-0">No bio available</p><?php endif; ?>
                    </div>
                </div>
                <button
                    class="btn btn-success w-100 mt-auto addBookBtn"
                    onclick="openAddBookModal(`<?= $author['id'] ; ?>`, `<?= $author['name'] ; ?>`)">
                    Add New Book
                </button>
            </div>
        </div>
    </div><?php endforeach; ?>
</div><?php endif; ?>
<?php echo preparePagination($authors['totalPages'], $authors['currentPage'], 'authors'); ?>




<div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add Author</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAuthorForm">
                    <div class="mb-3">
                        <label class="form-label" for="AuthorName">Author :</label>
                        <input type="text" class="form-control" placeholder="Enter Author Name" name="authorName" id="AuthorName">
                        <p class="alert alert-danger mt-3 d-none" data-error="authorName"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="AuthorBio">Bio :</label>
                        <textarea class="form-control" placeholder="Enter Author Bio" name="authorBio" id="AuthorBio" rows="10" style="resize: none;"></textarea>
                        <p class="alert alert-danger mt-3 d-none" data-error="authorBio"></p>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addAuthorModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add Book</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBookForm" enctype="multipart/form-data">
                    <input type="hidden" name="authorId" id="BookAuthorId">
                    <div class="mb-3">
                        <label class="form-label" for="AuthorId">Author :</label>
                        <select id="AuthorId" class="form-control" disabled>
                            <option value="" selected hidden></option>
                        </select>
                        <p class="alert alert-danger mt-3 d-none" data-error="authorId"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="BookTitle">Title :</label>
                        <input type="text" class="form-control" placeholder="Enter Book Title" name="bookTitle" id="BookTitle">
                        <p class="alert alert-danger mt-3 d-none" data-error="bookTitle"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="BookImg">Image :</label>
                        <input type="file" class="form-control" placeholder="Enter Book Image URL" name="bookImg" id="BookImg">
                        <p class="alert alert-danger mt-3 d-none" data-error="bookImg"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="BookDesc">Description :</label>
                        <textarea class="form-control" placeholder="Enter Book Description" name="bookDesc" id="BookDesc" rows="10" style="resize: none;"></textarea>
                        <p class="alert alert-danger mt-3 d-none" data-error="bookDesc"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="BookPrice">Price :</label>
                        <input type="text" class="form-control" placeholder="Enter Book Price" name="bookPrice" id="BookPrice">
                        <p class="alert alert-danger mt-3 d-none" data-error="bookPrice"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="BookStock">Stock :</label>
                        <input type="text" class="form-control" placeholder="Enter Book Stock" name="bookStock" id="BookStock">
                        <p class="alert alert-danger mt-3 d-none" data-error="bookStock"></p>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
                            </div><?php endif; ?>
                            <div class="tab-pane fade" id="books-tab-pane" role="tabpanel"
                                aria-labelledby="books-tab" tabindex="0">
                                <?php if (empty($books['data'])): ?>
<div class="alert alert-warning text-center" role="alert">
    No books found.
</div><?php else: ?>
<div id="BoolsFilter">
    <form id="BooksFilterForm" method="POST">
        <div class="row">
            <div class="col-lg-6">
                <div class="input-group mb-3">
                    <label for="FilterBookTitle" class="input-group-text"><i class="fas fa-book"></i></label>
                    <input type="text" class="form-control" placeholder="Title..." id="FilterBookTitle" name="filterBookTitle">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-group mb-3">
                    <label for="FilterAuthorName" class="input-group-text"><i class="fas fa-user"></i></label>
                    <input type="text" class="form-control" placeholder="Author..." id="FilterAuthorName" name="filterAuthorName">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-group mb-3">
                    <label for="FilterMinPrice" class="input-group-text"><i class="fas fa-dollar-sign"></i></label>
                    <input type="text" class="form-control" placeholder="Min Price..." id="FilterMinPrice" name="filterMinPrice">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-group mb-3">
                    <label for="FilterMaxPrice" class="input-group-text"><i class="fas fa-dollar-sign"></i></label>
                    <input type="text" class="form-control" placeholder="Max Price..." id="FilterMaxPrice" name="filterMaxPrice">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-group mb-3">
                    <label for="FilterStock" class="input-group-text"><i class="fas fa-hashtag"></i></label>
                    <input type="text" class="form-control" placeholder="Stock..." id="FilterStock" name="filterStock">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-group mb-3">
                    <label for="FilterSort" class="input-group-text"><i class="fas fa-sort"></i></label>
                    <select class="form-select" id="FilterSort" name="filterSort">
                        <option value="DESC" selected>↑ DESC</option>
                        <option value="ASC">↓ ASC</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-success w-100 mb-3">Filter</button>
        </div>
    </form>
</div>

<div class="row"><?php foreach ($books['data'] as $book): ?>
    <div class="col-lg-4 col-md-6 mb-4">
        <!-- <div class="card text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis" data-book-id="<?= $book['id'] ; ?>"><?php if ($book['image']): ?>
            <img src="<?php echo asset('images/uploads/'); ?><?= $book['image'] ; ?>" class="card-img-top m-auto" alt="" style="width: 100px;"><?php else: ?>
            <img src="<?php echo asset('images/book.png'); ?>" class="card-img-top m-auto" alt="" style="width: 100px;"><?php endif; ?>
            <div class="card-body">
                <h5 class="card-title mb-3"><?= $book['title'] ; ?></h5>
                <div class="row mb-3">
                    <div class="col-4">
                        <div class="item d-flex align-items-center">
                            <h6 class="mb-0">Author :</h6>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="item text-start">
                            <h6><?= $book['author_name'] ; ?></h6>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <div class="item d-flex align-items-center">
                            <h6 class="mb-0">Description :</h6>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="item text-start">
                            <h6><?php echo substr($book['description'], 0, 100); ?>...</h6>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <div class="item d-flex align-items-center">
                            <h6 class="mb-0">Price :</h6>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="item text-start">
                            <h6><?= $book['price'] ; ?></h6>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <div class="item d-flex align-items-center">
                            <h6 class="mb-0">Stock :</h6>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="item text-start">
                            <h6><?= $book['stock'] ; ?></h6>
                        </div>
                    </div><?php if (isAuth("customer" ?? null)): ?>
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="Quantity" id="bookQuantity-<?= $book['id'] ; ?>" name="bookQuantity">
                        <button class="btn btn-outline-success" type="button" onclick="addToCart(`<?= $book['id'] ; ?>`,this)">Add to Cart</button>
                    </div><?php endif; ?>
                </div>
            </div>
        </div> -->
        <div class="authorCard card text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis" data-book-id="<?= $book['id'] ; ?>"><?php if ($book['image']): ?>
            <img src="<?php echo asset('images/uploads/'); ?><?= $book['image'] ; ?>" class="card-img-top m-auto" alt="" style="width: 100px;"><?php else: ?>
            <img src="<?php echo asset('images/book.png'); ?>" class="card-img-top m-auto" alt="" style="width: 100px;"><?php endif; ?>
            <div class="card-body">
                <div class="card-title mb-3">
                    <h5 class="card-title mb-1"><?= $book['title'] ; ?></h5>
                    <h6><?= $book['author_name'] ; ?></h6>
                </div>
                <div class="ulContainer py-3 mb-3 text-start">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1">
                            <p class="mb-0"><?= $book['stock'] ; ?></p>
                            <h6 class="mb-0">Stock</h6>
                        </li>
                        <li class="mb-1">
                            <p class="mb-0"><?= $book['price'] ; ?></p>
                            <h6 class="mb-0">Price</h6>
                        </li>
                    </ul>
                </div>
                <div class="border-top border-bottom py-3 mb-3 text-start">
                    <h6 class="mb-1">Description :</h6>
                    <div class="item text-start">
                        <p class="mb-0"><?php echo substr($book['description'], 0, 100); ?>...</p>
                    </div>
                </div><?php if (isAuth("customer" ?? null)): ?>
                <div class="input-group">
                    <input type="number" class="form-control" placeholder="Quantity" id="bookQuantity-<?= $book['id'] ; ?>" name="bookQuantity">
                    <button class="btn btn-outline-success" type="button" onclick="addToCart(`<?= $book['id'] ; ?>`,this)">Add to Cart</button>
                </div><?php endif; ?>
            </div>
        </div>
    </div><?php endforeach; ?>
</div><?php endif; ?>
<?php echo preparePagination($books['totalPages'], $books['currentPage'], 'books'); ?>
                            </div>
                            <div class="tab-pane fade" id="orders_ordered-tab-pane" role="tabpanel"
                                aria-labelledby="orders_ordered-tab" tabindex="0">
                                <div class="table-responsive">
    <table class="table table-info table-striped table-hover align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Customer</th>
                <th scope="col">Total Price</th>
                <th scope="col">Details</th>
                <th scope="col">Created At</th><?php if (isAuth("admin" ?? null)): ?>
                <th scope="col">Options</th><?php endif; ?>
            </tr>
        </thead>
        <tbody><?php if (empty($orders['ordered']['data'])): ?>
            <tr>
                <td colspan="6" class="text-center table-danger">No ordered orders found.</td>
            </tr><?php else: ?><?php foreach ($orders['ordered']['data'] as $orderedOrder): ?>
            <tr data-order-id="<?= $orderedOrder['id'] ; ?>">
                <th scope="row"><?= $orderedOrder['id'] ; ?></th>
                <td><?= $orderedOrder['customer_name'] ; ?></td>
                <td><?= $orderedOrder['total_price'] ; ?></td>
                <td>
                    <span class="badge text-bg-success" style="cursor: pointer;" onclick="getCartItems(`<?= $orderedOrder['id'] ; ?>`, 'showOrder');">Show Details</span>
                </td>
                <td><?= $orderedOrder['created_at'] ; ?></td><?php if (isAuth("admin" ?? null)): ?>
                <td>
                    <button class="btn btn-sm btn-danger me-2" onclick="cancelOrder(`<?= $orderedOrder['id'] ; ?>`)">Cancel</button>
                    <button class="btn btn-sm btn-success" onclick="doneOrder(`<?= $orderedOrder['id'] ; ?>`)">Done</button>
                </td><?php endif; ?>
            </tr><?php endforeach; ?><?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo preparePagination($orders['ordered']['totalPages'], $orders['ordered']['currentPage'], 'orders_ordered'); ?><?php if (isAuth("admin" ?? null)): ?>
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Cancel Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="cancelReason" class="form-label">Cancel Reason</label>
                        <textarea class="form-control" id="cancelReason" rows="3"></textarea>
                    </div>
                    <button class="btn btn-danger w-100 mt-2">Cancel Order</button>
                </form>
            </div>
        </div>
    </div>
</div><?php endif; ?>
                            </div>
                            <div class="tab-pane fade" id="orders_canceled-tab-pane" role="tabpanel"
                                aria-labelledby="orders_canceled-tab" tabindex="0">
                                <div class="table-responsive">
    <table class="table table-info table-striped table-hover align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Customer</th>
                <th scope="col">Total Price</th>
                <th scope="col">Details</th>
                <th scope="col">Created At</th>
            </tr>
        </thead>
        <tbody><?php if (empty($orders['canceled']['data'])): ?>
            <tr>
                <td colspan="5" class="text-center table-danger">No canceled orders found.</td>
            </tr><?php else: ?><?php foreach ($orders['canceled']['data'] as $canceledOrder): ?>
            <tr>
                <th scope="row"><?= $canceledOrder['id'] ; ?></th>
                <td><?= $canceledOrder['customer_name'] ; ?></td>
                <td><?= $canceledOrder['total_price'] ; ?></td>
                <td>
                    <span class="badge text-bg-success " style="cursor: pointer;" onclick="getCartItems(`<?= $canceledOrder['id'] ; ?>`, 'showOrder');">Show Details</span>
                </td>
                <td><?= $canceledOrder['created_at'] ; ?></td>
            </tr><?php endforeach; ?><?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo preparePagination($orders['canceled']['totalPages'], $orders['canceled']['currentPage'], 'orders_canceled'); ?>
                            </div>
                            <div class="tab-pane fade" id="orders_done-tab-pane" role="tabpanel"
                                aria-labelledby="orders_done-tab" tabindex="0">
                                <div class="table-responsive">
    <table class="table table-info table-striped table-hover align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Customer</th>
                <th scope="col">Total Price</th>
                <th scope="col">Details</th>
                <th scope="col">Created At</th>
            </tr>
        </thead>
        <tbody><?php if (empty($orders['done']['data'])): ?>
            <tr>
                <td colspan="5" class="text-center table-danger">No done orders found.</td>
            </tr><?php else: ?><?php foreach ($orders['done']['data'] as $doneOrder): ?>
            <tr>
                <th scope="row"><?= $doneOrder['id'] ; ?></th>
                <td><?= $doneOrder['customer_name'] ; ?></td>
                <td><?= $doneOrder['total_price'] ; ?></td>
                <td>
                    <span class="badge text-bg-success" style="cursor: pointer;" onclick="getCartItems(`<?= $doneOrder['id'] ; ?>`, 'showOrder');">Show Details</span>
                </td>
                <td><?= $doneOrder['created_at'] ; ?></td>
            </tr><?php endforeach; ?><?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo preparePagination($orders['done']['totalPages'], $orders['done']['currentPage'], 'orders_done'); ?>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="userEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form data-type="" method="POST" id="userEditForm">
                    <div class="modal-body">
                        <label class="form-label">Value</label>
                        <input type="text" class="form-control" placeholder="Enter new value">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info text-white">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Cart :</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>


</body>

</html>