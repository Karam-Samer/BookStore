function showErrors(errors) {
  for (let error in errors) {
    $(`p[data-error="${error}"]`).text(errors[error]).removeClass("d-none");
  }
}

function addAuthor(author) {
  let shortBio =
      author.authorBio.length > 100
        ? author.authorBio.substring(0, 100) + "..."
        : author.authorBio,
    authorImg = imgPath("author.png");

  $("#authors-tab-pane > .row").prepend(`
        <div class="col-lg-4 col-md-6 mb-4">
        <div class="card text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis h-100">
            <img src="${authorImg}" class="card-img-top m-auto" alt="" style="width: 100px;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title mb-3">${author.authorName}</h5>
                <div class="row mb-3">
                    <div class="col-3">
                        <div class="item d-flex align-items-center">
                            <h6 class="mb-0">Bio :</h6>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="item text-start">
                            <h6>${shortBio}...</h6>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success w-100 mt-auto">Ban</button>
            </div>
        </div>
    </div>
    `);
}

function imgPath(imgName, defaultImg = "default.png") {
  if (imgName == null) {
    imgName = defaultImg;
  }
  return window.location.origin + "/BookStore/public/assets/images/" + imgName;
}

function editUser(type, value) {
  let modal = $("#userEditModal");
  let inputHtml = "";
  if (type === "Gender") {
    inputHtml = `
      <label class="form-label" for="gender">Value</label>
      <select class="form-select" name="gender" id="gender">
        <option value="Male" ${value === "male" ? "selected" : ""}>Male</option>
        <option value="Female" ${value === "female" ? "selected" : ""}>Female</option>
      </select>
    `;
  } else {
    inputHtml = `
      <label class="form-label" for="${type.toLowerCase()}">Value</label>
      <input type="text" class="form-control" placeholder="Enter new value" value="${value}" name="${type.toLowerCase()}" id="${type.toLowerCase()}"></input>
    `;
  }
  modal.find(".modal-title").text(`Edit ${type}`);
  modal.find("#userEditForm .modal-body").html(inputHtml);
  modal.find("#userEditForm").attr("data-type", type.toLowerCase());
}

function BookCard(books) {
  let bookCards = "";
  let description = "";
  for (let book in books) {
    description =
      books[book]["description"].length > 100
        ? books[book]["description"].substring(0, 100) + "..."
        : books[book]["description"];
    if (books[book]["image"]) {
      img = imgPath(`uploads/${books[book]["image"]}`);
    } else {
      img = imgPath("book.png");
    }
    bookCards += `
        <div class="col-lg-4 col-md-6 mb-4">
        <div class="card text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis">
            <img src="${img}" class="card-img-top m-auto" alt="" style="width: 100px;">
            <div class="card-body">
                <h5 class="card-title mb-3">${books[book]["title"]}</h5>
                <div class="row mb-3">
                    <div class="col-4">
                        <div class="item d-flex align-items-center">
                            <h6 class="mb-0">Author :</h6>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="item text-start">
                            <h6>${books[book]["author_name"]}</h6>
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
                            <h6>${books[book]["description"].substring(0, 100)}...</h6>
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
                            <h6>${books[book]["price"]}</h6>
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
                            <h6>${books[book]["stock"]}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `;
  }
  return bookCards;
}

function preparePagination(totalPages, currentPage, type) {
  if (totalPages <= 1) {
    return "";
  }
  let prepareLi = "";

  let nextPage = currentPage < totalPages ? currentPage + 1 : totalPages;
  let isNextDisabled = currentPage >= totalPages ? "disabled" : "";

  let prevPage = currentPage > 1 ? currentPage - 1 : 1;
  let isPrevDisabled = currentPage <= 1 ? "disabled" : "";

  let profileLink = window.location.origin + "/profile";

  for (let i = 1; i <= totalPages; i++) {
    let isActive = i == currentPage ? "active" : "";
    prepareLi += `<li class="page-item ${isActive}"><a class='page-link' href="${profileLink}?${type}-page=${i}">${i}</a></li>`;
  }

  let pagination = `<nav aria-label='Page navigation example'>
                    <ul class='pagination'>
                        <li class='page-item ${isPrevDisabled}'>
                            <a class='page-link' href='${profileLink}?${type}-page=${prevPage}'>Previous</a>
                        </li>
                        ${prepareLi}
                        <li class='page-item ${isNextDisabled}'>
                            <a class='page-link' href='${profileLink}?${type}-page=${nextPage}'>Next</a>
                        </li>
                    </ul>
                </nav>`;

  return pagination;
}

function Toast(type, message) {
  Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    },
  }).fire({
    icon: type,
    title: message,
  });
}

