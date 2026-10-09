function cancelOrder(orderId) {
  $("#cancelReason").val("");
  openModal("#cancelOrderModal");
  $("#cancelOrderModal .modal-body form").submit(function (e) {
      e.preventDefault();
      let cancelReason = $("#cancelReason").val();
      $.ajax({
        type: "POST",
        url: "/profile/cancelOrder",
        data: { orderId: parseInt(orderId), cancelReason: cancelReason },
        dataType: "json",
        success: function (response) {
          Swal.fire({
            title: "Cancelled!",
            text: "Your order has been cancelled successfully.",
            icon: "success",
            confirmButtonColor: "#c8956c",
            background: "#2a2118",
            color: "#f5efe6",
          });
          $(
            `#orders_ordered-tab-pane .table tbody tr[data-order-id="${orderId}"]`,
          ).remove();
          $("#orders_canceled-tab-pane .table tbody .emptyRow").closest("tr").remove();
          $(`#orders_canceled-tab-pane .table tbody`).prepend(
            tableComponent(response.data),
          );
          $("#cancelOrderModal .btn-close").get(0).click();
          $("#cancelReason").val("");
        },
        error: function (response) {
          Swal.fire({
            title: "Error!",
            text: response.responseJSON?.message,
            icon: "error",
            confirmButtonColor: "#c8956c",
            background: "#2a2118",
            color: "#f5efe6",
          });
        },
      });
    });
}

function doneOrder(orderId) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#c8956c",
    cancelButtonColor: "#c45e4c",
    confirmButtonText: `Yes, done it!`,
    background: "#2a2118",
    color: "#f5efe6",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "/profile/doneOrder",
        data: { orderId: parseInt(orderId) },
        dataType: "json",
        success: function (response) {
          Swal.fire({
            title: "Done!",
            text: "Your order has been done successfully.",
            icon: "success",
            confirmButtonColor: "#c8956c",
            background: "#2a2118",
            color: "#f5efe6",
          });

          $(`#orders_ordered-tab-pane .table tbody tr[data-order-id="${orderId}"]`).remove();
          $("#orders_done-tab-pane .table tbody .emptyRow").closest("tr").remove();
          $(`#orders_done-tab-pane .table tbody`).prepend(
            tableComponent(response.data),
          );
        },
        error: function (response) {
          Swal.fire({
            title: "Error!",
            text: response.responseJSON?.message,
            icon: "error",
            confirmButtonColor: "#c8956c",
            background: "#2a2118",
            color: "#f5efe6",
          });
        },
      });
    }
  });
}

function BookCard(books, type) {
  let bookCards = "";

  for (let book in books) {
    let description =
      books[book]["description"] && books[book]["description"].length > 100
        ? books[book]["description"].substring(0, 100) + "..."
        : books[book]["description"] || "";

    let img = books[book]["image"]
      ? imgPath(`uploads/${books[book]["image"]}`)
      : imgPath("book.png");

    let bookId = books[book]["book_id"] ?? books[book]["id"];
    let authorName = books[book]["author_name"] ?? books[book]["name"] ?? "";
    let isOrderType = type === "showOrder";

    let additionalHtml = "";

    if (type === "books") {
      additionalHtml = `
        <div class="mb-3 text-start">
          <h6 class="mb-1">Description :</h6>
          <div class="item text-start">
            <p class="mb-0">${description}</p>
          </div>
        </div>
      `;
    } else if (type === "showOrder") {
      additionalHtml = `
        <div class="row mb-3">
          <div class="col-4">
            <div class="item d-flex align-items-center">
              <h6 class="mb-0">Subtotal :</h6>
            </div>
          </div>
          <div class="col-8">
            <div class="item text-start">
              <h6 class="subtotal">${books[book]["subtotal"]}</h6>
            </div>
          </div>
        </div>
      `;
    }

    let ulContent = isOrderType
      ? `
        <li class="mb-1">
          <p class="mb-0">${books[book]["quantity"] ?? ""}</p>
          <h6 class="mb-0">Quantity</h6>
        </li>
      `
      : `
        <li class="mb-1">
          <p class="mb-0">${books[book]["stock"] ?? ""}</p>
          <h6 class="mb-0">Stock</h6>
        </li>
      `;

    bookCards += `
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="authorCard card h-100 text-center rounded-4 py-3 px-2 border-0 position-relative" data-book-id="${bookId}">
          <img src="${img}" class="card-img-top m-auto" alt="" style="width: 100px;">
          <div class="card-body d-flex flex-column">
            <div class="card-title mb-3">
              <h5 class="card-title mb-1">${books[book]["title"]}</h5>
              <h6>${authorName}</h6>
            </div>
            <div class="ulContainer py-3 mb-3 text-start">
              <ul class="list-unstyled mb-0">
                ${ulContent}
                <li class="mb-1">
                  <p class="mb-0">${books[book]["price"]}</p>
                  <h6 class="mb-0">Price</h6>
                </li>
              </ul>
            </div>
            ${additionalHtml}
          </div>
        </div>
      </div>
    `;
  }

  return bookCards;
}
