<template>
    <div>
        <nav class="row" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item font-weight-bold">
                    <a href="/acceuil"
                        ><b-icon-arrow-left></b-icon-arrow-left> RETOUR</a
                    >
                </li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-11">
                <h3>MES ORDONNANCES</h3>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-1">
                <button
                    class="btn btn-primary   mr-1"
                    v-b-modal.modal-prescription
                    title="Ajouter une nouvelle ordonnance"
                >
                    <b-icon-plus></b-icon-plus>
                    Ajouter
                </button>
                <download-excel
                    :data="prescriptionsToExport"
                    class="d-inline mb-1"
                    name="Tableau de mes ordonnances"
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
                                        v-model="filter"
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
                        :items="prescriptions"
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
                        <template v-slot:cell(prescribed_to)="data"
                            >{{ data.value.nom }}
                            {{ data.value.prenom }}</template
                        >
                        <template v-slot:cell(actions)="data">
                            <b-dropdown
                                right
                                text="Actions"
                                variant="outline-dark  "
                            >
                                <b-dropdown-item
                                    :href="
                                        `/patients/${data.item.prescribed_to.id}/edit`
                                    "
                                >
                                    <b-icon-person-lines-fill
                                        class="mr-1"
                                        variant="primary"
                                    ></b-icon-person-lines-fill>
                                    Voir le patient</b-dropdown-item
                                >
                                <b-dropdown-item
                                    @click="show(data.item.medicaments)"
                                    ><b-icon-arrow-repeat
                                        class="mr-1"
                                        variant="info"
                                    ></b-icon-arrow-repeat>
                                    Détails</b-dropdown-item
                                >
                                <b-dropdown-item
                                    @click="
                                        removePrescription(
                                            data.index,
                                            data.item.id
                                        )
                                    "
                                    ><b-icon-trash
                                        class="mr-1"
                                        variant="danger"
                                    ></b-icon-trash>
                                    Supprimer</b-dropdown-item
                                >
                                <b-dropdown-item
                                    @click="
                                        printSelectedPrescription(data.item)
                                    "
                                    ><b-icon-printer-fill
                                        class="mr-1"
                                        variant="secondary"
                                    ></b-icon-printer-fill>
                                    Imprimer</b-dropdown-item
                                >
                            </b-dropdown>
                        </template>
                    </b-table>
                    <b-pagination
                        pills
                        align="center"
                        v-model="currentPage"
                        :total-rows="rows"
                        :per-page="perPage"
                        aria-controls="my-table"
                    ></b-pagination>
                </div>
            </div>
        </div>
        <b-modal ref="modal-medics" ok-only title="Liste des médicaments">
            <ol>
                <li class="my-4" v-for="(medic, index) in medics" :key="index">
                    {{ medic }}
                </li>
            </ol>
        </b-modal>
        <b-modal
            id="modal-prescription"
            title="Nouvelle ordonnance"
            no-fade
            button-size="sm"
            ok-title="Imprimer"
            cancel-title="Annuler"
        >
            <div>
                <b-form>
                    <div class="position-relative form-group">
                        <multiselect
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
                        id="input-group-ordonnance"
                        label="Sélectionner l'ordonnance type"
                        label-for="input-ordonnance"
                        class="font-weight-bold"
                    >
                        <b-form-select
                            v-model="selected"
                            :options="ordonnances_type"
                            class="col-sm-10"
                        ></b-form-select>
                    </b-form-group>
                    <b-form-group label="Médicaments">
                        <b-form-checkbox-group
                            v-model="selectedMeds"
                            :options="medics"
                            name="flavour-2a"
                            stacked
                        ></b-form-checkbox-group>
                    </b-form-group>

                    <b-button
                        variant="primary"
                        size="sm"
                        href="javascript:void(0);"
                        v-b-modal.modal-add-new-medic
                    >
                        Ajouter un médicament
                    </b-button>
                    <b-modal
                        id="modal-add-new-medic"
                        title="Ajouter médicament"
                        no-fade
                        button-size="sm"
                        ok-title="Ajouter"
                        cancel-title="Annuler"
                        @ok="addNewMedic"
                        @hidden="resetModal"
                    >
                        <b-form-input
                            v-model="newMedic"
                            placeholder="Renseigner le médicament"
                        ></b-form-input>
                    </b-modal>
                </b-form>
            </div>
            <template v-slot:modal-footer="{}">
                <!-- Emulate built in modal footer ok and cancel button actions -->
                <b-button size="sm" variant="secondary" @click="onReset()"
                    >Annuler</b-button
                >
                <b-button size="sm" variant="success" @click="onSubmit()">
                    Validez
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
                <div class="d-block">
                    <ul v-for="med in selectedMeds">
                        <li>{{ med }}</li>
                    </ul>
                </div>
            </div>
        </b-container>
        <!-- END Print Model -->
    </div>
