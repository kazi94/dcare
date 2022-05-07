<template>
    <div>
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-11">
                <h3>MES HONORAIRES</h3>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-1">
                <button
                    class="btn btn-primary   mr-1"
                    v-b-modal.modal-payment
                    title="Ajouter un nouveau règlement"
                >
                    <b-icon-plus></b-icon-plus>
                    Ajouter
                </button>
                <download-excel
                    :data="paymentsToExport"
                    class="d-inline mb-1"
                    name="Tableau de mes règlements"
                >
                    <button
                        class="btn btn-success  "
                        title="Exporter le tableau en format Excel"
                    >
                        <b-icon-file-earmark-spreadsheet-fill></b-icon-file-earmark-spreadsheet-fill>
                        Exporter
                    </button>
                </download-excel>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-body">
                    <b-row>
                        <b-col lg="6" class="my-1">
                            <b-form-group
                                label="Filtrer"
                                label-cols-sm="3"
                                label-align-sm="right"
                                label-size="sm"
                                label-for="filterInput"
                                class="mb-0"
                            >
                                <b-input-group size="sm">
                                    <b-form-input
                                        name="filter"
                                        type="search"
                                        id="filterInput"
                                        placeholder="taper pour rechercher"
                                    ></b-form-input>
                                    <b-input-group-append>
                                        <b-button
                                            :disabled="!filter"
                                            @click="filter = ''"
                                            >Annuler</b-button
                                        >
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-table
                        striped
                        hover
                        :items="payments"
                        :fields="fields"
                        foot-clone
                        responsive="sm"
                        :per-page="perPage"
                        :current-page="currentPage"
                        :busy.sync="isBusy"
                        :filter="filter"
                        :filterIncludedFields="filterOn"
                        @filtered="onFiltered"
                        bordered
                    >
                        <template v-slot:cell(index)="data">{{
                            data.index + 1
                        }}</template>
                        <template v-slot:cell(total_paid)="data"
                            ><span class="text-success font-weight-bold"
                                >{{ data.item.total_paid }} DA</span
                            ></template
                        >
                        <template v-slot:cell(created_to)="data"
                            >{{ data.value.nom }}
                            {{ data.value.prenom }}</template
                        >
                        <template v-slot:cell(validated_payment_by)="data"
                            >Dr.{{ data.value.name }}
                            {{ data.value.prenom }}</template
                        >
                        <template v-slot:cell(actions)="data">
                            <b-dropdown
                                right
                                text="Actions"
                                variant="outline-dark  "
                            >
                                <b-dropdown-item
                                    @click="
                                        removePayment(data.index, data.item.id)
                                    "
                                    ><b-icon-trash
                                        class="mr-1"
                                        variant="danger"
                                    ></b-icon-trash>
                                    Supprimer</b-dropdown-item
                                >
                                <!-- <b-dropdown-item
                                    @click="printSelectedPayment(data.item)"
                                    ><b-icon-printer-fill
                                        class="mr-1"
                                        variant="secondary"
                                    ></b-icon-printer-fill>
                                    Imprimer</b-dropdown-item
                                > -->
                            </b-dropdown>
                        </template>
                    </b-table>
                    <b-pagination
                        pills
                        align="center"
                        name="currentPage"
                        :total-rows="rows"
                        :per-page="perPage"
                        aria-controls="my-table"
                    ></b-pagination>
                </div>
            </div>
        </div>
        <b-modal id="modal-payment" title="Nouveau Règlement" no-fade>
            <b-form id="myForm" name="myForm">
                <div>
                    <div class="position-relative form-group">
                        <multiselect
                            name="selectedPatient"
                            v-model="selectedPatient"
                            :options="patients"
                            placeholder="Sélectionner un patient"
                            track-by="id"
                            label="nom"
                            ><span slot="noResult"
                                >Oops! Aucun patient trouvé !</span
                            ></multiselect
                        >
                    </div>
                    <b-form-group
                        id="input-group-2"
                        label="Date de règlement"
                        label-for="input-date-payment"
                    >
                        <b-form-input
                            id="input-date-payment"
                            v-model="form.paid_at"
                            type="date"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        id="input-group-3"
                        label="Montant"
                        label-for="input-total-paid"
                    >
                        <b-form-input
                            id="input-total-paid"
                            v-model="form.total_paid"
                            type="text"
                            placeholder="Renseigner le montant net versé..."
                            required
                        ></b-form-input>
                    </b-form-group>
                </div>
            </b-form>
            <template #modal-footer>
                <!-- Emulate built in modal footer ok and cancel button actions -->
                <b-button size="sm" variant="secondary" @click="onReset()"
                    >Annuler</b-button
                >
                <b-button
                    size="sm"
                    type="submit"
                    variant="success"
                    @click="onSubmit()"
                >
                    Ajouter
                    <b-icon
                        icon="check-circle-fill"
                        variant="white"
                        class="mr-1"
                    ></b-icon>
                </b-button>
            </template>
        </b-modal>
        <!-- Print Model -->
        <b-container fluid id="printMe" style="display : none">
            <b-row align-h="center">
                <b-img
                    width="150"
                    height="150"
                    :src="user.cabinet.logo"
                    rounded="circle"
                    alt="Logo cabinet dentaire"
                ></b-img>
            </b-row>
            <b-row class=" mb-2 mt-1 ml-2">
                <b-col>
                    <p>
                        <strong>Patient :</strong> {{ patient.nom }}
                        {{ patient.prenom }}
                    </p>
                    <p><strong>Age :</strong> {{ patient.age }} ans</p>
                    <p><strong>Téléphone :</strong> {{ patient.num_tel }}</p>
                </b-col>
                <b-col class="border-left">
                    <p>
                        <strong>Chirurgien :</strong> Dr.{{ user.name }}
                        {{ user.prenom }}
                    </p>
                </b-col>
                <b-col class="border-left">
                    <p><strong>Le :</strong> {{ today }}</p>
                </b-col>
            </b-row>

            <div>
                <h3 class="ml-2">Liste des médicaments</h3>
                <div class="d-block"></div>
            </div>
        </b-container>
        <!-- END Print Model -->
    </div>
