@extends('layouts.app')
@section('title')
    Mon Cabinet
@endsection

@section('styles')
    <link href="{{ asset('plugins/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/jquery-ui/css/jquery_ui.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="app-main__inner" style="padding-top: 15px;">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="bg-love-kiss icon-gradient pe-7s-graph1">
                        </i>
                    </div>
                    <div>MON CABINET
                        <div class="page-title-subheading">Affiche le Tableau de bord du cabinet dentaire.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-midnight-bloom">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left text-white">
                                <div class="widget-heading">PATIENTS</div>
                                <div class="widget-subheading">Nombre de patients ajoutés aujourd'hui</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white">{{ $countPatients }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-arielle-smile ">
                    <div class="widget-content-outer text-white">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-heading">PRESCRIPTIONS</div>
                                <div class="widget-subheading">Nombre d'ordonnances prescrites aujourd'hui </div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers">{{ $prescriptions }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-amy-crisp">
                    <div class="widget-content-outer text-white">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-heading">ACTES</div>
                                <div class="widget-subheading">Nombre d'actes faits aujourd'hui </div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers">{{ $actes }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="mb-3 card">
                    <div class="card-header-tab card-header-tab-animation card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                            Liste des rendez-vous
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tabs-eg-77">

                                <h6 class="text-muted text-uppercase font-size-md opacity-5 font-weight-normal">PATIENTS
                                </h6>
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container ps ps--active-y">
                                        <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                            @foreach ($toDayAppointements as $toDayAppointement)
                                                <li class="list-group-item">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <img width="42" class="rounded-circle"
                                                                    src="{{ asset('img/user.png') }}" alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">
                                                                    {{ $toDayAppointement->patient->nom . ' ' . $toDayAppointement->patient->prenom }}
                                                                </div>
                                                                <div class="widget-subheading">
                                                                    <span
                                                                        style="color : {{ $toDayAppointement->category->color }}; font-weight:bold ">
                                                                        {{ $toDayAppointement->category ? $toDayAppointement->category->name : '' }}
                                                                    </span>
                                                                    |
                                                                    <span style="font-weight: bold">
                                                                        {{ $toDayAppointement->assignedTo ? $toDayAppointement->assignedTo->doctor : '' }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="font-size-xlg text-muted">
                                                                    <span>{{ $toDayAppointement->hour_appointement }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                            @endforeach

                                        </ul>
                                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                        </div>
                                        <div class="ps__rail-y" style="top: 0px; height: 200px; right: 0px;">
                                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 131px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-block text-center card-footer">
                        <button class="btn-wide btn btn-success  "
                            onclick="location.href='{{ route('appointement.index') }}'">MON AGENDA</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="mb-3 card">
                    <div class="card-header-tab card-header-tab-animation card-header">
                        <div class="card-header-title">
                            <!-- <i class="header-icon pe-7s-users icon-gradient bg-love-kiss"> </i> -->
                            PATIENTS
                        </div>
                    </div>
                    <div class="card-body chart-responsive" id="chart-patient">
                        <div class="form-group">
                            <label for="from">Du</label>
                            <input type="text" id="from" name="from" autocomplete="off">
                            <label for="to">Au</label>
                            <input type="text" id="to" name="to" autocomplete="off">
                            <canvas id="line-chart-patients" width="400" height="200"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_scripts')
    <script src="{{ asset('plugins/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/ChartJs/js/Chart.bundle.js') }}"></script>
    <script src="{{ asset('plugins/ChartJs/js/util.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        let colors = [
            "#38eb7a",
            "#ffab03",
            "#ffda05",
            "#00b803",
            "#47a7c9",
            "#704444",
            "#1c2a57",
            "#f505c9",
            "#c90ffc",
            "#0fecfc",
            "#0ffcd1",
            "#d4fc0f",
            "#f5cc00",
            "#f58f00",
        ];

        $(function() {
            var chartPatients;
            var dateFormat = "mm/dd/yy",
                configFrom = {
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    changeYear: true
                },
                configTo = {
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    changeYear: true
                };
            var from = $("#from")
                .datepicker(configFrom)
                .on("change", function() {
                    to.datepicker("option", "minDate", toDate(this));
                });
            var to = $("#to").datepicker(configTo)
                .on("change", function() {
                    from.datepicker("option", "maxDate", toDate(this));
                });

            /**
             * Parse DateTime to Date Format
             * @argument element datetime value
             * @returns {Date} date
             */
            function toDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }
            // -------------
            // - PATIENTS  CHART -
            // -------------
            var ctx2 = document.getElementById('line-chart-patients').getContext('2d');

            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/api/patients/get-between-dates//',
                    type: 'GET',
                    dataType: 'JSON',

                })
                .done(function(obj) {
                    drawPrescPatientChart(obj);
                })
                .fail(function(e1, e2) {
                    console.log(e1 + e2);
                })
                .always(function() {
                    console.log("complete");
                });

            function drawPrescPatientChart(obj) {
                // return array of labels , and data
                var labels = obj.map(function(e) {
                    return moment(e.date_created).format(
                        'LL'
                    ); // moment().format() : affiche la date dans un format spécifique , ll : 'Jan 29,2019'
                });
                var data = obj.map(function(e) {
                    return e.nbr;
                });;

                //Configuration des éléments du graphe
                var color = Chart.helpers.color;
                var config = {
                    type: 'line',
                    data: {
                        labels: labels, // labels: les valeurs de l'axe des x , ici : updated_at
                        datasets: [{
                            label: 'Nombre de Patients',
                            backgroundColor: color(window.chartColors.red).alpha(0.5)
                                .rgbString(), //Couleur de fond du rectangle afficher dans le titre
                            borderColor: window.chartColors
                                .red, //Couleur de bordure du rectangle afficher dans le titre
                            fill: false,
                            data: data, // data les valeur de l'axe des y
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            xAxes: [{
                                type: 'time', // time pour afficher en forme de date extensible
                                display: true, //Afficher l'axe des x
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Temps' // Donner un label à l'axe des x
                                },
                                ticks: {
                                    major: {
                                        fontStyle: 'bold',
                                        fontColor: '#f0000'
                                    }
                                }
                            }],
                            yAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Nombre de patients'
                                }
                            }]
                        },
                        legend: {
                            labels: {
                                defaultFontSize: 18
                            }
                        }
                    }
                };

                //Création du graphe
                chartPatients = new Chart(ctx2, config);
            }

            $('input').on('change', function(event) {
                event.preventDefault();
                var from = $(this).parent().find('input[name="from"]').val();
                var to = $(this).parent().find('input[name="to"]').val();

                if (from && to) {
                    var idChart = $(this).parent().find('canvas').attr('id');
                    console.log(idChart);
                    var rangeStart = moment(from).format("YYYY-MM-DD");
                    var rangeEnd = moment(to).format("YYYY-MM-DD");
                    console.log(rangeStart);
                    console.log(rangeEnd);
                    var url = getUrl(idChart, rangeStart, rangeEnd);
                    var request = $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'JSON',
                        // data: {
                        //     rangeStart: rangeStart,
                        //     rangeEnd: rangeEnd,
                        // },
                        cache: false
                    });
                    request.done(function(response, textStatus) {
                        console.log('done');
                        switch (idChart) {
                            case 'line-chart-patients': // Patients Chart
                                removeDataset(chartPatients);
                                drawPrescPatientChart(response, chartPatients);

                                break;
                            default:
                                break;
                        }


                    });
                    request.fail(function(textStatus, errorThrown) {
                        // Log the error to the console
                        console.error(
                            "The following error occurred: " +
                            textStatus, errorThrown
                        );
                    });

                    request.always(function() {
                        console.log('request finished');
                    });
                }
            });

            function getUrl(idChart, rangeStart, rangeEnd) {
                switch (idChart) {
                    case 'line-chart-patients':
                        return '/api/patients/get-between-dates/' + rangeStart + '/' + rangeEnd
                        break;
                    default:
                        break;
                }
            }

            function removeDataset(chart) {
                chart.data.labels.pop();
                chart.data.datasets = [];
                chart.update();
            };
        });
    </script>
@endsection
