<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | {{ auth('role') }}</title>
    <link rel="stylesheet" href="{{ asset('CSS/plugins/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/plugins/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/style.css') }}">


    <script src="{{ asset('JS/plugins/jquery.js') }}"></script>
    <script src="{{ asset('JS/plugins/alert.js') }}"></script>
    <script src="{{ asset('JS/plugins/bootstrap.js') }}"></script>
    <script src="{{ asset('JS/profile/functions.js') }}"></script>
    @auth("customer")
    <script src="{{ asset('JS/profile/customer/cart.js') }}"></script>
    <script src="{{ asset('JS/profile/customer/orders.js') }}"></script>
    @elseauth("admin")
    <script src="{{ asset('JS/profile/admin/admin.js') }}"></script>
    @endauth
    <script src="{{ asset('JS/profile/profile.js') }}"></script>
</head>

<body>
    <x-Navbar />
    <section id="Dashboard" class="py-4 px-2">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card text-center rounded-4 py-3 px-2 border-0">
                        <img src="{{ asset('images/default.png') }}" class="card-img-top m-auto" alt="" style="width: 100px;">

                        <div class="card-body">
                            <h5 class="card-title mb-3 d-flex align-items-center justify-content-center gap-2">
                                <i class="fa-regular fa-pen-to-square edit" role="button" data-edit-label="Name"
                                    data-bs-toggle="modal" data-bs-target="#userEditModal" onclick="editUser(`Name`,`{{ auth('name') }}`)"></i>
                                <span data-type="name">{{ auth("name") }}</span>
                            </h5>

                            <div class="row mb-3">
                                <div class="col-4 d-flex">
                                    <i class="fa-regular fa-pen-to-square edit" role="button" data-edit-label="Email"
                                        data-bs-toggle="modal" data-bs-target="#userEditModal" onclick="editUser(`Email`,`{{ auth('email') }}`)"></i>
                                    <h6 class="mb-0" style="white-space: nowrap;">Email :</h6>
                                </div>
                                <div class="col-8">
                                    <div class="item text-start">
                                        <h6 class="mb-0 secondaryText" data-type="email">{{ auth("email") }}</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4 d-flex">
                                    <i class="fa-regular fa-pen-to-square edit" role="button" data-edit-label="Gender"
                                        data-bs-toggle="modal" data-bs-target="#userEditModal" onclick="editUser(`Gender`,`{{ auth('gender') }}`)"></i>
                                    <h6 class="mb-0" style="white-space: nowrap;">Gender :</h6>
                                </div>
                                <div class="col-8">
                                    <div class="item text-start">
                                        <h6 class="mb-0 secondaryText" data-type="gender">{{ auth("gender") }}</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4 d-flex">
                                    <i class="fa-regular fa-pen-to-square edit" role="button" data-edit-label="Phone"
                                        data-bs-toggle="modal" data-bs-target="#userEditModal" onclick="editUser(`Phone`, `{{ auth('phone') }}`)"></i>
                                    <h6 class="mb-0" style="white-space: nowrap;">Phone :</h6>
                                </div>
                                <div class="col-8">
                                    <div class="item text-start">
                                        <h6 class="mb-0 secondaryText" data-type="phone">{{ auth("phone") }}</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4 d-flex">
                                    <i class="fa-regular fa-pen-to-square edit" role="button" data-edit-label="password"
                                        data-bs-toggle="modal" data-bs-target="#userEditModal" onclick="editUser(`password`, '')"></i>
                                    <h6 class="mb-0" style="white-space: nowrap;">Password :</h6>
                                </div>
                                <div class="col-8">
                                    <div class="item text-start">
                                        <h6 class="mb-0 secondaryText">••••••••</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 rounded-5 p-4">
                    <div class="container">

                        <ul class="nav nav-tabs position-relative " id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="statistics-tab" data-bs-toggle="tab"
                                    data-bs-target="#statistics-tab-pane" type="button" role="tab"
                                    aria-controls="statistics-tab-pane" aria-selected="true">
                                    Statistics
                                </button>
                            </li>
                            @auth("admin")
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
                            @endauth
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
                            @auth("customer")
                            <button type="button" class="btn cartBtn py-2 px-3 position-absolute top-0 end-0" onclick="getCartItems()">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount">
                                    {{ $total['totalCartItems'] }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </button>
                            @endauth
                        </ul>

                        <div class="tab-content mt-3" id="myTabContent">

                            <div class="tab-pane fade show active" id="statistics-tab-pane" role="tabpanel"
                                aria-labelledby="statistics-tab" tabindex="0">
                                <x-statisticsCards />
                            </div>
                            @auth("admin")
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
                            @endauth
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
                    <h1 class="modal-title fs-5">Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form data-type="" data-edit-label="" method="POST" id="userEditForm">
                    <div class="modal-body p-4">
                        <label class="form-label">Value</label>
                        <input type="text" class="form-control" placeholder="Enter new value">
                    </div>
                    <div class="modal-footer py-3 px-4">
                        <button type="submit" class="btn mainButton">Save changes</button>
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
                <div class="modal-body p-4">
                </div>
            </div>
        </div>
    </div>


</body>

</html>