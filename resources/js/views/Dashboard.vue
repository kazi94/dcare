<template>
    <div>
        <div class="app-main__inner" style="padding-top: 15px">
            <div class="row">
                <div class="col-md-3 col-xl-3">
                    <div class="card mb-3 widget-content bg-midnight-bloom">
                        <div class="widget-content-outer">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left text-white">
                                    <div class="widget-heading opacity-10">
                                        PATIENTS DU JOUR
                                    </div>
                                    <div class="widget-subheading">
                                        Nombre de patients ajoutés.
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-white">
                                        {{ dailyData.patientsNumber }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xl-3">
                    <div class="card mb-3 widget-content bg-plum-plate">
                        <div class="widget-content-outer text-white">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading opacity-10">
                                        PRESCRIPTIONS DU JOUR
                                    </div>
                                    <div class="widget-subheading">
                                        Nombre d'ordonnances prescrites.
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers">
                                        {{ dailyData.prescriptionsNumber }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xl-3">
                    <div class="card mb-3 widget-content bg-amy-crisp">
                        <div class="widget-content-outer text-white">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading opacity-10">
                                        ACTES DU JOUR
                                    </div>
                                    <div class="widget-subheading">
                                        Nombre d'actes faits.
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers">
                                        {{ dailyData.actesNumber }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-3 col-xl-3" v-if="user.role_id != 3">
                    <button class="btn btn-info pull-right">
                        <router-link
                            :to="{ name: 'statistics' }"
                            class="text-decoration-none text-white"
                            >Statistiques</router-link
                        >
                        <i class="fa fa-chart-bar"></i>
                    </button>
                </div> -->
            </div>
            <div class="row">
                <div class="col-md-3 col-lg-6">
                    <div class="mb-3 card">
                        <div
                            class="
                                card-header-tab
                                card-header-tab-animation
                                card-header
                                justify-content-between
                            "
                        >
                            <div class="card-header-title">
                                <i
                                    class="
                                        bg-premium-dark
                                        header-icon
                                        icon-gradient
                                        pe-7s-date
                                    "
                                >
                                </i>
                                Liste des rendez-vous
                            </div>

                            <div>
                                <button
                                    class="btn-wide btn btn-primary"
                                    onclick="location.href='/rendez-vous'"
                                    title="Mon Agenda"
                                >
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6
                                class="
                                    text-muted text-uppercase
                                    font-size-md
                                    opacity-5
                                    font-weight-normal
                                "
                                v-if="toDayAppointements.length > 0"
                            >
                                PATIENTS
                            </h6>
                            <div
                                class="scroll-area-lg"
                                v-if="toDayAppointements.length > 0"
                            >
                                <div
                                    class="scrollbar-container ps ps--active-y"
                                >
                                    <ul
                                        class="
                                            rm-list-borders
                                            rm-list-borders-scroll
                                            list-group list-group-flush
                                        "
                                    >
                                        <li
                                            class="list-group-item border-top"
                                            v-for="(toDayAppointement,
                                            key) in toDayAppointements"
                                            :key="key"
                                        >
                                            <div class="widget-content p-0">
                                                <div
                                                    class="
                                                        widget-content-wrapper
                                                    "
                                                >
                                                    <div
                                                        class="
                                                            widget-content-left
                                                            mr-3
                                                        "
                                                    >
                                                        <img
                                                            width="42"
                                                            class="
                                                                rounded-circle
                                                            "
                                                            :src="
                                                                toDayAppointement
                                                                    .patient
                                                                    .sexe == 'F'
                                                                    ? '/img/user-f.png'
                                                                    : '/img/user.png'
                                                            "
                                                            alt=""
                                                        />
                                                    </div>
                                                    <div
                                                        class="
                                                            widget-content-left
                                                        "
                                                    >
                                                        <div
                                                            class="
                                                                widget-heading
                                                                opacity-10
                                                            "
                                                        >
                                                            <router-link
                                                                :to="{
                                                                    name:
                                                                        'patient',
                                                                    params: {
                                                                        id:
                                                                            toDayAppointement
                                                                                .patient
                                                                                .id
                                                                    }
                                                                }"
                                                            >
                                                                {{
                                                                    toDayAppointement
                                                                        .patient
                                                                        .nom +
                                                                        " " +
                                                                        toDayAppointement
                                                                            .patient
                                                                            .prenom
                                                                }}
                                                            </router-link>

                                                            |
                                                            <span>{{
                                                                toDayAppointement.hour_appointement
                                                            }}</span>
                                                        </div>
                                                        <div
                                                            class="
                                                                widget-subheading
                                                            "
                                                        >
                                                            <span
                                                                :style="{
                                                                    color:
                                                                        toDayAppointement
                                                                            .category
                                                                            .color
                                                                }"
                                                                style="
                                                                    font-weight: 700;
                                                                "
                                                            >
                                                                {{
                                                                    toDayAppointement.category
                                                                        ? toDayAppointement
                                                                              .category
                                                                              .name
                                                                        : ""
                                                                }}
                                                            </span>
                                                            |
                                                            <span
                                                                style="
                                                                    font-weight: bold;
                                                                "
                                                            >
                                                                {{
                                                                    toDayAppointement.assigned_to
                                                                        ? toDayAppointement
                                                                              .assigned_to
                                                                              .doctor
                                                                        : ""
                                                                }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="
                                                            widget-content-right
                                                        "
                                                    >
                                                        <div class="text-muted">
                                                            <span
                                                                class="
                                                                    badge
                                                                    badge-success
                                                                "
                                                                style="
                                                                    cursor: pointer;
                                                                "
                                                                @click="
                                                                    handleAppointement(
                                                                        'validate',
                                                                        toDayAppointement,
                                                                        key
                                                                    )
                                                                "
                                                            >
                                                                Présent(e)</span
                                                            >
                                                            <span
                                                                class="
                                                                    badge
                                                                    badge-danger
                                                                "
                                                                style="
                                                                    cursor: pointer;
                                                                "
                                                                @click="
                                                                    handleAppointement(
                                                                        'cancel',
                                                                        toDayAppointement,
                                                                        key
                                                                    )
                                                                "
                                                            >
                                                                Absent(e)</span
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="scroll-area-lg text-center" v-else>
                                <div class="mt-5">
                                    <i
                                        class="
                                            bg-sunny-morning
                                            fa-8x
                                            icon-gradient
                                            pe-7s-smile
                                        "
                                    ></i>
                                    <h3 class="text-dark">
                                        Woohoo, Aucun rendez-vous pour
                                        aujourd'hui !
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-lg-6">
                    <div class="mb-3 card">
                        <div
                            class="
                                card-header-tab
                                card-header-tab-animation
                                card-header
                            "
                        >
                            <div class="card-header-title">
                                <i
                                    class="
                                        bg-premium-dark
                                        header-icon
                                        icon-gradient
                                        pe-7s-hourglass
                                    "
                                >
                                </i>
                                Salle d'attente
                            </div>
                        </div>
                        <div class="card-body">
                            <div v-if="waitingPatients.length > 0">
                                <h6
                                    class="
                                        text-muted text-uppercase
                                        font-size-md
                                        opacity-5
                                        font-weight-normal
                                    "
                                >
                                    PATIENTS
                                </h6>
                                <div class="scroll-area-lg">
                                    <div class="scrollbar-container">
                                        <ul
                                            class="
                                                rm-list-borders
                                                rm-list-borders-scroll
                                                list-group list-group-flush
                                            "
                                        >
                                            <li
                                                class="
                                                    list-group-item
                                                    border-top
                                                "
                                                v-for="(waitingPatient,
                                                key) in waitingPatients"
                                                :key="key"
                                            >
                                                <div class="widget-content p-0">
                                                    <div
                                                        class="
                                                            widget-content-wrapper
                                                        "
                                                    >
                                                        <div
                                                            class="
                                                                widget-content-left
                                                                mr-3
                                                            "
                                                        >
                                                            <img
                                                                width="42"
                                                                class="
                                                                    rounded-circle
                                                                "
                                                                :src="
                                                                    waitingPatient
                                                                        .patient
                                                                        .sexe ==
                                                                    'F'
                                                                        ? '/img/user-f.png'
                                                                        : '/img/user.png'
                                                                "
                                                                alt=""
                                                            />
                                                        </div>
                                                        <div
                                                            class="
                                                                widget-content-left
                                                            "
                                                        >
                                                            <div
                                                                class="
                                                                    widget-heading
                                                                    opacity-10
                                                                "
                                                            >
                                                                <router-link
                                                                    :to="{
                                                                        name:
                                                                            'patient',
                                                                        params: {
                                                                            id:
                                                                                waitingPatient
                                                                                    .patient
                                                                                    .id
                                                                        }
                                                                    }"
                                                                >
                                                                    {{
                                                                        waitingPatient
                                                                            .patient
                                                                            .nom +
                                                                            " " +
                                                                            waitingPatient
                                                                                .patient
                                                                                .prenom
                                                                    }}
                                                                </router-link>
                                                                |
                                                                <span>{{
                                                                    waitingPatient.hour_appointement
                                                                }}</span>
                                                            </div>
                                                            <div
                                                                class="
                                                                    widget-subheading
                                                                "
                                                            >
                                                                <span
                                                                    :style="{
                                                                        color:
                                                                            waitingPatient
                                                                                .category
                                                                                .color
                                                                    }"
                                                                    style="
                                                                        font-weight: 700;
                                                                    "
                                                                >
                                                                    {{
                                                                        waitingPatient.category
                                                                            ? waitingPatient
                                                                                  .category
                                                                                  .name
                                                                            : ""
                                                                    }}
                                                                </span>
                                                                |
                                                                <span
                                                                    style="
                                                                        font-weight: bold;
                                                                    "
                                                                >
                                                                    {{
                                                                        waitingPatient.assigned_to
                                                                            ? waitingPatient
                                                                                  .assigned_to
                                                                                  .doctor
                                                                            : ""
                                                                    }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="
                                                                widget-content-right
                                                            "
                                                        >
                                                            <div
                                                                class="
                                                                    text-muted
                                                                "
                                                            >
                                                                <span
                                                                    style="
                                                                        cursor: pointer;
                                                                    "
                                                                    title="Mettre fin à l'attente du patient"
                                                                    @click="
                                                                        getToConsultation(
                                                                            waitingPatient.id,
                                                                            key
                                                                        )
                                                                    "
                                                                    class="
                                                                        font-weight-bolder
                                                                    "
                                                                    :class="{
                                                                        'text-danger':
                                                                            waitingPatient.is_delayed,
                                                                        'text-success': !waitingPatient.is_delayed
                                                                    }"
                                                                    >+
                                                                    {{
                                                                        waitingPatient.waiting_time
                                                                    }}</span
                                                                >
                                                                <!-- <span
                                                                    class="
                                                                        badge
                                                                        badge-success
                                                                    "
                                                                    style="
                                                                        cursor: pointer;
                                                                    "
                                                                >
                                                                    <i
                                                                        title="Passer à la consultation"
                                                                        class="
                                                                            fa
                                                                            fa-check
                                                                            bg-success
                                                                        "
                                                                    ></i
                                                                ></span> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="scroll-area-lg text-center" v-else>
                                <div class="mt-5">
                                    <i
                                        class="
                                            bg-sunny-morning
                                            fa-8x
                                            icon-gradient
                                            pe-7s-smile
                                        "
                                    ></i>
                                    <h3 class="text-dark">
                                        Woohoo, Aucun patient dans la salle
                                        d'attente !
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import statisticApi from "@/services/api/statisticApi.js";
import userApi from "@/services/api/userApi.js";
import appointementApi from "@/services/api/appointementApi.js";
import Appointements from "@/Components/Patient/Appointements";

