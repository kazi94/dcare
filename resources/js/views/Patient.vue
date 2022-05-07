<template lang="">
    <div>
        <portal to="header">
            <div class="app-header-left">
                <ul class="header-menu nav">
                    <b-skeleton-wrapper :loading="!isMounted">
                        <template #loading>
                            <div class="d-flex">
                                <b-skeleton
                                    type="button"
                                    class="m-1"
                                ></b-skeleton>
                                <b-skeleton
                                    type="button"
                                    class="m-1"
                                ></b-skeleton>
                                <b-skeleton
                                    type="button"
                                    class="m-1"
                                ></b-skeleton>
                                <b-skeleton
                                    type="button"
                                    class="m-1"
                                ></b-skeleton>
                            </div>
                        </template>
                        <li class="nav-item">
                            <patient-modal
                                ref="patient_modal"
                                v-if="isMounted"
                                @patient-updated="onUpdatedPatient"
                                :csrf="csrf"
                                :users="users"
                                :user="user"
                            >
                            </patient-modal>
                        </li>
                        <li class="btn-group nav-item">
                            <prescription-button
                                v-if="isMounted"
                                :patient="patient"
                                :user="user"
                                @get-prescription="getPrescription"
                            >
                            </prescription-button>
                        </li>
                        <li class="btn-group nav-item">
                            <radiographie-button
                                v-if="isMounted"
                                :patient="patient"
                                @get-image="getImage"
                                :user="user"
                            >
                            </radiographie-button>
                        </li>
                        <li class="btn-group nav-item">
                            <rendez-vous-btn
                                v-if="isMounted"
                                :patient="patient"
                                :user="user"
                            >
                            </rendez-vous-btn>
                        </li>
                    </b-skeleton-wrapper>
                </ul>
            </div>
        </portal>
        <div class="widget-content-right header-user-info ml-3">
            <portal to="header-right" v-if="isMounted">
                <appointements :patient="patient"></appointements>
            </portal>
        </div>
        <div class="app-main__inner" style="padding: 15px 15px 0">
            <div class="row">
                <div class="col-md-12">
                    <b-skeleton-wrapper :loading="!isMounted">
                        <template #loading>
                            <div>
                                <div class="mb-4">
                                    <div class="main-card mb-1 card">
                                        <div class="card-body bg-white">
                                            <div class="row">
                                                <b-col cols="1"
                                                    ><b-skeleton
                                                        type="avatar"
                                                    ></b-skeleton
                                                ></b-col>
                                                <b-col cols="5"
                                                    ><b-skeleton
                                                        width="50%"
                                                    ></b-skeleton>

                                                    <b-skeleton
                                                        width="50%"
                                                    ></b-skeleton
                                                ></b-col>
                                                <b-col cols="5"
                                                    ><b-skeleton-icon
                                                        icon="bar-chart-fill"
                                                        :icon-props="{
                                                            fontScale: 2
                                                        }"
                                                    ></b-skeleton-icon>
                                                </b-col>
                                                <b-col cols="1"
                                                    ><b-skeleton
                                                        type="button"
                                                    ></b-skeleton
                                                ></b-col>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <b-skeleton-img
                                        no-aspect
                                        height="350px"
                                    ></b-skeleton-img>
                                </div>
                            </div>
                        </template>
                        <informations-component
                            :patient="patient"
                            @update-patient="onUpdatePatient"
                            v-if="isMounted"
                        >
                        </informations-component>

                        <card-tabs-component
                            v-if="isMounted"
                            :patient="patient"
                            :user="user"
                            ref="tabs"
                        >
                        </card-tabs-component>
                    </b-skeleton-wrapper>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
</template>
<script>
import InformationsComponent from "@/Components/Patient/InformationsComponent";
import PatientModal from "@/Components/Patient/PatientModal";
import PrescriptionButton from "@/Components/Patient/PrescriptionButton";
import RendezVousBtn from "@/Components/Patient/RendezVousBtn";
import RadiographieButton from "@/Components/Patient/RadiographieButton";
import CardTabsComponent from "@/Components/Patient/CardTabsComponent";
import Appointements from "@/Components/Patient/Appointements";

export default {
    props: ["user", "csrf", "users"],
    data() {
        return {
            // pathologies: [],
            // antecedents: [],
            title: null,
            patient: {},
            isMounted: false
            // totalToDo: 0,
            // totalPaid: 0,
            // totalDone: 0,
        };
    },
    components: {
        PatientModal,
        PrescriptionButton,
        InformationsComponent,
        CardTabsComponent,
        RendezVousBtn,
        Appointements,
        RadiographieButton
    },
    methods: {
        // handletotalToDo(val) {
        //     this.totalToDo = val;
        // },
        // handletotalDone(val) {
        //     this.totalDone = val;
        // },
        // handletotalPaid(val) {
        //     this.totalPaid = val;
        // },
        // handlePaymentDone(val) {
        //     this.totalPaid = val.total_paid;
        // },
        getPrescription(prescription) {
            this.$refs.tabs.getPrescription(prescription);
        },
        newModal() {
            // @ts-ignore
            $("#patient_add_modal").modal("show");
        },
        getImage(url) {
            this.$refs.tabs.getImage(url);
        },
        /**
         * open Update Patient Modal
         */
        onUpdatePatient(patient) {
            this.$refs.patient_modal.updateModal(patient);
        },
        onUpdatedPatient(patient) {
            this.patient = patient;
        },
        mountPatientFolder() {
            this.patient_id = this.$route.params.id;
            axios
                .get("/api/patients/" + this.patient_id + "/edit")
                .then(response => {
                    this.patient = response.data.patient;
                    // this.pathologies = response.data.pathologies;
                    // this.antecedents = response.data.antecedents;
                    this.title =
                        "Dosier Patient " +
                        this.patient.nom +
                        " " +
                        this.patient.prenom;
                    this.isMounted = true;
                });
        }
    },
    watch: {},

    mounted() {
        this.$store.state.totalPaid = 0;
        this.$store.state.totalDone = 0;
        this.mountPatientFolder();
    },
    created() {}
};
</script>
