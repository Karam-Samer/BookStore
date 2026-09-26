@empty($admins['data'])
<div class="alert alert-warning text-center w-75 m-auto" role="alert">
    No admins found.
</div>
@else
<div class="row">
    @foreach ($admins['data'] as $admin)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis">
            @if ($admin['is_banned'])
            <span class="badge text-bg-danger position-absolute" style="top: 10px; right: 10px;">Banned</span>
            @endif
            <img src="{{ asset('images/admin.png') }}" class="card-img-top m-auto" alt="" style="width: 100px;">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ $admin['name'] }}</h5>
                <div class="row mb-3">
                    <div class="col-4">
                        <div class="item d-flex align-items-center">
                            <h6 class="mb-0">Email :</h6>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="item text-start">
                            <h6>{{ $admin['email'] }}</h6>
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
                            <h6>{{ $admin['gender'] }}</h6>
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
                            <h6>{{ $admin['phone'] }}</h6>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    @if ($admin['is_banned'])
                    <button class="btn btn-success w-100">Unban</button>
                    @else
                    <button class="btn btn-danger w-100">Ban</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @endforeach
</div>
@endempty




{{ preparePagination($admins['totalPages'], $admins['currentPage'], 'admins') }}