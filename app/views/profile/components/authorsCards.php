@empty($authors['data'])
<div class="alert alert-warning text-center" role="alert">
    No authors found.
</div>
@else
<button class="btn mainButton w-100 mb-3"
    data-bs-toggle="modal" data-bs-target="#addAuthorModal">Add Author</button>

<div class="row">
    @foreach ($authors['data'] as $author)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="authorCard card text-center rounded-4 p-3 border-0 h-100">
            <img src="{{ asset('images/author.png') }}" class="card-img-top m-auto" alt="" style="width: 100px;">
            <div class="card-body d-flex flex-column p-2">
                <h5 class="card-title fw-bold mb-3">{{ $author['name'] }}</h5>
                <div class="cardInfo py-3 mb-3 text-start">
                    <h6 class="mb-1">Bio :</h6>
                    <div class="item text-start">
                        @if ( $author['bio'] )
                        <p class="mb-0">{{ authorBio($author['bio']) }}</p>
                        @else
                        <p class="text-warning mb-0">No bio available</p>
                        @endif
                    </div>
                </div>
                <button
                    class="btn mainButton w-100 mt-auto addBookBtn"
                    onclick="openAddBookModal(`{{ $author['id'] }}`, `{{ $author['name'] }}`)">
                    Add New Book
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endempty

{{ preparePagination($authors['totalPages'], $authors['currentPage'], 'authors') }}




<div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add Author</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addAuthorForm">
                    <div class="mb-3">
                        <label class="form-label" for="AuthorName">Author :</label>
                        <input type="text" class="form-control" placeholder="Enter Author Name" name="authorName" id="AuthorName">
                        <p class="alert alert-danger mt-3 d-none" data-error="authorName"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="AuthorBio">Bio :</label>
                        <textarea class="form-control" placeholder="Enter Author Bio" name="authorBio" id="AuthorBio" rows="10" style="resize: none;"></textarea>
                        <p class="alert alert-danger mt-3 d-none" data-error="authorBio"></p>
                    </div>
                    <button type="submit" class="btn mainButton w-100">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addAuthorModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add Book</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addBookForm" enctype="multipart/form-data">
                    <input type="hidden" name="authorId" id="BookAuthorId">
                    <div class="mb-3">
                        <label class="form-label" for="AuthorId">Author :</label>
                        <select id="AuthorId" class="form-control" disabled>
                            <option value="" selected hidden></option>
                        </select>
                        <p class="alert alert-danger mt-3 d-none" data-error="authorId"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="BookTitle">Title :</label>
                        <input type="text" class="form-control" placeholder="Enter Book Title" name="bookTitle" id="BookTitle">
                        <p class="alert alert-danger mt-3 d-none" data-error="bookTitle"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="BookImg">Image :</label>
                        <input type="file" class="form-control" placeholder="Enter Book Image URL" name="bookImg" id="BookImg">
                        <p class="alert alert-danger mt-3 d-none" data-error="bookImg"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="BookDesc">Description :</label>
                        <textarea class="form-control" placeholder="Enter Book Description" name="bookDesc" id="BookDesc" rows="10" style="resize: none;"></textarea>
                        <p class="alert alert-danger mt-3 d-none" data-error="bookDesc"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="BookPrice">Price :</label>
                        <input type="text" class="form-control" placeholder="Enter Book Price" name="bookPrice" id="BookPrice">
                        <p class="alert alert-danger mt-3 d-none" data-error="bookPrice"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="BookStock">Stock :</label>
                        <input type="text" class="form-control" placeholder="Enter Book Stock" name="bookStock" id="BookStock">
                        <p class="alert alert-danger mt-3 d-none" data-error="bookStock"></p>
                    </div>
                    <button type="submit" class="btn mainButton w-100">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>