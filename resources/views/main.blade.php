<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="fr">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="icon" href="/img/favicon.ico" type="image/x-icon" /> -->
    <title>@yield('title')</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
</head>


<body>
    <div id="app">

        <app :user="{{ Auth::user()->load('cabinet', 'role') }}" :csrf="{{ json_encode(csrf_token()) }}" />

    </div>

{{-- <script src="https://cdn.jsdelivr.net/gh/underground-works/clockwork-browser@1/dist/toolbar.js"></script> --}}
   {{-- <script src="{{ asset('architect/assets/scripts/main.js') }}"></script> --}}
    <script src="{{ mix('js/app.js') }}"></script>

</body>

</html>
