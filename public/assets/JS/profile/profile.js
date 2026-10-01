$(document).ready(function () {
  let type = window.location.search.replace("?", "").split("-")[0];
  let tab = $(`#${type}-tab`).get(0);
  if (!tab) {
    return;
  }

  tab?.click();
  tab?.blur();
});

$(document).on("submit", "#userEditForm", function (e) {
  e.preventDefault();

  let type = $(this).attr("data-type");
  let formData = new FormData(this);

  $.ajax({
    type: "POST",
    url: `profile/edit/${type}`,
    data: formData,
    dataType: "json",
    success: function (response) {
      Toast(response.data.type, response.message);
      if (type === "name") {
        $(`span[data-type="name"]`).text(response.data.value);
      } else if (type === "password") {
        $(`h6[data-type="password"]`).text("");
      } else {
        $(`h6[data-type="${type}"]`).text(response.data.value);
      }
    },
    error: function (response) {
      console.log(response);
      console.log(response.responseJSON);
      Toast(
        response.responseJSON.data.type,
        response.responseJSON.data.message,
      );
    },
  });
  let modalElement = document.getElementById("userEditModal");

  const modal = bootstrap.Modal.getInstance(modalElement);

  modal?.hide();
});

$(document).on("submit", "#addAuthorForm", function (e) {
  e.preventDefault();

  let formData = new FormData(this);

  $.ajax({
    type: "POST",
    url: "profile/addAuthor",
    data: formData,
    processData: false,
    contentType: false,
    dataType: "json",

    success: function (response) {
      $("#addAuthorModal p[data-error]").addClass("d-none");
      $("#addAuthorForm")[0].reset();

      const modal = bootstrap.Modal.getInstance($("#addAuthorModal").get(0));
      modal?.hide();

      addAuthor(response.data);
    },

    error: function (response) {
      let errors = response.responseJSON.data;
      showErrors(errors);
    },
  });
});

$(document).on(
  "focus",
  "#addAuthorForm input, #addAuthorForm textarea",
  function () {
    $(this).next("p[data-error]").addClass("d-none");
  },
);

$(document).on("submit", "#BooksFilterForm", function (e) {
  e.preventDefault();

  let formData = new FormData(this);
  let page = 1;
  formData.append("page", page);

  $.ajax({
    type: "POST",
    url: "profile/filterBooks",
    data: formData,
    success: function (response) {
      let books = response.data.data,
        currentPage = response.data.currentPage,
        totalPages = response.data.totalPages;
      $("#books-tab-pane > .row").html("");
      if (books.length == 0) {
        $("#books-tab-pane > .row").html(
          `<div class="alert alert-warning text-center" role="alert">
              No books found.
            </div>`,
        );
        return;
      }
      let booksHtml = BookCard(books);
      $("#books-tab-pane > nav ").remove();

      $("#books-tab-pane > .row").html(booksHtml);

      $("#books-tab-pane").append(
        preparePagination(totalPages, currentPage, "books"),
      );
    },
    error: function (response) {
      Toast(
        response.responseJSON.data.type,
        response.responseJSON.data.message,
      );
    },
  });
});

$(document).on("click", "#books-tab-pane .page-link", function (e) {
  e.preventDefault();
  let page = $(this).attr("href").split("=")[1];
  let formData = new FormData($("#BooksFilterForm").get(0));
  formData.append("page", page);
  $.ajax({
    type: "POST",
    url: "profile/filterBooks",
    data: formData,
    success: function (response) {
      let books = response.data.data,
        currentPage = response.data.currentPage,
        totalPages = response.data.totalPages;
      $("#books-tab-pane > .row").html("");
      if (books.length == 0) {
        $("#books-tab-pane > .row").html(
          `<div class="alert alert-warning text-center" role="alert">
              No books found.
            </div>`,
        );
        return;
      }
      let booksHtml = BookCard(books);

      $("#books-tab-pane > .row").html(booksHtml);

      $("#books-tab-pane > nav ").remove();

      $("#books-tab-pane").append(
        preparePagination(totalPages, currentPage, "books"),
      );
    },
    error: function (response) {
      Toast("error", response.responseJSON.data.message);
    },
  });
});
function openAddBookModal(that, authorId, authorName) {
  that.blur();
  $("#AuthorId option").val(authorId).text(authorName);
  $("#BookAuthorId").val(authorId);

  const modal = new bootstrap.Modal($("#addBookModal").get(0));
  modal.show();
}

$(document).on("submit", "#addBookForm", function (e) {
  e.preventDefault();

  let formData = new FormData(this);

  $.ajax({
    type: "POST",
    url: "profile/addBook",
    data: formData,
    dataType: "json",
    success: function (response) {
      $("#addBookModal p[data-error]").addClass("d-none");
      $("#addBookForm")[0].reset();

      const modal = bootstrap.Modal.getInstance($("#addBookModal").get(0));
      modal?.hide();

      let book = response.data;

      $("#books-tab-pane > .row").prepend(BookCard([book]));
    },
    error: function (response) {
      let errors = response.responseJSON.data;
      showErrors(errors);
    },
  });
});

function banUser(that, userId, text) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: `Yes, ${text} it!`,
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "profile/banUser",
        data: { userId: userId },
        dataType: "json",
        success: function (response) {
          Swal.fire({
            title: "Deleted!",
            text: "Your file has been deleted.",
            icon: "success",
          });
          let button = $(that);
          if (text === "ban") {
            button.closest(".card").prepend(`
                        <span class="badge text-bg-danger position-absolute" style="top: 10px; right: 10px;">Banned</span>
                    `);
          } else {
            button.closest(".card").find(".badge").remove();
          }
          button.attr(
            "onclick",
            `banUser(this, ${userId}, '${text === "ban" ? "unban" : "ban"}')`,
          );
          button.text(text === "ban" ? "Unban" : "Ban");
          button.toggleClass("btn-danger btn-success");
        },
        error: function (response) {
          console.log(response);
          console.log(response.responseJSON);
          Toast("error", response.responseJSON.message);
        },
      });
    }
  });
}

// $(document).on("click", "#orders_ordered-tab-pane .page-link", function (e) {
//   e.preventDefault();
//   let page = $(this).attr("href").split("=")[1];
//   $.ajax({
//     type: "POST",
//     url: "profile/pagination/ordered",
//     data: { page: page },
//     success: function (response) {
//       console.log(response);
//       let orders = response.data.data.data,
//         currentPage = response.data.data.currentPage,
//         totalPages = response.data.data.totalPages;
//       $("#orders_ordered-tab-pane > .table-responsive").html("");
//       if (orders.length == 0) {
//         $("#orders_ordered-tab-pane > .table-responsive").html(
//           `<div class="alert alert-warning text-center" role="alert">
//               No orders found.
//             </div>`,
//         );
//         return;
//       }
//       let ordersHtml = orderTable(orders,"ordered");
//       $("#orders_ordered-tab-pane > .table-responsive").html(ordersHtml);

//       $("#orders_ordered-tab-pane > nav ").remove();

//       $("#orders_ordered-tab-pane").append(
//         preparePagination(totalPages, currentPage, "orders_ordered"),
//       );
//     },
//     error: function (response) {
//       Toast("error", response.responseJSON.data.message);
//     },
//   });
// });
