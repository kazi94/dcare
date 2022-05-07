<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dossier patient {{ $patient->nom }} {{ $patient->prenom }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;1,300&family=Rubik:ital,wght@0,400;1,300&display=swap"
        rel="stylesheet">
    <meta name="msapplication-tap-highlight" content="no">

    <link rel="stylesheet" href="{{ asset('architect/main.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/lightgallery.js-master/src/css/lightgallery.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('plugins/loading/loading-bar.css') }}"> --}}


</head>

<body>
    {{-- <div class="se-pre-con"></div> --}}
    <div id="app" class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header closed-sidebar">

        <!-- HEADER -->
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic is-active"
                            data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button"
                        class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>

            <div class="app-header__content">
                <div class="app-header-left">
                    <ul class="header-menu nav">
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link" v-on:click="newModal()" data-toggle="tooltip"
                                data-placement="bottom" title="Ajouter un nouveau patient">
                                <i class="nav-link-icon fa fa-plus icon-gradient bg-primary"> </i>
                                Patient
                            </a>
                        </li>
                        <li class="btn-group nav-item">
                            <prescription-button :patient="{{ $patient->toJson() }}"
                                :user="{{ Auth::user()->load('cabinet') }}" @get-prescription="getPrescription">
                            </prescription-button>
                        </li>
                        <li class="btn-group nav-item">

                            <radiographie-button :patient="{{ $patient->toJson() }}" @get-image="getImage"
                                :user="{{ Auth::user() }}">
                            </radiographie-button>
                        </li>
                        <li class="btn-group nav-item">
                            <rendez-vous-btn :patient="{{ $patient->toJson() }}" :user="{{ Auth::user() }}">
                            </rendez-vous-btn>
                        </li>
                    </ul>
                </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                            aria-expanded="false" class="p-0 btn">
                                            {{-- <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}+{{ Auth::user()->prenom }}"
                                                alt="..." width="42" class="rounded-circle"> --}}
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div aria-labelledby="dropdownMenuButton1"
                                            class="dropdown-menu dropdown-menu-right">
                                            {{-- <button type="button" tabindex="0" class="dropdown-item">User Account</button> --}}
                                            <button type="button" tabindex="0" class="dropdown-item"
                                                onclick="location.href='{{ route('setting.index') }}'">Paramètres</button>
                                            <div tabindex="-1" class="dropdown-divider"></div>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                            <button type="button" tabindex="0" class="dropdown-item" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">Déconnexion</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        Dr. {{ strtoupper(Auth::user()->name) }}
                                        {{ strtoupper(Auth::user()->prenom) }}

                                    </div>
                                    <div class="widget-subheading">
                                        {{ Auth::user()->profession }}
                                    </div>
                                </div>
                                <div class="widget-content-right header-user-info ml-3">
                                    <appointements :patient="{{ $patient->toJson() }}"></appointements>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HEADER -->

        <div class="app-main">

            <!-- SIDEBAR -->
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                                data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button"
                            class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading">APPLICATIONS</li>
                            <li>
                                <a href="{{ route('home.index') }}">
                                    <i class="bg-primary icon-gradient metismenu-icon pe-7s-home"></i>
                                    Acceuil
                                </a>
                            </li>
                            @canany(['isAdmin', 'isDentist'], Auth::user())
                                <li>
                                    <a href="{{ route('cabinet.index') }}" {{-- class="mm-active" --}}>
                                        <i class="metismenu-icon pe-7s-graph2"></i>
                                        Mon cabinet
                                    </a>
                                </li>
                            @endcanany
                            <li>
                                <a href="{{ route('patients.index') }}" class="">
                                    <i class="metismenu-icon icon-gradient bg-happy-itmeo pe-7s-id"></i>
                                    Mes patients
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('payments.index') }}" class="">
                                    <i class="metismenu-icon icon-gradient bg-grow-early pe-7s-cash"></i>
                                    Mes honoraires
                                </a>
                            </li>
                            @canany(['isAdmin', 'isDentist'], Auth::user())
                                <li>
                                    <a href="{{ route('prescriptions.index') }}" class="">
                                        <i class="metismenu-icon icon-gradient bg-happy-fisher pe-7s-note2"></i>
                                        Mes ordonnances
                                    </a>
                                </li>
                            @endcanany
                            <li>
                                <a href="{{ route('appointement.index') }}" class="">
                                    <i class="metismenu-icon icon-gradient bg-plum-plate pe-7s-date"></i>
                                    Mon agenda
                                </a>
                            </li>
                            @can('isAdmin', Auth::user())
                                <li>
                                    <a href="{{ route('setting.index') }}" class="">
                                        <i
                                            class="metismenu-icon icon-gradient bg-mean-fruit font-weight-bold pe-7s-config"></i>
                                        Réglages
                                    </a>
                                </li>
                            @endcan
                            @canany(['isAdmin', 'isDentist'], Auth::user())
                                <li class="app-sidebar__heading">MEDIAS</li>
                                <li>
                                    <a href="{{ route('demos.index') }}" class="">
                                        <i
                                            class="metismenu-icon icon-gradient bg-mean-fruit font-weight-bold pe-7s-video"></i>
                                        Mes videos
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('bibliotheque.index') }}" class="">
                                        <i
                                            class="metismenu-icon icon-gradient bg-mean-fruit font-weight-bold pe-7s-photo"></i>
                                        Mes photos
                                    </a>
                                </li>
                            @endcanany
                        </ul>
                    </div>
                </div>
            </div>
            <!-- END SIDEBAR -->

            <!-- CONTENT -->
            <div class="app-main__outer">
                <div class="app-main__inner" style="padding : 15px 15px 0">

                    <!-- 
                            <div class="app-page-title">
                             <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-folder icon-gradient bg-happy-itmeo">
                                        </i>
                                    </div>
                                    <div>MES PATIENTS
                                        <div class="page-title-subheading">Liste des patients et ses informations médicales
                                        </div>
                                    </div>
                                </div> 
                                </div>
                            </div>
                        -->

                    <div class="row">

                        <div class="col-md-12">
                            <informations-component :patient="{{ $patient }}"
                                v-on:updated-patient="regeneratePatient" :pathologies="{{ $pats->toJson() }}"
                                :antecedents="{{ $ant->toJson() }}">
                            </informations-component>

                            <card-tabs-component :patient="{{ $patient }}"
                                :user="{{ Auth::user()->load('cabinet') }}" ref="tabs">
                            </card-tabs-component>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <!-- <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="app-footer__inner">
                                <div class="app-footer-left">
                                    <ul class="nav">
                                        <li class="nav-item">
                                dCare & Health - developed by <a href="https://www.hic-sante.com">HIC Santé</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>  -->
                <!-- END FOOTER -->

            </div>
            <!-- END CONTENT -->

        </div>


        <!-- --------------------------MODALS-------------------------- -->
        <div class="modal fade patient_add_modal" tabindex="-1" id="patient_add_modal" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nouveau Patient</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <patient-component v-bind:pathologies="{{ $pats->toJson() }}"
                        v-bind:antecedents="{{ $ant->toJson() }}" csrf="{{ csrf_token() }}">
                    </patient-component>

                </div>
            </div>
        </div>

    </div>



    <script type="text/javascript" src="{{ asset('plugins/jquery-3.4.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('architect/assets/scripts/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js') }}">
    </script>
    <!-- lightgallery plugins -->
    <script src="{{ asset('plugins/lightgallery.js-master/dist/js/lightgallery.min.js') }}"></script>
    <script src="{{ asset('plugins/lightgallery.js-master/demo/js/lg-fullscreen.min.js') }}"></script>
    <script src="{{ asset('plugins/lightgallery.js-master/demo/js/lg-thumbnail.min.js') }}"></script>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ asset('plugins/loading/progress_loading.js') }}"></script> --}}
    <script>
        // Animate loader off screen
        //$(".se-pre-con").fadeOut("slow");
    </script>
</body>

</html>
