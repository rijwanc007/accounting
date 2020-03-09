<!DOCTYPE html>
<html lang="en">
@include('admin.include.head_link')
  <body>
    <div class="container-scroller">
      @include('admin.include.header')
      <div class="container-fluid page-body-wrapper">
        @include('admin.include.side_bar')
        <div class="main-panel">
          <div class="content-wrapper">
           @yield('content')
          </div>
          @include('admin.include.footer')
        </div>
      </div>
    </div>
    @include('admin.include.footer_link')
    <script>
      toastr.options = {
        "debug": false,
        "positionClass": "toast-top-left",
        "onclick": null,
        "fadeIn": 300,
        "fadeOut": 1000,
        "timeOut": 5000,
        "extendedTimeOut": 1000
      };
      @if(Session::has('success'))
      toastr.success("{{Session::get('success')}}");
      @endif
      @if(Session::has('error'))
      toastr.error("{{Session::get('error')}}");
      @endif
    </script>
  </body>
</html>

