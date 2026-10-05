@empty($books['data'])
<div class="alert alert-warning text-center" role="alert">
    No books found.
</div>
@else
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

<div class="row">
    @foreach ($books['data'] as $book)
    <div class="col-lg-4 col-md-6 mb-4">
        <!-- <div class="card text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis" data-book-id="{{ $book['id'] }}">
            @if ($book['image'])
            <img src="{{ asset('images/uploads/') }}{{ $book['image'] }}" class="card-img-top m-auto" alt="" style="width: 100px;">
            @else
            <img src="{{ asset('images/book.png') }}" class="card-img-top m-auto" alt="" style="width: 100px;">
            @endif
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
                    @auth("customer")
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="Quantity" id="bookQuantity-{{ $book['id'] }}" name="bookQuantity">
                        <button class="btn btn-outline-success" type="button" onclick="addToCart(`{{ $book['id'] }}`,this)">Add to Cart</button>
                    </div>
                    @endauth
                </div>
            </div>
        </div> -->
        <div class="authorCard card text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis" data-book-id="{{ $book['id'] }}">
            @if ($book['image'])
            <img src="{{ asset('images/uploads/') }}{{ $book['image'] }}" class="card-img-top m-auto" alt="" style="width: 100px;">
            @else
            <img src="{{ asset('images/book.png') }}" class="card-img-top m-auto" alt="" style="width: 100px;">
            @endif
            <div class="card-body">
                <div class="card-title mb-3">
                    <h5 class="card-title mb-1">{{ $book['title'] }}</h5>
                    <h6>{{ $book['author_name'] }}</h6>
                </div>
                <div class="ulContainer py-3 mb-3 text-start">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1">
                            <p class="mb-0">{{ $book['stock'] }}</p>
                            <h6 class="mb-0">Stock</h6>
                        </li>
                        <li class="mb-1">
                            <p class="mb-0">{{ $book['price'] }}</p>
                            <h6 class="mb-0">Price</h6>
                        </li>
                    </ul>
                </div>
                <div class="border-top border-bottom py-3 mb-3 text-start">
                    <h6 class="mb-1">Description :</h6>
                    <div class="item text-start">
                        <p class="mb-0">{{ substr($book['description'], 0, 100) }}...</p>
                    </div>
                </div>
                @auth("customer")
                <div class="input-group">
                    <input type="number" class="form-control" placeholder="Quantity" id="bookQuantity-{{ $book['id'] }}" name="bookQuantity">
                    <button class="btn btn-outline-success" type="button" onclick="addToCart(`{{ $book['id'] }}`,this)">Add to Cart</button>
                </div>
                @endauth
            </div>
        </div>
    </div>
    @endforeach
</div>
@endempty

{{ preparePagination($books['totalPages'], $books['currentPage'], 'books') }}