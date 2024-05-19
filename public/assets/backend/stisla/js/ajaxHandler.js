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
  iziToast.success({
    title: 'Success',
    message: message,
    position: 'topRight'
  });
}

// Fungsi untuk menampilkan Toastr error
function showErrorToast(message) {
  iziToast.error({
    title: 'Error',
    message: message,
    position: 'topRight'
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

function submitTransaksiForm(form, successCallback, errorCallback) {
  $.ajax({
    url: form.attr("action"),
    type: form.attr("method"),
    data: form.serialize(), // Menggunakan serialize untuk mengambil data form
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
        if (response.success) {
          successCallback(response);
        } else {
          errorCallback(response);
        }
      },
      error: function(xhr, status, error) {
          errorCallback(xhr.responseJSON);
      }
  });
}

function errorCallback(errors) {
  if (errors && errors.message) {
      // Menampilkan pesan kesalahan kepada pengguna menggunakan toast error
      showErrorToast(errors.message);
  } else {
      // Menampilkan pesan kesalahan umum jika tidak ada pesan yang diterima
      showErrorToast('Terjadi kesalahan. Silakan coba lagi.');
  }
}

// Fungsi untuk menampilkan SweetAlert konfirmasi
function showConfirmationAlert(title, text, successCallback) {
  swal({
    title: title,
    text: text,
    icon: 'warning',
    buttons: ['No', 'Yes'],
    dangerMode: true,
  }).then(function(result) {
    if (result) {
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
  swal({
    title: 'Konfirmasi',
    text: 'Apakah anda yakin untuk menghapus data ini?',
    icon: 'warning',
    buttons: ['Tidak', 'Ya'],
    dangerMode: true,
  }).then(function(result) {
    if (result) {
      var url = form.getAttribute('action');

      $.ajax({
        url: url,
        type: 'DELETE',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          if (response.success) {
            swal({
              title: 'Success',
              text: response.message,
              icon: 'success',
            }).then(function() {
              window.location.reload();
            });
          } else {
            swal({
              title: 'Error',
              text: response.message,
              icon: 'error',
            });
          }
        },
        error: function(xhr, status, error) {
          swal({
            title: 'Error',
            text: 'Terjadi kesalahan saat menghapus data',
            icon: 'error',
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

function initializeDataTableWithFilter(tableClass, url, requestData, columns) {
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
          type: "POST",
          data: requestData // Tambahkan data permintaan ke server
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


function initializeDataTableWithYearFilter(tableClass, url, columns) {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $('#tahun_anggaran').on('change', function() {
    const selectedYear = $(this).val();
    $(tableClass).DataTable().ajax.url(url).draw();
  });
  
  $(tableClass).DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      ajax: {
          url: url,
          type: "POST",
          data: function(d) {
              d.tahun_anggaran = $('#tahun_anggaran').val();
          }
      },
      columns: columns,
      searching: false,
      bLengthChange:  false,
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


function terbilang(number) {
  const huruf = [
    '',
    'Satu',
    'Dua',
    'Tiga',
    'Empat',
    'Lima',
    'Enam',
    'Tujuh',
    'Delapan',
    'Sembilan'
  ];
  const belasan = [
    'Sepuluh',
    'Sebelas',
    'Dua Belas',
    'Tiga Belas',
    'Empat Belas',
    'Lima Belas',
    'Enam Belas',
    'Tujuh Belas',
    'Delapan Belas',
    'Sembilan Belas'
  ];
  const puluhan = [
    '',
    'Sepuluh',
    'Dua Puluh',
    'Tiga Puluh',
    'Empat Puluh',
    'Lima Puluh',
    'Enam Puluh',
    'Tujuh Puluh',
    'Delapan Puluh',
    'Sembilan Puluh'
  ];
  const satuan = ['', 'Ribu', 'Juta', 'Miliar', 'Triliun'];

  let result = '';

  if (number === 0) {
    return 'nol';
  }

  let count = 0;
  while (number > 0) {
    if (number % 1000 > 0) {
      result = terbilangRatusan(number % 1000) + ' ' + satuan[count] + ' ' + result;
    }
    number = Math.floor(number / 1000);
    count++;
  }

  return result.trim();
}

function terbilangRatusan(number) {
  const huruf = [
    '',
    'Satu',
    'Dua',
    'Tiga',
    'Empat',
    'Lima',
    'Enam',
    'Tujuh',
    'Delapan',
    'Sembilan'
  ];
  const belasan = [
    'Sepuluh',
    'Sebelas',
    'Dua Belas',
    'Tiga Belas',
    'Empat Belas',
    'Lima Belas',
    'Enam Belas',
    'Tujuh Belas',
    'Delapan Belas',
    'Sembilan Belas'
  ];
  const puluhan = [
    '',
    'Sepuluh',
    'Dua Puluh',
    'Tiga Puluh',
    'Empat Puluh',
    'lima Puluh',
    'Enam Puluh',
    'Tujuh Puluh',
    'Delapan Puluh',
    'Sembilan Puluh'
  ];

  let result = '';

  if (number >= 100) {
    result += huruf[Math.floor(number / 100)] + ' ratus ';
    number %= 100;
  }

  if (number >= 20) {
    result += puluhan[Math.floor(number / 10)] + ' ';
    number %= 10;
  } else if (number >= 10) {
    result += belasan[number - 10] + ' ';
    number = 0;
  }

  if (number > 0) {
    result += huruf[number] + ' ';
  }

  return result.trim();
}
