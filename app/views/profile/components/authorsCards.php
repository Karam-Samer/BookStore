@empty($authors['data'])
<div class="alert alert-warning text-center" role="alert">
    No authors found.
</div>
@else
<div class="row">
    @foreach ($authors['data'] as $author)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis">
            <img src="{{ asset('images/author.png') }}" class="card-img-top m-auto" alt="" style="width: 100px;">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ $author['name'] }}</h5>
                <div class="row mb-3">
                    <div class="col-4">
                        <div class="item d-flex align-items-center">
                            <h6 class="mb-0">Bio :</h6>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="item text-start">
                            <h6>{{ substr($author['bio'], 0, 100) }}...</h6>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button class="btn btn-danger w-100">Ban</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endempty

{{ preparePagination($authors['totalPages'], $authors['currentPage'], 'authors') }}
