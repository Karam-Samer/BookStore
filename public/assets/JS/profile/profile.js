$(document).ready(function () {
  let type = window.location.search.replace("?", "").split("-")[0];
  if (!type) return;
  let tab = $(`#${type}-tab`).get(0);

  tab.click();
  tab.blur();
});

function editUser(type, value) {
  let modal = $("#userEditModal");
  let inputHtml = "";
  if (type === "Gender") {
    inputHtml = `
      <label class="form-label">Value</label>
      <select class="form-select">
        <option value="Male" ${value === "male" ? "selected" : ""}>Male</option>
        <option value="Female" ${value === "female" ? "selected" : ""}>Female</option>
      </select>
    `;
  } else {
    inputHtml = `
      <label class="form-label">Value</label>
      <input type="text" class="form-control" placeholder="Enter new value" value="${value}" name="${type.toLowerCase()}"></input>
    `;
  }
  modal.find(".modal-title").text(`Edit ${type}`);
  modal.find("#userEditForm .modal-body").html(inputHtml);
  modal.find("#userEditForm").attr("data-type", type.toLowerCase());
}

$(document).on("submit", "#userEditForm", function (e) {
  e.preventDefault();

  let type = $(this).attr("data-type");
  let formData = new FormData(this);

  $.ajax({
    type: "POST",
    url: "/BookStore/public/profile/edit/" + type,
    data: formData,
    dataType: "json",
    success: function (response) {
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
        icon: response.data.type,
        title: response.message,
      });
      if (type === "name") {
        $(`span[data-type="name"]`).text(response.data.value);
      } else if (type === "password") {
        $(`h6[data-type="password"]`).text("");
      } else {
        $(`h6[data-type="${type}"]`).text(response.data.value);
      }
    },
    error: function (xhr) {
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
        icon: xhr.responseJSON.data.type,
        title: xhr.responseJSON.message,
      });
    },
  });
  let modalElement = document.getElementById("userEditModal");

  const modal = bootstrap.Modal.getInstance(modalElement);

  modal?.hide();
});