import "../assets/architect/main.js";

export default {
    data() {
        return {
            toDayAppointements: [],
            dailyData: {
                actesNumber: "",
                prescriptionsNumber: "",
                patientsNumber: "",
                totalPayments: ""
            },
            user: "",
            waitingPatients: []
        };
    },
    methods: {
        async fetchToDayData() {
            const response = await statisticApi.getDailyData();
            this.dailyData = {
                patientsNumber: response.data.patientsNumber,
                prescriptionsNumber: response.data.prescriptionsNumber,
                actesNumber: response.data.actesNumber,
                totalPayments: response.data.totalPayments
            };
        },
        async fetchTodayAppointementsAndWatingPatients() {
            const response = await statisticApi.getToDayAppointements();

            this.toDayAppointements = response.data["toDayAppointements"];
            this.waitingPatients = response.data["waitingPatientsOfToday"];
            this.waitingPatients.forEach(item => {
                this.calculateTime(item);
            });
        },
        async fetchUser() {
            const response = await userApi.getAuthUser();

            this.user = response.data;
        },
        async handleAppointement(state, appointement, idx) {
            var self = this;
            var form = new FormData();
            form.append("state", state);
            const response = await appointementApi.updateState(
                form,
                appointement.id
            );
            appointement = response.data;

            if (state == "validate") {
                this.waitingPatients.push(appointement);
                self.calculateTime(appointement);
            }
            this.toDayAppointements.splice(idx, 1);
        },
        calculateTime(appointement) {
            var timeBegan = null,
                timeStopped = null,
                stoppedDuration = 0,
                started = null,
                that = this,
                idx = that.waitingPatients.findIndex(
                    e => e.id == appointement.id
                ),
                running = false;
            start(appointement);
            function start(appointement) {
                if (running) return;

                if (timeBegan === null) {
                    // reset();
                    timeBegan = appointement.state_modified_at
                        ? new Date(appointement.state_modified_at)
                        : new Date();
                }

                if (timeStopped !== null) {
                    stoppedDuration += new Date() - timeStopped;
                }

                // started = clockRunning();
                started = setInterval(clockRunning, 10);
                running = true;
            }
            function clockRunning() {
                var currentTime = new Date(),
                    timeElapsed = new Date(
                        currentTime - timeBegan - stoppedDuration
                    ),
                    hour = timeElapsed.getUTCHours(),
                    min = timeElapsed.getUTCMinutes(),
                    sec = timeElapsed.getUTCSeconds();
                // ms = timeElapsed.getUTCMilliseconds();
                // var idx = that.waitingPatients.findIndex(
                //     e => e.appointement == appointement
                // );
                // console.log("clockRunning " + idx);
                that.waitingPatients[idx].waiting_time =
                    zeroPrefix(hour, 2) +
                    ":" +
                    zeroPrefix(min, 2) +
                    ":" +
                    zeroPrefix(sec, 2);
                // "." +
                // zeroPrefix(ms, 3);
            }

            function zeroPrefix(num, digit) {
                var zero = "";
                for (var i = 0; i < digit; i++) {
                    zero += "0";
                }
                return (zero + num).slice(-digit);
            }
        },
        async getToConsultation(appointement_id, idx) {
            var form = new FormData();
            form.append("state", "done");
            const response = await appointementApi.updateState(
                form,
                appointement_id
            );
            this.waitingPatients.splice(idx, 1);
        }
    },
    computed: {
        event() {
            return this.now;
        }
    },
    created() {
        // var self = this;
        // setInterval(function() {
        //     self.now = Date.now();
        // }, 1000);
    },
    mounted() {
        //* GET THE DAY DATA
        this.fetchToDayData();

        //* GET APPOINTEMENTS OF TODAY
        this.fetchTodayAppointementsAndWatingPatients();

        //* GET USERS
        this.fetchUser();
    }
};
</script>
