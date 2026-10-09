function addToCart(bookId, that) {
  let quantityVal = $(that).prev().val();
  if (quantityVal < 0) {
    Toast("error", "Quantity must be greater than 0");
    return;
  }

  $.ajax({
    type: "POST",
    url: "/profile/addToCart",
    data: { bookId: bookId, quantity: quantityVal },
    dataType: "json",
    success: function (response) {
      Toast("success", "Book added to cart");
      $(that).prev().val("");
      $("#cartCount").text(response.data.totalItems);
    },
    error: function (response) {
      Toast("error", response.responseJSON?.message);
    },
  });
}

function updateQuantity(that, action) {
  let quantityInput = $(that).siblings("input");
  let currentQuantity = parseInt(quantityInput.val());
  if (action === "add") {
    quantityInput.val(currentQuantity + 1);
  } else if (action === "remove" && currentQuantity > 1) {
    quantityInput.val(currentQuantity - 1);
  } else {
    Toast("error", "Quantity must be greater than 0");
    quantityInput.val(0);
  }
}

function updateItemQuantity(that, orderItemId, action) {
  let $card = $(that).closest(".card"),
    $inputElement = $card.find("input"),
    bookIdVal = $card.data("book-id"),
    data = {
      orderItemId: orderItemId,
      quantity: parseInt($inputElement.val()),
      bookId: parseInt(bookIdVal),
    };
  $(that).prop("disabled", true);

  $.ajax({
    type: "POST",
    url: `/profile/updateCart`,
    data: data,
    dataType: "json",
    success: function (response) {
      if (response.data.orderItem?.quantity === 0) {
        $(that).closest(".col-lg-4").remove();
      }
      $inputElement.val(response.data.orderItem?.quantity);
      $("#cartModal .modal-body h5 span").text(response.data.totalPrice);
      $(that)
        .closest(".card")
        .find(".subtotal")
        .text(response.data.orderItem?.subtotal);

      $("#cartCount").text(response.data.totalItems);

      if (response.data.totalItems == 0) {
        $("#cartModal .modal-body").html(emptyCart());
      }
    },
    error: function (response) {
      Toast("error", response.responseJSON?.message);
    },
    complete: function () {
      setTimeout(function () {
        $(that).prop("disabled", false);
      }, 500);
    },
  });
}

function deleteBook(orderItemId, that) {
  $(that).prop("disabled", true);
  $.ajax({
    type: "POST",
    url: "/profile/removeFromCart",
    data: { orderItemId: parseInt(orderItemId) },
    dataType: "json",
    success: function (response) {
      $(that).closest(".col-lg-4").remove();
      $("#cartModal .modal-body h5 span").text(response.data.totalPrice);
      $("#cartCount").text(response.data.totalItems);
      if (response.data.totalItems == 0) {
        $("#cartModal .modal-body").html(emptyCart());
      }
    },
    error: function (response) {
      Toast("error", response.responseJSON?.message);
    },
    complete: function () {
      setTimeout(function () {
        $(that).prop("disabled", false);
      }, 500);
    },
  });
}

function fireOrder(orderId) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#c8956c",
    cancelButtonColor: "#c45e4c",
    confirmButtonText: `Yes, order it!`,
    background: "#2a2118",
    color: "#f5efe6",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "/profile/fireOrder",
        data: { orderId: parseInt(orderId) },
        dataType: "json",
        success: function (response) {
          Swal.fire({
            title: "Order Placed!",
            text: "Your order has been placed successfully.",
            icon: "success",
            confirmButtonColor: "#c8956c",
            background: "#2a2118",
            color: "#f5efe6",
          });

          $("#cartModal .modal-body").html(emptyCart());
          $("#cartCount").text(0);

          $("#cartModal .btn-close").get(0).click();
          $("#orders_ordered-tab-pane .table tbody td.emptyRow")
            .closest("tr")
            .remove();
          $("#orders_ordered-tab-pane .table tbody").prepend(
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

function emptyCart() {
  return `
  <div class="alert alert-warning text-center" role="alert">
                Your cart is empty.
  </div>`;
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
        <div class="input-group mt-auto">
          <input type="number" class="form-control" placeholder="Quantity" id="bookQuantity-${books[book]["id"]}" name="bookQuantity">
          <button class="btn cartBtn py-2 px-3" type="button" onclick="addToCart('${books[book]["id"]}', this)">Add to Cart</button>
        </div>
      `;
    } else if (type === "cart") {
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
        <div class="input-group buttonsContainer m-auto mt-auto">
          <button class="btn secondaryButton btn-sm" type="button" onclick="updateQuantity(this, 'remove')">
            <i class="fa-solid fa-minus"></i>
          </button>
          <input type="text" class="form-control text-center" placeholder="Quantity" name="bookQuantity" value="${books[book]["quantity"]}" disabled>
          <button class="btn mainButton btn-sm" type="button" onclick="updateQuantity(this, 'add')">
            <i class="fa-solid fa-plus"></i>
          </button>
        </div>
        <div class="d-flex justify-content-center mt-3">
          <button class="btn mainButton" type="button" onclick="updateItemQuantity(this, '${books[book]["order_item_id"]}')">
            Update
          </button>
        </div>
        <div class="badge position-absolute" style="top: 15px; right: 15px;">
          <i class="fa-solid fa-trash-can text-danger fs-6 deleteIcon" style="cursor: pointer;" onclick="deleteBook('${books[book]["order_item_id"]}', this)"></i>
        </div>
      `;
    } else if (type === "showOrder") {
      additionalHtml = `
        <div class="row mb-3 mt-auto">
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
