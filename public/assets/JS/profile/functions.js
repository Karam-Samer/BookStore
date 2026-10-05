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
        <div class="card h-100 text-center rounded-4 py-3 px-2 border-0 bg-primary-subtle text-primary-emphasis position-relative">

            <img
                src="${authorImg}"
                class="card-img-top m-auto"
                alt="Author"
                style="width: 100px;">

            <div class="card-body d-flex flex-column">

                <h5 class="card-title fw-bold mb-3">
                    ${author.authorName}
                </h5>

                <div class="border-top border-bottom py-3 mb-3 text-start">
                    <h6 class="mb-0">
                        ${shortBio}...
                    </h6>
                </div>

                <button class="btn btn-success w-100 mt-auto">
                    Ban
                </button>

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

// function orderTable(orders, userType = "user") {
//   console.log(userType);
//   let tableBody = "",
//     tableRows = "";
//   newBody = ``;
//   newRow = ``;
//   if (userType === "admin") {
//     newBody = `<td>
//                     <button class="btn btn-sm btn-danger me-2">Cancel</button>
//                     <button class="btn btn-sm btn-success">Done</button>
//                 </td>`;
//     newRow = `<th scope="col">Options</th>`;
//   }

//   tableRows = `
//   <table class="table table-info table-striped table-hover align-middle">
//         <thead>
//             <tr>
//                 <th scope="col">#</th>
//                 <th scope="col">Customer</th>
//                 <th scope="col">Total Price</th>
//                 <th scope="col">Details</th>
//                 <th scope="col">Created At</th>
//                 ${newRow}
//             </tr>
//             </thead>
//             <tbody>`;

//   orders.forEach((order) => {
//     tableBody += `
//     <tr>
//       <th scope="row">${order["id"]}</th>
//       <td>${order["customer_name"]}</td>
//                 <td>${order["total_price"]}</td>
//                 <td>
//                     <a href="#">See Details</a>
//                 </td>
//                 <td>${order["created_at"]}</td>
//                 ${newBody}
//             </tr>
//             `;
//   });

//   tableBody += `</tbody> </table>`;
//   html = tableRows + tableBody;
//   return html;
// }

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
            text: `User has been ${text}ned.`,
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

function openAddBookModal(authorId, authorName) {
  $("#AuthorId option").val(authorId).text(authorName);
  $("#BookAuthorId").val(authorId);

  openModal("#addBookModal");
}

function openModal(ModalId) {
  const modal = new bootstrap.Modal($(ModalId).get(0));
  modal.show();
  document.activeElement?.blur();
}

//Customer

function getCartItems(orderId = null, status = "cart") {
  if (orderId !== null) {
    data = { orderId: parseInt(orderId) };
  } else {
    data = {};
  }
  $.ajax({
    type: "POST",
    url: "profile/getCartItems",
    data: data,
    dataType: "json",
    success: function (response) {
      console.log(response);
      openModal("#cartModal");
      let Books = response.data;
      let BooksHtml = BookCard(response.data, status);
      if (Books.length === 0) {
        $("#cartModal .modal-body").html(emptyCart());
        return;
      }
      $("#cartModal .modal-body").html(`
        <h5 class="mb-3 text-center">Total Price: <span class="text-success">${Books[0]?.total_price ?? 0}</span></h5>
        <div class="row">
        ${BooksHtml}
        ${
          status === "cart"
            ? `
          <button class="btn btn-primary mt-3" onclick="fireOrder(${Books[0]["order_id"]})">Place Order</button>`
            : ""
        }
        </div>
        `);
    },
    error: function (response) {
      console.log(response);
      Toast("error", response.responseJSON.message);
    },
  });
}

function tableComponent(orders, type = "user", orderType = false) {
  let tableHtml = "",
    checked = false,
    newBody = "";
  if (type === "admin" && orderType) {
    checked = true;
  }

  for (let order in orders) {
    console.log(orders[order]["id"]);
    if (checked) {
      newBody = `<td>
                    <button class="btn btn-sm btn-danger me-2" onclick="cancelOrder('${orders[order]["id"]}')">Cancel</button>
                    <button class="btn btn-sm btn-success" onclick="doneOrder('${orders[order]["id"]}')">Done</button>
                </td>`;
    }
    tableHtml += `
            <tr>
                <th scope="row">${orders[order].id}</th>
                <td>${orders[order].customer_name}</td>
                <td>${orders[order].total_price}</td>
                <td>
                <span class="badge text-bg-success" style="cursor: pointer;" onclick="getCartItems('${orders[order].id}', 'showOrder');">Show Details</span>
                </td>
                <td>${orders[order].created_at}</td>
                ${checked ? newBody : ""}
            </tr>`;
  }
  return tableHtml;
}