</template>

<script>
import { jsPDF } from "jspdf";

export default {
    components: {},
    props: ["user"],
    data() {
        return {
            prescriptions_to_export: [],
            selectedMedics: [],
            fields: [
                "index",
                {
                    key: "date_prescription",
                    label: "Date de prescription",
                    sortable: true
                },
                { key: "prescribed_to", label: "Patient", sortable: true },
                "Actions"
            ],
            prescriptions: [],
            prescriptionsToExport: [],
            boxOne: "",
            perPage: 10,
            currentPage: 1,
            isBusy: false,
            filter: null,
            filterOn: [],
            selected: null,
            selectedPatient: null,
            selectedMeds: null,
            medics: [],
            ordonnances_type: [],
            newMedic: null,
            today: "",
            patients: [],
            patient: {
                nom: "",
                prenom: "",
                age: "",
                num_tel: ""
            }
        };
    },
    methods: {
        fetchOrdonnancesType() {
            axios
                .get("/admin/ordonnance-type/get-ordonnances-type")
                .then(response => {
                    this.ordonnances_type = response.data;
                })
                .catch(exception => {
                    console.log(exception);
                });
        },
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
            this.$bvModal.hide("modal-prescription");
            this.selectedMeds = [];
            this.medics = [];
        },
        onSubmit() {
            if (this.selectedMeds.length != 0 && this.selectedPatient) {
                // save prescription to db
                this.savePrescription();
            } else alert("Veuillez sélectionner un médicament");
        },
        printPrescription(prescription) {
            const doc = new jsPDF();
            const arr = this.splitMedics(prescription.medicaments);
            let y = 95;
            var pageWidth = 8.5,
                lineHeight = 1.2,
                margin = 0.5,
                maxLineWidth = pageWidth - margin * 2,
                fontSize = 24,
                ptsPerInch = 72,
                oneLineHeight = (fontSize * lineHeight) / ptsPerInch;
            // Header
            doc.setFont("helvetica", "normal");
            doc.addImage(this.user.cabinet.logo, "JPEG", 15, 15, 30, 30);
            doc.setFontSize(30);
            doc.setTextColor(4, 172, 236);
            doc.text("Dr " + this.user.name + " " + this.user.prenom, 50, 27);
            doc.setFontSize(17);
            doc.setTextColor(48, 48, 48);
            doc.text("Cabinet de chirurgie dentaire", 50, 35);

            doc.setTextColor(0, 0, 0);
            doc.text(
                "Nom,Prénom: " +
                    this.patient.nom +
                    " " +
                    this.patient.prenom +
                    ", Age: " +
                    this.patient.age +
                    " ans, Date: " +
                    prescription.date_prescription,
                15,
                65
            );

            doc.setDrawColor(35, 188, 126);
            doc.setLineWidth(0.5);
            doc.line(10, 80, 70, 80);

            doc.setFontSize(25);
            doc.setFont("helvetica", "bold");
            doc.setTextColor(35, 188, 126);
            doc.text("ORDONNANCE", 70, 82);

            doc.setDrawColor(35, 188, 126);
            doc.setLineWidth(0.5);
            doc.line(135, 80, 200, 80);

            // Prescription
            doc.setFontSize(17);
            doc.setTextColor(0, 0, 0);
            var text = "";
            arr.forEach((val, index) => {
                // doc.text(index + 1 + "- " + val, 10, y); // 2nd args : x position; 3rd args : y position
                // y += 10;
                text += index + 1 + "- " + val + "\n";
            });
            var textLines = doc.splitTextToSize(text, 200);

            // doc.text can now add those lines easily; otherwise, it would have run text off the screen!
            doc.text(textLines, 10, 95);
            // Footer
            doc.setDrawColor(0, 0, 0);
            doc.setLineWidth(0.5);
            doc.line(10, 270, 200, 270);

            doc.setFont("helvetica", "bold");
            doc.setFontSize(17);
            doc.setTextColor(48, 48, 48);
            doc.text(
                "0553 40 07 65 - 041 66 41 65 - " + this.user.email,
                38,
                277
            );
            doc.text(this.user.cabinet.adresse, 38, 285);

            // doc.save("ordonnance.pdf");
            // Set the document to automatically print via JS
            doc.autoPrint();
            window.open(doc.output("bloburl"), "_blank");
        },
        savePrescription() {
            let form = new FormData();
            let vm = this;
            form.set("medicaments", this.selectedMeds);
            form.set("patient_id", this.selectedPatient.id);
            this.patient = this.patients[
                this.patients.findIndex(p => p.id == this.selectedPatient.id)
            ];
            // save the prescription into the db
            axios
                .post("/patients/prescription", form)
                .then(response => {
                    if (confirm("voulez vous imprimer la prescription ?")) {
                        this.printPrescription(response.data.prescription);
                    }
                    this.prescriptions.push(response.data.prescription);
                    // close the modal
                    this.onReset();
                    this.$toaster.success("Ordonnance ajoutée !");
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
        },
        /**
         * Add the new drug to the list of drugs
         */
        addNewMedic() {
            return this.newMedic ? this.medics.push(this.newMedic) : false;
        },
        /**
         * on Hide the modal add new medic
         */
        resetModal() {
            this.newMedic = "";
        },
        /*
         * Show list of Drugs
         */
        show(medicaments) {
            this.medics = this.splitMedics(medicaments);

            this.$refs["modal-medics"].show();
        },
        splitMedics(meds) {
            return meds.split(",");
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        //remove removePrescription
        removePrescription(index, id) {
            this.boxOne = "";
            this.$bvModal
                .msgBoxConfirm("Voulez vous supprimer la prescription ?", {
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
                            .delete("/api/prescriptions/" + id)
                            .then(response => {
                                this.prescriptions.splice(index, 1);
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
        printSelectedPrescription(prescription) {
            this.today = prescription.date_prescription;
            this.selectedMeds = this.splitMedics(prescription.medicaments);
            this.patient = prescription.prescribed_to;
            setTimeout(
                function() {
                    this.printPrescription(prescription);
                }.bind(this),
                1000
            );
            console.log("object");
        },
        fetchPrescriptions() {
            this.isBusy = true;
            // on mounted page, display all prescriptions
            axios.get("/api/prescriptions").then(response => {
                this.prescriptions = response.data;
                this.prescriptionsToExport = this.prescriptions.map(
                    (p, idx) => {
                        return {
                            index: ++idx,
                            Patient:
                                p.prescribed_to.nom +
                                " " +
                                p.prescribed_to.prenom,
                            medicaments: p.medicaments,
                            "Date de prescription": p.date_prescription,
                            "Modifié par": p.updated_by
                                ? "Dr." +
                                  p.updated_by.name +
                                  " " +
                                  p.updated_by.prenom
                                : ""
                        };
                    }
                );
                this.isBusy = false;
            });
        }
    },
    computed: {
        rows() {
            return this.prescriptions.length;
        }
    },
    watch: {
        /*
         * Show the list of medocs when ordonnance type is selected
         */
        selected: {
            handler: function(newV) {
                let vm = this;
                console.log(newV);
                let selectedOrdonnance = newV; // Ex : 4 or 5 , 6 , {id}
                vm.ordonnances_type.forEach(function(value, index) {
                    if (value.value === newV) {
                        value.medicaments.forEach(med => {
                            vm.medics.push(med); // show the list of medocs
                        });
                    }
                });
                vm.selectedMeds = vm.medics; // check all medics
            }
        }
    },
    mounted() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, "0");
        var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
        var yyyy = today.getFullYear();

        this.today = mm + "/" + dd + "/" + yyyy;
        this.fetchPrescriptions();
        this.fetchOrdonnancesType();
        this.fetchPatients();
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
