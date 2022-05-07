@extends('layouts.app')
@section('title')
    Page d'acceuil
@endsection

@section('content')
    <div class="app-main__inner">

        <h3>APPLICATIONS
        </h3>

        <div class="row">

            <div class="col-md-9">

                <div class="row">
                    @canany(['isAdmin', 'isDentist'], Auth::user())
                        <div class="col-md-3 mr-3" style="cursor: pointer;">

                            <div class="mb-3 text-center card card-body"
                                onclick="window.location.href = '{{ route('cabinet.index') }}'">

                                <i class=" pe-7s-graph1 icon-gradient bg-asteroid fa-5x mb-2">
                                </i>

                                <h5 class="card-title">MON CABINET
                                </h5>
                                Consulter le tableau de bord de votre cabinet.

                            </div>

                        </div>
                    @endcanany
                    <div class="col-md-3 mr-3" style="cursor: pointer;">

                        <div class="mb-3 text-center card card-body card-patient"
                            onclick="window.location.href = '{{ route('patients.index') }}'">

                            <i class=" pe-7s-id icon-gradient bg-happy-itmeo fa-5x mb-2">
                            </i>

                            <h5 class="card-title">MES PATIENTS
                            </h5>
                            Gérez vos patients et leurs dossiers médicales.

                        </div>

                    </div>
                    @canany(['isAdmin', 'isDentist'], Auth::user())
                        <div class="col-md-3 mr-3" style="cursor: pointer;">

                            <div class="mb-3 text-center card card-body"
                                onclick="window.location.href = '{{ route('prescriptions.index') }}'">

                                <i class=" pe-7s-note2 icon-gradient bg-happy-fisher fa-5x mb-2">
                                </i>

                                <h5 class="card-title">MES ORDONNANCES
                                </h5>
                                Gérez vos les ordonnances de vos patients.

                            </div>

                        </div>
                    @endcanany
                    <div class="col-md-3 mr-3" style="cursor: pointer;">

                        <div class="mb-3 text-center card card-body"
                            onclick="window.location.href = '{{ route('payments.index') }}'">

                            <i class=" pe-7s-cash icon-gradient bg-grow-early fa-5x mb-2">
                            </i>

                            <h5 class="card-title">MES HONORAIRES
                            </h5>
                            Gérez les honoraires de vos patients .

                        </div>

                    </div>

                    <div class="col-md-3 mr-3" style="cursor: pointer;">

                        <div class="mb-3 text-center card card-body"
                            onclick="window.location.href = '{{ route('appointement.index') }}'">

                            <i class=" pe-7s-date icon-gradient bg-plum-plate fa-5x mb-2">
                            </i>

                            <h5 class="card-title">AGENDA
                            </h5>
                            Gérez les prises de rendez-vous des patients .

                        </div>

                    </div>
                    @can('isAdmin', Auth::user())
                        <div class="col-md-3 mr-3" style="cursor: pointer;">

                            <div class="mb-3 text-center card card-body"
                                onclick="window.location.href = '{{ route('setting.index') }}'">

                                <i class=" pe-7s-config  icon-gradient bg-mean-fruit fa-5x mb-2">
                                </i>

                                <h5 class="card-title">REGLAGES
                                </h5>
                                Gérez les réglages de votre cabinet.

                            </div>

                        </div>
                    @endcan


                </div>

            </div>

            <div class="col-md-3">

                <div class="row">

                    <div class="col-md-12">
                        <div class="mb-3 text-center card card-body">

                            <i class="fa fa-user-md icon-gradient bg-mean-fruit fa-5x mb-2">
                            </i>

                            <h3 class="text-center">Bienvenue Dr.{{ strtoupper(Auth::user()->name) }}
                                {{ Auth::user()->prenom }}
                            </h3>
                            <p class="text-center">Votre dernière connexion {{ Auth::user()->last_login }} </p>
                            <b>Profile : </b>{{ Auth::user()->role->nom }} <br />
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        @canany(['isAdmin', 'isDentist'], Auth::user())
            <h3>MEDIAS
            </h3>

            <div class="row">

                <div class="col-md-3 mr-3" style="cursor: pointer;">

                    <div class="mb-3 text-center card card-body"
                        onclick="window.location.href = '{{ route('demos.index') }}'">

                        <i class=" pe-7s-video icon-gradient bg-mean-fruit fa-5x mb-2">
                        </i>

                        <h5 class="card-title">VIDEOS DEMOS
                        </h5>
                        Gérez votre bibliothèque de vidéos.

                    </div>

                </div>

                <div class="col-md-3 mr-3" style="cursor: pointer;">

                    <div class="mb-3 text-center card card-body"
                        onclick="window.location.href = '{{ route('bibliotheque.index') }}'">

                        <i class=" pe-7s-photo icon-gradient bg-mean-fruit fa-5x mb-2">
                        </i>

                        <h5 class="card-title">MES PHOTOS
                        </h5>
                        Gérez votre bibliothèque de photos.

                    </div>

                </div>

            </div>
        @endcanany
    </div>
@endsection
