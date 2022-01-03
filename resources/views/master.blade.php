<!DOCTYPE html>
<html lang="en">
@include('include.head_link')
<body>
<div class="container-scroller">
    @include('include.header')
    <div class="container-fluid page-body-wrapper">
        @include('include.side_bar')
        <div class="main-panel">
            <div class="text-center">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="content-wrapper">
                @yield('content')
            </div>
            @include('include.footer')
        </div>
    </div>
</div>
<a id="button"></a>
@include('include.js')
</body>
</html>

