<div class="row">
    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 statCard">
                <i class="fa-solid fa-book m-auto"></i>
                <h6 class="my-3">Total Books</h6>
                <p class="statNumber mb-0 fw-bolder">{{ $total['books'] }}</p>
            </div>
        </div>
    </div>





    @auth("admin")

    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 statCard">
                <i class="fa-solid fa-user-group m-auto"></i>
                <h6 class="my-3">Total Authors</h6>
                <p class="statNumber mb-0 fw-bolder">{{ $total['authors'] }}</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 statCard">
                <i class="fa-solid fa-users m-auto"></i>
                <h6 class="my-3">Total Customers</h6>
                <p class="statNumber mb-0 fw-bolder">{{ $total['customers'] }}</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 statCard">
                <i class="fa-solid fa-user-gear m-auto"></i>
                <h6 class="my-3">Total Admins</h6>
                <p class="statNumber mb-0 fw-bolder">{{ $total['admins'] }}</p>
            </div>
        </div>
    </div>

    @elseauth("customer")
    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 statCard">
                <i class="fa-solid fa-book m-auto"></i>
                <h6 class="my-3">Total Bought Books</h6>
                <p class="statNumber mb-0 fw-bolder">{{ $total['boughtBooks'] }}</p>
            </div>
        </div>
    </div>
    @endauth

    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 statCard">
                <i class="fa-solid fa-circle-pause m-auto"></i>
                <h6 class="my-3">Total Ordered Orders</h6>
                <p class="statNumber mb-0 fw-bolder">{{ $total['orders']['ordered'] }}</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 statCard">
                <i class="fa-solid fa-ban m-auto"></i>
                <h6 class="my-3">Total Cancelled Orders</h6>
                <p class="statNumber mb-0 fw-bolder">{{ $total['orders']['canceled'] }}</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0 statCard">
                <i class="fa-solid fa-circle-check m-auto"></i>
                <h6 class="my-3">Total Done Orders</h6>
                <p class="statNumber mb-0 fw-bolder">{{ $total['orders']['done'] }}</p>
            </div>
        </div>
    </div>
</div>