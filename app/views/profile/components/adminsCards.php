@empty($admins['data'])
<div class="alert alert-warning text-center w-75 m-auto" role="alert">
    No admins found.
</div>
@else

<div class="row">
    @foreach ($admins['data'] as $admin)

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="authorCard card h-100 text-center rounded-4 py-3 px-2 border-0 position-relative">

            @if ($admin['is_banned'])
            <span class="badge text-bg-danger position-absolute top-0 end-0 m-3">
                Banned
            </span>
            @endif





            <img
                src="{{ asset('images/admin.png') }}"
                class="card-img-top m-auto"
                alt="Admin"
                style="width: 100px;">

            @if ($admin['gender'] === 'female')
            <i class="fa-solid fa-venus position-absolute top-0 start-0 m-3 fs-4" style="color:darkmagenta;"></i>
            @else
            <i class="fa-solid fa-mars position-absolute top-0 start-0 m-3 fs-4" style="color:blue;"></i>
            @endif

            <div class="card-body d-flex flex-column">

                <h5 class="card-title fw-bold mb-3">
                    {{ $admin['name'] }}
                </h5>

                <div class="cardInfo py-3 mb-3 text-start">
                    <h6 class="mb-2">
                        {{ strlen($admin['email']) > 20 ? substr($admin['email'], 0, 20) . '...' : $admin['email'] }}
                    </h6>

                    <h6 class="mb-0">{{ $admin['phone'] }}</h6>

                </div>

                <div class="buttons mt-auto">
                    @if ($admin['is_banned'])
                    <button
                        class="btn mainButton w-100"
                        onclick="banUser(this, `{{ $admin['id'] }}`, 'unban')">
                        Unban
                    </button>
                    @else
                    <button
                        class="btn secondaryButton w-100"
                        onclick="banUser(this, `{{ $admin['id'] }}`, 'ban')">
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

{{ preparePagination($admins['totalPages'], $admins['currentPage'], 'admins') }}