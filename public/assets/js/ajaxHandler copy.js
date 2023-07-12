// File: ajaxHandler.js

// Fungsi untuk mengirim permintaan Ajax ke server
function sendAjaxRequest(url, method, data, successCallback, errorCallback) {
  $.ajax({
    url: url,
    type: method,
    data: data,
    dataType: 'json',
    success: successCallback,
    error: errorCallback
  });
}

// Fungsi untuk menampilkan SweetAlert sukses
function showSuccessAlert(message) {
  Swal.fire({
    icon: 'success',
    title: 'Success',
    text: message,
    showConfirmButton: false,
    timer: 1500
  });
}

// Fungsi untuk menampilkan SweetAlert error
function showErrorAlert(message) {
  Swal.fire({
    icon: 'error',
    title: 'Error',
    text: message,
    confirmButtonText: 'OK'
  });
}

// Fungsi untuk menangani submit form
function handleFormSubmit(form, successCallback, errorCallback) {
  $.ajax({
    url: form.attr("action"),
    type: form.attr("method"),
    data: new FormData(form[0]),
    processData: false,
    contentType: false,
    success: function (response) {
      if (response.success) {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: response.message,
          showConfirmButton: false,
          timer: 1500
        });
        successCallback(response);
      } else {
        errorCallback(response);
      }
    },
    error: function (xhr, status, error) {
      errorCallback(xhr.responseJSON);
    }
  });
}

// Fungsi untuk menangani update form
function handleFormUpdate(form, successCallback, errorCallback) {
  var url = form.attr('action');
  var method = 'PUT'; // Ubah sesuai dengan metode HTTP yang digunakan untuk update data (PUT atau PATCH)
  var data = form.serialize();

  sendAjaxRequest(
    url,
    method,
    data,
    function(response) {
      showSuccessAlert(response.message);
      successCallback(response);
    },
    function(error) {
      showErrorAlert('An error occurred.');
      errorCallback(error);
    }
  );
}

// Fungsi untuk menangani delete data
function handleDataDelete(event) {
  event.preventDefault();

  var form = event.target.closest('form');
  var url = form.getAttribute('action');

  Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to delete this data?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes',
    cancelButtonText: 'No'
  }).then(function(result) {
    if (result.isConfirmed) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', url, true);
      xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
      xhr.setRequestHeader('Content-type', 'application/json'); // Ganti ke application/json

      var data = {
        _method: 'DELETE'
      };

      xhr.onload = function() {
        if (xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          Swal.fire({
            title: 'Success',
            text: response.message,
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          }).then(function() {
            window.location.reload(); // Memuat ulang halaman
          });
        } else {
          Swal.fire({
            title: 'Error',
            text: 'An error occurred during the delete request.',
            icon: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        }
      };

      xhr.onerror = function() {
        Swal.fire({
          title: 'Error',
          text: 'An error occurred during the delete request.',
          icon: 'error',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
      };

      xhr.send(JSON.stringify(data)); // Mengirim data sebagai string JSON
    }
  });
}