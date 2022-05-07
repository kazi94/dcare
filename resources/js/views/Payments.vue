<template>
    <div>
        <div class="app-main__inner">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-11">
                    <h3>MES HONORAIRES</h3>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-1">
                    <debt-modal class="d-inline"></debt-modal>
                    <button
                        class="btn btn-primary mr-1"
                        v-b-modal.modal-payment
                        title="Ajouter un nouveau règlement"
                    >
                        <b-icon-plus></b-icon-plus>
                        Ajouter
                    </button>
                </div>
            </div>
            <b-card class="mb-2">
                <b-tabs
                    card
                    ref="tab"
                    justified
                    active-nav-item-class="font-weight-bold text-uppercase"
                >
                    <b-tab title="Règlements du jour" title-link-class="h6">
                        <today-payments-tab
                            :user="user"
                            ref="today_payments"
                        ></today-payments-tab>
                    </b-tab>

                    <b-tab title="Tous les règlements" title-link-class="h6">
                        <all-payments-tab
                            :user="user"
                            ref="all_payments"
                        ></all-payments-tab>
                    </b-tab>
                </b-tabs>
            </b-card>

            <b-modal
                id="modal-payment"
                title="Nouveau Règlement"
                header-bg-variant="midnight-bloom"
                header-text-variant="white"
                :hideFooter="true"
                no-fade
            >
                <form @submit.prevent="onSubmit">
                    <div>
                        <div class="position-relative form-group">
                            <multiselect
                                name="selectedPatient"
                                v-model="selectedPatient"
                                :options="patients"
                                :options-limit="20"
                                placeholder="Sélectionner un patient"
                                track-by="id"
                                @search-change="onSearchPatient"
                                label="fullName"
                                ><span slot="noResult"
                                    >Oops! Aucun patient trouvé !</span
                                ></multiselect
                            >
                        </div>
                        <b-form-group
                            id="input-group-2"
                            label="Date de règlement"
                            label-for="input-date-payment"
                            class="font-weight-bold"
                        >
                            <b-form-input
                                id="input-date-payment"
                                type="date"
                                v-model="form.paid_at"
                                name="paid_at"
                                required
                                :class="{
                                    'is-invalid': form.errors.has('paid_at')
                                }"
                            ></b-form-input>
                            <has-error :form="form" field="paid_at"></has-error>
                        </b-form-group>
                        <b-form-group
                            label="Montant de règlement en dinars"
                            label-for="name-input"
                            class="font-weight-bold"
                            :description="
                                form.total_paid != null
                                    ? 'Montant : ' +
                                      numberWithSpaces(form.total_paid) +
                                      ' DA'
                                    : ''
                            "
                        >
                            <b-form-input
                                id="name-input"
                                v-model="form.total_paid"
                                name="total_paid"
                                required
                                :class="{
                                    'is-invalid': form.errors.has('total_paid')
                                }"
                            ></b-form-input>
                            <has-error
                                :form="form"
                                field="total_paid"
                            ></has-error>
                        </b-form-group>
                        <span
                            class="text-success"
                            v-if="
                                selectedPatient.total_paid &&
                                    selectedPatient.plan &&
                                    selectedPatient.plan.total_done &&
                                    selectedPatient.total_paid.value -
                                        selectedPatient.plan.total_done.value >
                                        2000
                            "
                        >
                            <strong>Créditeur :</strong>
                            <span
                                >+
                                {{
                                    numberWithSpaces(
                                        selectedPatient.total_paid.value -
                                            selectedPatient.plan.total_done
                                                .value
                                    )
                                }}
                                DA</span
                            >
                        </span>
                        <span
                            class="text-danger"
                            v-if="
                                selectedPatient.total_paid &&
                                    selectedPatient.plan &&
                                    selectedPatient.plan.total_done &&
                                    selectedPatient.total_paid.value -
                                        selectedPatient.plan.total_done.value <=
                                        -2000
                            "
                        >
                            <strong>Débiteur :</strong>
                            <span
                                >{{
                                    numberWithSpaces(
                                        selectedPatient.total_paid.value -
                                            selectedPatient.plan.total_done
                                                .value
                                    )
                                }}
                                DA</span
                            >
                        </span>
                    </div>
                    <div class="mt-2 modal_footer pull-right">
                        <button
                            type="button"
                            class="btn btn-secondary text-uppercase"
                            @click="onReset"
                        >
                            Annuler
                        </button>
                        <input
                            :disabled="form.busy"
                            type="submit"
                            value="Encaisser"
                            class="btn text-uppercase btn-success"
                        />
                    </div>
                </form>
            </b-modal>
        </div>
    </div>
