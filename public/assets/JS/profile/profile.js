$(document).ready(function () {
  let type = window.location.search.replace("?", "").split("-")[0];
  if (!type) return;
  let tab = document.getElementById(`${type}-tab`);
  if (!tab) return;

  tab.click();
  tab.blur();
});

$(document).on("submit", "#userEditForm", function (e) {
  e.preventDefault();

  let type = $(this).attr("data-type");
  let label = $(this).attr("data-edit-label");
  let formData = new FormData(this);

  $.ajax({
    type: "POST",
    url: `/profile/edit/${type}`,
    data: formData,
    dataType: "json",
    success: function (response) {
      Toast(response.data.type, response.message);
      if (type === "name") {
        $(`span[data-type="name"]`).text(response.data.value);
        $(`i[data-edit-label="Name"]`).attr(
          "onclick",
          `editUser('Name', '${response.data.value}')`,
        );
      } else if (type === "password") {
        $(`h6[data-type="password"]`).text("");
      } else {
        $(`h6[data-type="${type}"]`).text(response.data.value);
        $(`i[data-edit-label="${label}"]`).attr(
          "onclick",
          `editUser('${label}', '${response.data.value}')`,
        );
      }
    },
    error: function (response) {
      Toast(
        response.responseJSON?.data?.type ?? "error",
        response.responseJSON?.message,
      );
    },
  });
  document.activeElement?.blur();

  $("#userEditModal .btn-close").get(0).click();
});

$(document).on("submit", "#addAuthorForm", function (e) {
  e.preventDefault();

  let formData = new FormData(this);

  $.ajax({
    type: "POST",
    url: "/profile/addAuthor",
    data: formData,
    processData: false,
    contentType: false,
    dataType: "json",

    success: function (response) {
      $("#addAuthorModal p[data-error]").addClass("d-none");
      $("#addAuthorForm")[0].reset();

      $("#addAuthorModal .btn-close").get(0).click();

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
  "#addAuthorForm input, #addAuthorForm textarea, #addBookForm input, #addBookForm textarea",
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
    url: "/profile/filterBooks",
    data: formData,
    dataType: "json",
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
      let booksHtml = BookCard(books, "books");
      $("#books-tab-pane > nav ").remove();

      $("#books-tab-pane > .row").html(booksHtml);

      $("#books-tab-pane").append(
        preparePagination(totalPages, currentPage, "books"),
      );
    },
    error: function (response) {
      Toast(
        response.responseJSON?.data?.type ?? "error",
        response.responseJSON?.message,
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
    url: "/profile/filterBooks",
    data: formData,
    dataType: "json",
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
      let booksHtml = BookCard(books, "books");

      $("#books-tab-pane > .row").html(booksHtml);

      $("#books-tab-pane > nav ").remove();

      $("#books-tab-pane").append(
        preparePagination(totalPages, currentPage, "books"),
      );
    },
    error: function (response) {
      Toast("error", response.responseJSON?.message);
    },
  });
});

$(document).on("submit", "#addBookForm", function (e) {
  e.preventDefault();

  let formData = new FormData(this);

  $.ajax({
    type: "POST",
    url: "/profile/addBook",
    data: formData,
    dataType: "json",
    success: function (response) {
      $("#addBookModal p[data-error]").addClass("d-none");
      $("#addBookForm")[0].reset();

      $("#addBookModal .btn-close").get(0).click();

      let book = response.data;

      $("#books-tab-pane > .row .alert").remove();
      $("#books-tab-pane > .row").prepend(BookCard([book], "books"));
    },
    error: function (response) {
      let errors = response.responseJSON.data;
        showErrors(errors);
    },
  });
});

$(document).on("click", "#orders_ordered-tab-pane .page-link", function (e) {
  e.preventDefault();

  let page = $(this).attr("href").split("=")[1];
  $.ajax({
    type: "POST",
    url: "/profile/pagination/ordered",
    data: { page: page },
    success: function (response) {
      let orders = response.data.orders.data,
        currentPage = response.data.orders.currentPage,
        totalPages = response.data.orders.totalPages;

      $("#orders_ordered-tab-pane > .table-responsive tbody").html("");
      if (orders.length == 0) {
        $("#orders_ordered-tab-pane > .table-responsive tbody").html(
          `<tr>
            <td colspan="${response.data.role === 'admin' ? 6 : 5}" class="text-center emptyRow">No ordered orders found.</td>
          </tr>`,
        );
        return;
      }
      let ordersHtml = tableComponent(orders, response.data.role, true);
      $("#orders_ordered-tab-pane > .table-responsive tbody").html(ordersHtml);

      $("#orders_ordered-tab-pane > nav ").remove();

      $("#orders_ordered-tab-pane").append(
        preparePagination(totalPages, currentPage, "orders_ordered"),
      );
    },
    error: function (response) {
      Toast("error", response.responseJSON?.message);
    },
  });
});

$(document).on("click", "#orders_canceled-tab-pane .page-link", function (e) {
  e.preventDefault();

  let page = $(this).attr("href").split("=")[1];
  $.ajax({
    type: "POST",
    url: "/profile/pagination/canceled",
    data: { page: page },
    success: function (response) {
      let orders = response.data.orders.data,
        currentPage = response.data.orders.currentPage,
        totalPages = response.data.orders.totalPages;

      $("#orders_canceled-tab-pane > .table-responsive tbody").html("");
      if (orders.length == 0) {
        $("#orders_canceled-tab-pane > .table-responsive tbody").html(
          `<tr>
            <td colspan="5" class="text-center emptyRow">No canceled orders found.</td>
          </tr>`,
        );
        return;
      }
      let ordersHtml = tableComponent(orders, response.data.role);
      $("#orders_canceled-tab-pane > .table-responsive tbody").html(ordersHtml);

      $("#orders_canceled-tab-pane > nav ").remove();

      $("#orders_canceled-tab-pane").append(
        preparePagination(totalPages, currentPage, "orders_canceled"),
      );
    },
    error: function (response) {
      Toast("error", response.responseJSON?.message);
    },
  });
});

$(document).on("click", "#orders_done-tab-pane .page-link", function (e) {
  e.preventDefault();

  let page = $(this).attr("href").split("=")[1];
  $.ajax({
    type: "POST",
    url: "/profile/pagination/done",
    data: { page: page },
    success: function (response) {
      let orders = response.data.orders.data,
        currentPage = response.data.orders.currentPage,
        totalPages = response.data.orders.totalPages;

      $("#orders_done-tab-pane > .table-responsive tbody").html("");
      if (orders.length == 0) {
        $("#orders_done-tab-pane > .table-responsive tbody").html(
          `<tr>
            <td colspan="5" class="text-center emptyRow">No done orders found.</td>
          </tr>`,
        );
        return;
      }
      let ordersHtml = tableComponent(orders);
      $("#orders_done-tab-pane > .table-responsive tbody").html(ordersHtml);

      $("#orders_done-tab-pane > nav ").remove();

      $("#orders_done-tab-pane").append(
        preparePagination(totalPages, currentPage, "orders_done"),
      );
    },
    error: function (response) {
      Toast("error", response.responseJSON?.message);
    },
  });
});
