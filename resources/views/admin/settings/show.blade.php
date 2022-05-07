@extends('layouts.app')
@section('title') Réglages @endsection
@section('content')
    <div class="app-main__inner" id="admin_app">

        <h3>REGLAGES
        </h3>

        <div class="row">

            <div class="col-sm-12">

                <div class="mb-3 card">
                    <div class="card-header card-header-tab-animation">

                        <ul class="nav nav-justified">

                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-0" class="nav-link show active">Générals
                                </a>
                            </li>
                            <li class="nav-item"> <a data-toggle="tab" href="#tab-1" class="nav-link show">Utilisateurs
                                </a>
                            </li>

                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-2" class="nav-link show">Ordonnances Type
                                </a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-4" class="nav-link show">Catégories
                                </a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-3" class="nav-link show">Actes
                                </a>
                            </li>

                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">

                            <div class="tab-pane show active" id="tab-0" role="tabpanel">
                                <general-component></general-component>
                            </div>
                            <div class="tab-pane " id="tab-1" role="tabpanel">
                                <user-component></user-component>
                            </div>
                            <div class="tab-pane" id="tab-2" role="tabpanel">
                                <ordonnance-component></ordonnance-component>
                            </div>
                            <div class="tab-pane" id="tab-4" role="tabpanel">
                                <category-component></category-component>
                            </div>
                            <div class="tab-pane " id="tab-3" role="tabpanel">
                                <act-component></act-component>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_scripts')
    <script src="/js/admin_app.js"></script>
@endsection
