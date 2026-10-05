function cancelOrder(orderId) {
  openModal("#cancelOrderModal");
  $("#cancelOrderModal .modal-body form").submit(function (e) {
    e.preventDefault();
    let cancelReason = $("#cancelReason").val();
    $.ajax({
      type: "POST",
      url: "profile/cancelOrder",
      data: { orderId: parseInt(orderId), cancelReason: cancelReason },
      dataType: "json",
      success: function (response) {
        console.log(response);
        Swal.fire({
          title: "Cancelled!",
          text: "Your order has been cancelled successfully.",
          icon: "success",
        });
        $(
          `#orders_ordered-tab-pane .table tbody tr[data-order-id="${orderId}"]`,
        ).remove();
        $(`#orders_canceled-tab-pane .table tbody`).prepend(
          tableComponent(response.data),
        );
        $("#cancelOrderModal .btn-close").get(0).click();
      },
      error: function (response) {
        console.log(response);
        swal.fire({
          title: "Error!",
          text: response.responseJSON.message,
          icon: "error",
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
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: `Yes, done it!`,
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "profile/doneOrder",
        data: { orderId: parseInt(orderId) },
        dataType: "json",
        success: function (response) {
          console.log(response);
          Swal.fire({
            title: "Done!",
            text: "Your order has been done successfully.",
            icon: "success",
          });

          $(`#orders_ordered-tab-pane .table tbody tr[data-order-id="${orderId}"]`).remove();
          $(`#orders_done-tab-pane .table tbody`).prepend(
            tableComponent(response.data),
          );
        },
        error: function (response) {
          swal.fire({
            title: "Error!",
            text: response.responseJSON.message,
            icon: "error",
          });
        },
      });
    }
  });
}

function BookCard(books, type) {
  let bookCards = "";
  let description = "";

  for (let book in books) {
    description =
      books[book]["description"].length > 100
        ? books[book]["description"].substring(0, 100) + "..."
        : books[book]["description"];

    let img = books[book]["image"]
      ? imgPath(`uploads/${books[book]["image"]}`)
      : imgPath("book.png");

    let additionalHtml = "";

    if (type === "books") {
      additionalHtml += `
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

      `;
    } else if (type === "showOrder") {
      additionalHtml += `
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

    bookCards += `
      <div class="col-lg-4 col-md-6 mb-4">
        <div
          class="card h-100 text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis position-relative"
          data-book-id="${books[book]["book_id"] ?? books[book]["id"]}">

          <img
            src="${img}"
            class="card-img-top m-auto"
            alt="Book"
            style="width: 100px;">

          <div class="card-body d-flex flex-column">

            <h5 class="card-title fw-bold mb-3">
              ${books[book]["title"]}
            </h5>

            <div class="border-top border-bottom py-3 mb-3 text-start">

              <h6 class="mb-2">
                <strong>Author:</strong>
                ${books[book]["author_name"] ?? books[book]["name"]}
              </h6>

              <h6 class="mb-2">
                <strong>Price:</strong>
                ${books[book]["price"]}
              </h6>

              <h6 class="mb-0">
                <strong>Description:</strong>
                ${description}
              </h6>

            </div>

            ${additionalHtml}

          </div>
        </div>
      </div>
    `;
  }

  return bookCards;
}
