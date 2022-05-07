<template>
    <div>
        <div class="main-card mb-1 card">
            <div class="card-header justify-content-between bg-white">
                <div class="d-flex">
                    <b-avatar
                        :src="
                            patient.sexe == 'F'
                                ? '/img/user-f.png'
                                : '/img/user.png'
                        "
                        size="3rem"
                        variant="default"
                        class="mr-1"
                    ></b-avatar>
                    <div class="">
                        <p class="h4 mb-0">
                            {{ patient.nom }} {{ patient.prenom }}

                            {{ patient.age ? "(" + patient.age + "ans) " : "" }}
                        </p>
                        <p v-if="patient.num_tel" class="mb-0 text-info">
                            {{ " Téléphone : " + patient.num_tel }}
                        </p>
                    </div>
                </div>
                <div class="h2">
                    <font-awesome-icon
                        size="xs"
                        v-if="patient.fumeur == 'Oui'"
                        icon="smoking"
                        title="Fumeur"
                    />
                    <font-awesome-icon
                        size="xs"
                        v-if="patient.pathologies.length > 0"
                        icon="heartbeat"
                        class="text-danger"
                        title="Pathologies générales"
                    />
                    <font-awesome-icon
                        size="xs"
                        v-if="patient.motivation == 'motivate'"
                        icon="signal"
                        class="text-success"
                        title="Motivé"
                    />
                    <font-awesome-icon
                        size="xs"
                        v-if="patient.motivation == 'less_motivate'"
                        icon="signal"
                        class="text-warning"
                        title="Moyennement motivé"
                    />
                    <font-awesome-icon
                        size="xs"
                        v-if="patient.motivation == 'no_motivate'"
                        icon="signal"
                        class="text-danger"
                        title="Non motivé"
                    />
                </div>
                <div class="">
                    <dt class="text-success" v-if="credit >= 2000">
                        <strong>Créditeur :</strong>
                        <span
                            >+
                            {{ numberWithSpaces(credit) }}
                            DA</span
                        >
                    </dt>
                    <dt class="text-danger" v-if="debtor <= -2000">
                        <strong>Débiteur :</strong>
                        <span>{{ numberWithSpaces(debtor) }} DA</span>
                    </dt>
                </div>
                <div class="">
                    <button
                        @click="updatePatient(patient)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Modifier les informations patient"
                        class="btn btn-primary font-weignt-bold"
                    >
                        <i class="pe-7s-note btn-icon-wrapper"></i>
                        Détails
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faSmoking,
    faHeartbeat,
    faSignal,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faSmoking, faHeartbeat, faSignal);
export default {
    components: {
        FontAwesomeIcon,
    },
    props: {
        patient: Object,
        // totalPaid: Number | String,
        // totalToDo: Number | String,
        // totalDone: Number | String,
    },
    data() {
        return {
            // totalPaids: this.totalPaid,
            // totalToDos: this.totalToDo,
            // totalDones: this.totalDone,
        };
    },
    methods: {
        updatePatient(patient) {
            this.$emit("update-patient", patient);
        },
        numberWithSpaces(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        },
    },
    computed: {
        credit: {
            get: function () {
                const val =
                    this.$store.state.totalPaid - this.$store.state.totalDone;
                if (val >= 2000) return val;
            },
            set: function (newValue) {
                return newValue;
            },
        },
        debtor: {
            get: function () {
                const val =
                    this.$store.state.totalPaid - this.$store.state.totalDone;
                if (val <= -2000) return val;
            },
            set: function (newValue) {
                return newValue;
            },
        },
    },
    watch: {},
    mounted() {
        // if (
        //     this.patient.total_paid &&
        //     this.patient.plan &&
        //     this.patient.total_paid.value - this.patient.plan.total > 0
        // ) {
        // this.credit = this.patient.total_paid.value - this.patient.plan.total;
        // }

        if (
            this.patient.plan &&
            this.patient.plan.total_done &&
            this.patient.total_paid
        ) {
            const val = parseInt(
                this.patient.total_paid.value -
                    this.patient.plan.total_done.value
            );

            if (val <= -2000) this.debtor = val;
            if (val >= 2000) this.credit = val;
        }
    },
    created() {},
};
</script>
