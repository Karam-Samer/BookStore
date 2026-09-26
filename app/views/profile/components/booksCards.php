@empty($books['data'])
    <div class="alert alert-warning text-center" role="alert">
        No books found.
    </div>
@else
<div class="row">
@foreach ($books['data'] as $book)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis">
            <img src="{{ asset('images/book.png') }}" class="card-img-top m-auto" alt="" style="width: 100px;">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ $book['title'] }}</h5>
                <div class="row mb-3">
                    <div class="col-4">
                        <div class="item d-flex align-items-center">
                            <h6 class="mb-0">Author :</h6>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="item text-start">
                            <h6>{{ $book['author_name'] }}</h6>
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
                            <h6>{{ substr($book['description'], 0, 100) }}...</h6>
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
                            <h6>{{ $book['price'] }}</h6>
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
                            <h6>{{ $book['stock'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
@endempty

{{ preparePagination($books['totalPages'], $books['currentPage'], 'books') }}