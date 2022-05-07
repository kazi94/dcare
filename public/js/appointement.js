

var CLIENT_ID = '56629036222-olt2h280r5kd381df4inirb9i1nuu2th.apps.googleusercontent.com';
var API_KEY = 'AIzaSyBxWjTEOkAzcCXP8WjNhNdMNGOhuoa9C6Y';

// Array of API discovery doc URLs for APIs used by the quickstart
var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest"];

// Authorization scopes required by the API; multiple scopes can be
// included, separated by spaces.
var SCOPES = "https://www.googleapis.com/auth/calendar";

function selectUser(params) {
    scheduler.clearAll();
    scheduler.load(`/rendez-vous/${params}`, "json");
}
let selectedFilter = 0;
// attach event handler to update filters object and refresh view (so filters will be applied)
function val() {
    selectedFilter = document.getElementById("search").value;
    scheduler.updateView();
}

function init($user_id = null) {

    /* -------------------------------------------------------------------------- */
    /*                       Config Scheduller and templates                      */
    /* -------------------------------------------------------------------------- */
    scheduler.config.touch = "force"; //when touch to the cas , modals appear
    scheduler.config.multi_day = true;
    scheduler.locale.labels.year_tab = "Année";
    scheduler.config.prevent_cache = true;
    scheduler.config.first_hour = 8; //first hour display in calendar
    scheduler.config.last_hour = 22;
    scheduler.config.start_on_monday = false; //Set First day to Sunday (Dimanche)
    scheduler.config.limit_time_select = true;
    scheduler.config.date_format = "%Y-%m-%d %H:%i:%s"; //parse returned date to spesefic format 
    scheduler.locale.labels.agenda_tab = "Agenda"; //Nom tab Agenda
    scheduler.locale.labels.date = "Date";
    scheduler.locale.labels.description = "Rendez-vous"; //the header of the description column
    scheduler.config.event_duration = 30; //specify the event duration in minutes for the auto_end_time parameter
    scheduler.config.auto_end_date = true;
    scheduler.config.details_on_dblclick = true;
    scheduler.config.quick_info_detached = true;
    scheduler.config.dblclick_create = true;
    scheduler.config.drag_create = false; // create on drag the event
    scheduler.locale.labels.section_type = "Type";
    scheduler.xy.margin_top = 30;
    scheduler.config.multisection = true;
    scheduler.locale.labels.timeline_tab = "Cabinet";
    scheduler.locale.labels.unit_tab = "Cabinet";
    scheduler.locale.labels.section_custom = "Assigner à ";
    scheduler.config.responsive_lightbox = true;
    scheduler.config.max_month_events = 4; // view more month view
    scheduler.xy.min_event_height = 12;
    scheduler.config.hour_size_px = 88; // change the height of the scale's unit of eventbox
    scheduler.config.icons_select = [
        "icon_validate",
        "icon_abandon",
        "icon_report",
        "icon_delete",
        "icon_details",
    ];
    scheduler.locale.labels.icon_validate = "Valider";
    scheduler.locale.labels.icon_abandon = "Annuler";
    scheduler.locale.labels.icon_report = "Reporter";
    scheduler.locale.labels.icon_details = "Modifier";

    scheduler._click.buttons.validate = (id) => {
        $.ajax({
            type: "POST",
            url: `/api/appointements/${id}/update-state`,
            data: {
                state: 'validate',
            },
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            datatype: "json"
        }).done(function () {
            dhtmlx.message({
                type: "toast-success",
                text: "Rendez-vous validé !"
            });
        })
            .fail(function (e) {
                dhtmlx.alert({
                    type: "alert-error",
                    text: "Erreur , Svp essayer de recharger votre page et réessayer"
                });
            });

    };
    scheduler._click.buttons.abandon = function (id) {
        $.ajax({
            type: "POST",
            url: `/api/appointements/${id}/update-state`,
            data: {
                state: 'cancel',
            },
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            datatype: "json"
        }).done(function () {
            dhtmlx.message({
                type: "success",
                text: "Rendez-vous annulé !"
            });
        })
            .fail(function (e) {
                dhtmlx.alert({
                    type: "alert-error",
                    text: "Erreur , Svp essayer de recharger votre page et réessayer"
                });
            });
    };
    scheduler._click.buttons.report = function (id) {

        $.ajax({
            type: "POST",
            url: "/api/appointements/" + id + "/update-state",
            data: {
                state: 'report',
            },
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            datatype: "json"
        }).done(function () {
            dhtmlx.message({
                type: "toast-report ",
                text: "Rendez-vous reporté !"
            });
        })
            .fail(function (e) {
                dhtmlx.alert({
                    type: "alert-error",
                    text: "Erreur , Svp essayer de recharger votre page et réessayer"
                });
            });
    };
    var format = scheduler.date.date_to_str("%H:%i");

    scheduler.templates.hour_scale = function (date) {
        const step = 30;
        let html = "";
        for (let i = 0; i < 60 / step; i++) {
            html += "<div style='height:44px;line-height:44px;'>" + format(date) + "</div>";
            date = scheduler.date.add(date, step, "minute");
        }
        return html;
    };
    scheduler.templates.week_date = function (start, end) {
        return scheduler.templates.day_date(start) + " &ndash; " +
            scheduler.templates.day_date(scheduler.date.add(end, -1, "day"));
    };
    /* -------------------------------------------------------------------------- */

    scheduler.filter_month = scheduler.filter_day = scheduler.filter_week = function (id, event) {
        // display event only if its type is set to true in filters obj
        // or it was not defined yet - for newly created event
        if (event.category_id == selectedFilter || selectedFilter == 0) {
            return true;
        }

        // default, do not display event
        return false;
    };

    /* -------------------------------------------------------------------------- */
    /*                              CONFIG MONTH VIEW                             */
    /* -------------------------------------------------------------------------- */
    // Define "view more" link
    scheduler.templates.month_events_link = function (date, count) {
        return "<a style='font-weight : bold'>Plus de détails.....(" + count + " RDV)</a>";
    };

    scheduler.attachEvent("onViewMoreClick", function (date) {
        scheduler.updateView(date, "week");
        return false;
    });

    scheduler.templates.event_bar_date = function (start, end, ev) {
        return "<b>" + scheduler.templates.event_date(start) + "</b>";
    };
    scheduler.templates.event_bar_text = function (start, end, event) {
        if (event.patient != undefined && event.patient.nom != undefined)
            return `<b > ${event.patient.nom}  ${event.patient.prenom} &nbsp;
                            <span class='badge badge-${(event.fauteuil == 1) ? 'danger' : 'success'} mr-1 p-1 rounded-circle'>${event.fauteuil}</span></b>`;
        else
            return event.text;
    };
    scheduler.templates.event_class = function (start, end, ev) {

        return "dhx_cal_month_event ";
    };
    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */
    /*                             CONFIG AGENDA VIEW                             */
    /* -------------------------------------------------------------------------- */
    // scheduler.templates.agenda_time = function (start, end) {
    //     return "<b style='color : white'>" + scheduler.templates.event_date(start) + "</b>";
    // };
    scheduler.templates.agenda_text = function (start, end, event) {
        if (event.patient != undefined && event.patient.nom != undefined)
            return `<b style='color:white'> ${event.patient.nom}  ${event.patient.prenom} &nbsp; ${event.text} &nbsp; Fauteuil : ${event.fauteuil}</b>`;
        else
            return `<b> ${event.text} </b>`;
    };
    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */
    /*                              CONFIG Unit AND TIMELINE VIEW                 */
    /* -------------------------------------------------------------------------- */


    var users = scheduler.serverList("users");
    var categories = scheduler.serverList("categories");
    var fauteuils = [{
        key: '1',
        label: "Fauteuil 1"
    },
    {
        key: '2',
        label: "Fauteuil 2"
    }
    ];
    var patients = scheduler.serverList("patients");
    scheduler.createTimelineView({
        name: "timeline",
        x_unit: "minute",
        x_date: "%H:%i",
        x_step: 30,
        x_size: 24,
        y_unit: users,
        y_property: "assign_to", // ici il va prendre la valeur de assignto de la table appointements et la comparer avec l'id des users pour l'ajouter dans sont timeline
        render: "bar",
        second_scale: {
            x_unit: "day", // unit which should be used for second scale
            x_date: "%F %d" // date format which should be used for second scale, "July 01"
        }
    });

    scheduler.createUnitsView({
        name: "unit",
        property: "assign_to",
        list: users
    });

    scheduler.addMarkedTimespan({
        start_date: new Date(2017, 6, 6, 10),
        end_date: new Date(2017, 6, 7, 12),
        type: "dhx_time_block",
        sections: {
            timeline: [1, 3], // list of sections
            unit: [1, 3]
        }
    });

    scheduler.addMarkedTimespan({
        start_date: new Date(2017, 6, 3, 13),
        end_date: new Date(2017, 6, 4, 13),
        type: "dhx_time_block",
        sections: {
            timeline: 2, // only 1 section
            unit: 2
        }
    });
    /* -------------------------------------------------------------------------- */


    /* -------------------------------------------------------------------------- */
    /*                              config light BOX                              */
    /* -------------------------------------------------------------------------- */
    scheduler.form_blocks["my.editor1"] = {
        render: function (sns) {
            let options = "";

            $.each(patients, function (index, val) {
                options += "<option value=" + val.key + ">" + val.label + "</option>";
            });
            let html = "<div class='dhx_cal_ltext' style='height:35px;'>" +
                "<select class='select2' name='patient_id' id='patients' style='width:300px; margin :5px;' required>" +
                options + "</select>" +
                "</div>";
            return html;
        },
        set_value: function (node, value, ev) {
            node.querySelector("[name='patient_id']").value = value || "";
        },
        get_value: function (node, ev) {
            return node.querySelector("[name='patient_id']").value;
        }
    };

    scheduler.attachEvent("onLightBox", function () {
        $('.select2').select2({
            tags: true
        }); // pour afficher select2
    });

    scheduler.config.lightbox.sections = [{
        name: "Patient*",
        height: 23,
        type: "my.editor1",
        map_to: "patient_id",
        options: scheduler.serverList("patients")
    },
    {
        name: "Famille*",
        height: 23,
        type: "select",
        map_to: "category_id",
        options: categories,
        vertical: "false"
    },
    {
        name: "Fauteuil*",
        height: 23,
        type: "select",
        map_to: "fauteuil",
        options: fauteuils,
        vertical: "false"
    },
    {
        name: "custom",
        height: 22,
        map_to: "assign_to",
        type: "select",
        options: users,
        vertical: "false"
    },
    {
        name: "Acte à faire",
        height: 80,
        map_to: "acte",
        type: "textarea",
        default_value: "Nouvel acte"
    },
    {
        name: "Période",
        height: 72,
        type: "time",
        map_to: "auto"
    }
    ];

    scheduler.templates.lightbox_header = function (start, end, event) {
        if (event.patient != undefined && event.patient.nom != undefined)
            return `${scheduler.templates.event_date(start)} - 
                ${scheduler.templates.event_date(end)}<b> ${event.patient.nom} ${event.patient.prenom} 
            </b>`;
        if (event.patient != undefined && event.patient.label != undefined)
            return `${scheduler.templates.event_date(start)} - 
                ${scheduler.templates.event_date(end)}<b>  ${event.patient.label}
                        </b> `;
        return `${scheduler.templates.event_date(start)} - 
                ${scheduler.templates.event_date(end)}`;
    };
    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */
    /*                         Config && Style Events Box                         */
    /* -------------------------------------------------------------------------- */

    /* ------------------------ Config Event box content ------------------------ */
    scheduler.templates.event_header = function (start, end, event) {

        if (event.patient != undefined && event.patient.nom != undefined)
            return `<div style='border-left: 5px solid ${event.category.color}; height: 43px; top: 0; left: 0;z-index: 99999999; position: absolute;'></div><b> ${event.patient.nom} ${event.patient.prenom} 
            </b><span class='badge badge-abs badge-${(event.fauteuil == 1) ? 'danger' : 'success'}
                        mr-1 p-1 rounded-circle'>${event.fauteuil}</span>`;
        if (event.patient != undefined && event.patient.label != undefined)
            return `<div style='border-left: 5px solid ${event.category.color}; height: 43px; top: 0; left: 0;z-index: 99999999; position: absolute;'></div><b>  ${event.patient.label}
                        </b><span class='badge badge-abs badge-${(event.fauteuil == 1) ? 'danger' : 'success'} 
                        mr-1 p-1 rounded-circle'>${event.fauteuil}</span > `;
        if (event.patient_id != undefined) return `<div style='border-left: 5px solid ${event.category.color}; height: 43px; top: 0; left: 0;z-index: 99999999; position: absolute;'></div>${event.patient_id} - 
                ${event.patient_id}
                <span class='badge badge-abs badge-${(event.fauteuil == 1) ? 'danger' : 'success'}
                        mr-1 p-1 rounded-circle'>${event.fauteuil}</span>`;

        return `${scheduler.templates.event_date(start)} - 
                ${scheduler.templates.event_date(end)}`;


    };

    scheduler.templates.event_text = function (start, end, event) {
        return "";
    };

    /* ------------------------ Handle on Save button ------------------------ */
    scheduler.attachEvent("onEventSave", function (id, ev, is_new) {
        // Validaton Form
        if (!ev.fauteuil || !ev.patient_id || !ev.category_id) {
            dhtmlx.alert("Tous les champs (*) sont obligatoires !");
            return false;
        }
        ev.category = ev.category_id;
        ev.up_patient_id = ev.patient_id;
        for (let patient of patients) {
            if (ev.patient_id == patient.key) {
                ev.patient = patient;
                break;
            }
        }
        // Detect Collision
        var events = scheduler.getEvents(ev.start_date, ev.end_date);
        var count = events.length;
        for (let i = 0; i < count; i++) {
            const event = events[i];
            const curr_fauteuil = ev.fauteuil; // From created event
            if (id != event.id && curr_fauteuil == event.fauteuil) {
                dhtmlx.alert("Attention ! Un autre rendez-vous est dèja pris dans pour le fauteuil N°" + ev
                    .fauteuil + ".");
                return true;
            }
        }
        return true;
    });
    var dblclickEv = 0;
    /**
     * 
     */
    scheduler.attachEvent("onDragEnd", function (id, mode, e) {
        console.log("On Drag End");
        setTimeout(function () {
            if (dblclickEv) {
                //console.log('onDragEnd after onDblClick');
            } else {
                //console.log('onDragEnd');
                if (mode == "move" || mode == "resize") {
                    // Detect Collision
                    var dragged_ev = scheduler.getEvent(id);
                    var events = scheduler.getEvents(dragged_ev.start_date, dragged_ev.end_date);
                    dragged_ev.up_patient_id = dragged_ev.patient_id;
                    var count = events.length;
                    for (let i = 0; i < count; i++) {
                        const event = events[i];
                        if (dragged_ev.id != event.id && dragged_ev.fauteuil == event.fauteuil) {
                            dhtmlx.alert(
                                "Attention ! Un autre rendez-vous est dèja pris dans pour le fauteuil N°" +
                                dragged_ev.fauteuil + ".");
                            return true;
                        }
                    }
                    return true;

                }
            }
            return true;
        }, 200);
        dblclickEv = 0;
    });
    /**
     * 
     */
    scheduler.attachEvent("onEventDrag", function (id, mode, ev) {
        console.log("On Event Drag");
        ev.up_patient_id = ev.patient_id;

    });
    /**
     * Handle on click on event box
     */
    scheduler.attachEvent("onClick", function (id, e) {
        console.log('onClick :>> ', "onClick");
        // remove this section and edit on dblclick will be available
        var clickedDate = scheduler.getActionData(e);
        scheduler.updateView(clickedDate.date, "week");
        dblclickEv = 1;
        //scheduler.hideQuickInfo();
        return true;
    });
    /**
     * Handle On Double Click on event BOX
     */
    scheduler.attachEvent("onDblClick", function (id, e) {
        //scheduler.showQuickInfo(id);
        dblclickEv = 1;
        return true;
    });

    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */
    /*                                  Tooltips                                  */
    /* -------------------------------------------------------------------------- */

    scheduler.templates.tooltip_text = function (
        start, end, event) {
        var info_text = "";
        if (event.patient != undefined && event.patient.nom != undefined) {
            info_text += "<b>Patient :</b> " + event.patient.nom + " " +
                event.patient.prenom + "</br>";
            info_text += "<b>Heure :</b> " + scheduler.templates.event_date(start) + " - " +
                scheduler.templates.event_date(end) + "</br>";
            info_text += "<b>Acte :</b> " + event.text +
                "</b>";

            return info_text;

        } else {
            info_text += "<b>Patient :</b> " + event.patient_id + " </br>";
            info_text += "<b>Heure :</b> " + scheduler.templates.event_date(start) + " - " +
                scheduler.templates.event_date(end) + "</br>";
            info_text += "<b>Acte :</b> " + event.acte +
                "</b>";

            return info_text;
        }

    };
    /* ---------------------------- Year Tooltips ---------------------------- */
    scheduler.templates.year_tooltip = function (start, end, event) {
        if (event.patient != undefined && event.patient.nom != undefined)
            return `<div style='color:white'> ${event.patient.nom}  ${event.patient.prenom} 
                            <span class='badge badge-${(event.fauteuil == 1) ? 'danger' : 'success'} mr-1 p-1 rounded-circle'>${event.fauteuil}</span></div>`;
        else
            return event.acte;
    };

    /* ------------------- Remove infobulle from Year view ------------------ */
    var view = null;

    scheduler.attachEvent("onViewChange", function (new_mode, new_date) {
        view = new_mode;
    });

    scheduler.attachEvent("onBeforeTooltip", function (id) {
        return view !== 'year';
    });
    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */
    /*                 Touch Support (Popup on click on event box)                */
    /* -------------------------------------------------------------------------- */

    /* ------------------- the content of the pop-up edit form ------------------ */
    scheduler.templates.quick_info_content = function (start, end, event) {
        if (event.patient != undefined && event.patient.nom != undefined)
            return `<b>Patient:</b> <a href='/patients/${event.patient.id}' target='_blank'>${event.patient.nom}   ${event.patient.prenom} </a><br>
                <b>Famille : </b> ${event.category.name} <br> 
                <b>Créer par :</b> ${event.created_by.name} ${event.created_by.prenom}</b><br/>
                <b>Assigner à :</b> ${event.assigned_to.name} ${event.assigned_to.prenom}`;
        else
            return "<b>Patient:</b>" + event.patient_id + " " + event.patient_id + "<br>" +
                "<b>Acte: </b>" + event.acte;

    };

    /* -------------------  the date of the pop-up edit form ------------------ */
    scheduler.templates.quick_info_date = function (start, end, ev) {
        return scheduler.templates.event_date(start) + " - " +
            scheduler.templates.event_date(end);

    };
    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */
    /*                        on templates ready after init                       */
    /* -------------------------------------------------------------------------- */
    scheduler.attachEvent("onTemplatesReady", function () {
        var fix_date = function (date) { // 17:48:56 -> 17:30:00
            date = new Date(date);
            if (date.getMinutes() <= 30)
                date.setMinutes(0);
            else
                date.setMinutes(30);

            return date;
        };



        var marked = null;
        var marked_date = null;
        var event_step = 30;
        scheduler.attachEvent("onEmptyClick", function (date, native_event) {
            scheduler.unmarkTimespan(marked);
            marked = null;

            var fixed_date = fix_date(date);
            scheduler.addEventNow(fixed_date, scheduler.date.add(fixed_date, event_step, "minute"));
            // dblclickEv = 1;
            // return true;
        });

        scheduler.attachEvent("onMouseMove", function (event_id, native_event) {
            var date = scheduler.getActionData(native_event).date;
            var fixed_date = fix_date(date);

            if (+fixed_date != +marked_date) {
                scheduler.unmarkTimespan(marked);

                marked_date = fixed_date;
                marked = scheduler.markTimespan({
                    start_date: fixed_date,
                    end_date: scheduler.date.add(fixed_date, event_step, "minute"),
                    css: "highlighted_timespan"
                });
            }
        });

    });
    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */
    /*                            Handle with Json Data                           */
    /* -------------------------------------------------------------------------- */

    /* ------------- load the current user appointements from db ------------- */
    scheduler.load("/rendez-vous/null", "json");

    var dp = new dataProcessor("/rendez-vous"); //Rest Mode : PUT,POST,DELETE
    dp.init(scheduler);
    dp.setTransactionMode({
        mode: "REST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                'content'), // specify Toekn to avoid 419 error
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' // to send Form Data instead of head request
        }
    });
    /* -------------------------------------------------------------------------- */

    /* --------------------------- INIT SCHEDULER HERE -------------------------- */
    scheduler.init('scheduler_here', new Date(), "week");
}

