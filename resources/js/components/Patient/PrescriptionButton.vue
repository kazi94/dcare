<template>
    <div v-if="user.role_id == 1 || user.role_id == 2">
        <a
            href="javascript:void(0);"
            v-b-modal.modal-prescription
            class="nav-link"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Ajouter une nouvelle ordonnance"
        >
            <i class="nav-link-icon fa fa-plus icon-gradient bg-primary"></i>
            Ordonnance
        </a>

        <!-- <b-modal
            id="modal-prescription"
            title="Nouvelle ordonnance"
            no-fade
            button-size="sm"
            ok-title="Imprimer"
            cancel-title="Annuler"
        >
            <div>
                <b-form>
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
                <b-button
                    size="sm"
                     
                    variant="secondary"
                    @click="onReset()"
                    >Annuler</b-button
                >
                <b-button
                    size="sm"
                     
                    variant="success"
                    @click="onSubmit()"
                >
                    Validez
                    <b-icon
                        icon="check-circle-fill"
                        variant="white"
                        class="mr-1"
                    ></b-icon>
                </b-button>
            </template>
        </b-modal> -->
        <b-modal
            id="modal-prescription"
            size="md"
            title="Nouvelle ordonnance"
            no-fade
            ref="b_modal"
        >
            <div>
                <b-form>
                    <div class="d-flex flex-wrap">
                        <div class="col-sm-12">
                            <!-- ORDONNANCE TYPE -->
                            <prescription-type-list
                                @selected-prescription="onSelectedPrescription"
                            ></prescription-type-list>

                            <drug-suggestion-list
                                ref="DrugSuggestionList"
                            ></drug-suggestion-list>
                        </div>
                    </div>
                </b-form>
            </div>
            <template v-slot:modal-footer="{}">
                <!-- Emulate built in modal footer ok and cancel button actions -->
                <b-button size="sm" variant="secondary" @click="onReset()"
                    >Annuler</b-button
                >
                <!-- <b-button size="sm" variant="primary" @click="onSubmit()">
                    Imprimer
                </b-button> -->
                <b-button size="sm" variant="success" @click="onSubmit()">
                    Ajouter
                </b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
import { jsPDF } from "jspdf";
import lato from "@/services/lato.js";
import PrescriptionTypeList from "@/Components/PrescriptionTypeList";
import DrugSuggestionList from "@/Components/DrugSuggestionList";
import PrescriptionRichTextEditor from "@/Components/PrescriptionRichTextEditor";
export default {
    props: {
        patient: {
            type: Object
        },
        user: {
            type: Object
        }
    },
    components: {
        PrescriptionTypeList,
        DrugSuggestionList,
        PrescriptionRichTextEditor
    },
    data() {
        return {
            newMedic: null,
            createdPrescription: "",
            today: "",
            drugs: []
        };
    },
    methods: {
        onSelectedPrescription(drugs) {
            this.$refs.DrugSuggestionList.drugs = drugs;
        },
        onReset() {
            this.$bvModal.hide("modal-prescription");
            this.$refs.DrugSuggestionList.selectedDrugs = [];
            this.$refs.DrugSuggestionList.drugs = [];
        },
        onSubmit() {
            if (this.$refs.DrugSuggestionList.selectedDrugs.length != 0) {
                //save prescription to db
                this.savePrescription();
            } else alert("Veuillez sélectionner un médicament");
        },

        splitMedics(meds) {
            return meds.split(",");
        },
        printPrescription(prescription) {
            const doc = new jsPDF();
            const myFont = lato;

            doc.addFileToVFS("MyFont.ttf", myFont);
            doc.addFont("MyFont.ttf", "MyFont", "bold");
            doc.setFont("MyFont");
            const arr = this.splitMedics(prescription.medicaments);
            let y = 95;
            var pageWidth = 8.5,
                lineHeight = 1.2,
                margin = 0.5,
                maxLineWidth = pageWidth - margin * 2,
                fontSize = 24,
                ptsPerInch = 72,
                oneLineHeight = (fontSize * lineHeight) / ptsPerInch;
            doc.setFont("MyFont", "bold");
            doc.addImage(this.user.cabinet.logo, "JPEG", 15, 15, 30, 30);
            doc.setFontSize(30);
            doc.setTextColor(48, 48, 48);
            doc.text(this.user.cabinet.nom, 50, 27);
            doc.setFontSize(17);
            doc.setTextColor(4, 172, 236);
            doc.text("Dr. " + this.user.name + " " + this.user.prenom, 50, 35);

            doc.setTextColor(0, 0, 0);
            doc.text(
                "Nom, Prénom : " +
                    this.patient.nom +
                    " " +
                    this.patient.prenom +
                    ",    Age: " +
                    this.patient.age +
                    " ans,      Date: " +
                    prescription.date_prescription,
                15,
                65
            );

            doc.setDrawColor(35, 188, 126);
            doc.setLineWidth(0.5);
            doc.line(10, 80, 70, 80);

            doc.setFontSize(25);
            doc.setFont("MyFont", "bold");
            doc.setTextColor(35, 188, 126);
            doc.text("ORDONNANCE", 70, 82);

            doc.setDrawColor(35, 188, 126);
            doc.setLineWidth(0.5);
            doc.line(135, 80, 200, 80);

            doc.setFontSize(17);
            doc.setFont("MyFont", "bold");
            doc.setTextColor(0, 0, 0);
            var text = "";
            arr.forEach((val, index) => {
                val = val
                    .replace("(pendant", "    (pendant")
                    .replace(").", ").    ");
                text += index + 1 + ". " + val + "\n\n";
            });
            var textLines = doc.splitTextToSize(text, 200);

            //doc.text can now add those lines easily; otherwise, it would have run text off the screen!
            doc.text(textLines, 10, 95);
            doc.setDrawColor(0, 0, 0);
            doc.setLineWidth(0.5);
            doc.line(10, 270, 200, 270);

            doc.setFont("MyFont", "bold");
            doc.setFontSize(17);
            doc.setTextColor(48, 48, 48);
            doc.text(
                "0553 40 07 65 - 041 66 41 65 - " + this.user.email,
                38,
                277
            );
            doc.text(this.user.cabinet.adresse, 38, 285);

            doc.save("ordonnance-" + this.today + ".pdf");
            //Set the document to automatically print via JS
            doc.autoPrint();
            window.open(doc.output("bloburl"), "_blank");
        },
        savePrescription() {
            let form = new FormData();
            let vm = this;
            form.set(
                "medicaments",
                this.$refs.DrugSuggestionList.selectedDrugs
            );
            form.set("patient_id", this.patient.id);
            // save the prescription into the db
            axios
                .post("/patients/prescription", form)
                .then(response => {
                    this.createdPrescription = response.data.prescription;
                    if (confirm("voulez vous imprimer la prescription ?")) {
                        this.printPrescription(this.createdPrescription);
                    }
                    //close the modal
                    this.onReset();
                    vm.$emit("get-prescription", response.data.prescription);
                    this.$toaster.success("Ordonnance ajoutée ! avec succés!");
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
        }
    },

    mounted() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, "0");
        var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
        var yyyy = today.getFullYear();

        this.today = mm + "/" + dd + "/" + yyyy;
    }
};
</script>
<style lang="scss">
.modal-xxl {
    max-width: 1440px;
}
</style>