</template>

<script>
export default {
    components: {},
    props: ["user"],
    data() {
        return {
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
                num_tel: ""
            },
            form: {
                paid_at: new Date().toISOString().slice(0, 10)
            },
            selectedPatient: ""
        };
    },
    methods: {
        fetchPatients() {
            axios
                .get("/api/patients")
                .then(response => {
                    this.patients = response.data.map(patient => {
                        patient["value"] = patient.id;
                        patient["text"] = patient.nom + " " + patient.prenom;
                        return patient;
                    });
                })
                .catch(exception => {
                    console.log(exception);
                });
        },
        onReset() {
            this.form = {};
            this.$bvModal.hide("modal-payment");
        },
        onSubmit() {
            if (this.selectedPatient) {
                // save prescription to db
                this.savePayment();
            } else alert("Veuillez sélectionner un patient");
        },
        printPrescription() {
            //this.$htmlToPaper("printMe");
        },
        savePayment() {
            let form = new FormData();
            form.set("total_paid", this.form.total_paid);
            form.set("paid_at", this.form.paid_at);
            form.set("patient_id", this.selectedPatient.id);
            form.set("paid_by", this.user.id);
            this.patient = this.patients[
                this.patients.findIndex(p => p.id == this.selectedPatient.id)
            ];
            // save the prescription into the db
            axios
                .post("/api/payments", form)
                .then(response => {
                    // if (
                    //     confirm("voulez vous imprimer un ticket de versement ?")
                    // ) {
                    //     this.printPayment();
                    // }
                    this.payments.push(response.data[0]);
                    // close the modal
                    this.onReset();
                    this.$toaster.success("Règlement effectué !");
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
        },
        /**
         * on Hide the modal add new medic
         */
        resetModal() {
            this.newMedic = "";
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        //remove removePayment
        removePayment(index, id) {
            this.boxOne = "";
            this.$bvModal
                .msgBoxConfirm("Voulez vous supprimer le règlement ?", {
                    title: "Confirmer la suppresion",
                    size: "sm",
                    buttonSize: "sm",
                    okVariant: "success",
                    okTitle: "Oui",
                    cancelTitle: "Non",
                    footerClass: "p-2",
                    hideHeaderClose: false,
                    centered: true
                })
                .then(value => {
                    this.boxOne = value;
                    if (this.boxOne == true)
                        axios
                            .delete("/api/payments/" + id)
                            .then(response => {
                                this.payments.splice(index, 1);
                                this.$toaster.success(response.data.success);
                            })
                            .catch(exception => {
                                this.$toaster.error(exception);
                            });
                })
                .catch(err => {
                    this.$toaster.error(err);
                });
        },
        printSelectedPayment(prescription) {
            this.patient = prescription.prescribed_to;
            setTimeout(
                function() {
                    this.$htmlToPaper("printMe");
                }.bind(this),
                1000
            );
        },
        fetchPayments() {
            this.isBusy = true;
            // on mounted page, display all payments
            axios.get("/api/payments").then(response => {
                this.payments = response.data;
                this.paymentsToExport = this.payments.map((p, idx) => {
                    return {
                        index: ++idx,
                        Patient: p.created_to?.nom + " " + p.created_to?.prenom,
                        Montant: p.total_paid + " DA",
                        "Date de règlement": p.paid_at,
                        "Validé par": p.validated_payment_by.doctor
                    };
                });
                this.isBusy = false;
            });
        }
    },
    computed: {
        rows() {
            return this.payments.length;
        }
    },
    watch: {},
    mounted() {
        this.fetchPayments(); // Show the list of my payments
        this.fetchPatients(); // Show the list of all patients
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