</template>

<script>
import Vue from "vue";
import Multiselect from "vue-multiselect";

import DebtModal from "@/Components/DebtModal";
import TodayPaymentsTab from "@/Components/Payment/TodayPaymentsTab";
import AllPaymentsTab from "@/Components/Payment/AllPaymentsTab";
import patientApi from "@/services/api/patientsApi.js";
Vue.component("multiselect", Multiselect);
export default {
    components: {
        DebtModal,
        AllPaymentsTab,
        TodayPaymentsTab
    },
    props: ["user"],
    data() {
        return {
            paymentsInfo: null,
            fields: [
                "index",
                {
                    key: "created_to",
                    label: "Patient",
                    sortable: true
                },
                {
                    key: "total_paid",
                    label: "Montant",
                    sortable: true
                },
                {
                    key: "paid_at",
                    label: "Date de règlement",
                    sortable: true
                },
                {
                    key: "validated_payment_by",
                    label: "Validé par",
                    sortable: true
                },
                "Actions"
            ],
            payments: [],
            paymentsToExport: [],
            boxOne: "",
            perPage: 10,
            currentPage: 1,
            isBusy: false,
            filter: null,
            filterOn: [],
            today: "",
            patients: [],
            patient: {
                nom: "",
                prenom: "",
                age: "",
                num_tel: "",
                fullName: ""
            },
            form: new Form({
                paid_at: new Date().toISOString().substring(0, 10),
                total_paid: null
            }),
            selectedPatient: "",
            totalRows: null
        };
    },
    methods: {
        async onSearchPatient(searchQuery) {
            if (searchQuery.length >= 2) {
                const response = await patientApi.searchPatient(searchQuery);

                this.patients = response.data.map(patient => {
                    patient["value"] = patient.id;
                    patient["fullName"] = patient.nom + " " + patient.prenom;
                    return patient;
                });
            }
        },
        fetchPatients() {
            axios
                .get("/api/patient/get-with-total-paid")
                .then(response => {
                    this.patients = response.data.map(patient => {
                        patient["value"] = patient.id;
                        patient["fullName"] =
                            patient.nom + " " + patient.prenom;
                        return patient;
                    });
                })
                .catch(exception => {
                    console.log(exception);
                });
        },
        onReset() {
            this.form.reset();
            this.selectedPatient = {};
            this.$bvModal.hide("modal-payment");
        },
        onSubmit() {
            if (this.selectedPatient) {
                // save prescription to db
                this.savePayment();
            } else alert("Veuillez sélectionner un patient");
        },
        async savePayment() {
            this.form.patient_id = this.selectedPatient.id;
            this.form.paid_by = this.user.id;
            this.patient = this.patients[
                this.patients.findIndex(p => p.id == this.selectedPatient.id)
            ];
            // save the prescription into the db
            const response = await this.form.post("/api/payments");

            this.$refs.all_payments.payments.push(response.data[0]);
            this.$refs.today_payments.payments.push(response.data[0]);
            // close the modal
            this.onReset();
            this.$toaster.success("Règlement effectué !");
            this.patients = this.fetchPatients();
        },
        numberWithSpaces(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
    },
    computed: {},
    watch: {},
    mounted() {
        //this.fetchPatients(); // Show the list of all patients
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
