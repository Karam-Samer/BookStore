@empty($customers['data'])
<div class="alert alert-warning text-center w-75 m-auto" role="alert">
    No customers found.
</div>
@else

<div class="row">
    @foreach ($customers['data'] as $customer)

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis position-relative">

            @if ($customer['is_banned'])
            <span class="badge text-bg-danger position-absolute top-0 end-0 m-3">
                Banned
            </span>
            @endif

            <img
                src="{{ asset('images/customer.png') }}"
                class="card-img-top m-auto"
                alt="Customer"
                style="width: 100px;">

            @if ($customer['gender'] === 'female')
            <i class="fa-solid fa-venus position-absolute top-0 start-0 m-3 fs-4"
                style="color:darkmagenta;"></i>
            @else
            <i class="fa-solid fa-mars position-absolute top-0 start-0 m-3 fs-4"
                style="color:blue;"></i>
            @endif

            <div class="card-body d-flex flex-column">

                <h5 class="card-title fw-bold mb-3">
                    {{ $customer['name'] }}
                </h5>

                <div class="border-top border-bottom py-3 mb-3 text-start">

                    <h6 class="mb-2">
                        {{ strlen($customer['email']) > 20 ? substr($customer['email'], 0, 20) . '...' : $customer['email'] }}
                    </h6>

                    <h6 class="mb-0">
                        {{ $customer['phone'] }}
                    </h6>

                </div>

                <div class="buttons mt-auto">
                    @if ($customer['is_banned'])
                    <button
                        class="btn btn-success w-100"
                        onclick="banUser(this, `{{ $customer['id'] }}`, 'unban')">
                        Unban
                    </button>
                    @else
                    <button
                        class="btn btn-danger w-100"
                        onclick="banUser(this, `{{ $customer['id'] }}`, 'ban')">
                        Ban
                    </button>
                    @endif
                </div>

            </div>
        </div>
    </div>

    @endforeach
</div>

@endempty

{{ preparePagination($customers['totalPages'], $customers['currentPage'], 'customers') }}