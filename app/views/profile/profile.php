<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="{{ asset('CSS/plugins/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/plugins/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/global.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/profile/profile.css') }}">

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
</head>

<body>
    <x-Navbar />

    <section id="Dashboard" class="py-4">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card text-center rounded-4 py-3 px-2 border-0 shadow-sm">
                        <img src="{{ asset('images/default.png') }}" class="card-img-top m-auto" alt="" style="width: 100px;">

                        <div class="card-body">
                            <h5 class="card-title mb-3 d-flex align-items-center justify-content-center gap-2">
                                <i class="fa-regular fa-pen-to-square edit text-info" role="button"
                                    data-bs-toggle="modal" data-bs-target="#userEditModal"></i>
                                <span>Mohamed Atya</span>
                            </h5>

                            <div class="row mb-3">
                                <div class="col-4 d-flex">
                                    <i class="fa-regular fa-pen-to-square edit text-info" role="button"
                                        data-bs-toggle="modal" data-bs-target="#userEditModal"></i>
                                    <h6 class="mb-0" style="white-space: nowrap;">Email :</h6>
                                </div>
                                <div class="col-8">
                                    <div class="item text-start">
                                        <h6 class="mb-0 text-muted">Matya032@gmail.com</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4 d-flex">
                                    <i class="fa-regular fa-pen-to-square edit text-info" role="button"
                                        data-bs-toggle="modal" data-bs-target="#userEditModal"></i>
                                    <h6 class="mb-0" style="white-space: nowrap;">Gender :</h6>
                                </div>
                                <div class="col-8">
                                    <div class="item text-start">
                                        <h6 class="mb-0 text-muted">Male</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4 d-flex">
                                    <i class="fa-regular fa-pen-to-square edit text-info" role="button"
                                        data-bs-toggle="modal" data-bs-target="#userEditModal"></i>
                                    <h6 class="mb-0" style="white-space: nowrap;">Password :</h6>
                                </div>
                                <div class="col-8">
                                    <div class="item text-start">
                                        <h6 class="mb-0 text-muted">••••••••</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4 d-flex">
                                    <i class="fa-regular fa-pen-to-square edit text-info" role="button"
                                        data-bs-toggle="modal" data-bs-target="#userEditModal"></i>
                                    <h6 class="mb-0" style="white-space: nowrap;">Age :</h6>
                                </div>
                                <div class="col-8">
                                    <div class="item text-start">
                                        <h6 class="mb-0 text-muted">24</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-9 bg-body rounded-5 p-4 shadow-sm">
                    <div class="container">

                        <!-- Nav Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="statistics-tab" data-bs-toggle="tab"
                                    data-bs-target="#statistics-tab-pane" type="button" role="tab"
                                    aria-controls="statistics-tab-pane" aria-selected="true">
                                    Statistics
                                </button>
                            </li>
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
                            </li>
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
                            </li>
                        </ul>

                        <div class="tab-content mt-3" id="myTabContent">

                            <div class="tab-pane fade show active" id="statistics-tab-pane" role="tabpanel"
                                aria-labelledby="statistics-tab" tabindex="0">
                                <x-statisticsCards />
                            </div>

                            <div class="tab-pane fade" id="admins-tab-pane" role="tabpanel"
                                aria-labelledby="admins-tab" tabindex="0">
                                <x-adminsCards />
                            </div>

                            <div class="tab-pane fade" id="customers-tab-pane" role="tabpanel"
                                aria-labelledby="customers-tab" tabindex="0">
                                <x-customersCards />
                            </div>
                            <div class="tab-pane fade" id="authors-tab-pane" role="tabpanel"
                                aria-labelledby="authors-tab" tabindex="0">
                                <x-authorsCards />
                            </div>
                            <div class="tab-pane fade" id="books-tab-pane" role="tabpanel"
                                aria-labelledby="books-tab" tabindex="0">
                                <x-booksCards />
                            </div>
                            <div class="tab-pane fade" id="orders_ordered-tab-pane" role="tabpanel"
                                aria-labelledby="orders_ordered-tab" tabindex="0">
                                <x-ordersOrderedTable />
                            </div>
                            <div class="tab-pane fade" id="orders_canceled-tab-pane" role="tabpanel"
                                aria-labelledby="orders_canceled-tab" tabindex="0">
                                <x-ordersCanceledTable />
                            </div>
                            <div class="tab-pane fade" id="orders_done-tab-pane" role="tabpanel"
                                aria-labelledby="orders_done-tab" tabindex="0">
                                <x-ordersDoneTable />
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
                    <h1 class="modal-title fs-5" id="userEditModalLabel">Edit User Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Value</label>
                    <input type="text" class="form-control" placeholder="Enter new value">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info text-white" data-bs-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="productModalLabel">Edit Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control mb-3" value="Laptop Dell XPS 15">

                    <label class="form-label">Price</label>
                    <input type="number" name="price" class="form-control mb-3" value="1500">

                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control mb-3" value="12">

                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Available" selected>Available</option>
                        <option value="Out of stock">Out of stock</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info text-white" data-bs-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>