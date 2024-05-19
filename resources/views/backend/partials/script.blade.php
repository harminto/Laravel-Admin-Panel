<!-- General JS Scripts -->
<script src="{{ asset('assets/backend/stisla/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/backend/stisla/modules/popper.js') }}"></script>
{{-- <script src="{{ asset('assets/backend/stisla/modules/tooltip.js') }}"></script> --}}
<script src="{{ asset('assets/backend/stisla/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/backend/stisla/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
{{-- <script src="{{ asset('assets/backend/stisla/modules/moment.min.js') }}"></script> --}}

<script src="{{ asset('assets/backend/stisla/js/stisla.js') }}"></script>
<script src="{{ asset('assets/backend/stisla/modules/toastr/toastr.min.js') }}"></script>

@yield('custom-javascript')

<script src="{{ asset('assets/backend/stisla/modules/nprogress/nprogress.js') }}"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    NProgress.configure({ showSpinner: false });

    var elements = document.querySelectorAll('a[data-nprogress], button[data-nprogress]');
    elements.forEach(function(element) {
        element.addEventListener("click", function() {
            NProgress.start();
        });
    });
  });
</script>

<!-- Ajax Handler -->
<script src="{{ asset('assets/backend/stisla/modules/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/backend/stisla/js/ajaxHandler.js') }}"></script>
<!-- JS Libraies -->
<script src="{{ asset('assets/backend/stisla/modules/izitoast/js/iziToast.min.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('assets/backend/stisla/js/scripts.js') }}"></script>
<script src="{{ asset('assets/backend/stisla/js/custom.js') }}"></script>
