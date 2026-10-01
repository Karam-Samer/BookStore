@empty($authors['data'])
<div class="alert alert-warning text-center" role="alert">
    No authors found.
</div>
@else
<button class="btn btn-success w-100 mb-3" role="button"
    data-bs-toggle="modal" data-bs-target="#addAuthorModal">Add Author</button>

<div class="row">
    @foreach ($authors['data'] as $author)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis h-100">
            <img src="{{ asset('images/author.png') }}" class="card-img-top m-auto" alt="" style="width: 100px;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title mb-3">{{ $author['name'] }}</h5>
                <div class="row mb-3">
                    <div class="col-3">
                        <div class="item d-flex align-items-center">
                            <h6 class="mb-0">Bio :</h6>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="item text-start">
                            @if ( $author['bio'] )
                            <h6>{{ authorBio($author['bio']) }}</h6>
                            @else
                            <h6 class="text-danger">No bio available</h6>
                            @endif
                        </div>
                    </div>
                </div>
                <button
                    class="btn btn-success w-100 mt-auto addBookBtn"
                    onclick="openAddBookModal(this, `{{ $author['id'] }}`, `{{ $author['name'] }}`)">
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
            <div class="modal-body">
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
                    <button type="submit" class="btn btn-success w-100">Add</button>
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
            <div class="modal-body">
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
                    <button type="submit" class="btn btn-success w-100">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>