@empty($customers['data'])
<div class="alert alert-warning text-center" role="alert">
    No customers found.
</div>
@else

<div class="row">
    @foreach ($customers['data'] as $customer)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis">
            @if ($customer['is_banned'])
            <span class="badge text-bg-danger position-absolute" style="top: 10px; right: 10px;">Banned</span>
            @endif
            <img src="{{ asset('images/customer.png') }}" class="card-img-top m-auto" alt="" style="width: 100px;">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ $customer['name'] }}</h5>
                <div class="row mb-3">
                    <div class="col-4">
                        <div class="item d-flex align-items-center">
                            <h6 class="mb-0">Email :</h6>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="item text-start">
                            <h6>{{ $customer['email'] }}</h6>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <div class="item d-flex align-items-center">
                            <h6 class="mb-0">Gender :</h6>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="item text-start">
                            <h6>{{ $customer['gender'] }}</h6>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <div class="item d-flex align-items-center">
                            <h6 class="mb-0">Phone :</h6>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="item text-start">
                            <h6>{{ $customer['phone'] }}</h6>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    @if ($customer['is_banned'])
                    <button class="btn btn-success w-100" onclick="banUser(this, `{{ $customer['id'] }}`, 'unban')">Unban</button>
                    @else
                    <button class="btn btn-danger w-100" onclick="banUser(this, `{{ $customer['id'] }}`, 'ban')">Ban</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endempty

{{ preparePagination($customers['totalPages'], $customers['currentPage'], 'customers') }}