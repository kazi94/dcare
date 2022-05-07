@extends('layouts.app')

@section('title')
    Ma Bibliothèque
@endsection

@section('content')
    <div class="app-main__inner" id="gallery">
        <gallery :user="{{ Auth::user()->load('cabinet') }}"></gallery>
    </div>
@endsection

@section('js_scripts')
    <script src="/js/gallery.js"></script>
@endsection
