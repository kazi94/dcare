<!doctype html>
<html lang="fr">
@include('layouts.head')

<body @if (strpos(url()->current(), '/rendez-vous') != false) onload="init({{ Auth::user()->id }});" @endif>

    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header closed-sidebar">
        @include('layouts.header')
        <div class="app-main">

            @include('layouts.aside')

            <div class="app-main__outer">

                @yield('content')

                @include('layouts.footer')

            </div>
        </div>
    </div>
    <script src="{{ asset('plugins/jquery-3.4.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js') }}">
    </script>
    <!-- <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

    </script> -->

    @yield('js_scripts')
</body>

</html>