/**
 *  On load, called to load the auth2 library and API client library.
 */
function handleClientLoad() {
    gapi.load('client:auth2', initClient);
}

/**
 *  Initializes the API client library and sets up sign-in state
 *  listeners.
 */
function initClient() {
    gapi.client.init({
        apiKey: API_KEY,
        clientId: CLIENT_ID,
        discoveryDocs: DISCOVERY_DOCS,
        scope: SCOPES
    }).then(function () {
        // Listen for sign-in state changes.
        // gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);

        // // Handle the initial sign-in state.
        // updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
    }, function (error) {
        alert(JSON.stringify(error, null, 2));
    });
}
/**
 *  Called when the signed in status changes, to update the UI
 *  appropriately. After a sign-in, the API is called.
 */
function updateSigninStatus(isSignedIn) {
    $.get("/api/appointements/from-today")
        .done(function (res) {

            function inGCalendar(event_id) {
                if (event_id)
                    return gapi.client.calendar.events.get({
                        'calendarId': "primary",
                        'eventId': event_id
                    }).execute();
                return false;
            }

            //* INSERT EACH EVENT INDIV INTO GOOGLE CALENDAR
            res.forEach(r => {
                const resource = {
                    "summary": r.text,
                    "start": {
                        "dateTime": ISODateString(new Date(Date.parse(r.start_date)))
                    },
                    "end": {
                        "dateTime": ISODateString(new Date(Date.parse(r.end_date)))
                    }
                };

                // IF EVENT ID NOT NULL AND EXIST INTO gCALENDAR, UPDATE THE EXISTING EVENT
                if (r.event_id && inGCalendar(r.event_id)) {
                    var event = inGCalendar(r.event_id);
                    event.summary = r.text;
                    event.start.dateTime = ISODateString(new Date(Date.parse(r.start_date)));
                    event.end.dateTime = ISODateString(new Date(Date.parse(r.end_date)));
                    gapi.client.calendar.events.update("primary", event.getId(), event);
                } else if (!r.event_id) {
                    // ELSE IF EVENT ID NULL CREATE NEW EVENT INTO gCALENDAR
                    const request = gapi.client.calendar.events.insert({
                        'calendarId': "primary",
                        'resource': resource
                    });
                    request.execute(function (event) {
                        calendarEventId = {
                            event_id: event.id,
                            id: r.id
                        };
                        //* INSERT CALENDAR EVENTS ID INTO DB
                        syncAppointement(calendarEventId);
                    });
                } else if (r.event_id && !inGCalendar(r.event_id)) {
                    // ELSE IF EVENT ID NOT NULL AND NOT EXIST INTO gCALENDAR DELETE FROM LOCAL CALENDAR
                    deleteAppointement(r.id);
                }
            });
        }).fail(function (error, code) {
            alert(error + code);
        })
}

function deleteAppointement(id) {
    $.ajax({
        url: "/api/appointements/" + id,
        method: "delete",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    }).done(res => {
        console.log(res);
    })
}

function syncAppointement(calendarEventsId) {
    $.ajax({
        url: "/api/appointements/sync",
        method: "post",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            "calendarEventsId": calendarEventsId,

        }
    }).done(res => {
        console.log(res);
    })
}
// default google time format : 2021-12-05T12:00:00+01:00
function ISODateString(d) {
    function pad(n) {
        return n < 10 ? '0' + n : n
    }
    return d.getUTCFullYear() + '-' + pad(d.getUTCMonth() + 1) + '-' + pad(d.getUTCDate()) + 'T' + pad(d
        .getUTCHours()) + ':' + pad(d.getUTCMinutes()) + ':' + pad(d.getUTCSeconds()) + 'Z'
}
function sync() {
    const isSignedIn = gapi.auth2.getAuthInstance().isSignedIn.get();
    if (!isSignedIn) {
        gapi.auth2.getAuthInstance().signIn();
        updateSigninStatus(isSignedIn)

    }
    else
        updateSigninStatus(isSignedIn)

}