@extends('layouts.app')
@section('title')
    Mon agenda
@endsection
@section('styles')
    <script src="/plugins/scheduler/codebase/dhtmlxscheduler.js?v=5.2.1" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="{{ asset('/plugins/scheduler/codebase/dhtmlxscheduler_material.css?v=5.2.1') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/appointement.css') }}">
@endsection

@section('header')
    <div class="">
        @foreach ($users as $user)
            <button class=" btn badge text-white" style="background-color: {{ $user->color }}"
                onclick="selectUser({{ $user->id }})"><i class="fa fa-user mr-1"></i>
                {{ $user->name }}</button>
        @endforeach
        <button class="btn badge badge-info" onclick="selectUser(null)"><i class="fa fa-users mr-1"></i> TOUT</button>

    </div>
@endsection
@section('content')
    <!-- CONTENT -->
    <div class="app-main__outer" style="padding : 5px 5px 0">
        <div class="app-main__inner">

            <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
                <div class="dhx_cal_navline">
                    <div class="dhx_cal_prev_button">&nbsp;</div>
                    <div class="dhx_cal_next_button">&nbsp;</div>
                    <div class="dhx_cal_today_button"></div>
                    <div style=" right: 175px; top: 5px;">
                        <button class="btn btn-outline-info mt-2" style=" line-height: 1.9;" onclick="sync()"
                            title="Synchroniser avec Google Agenda">
                            <i class="fa fa-sync"></i>
                        </button>
                    </div>
                    <div style="right: 220px">
                        <select onchange="val()" id="search" class="form-control">
                            <option value="0" selected>Filtrer par famille</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" style="background-color: {{ $category->color }}">
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="dhx_cal_date"></div>
                    <div class="dhx_cal_tab" name="unit_tab" style="right:360px;"></div>
                    <!-- <div class="dhx_cal_tab" name="timeline_tab" style="right:280px;"></div> -->
                    <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                    <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
                    <div class="dhx_cal_tab" name="agenda_tab" style="right:280px;"></div>
                    <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
                    <div class="dhx_cal_tab" name="year_tab" style="right:280px;"></div>

                </div>
                <div class="dhx_cal_header">
                </div>
                <div class="dhx_cal_data">
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js_scripts')
    <script src="/plugins/scheduler/codebase/ext/dhtmlxscheduler_agenda_view.js?v=5.2.1" type="text/javascript"></script>
    <script src="/plugins/scheduler/codebase/ext/dhtmlxscheduler_quick_info.js?v=5.2.1" type="text/javascript"></script>
    <script src="/plugins/scheduler/codebase/ext/dhtmlxscheduler_readonly.js?v=5.2.1" type="text/javascript"></script>
    <script src="/plugins/scheduler/codebase/sources/locale/locale_fr.js" type="text/javascript"></script>
    <script src="/plugins/select2/dist/js/select2.min.js" type="text/javascript"></script>
    <script src="/plugins/scheduler/codebase/ext/dhtmlxscheduler_limit.js" type="text/javascript"></script>
    <script src='/plugins/scheduler/codebase/ext/dhtmlxscheduler_timeline.js' type="text/javascript"></script>
    <script src="/plugins/scheduler/codebase/ext/dhtmlxscheduler_units.js" type="text/javascript"></script>
    <script src="/plugins/scheduler/codebase/ext/dhtmlxscheduler_multiselect.js" type="text/javascript"></script>
    <script src="/plugins/scheduler/codebase/ext/dhtmlxscheduler_tooltip.js" type="text/javascript"></script>
    <script src="/plugins/scheduler/codebase/ext/dhtmlxscheduler_quick_info.js"></script>
    <script src="/plugins/scheduler/codebase/ext/dhtmlxscheduler_year_view.js"></script>
    <script src="/plugins/scheduler/codebase/ext/dhtmlxscheduler_limit.js?v=5.3.11" type="text/javascript" charset="utf-8">

    </script>
    <script src="/js/appointement.js" type="text/javascript"></script>
    <script async defer src="https://apis.google.com/js/api.js" onload="this.onload=function(){};handleClientLoad()"
        onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>


@endsection
