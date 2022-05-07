@extends('layouts.app')

@section('title')
    Mes Honoraires
@endsection

@section('content')
    <div class="app-main__inner" id="payments">
        <payments :user="{{ Auth::user()->load('cabinet') }}"></payments>
    </div>
@endsection

@section('js_scripts')
    <script src="/js/liste-payments.js"></script>
@endsection
