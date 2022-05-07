@extends('layouts.app')

@section('title')
    Vidéos démo
@endsection

@section('content')
    <div class="app-main__inner" id="videos_demo">
        <videos-demo :user="{{ Auth::user()->load('cabinet') }}"></videos-demo>
    </div>
@endsection

@section('js_scripts')
    <script src="/js/liste-videos-demo.js"></script>
@endsection
