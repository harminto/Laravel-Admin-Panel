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

// Fungsi untuk menampilkan Toastr success
function showSuccessToast(message) {
  toastr.success(message);
}

// Fungsi untuk menampilkan Toastr error
function showErrorToast(message) {
  toastr.error(message);
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
  var method = 'POST'; // Ubah metode HTTP menjadi POST karena tidak didukung langsung oleh browser
  var data = new FormData(form[0]);
  data.append('_method', 'PUT'); // Tambahkan _method dengan nilai PUT ke data FormData

  $.ajax({
      url: url,
      type: method,
      data: data,
      processData: false,
      contentType: false,
      success: function(response) {
          successCallback(response);
      },
      error: function(xhr, status, error) {
          errorCallback(xhr.responseJSON);
      }
  });
}

// Fungsi untuk menampilkan SweetAlert konfirmasi
function showConfirmationAlert(title, text, successCallback) {
  Swal.fire({
    title: title,
    text: text,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes',
    cancelButtonText: 'No'
  }).then(function(result) {
    if (result.isConfirmed) {
      successCallback();
    }
  });
}

// Fungsi untuk menangani delete data
// JavaScript code
function handleFormDelete(event) {
  event.preventDefault();

  var form = event.target;
  var formData = new FormData(form);
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Konfirmasi menggunakan Swal sebelum melakukan tindakan penghapusan
  Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to delete this data?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'No'
  }).then(function(result) {
    if (result.isConfirmed) {
      // Mendapatkan URL dari atribut action pada form
      var url = form.getAttribute('action');

      // Kirim permintaan DELETE ke server menggunakan AJAX
      $.ajax({
        url: url,
        type: 'DELETE',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
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
        },
        error: function(xhr, status, error) {
          Swal.fire({
            title: 'Error',
            text: 'An error occurred during the delete request.',
            icon: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        }
      });
    }
  });
}

// Datatables Dynamic Data Handler
function initializeDataTable(tableClass, url, columns) {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $(tableClass).DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      ajax: {
          url: url,
          type: "POST"
      },
      columns: columns,
      language: {
          emptyTable: "Tidak ada data yang tersedia",
          info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
          infoEmpty: "Menampilkan 0 hingga 0 dari 0 entri",
          infoFiltered: "(disaring dari total _MAX_ entri)",
          lengthMenu: "Tampilkan _MENU_ entri per halaman",
          loadingRecords: "Memuat...",
          processing: "Sedang diproses...",
          search: "Cari:",
          zeroRecords: "Tidak ada data yang cocok",
          paginate: {
              first: "Pertama",
              last: "Terakhir",
              next: "Selanjutnya",
              previous: "Sebelumnya"
          },
          aria: {
              sortAscending: ": aktifkan untuk mengurutkan kolom secara ascending",
              sortDescending: ": aktifkan untuk mengurutkan kolom secara descending"
          }
      }
  });
}

