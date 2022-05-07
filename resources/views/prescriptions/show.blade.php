@extends('layouts.app')

@section('title')
Mes Ordonnances
@endsection

@section('content')
    <div class="app-main__inner" id="prescriptions">
        <prescriptions :user="{{ Auth::user()->load('cabinet') }}"></prescriptions>
    </div>
@endsection

@section('js_scripts')
    <script src="/js/liste-prescriptions.js"></script>
@endsection
