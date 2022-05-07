<template>
    <div>
        <div class="row d-block">
            <div class="col-sm-12" v-if="prescriptions.length > 0">
                <b-table
                    striped
                    hover
                    :items="prescriptions"
                    :fields="fields"
                    responsive="sm"
                    :per-page="perPage"
                    :current-page="currentPage"
                    :busy.sync="isBusy"
                >
                    <template v-slot:cell(index)="data">{{
                        data.index + 1
                    }}</template>
                    <template v-slot:cell(Medicaments)="data">
                        <b-button
                            size="sm"
                            variant="info"
                            class="mb-1"
                            @click="show(data.item.medicaments)"
                        >
                            Médicaments
                        </b-button>
                    </template>
                    <template v-slot:cell(Imprimer)="data">
                        <b-button
                            size="sm"
                            class="mb-1"
                            @click="print(data.item)"
                        >
                            <b-icon
                                icon="printer-fill"
                                aria-hidden="true"
                            ></b-icon>
                            Imprimer
                        </b-button>
                    </template>
                    <template v-slot:cell(Supprimer)="data">
                        <b-button
                            size="sm"
                            class="mb-1 btn-danger"
                            @click="remove(data.item.id, data.index)"
                        >
                            <b-icon
                                icon="trash-fill"
                                aria-hidden="true"
                            ></b-icon>
                            Supprimer
                        </b-button>
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
                <b-modal
                    ref="modal-medics"
                    ok-only
                    title="Liste des médicaments"
                >
                    <ol>
                        <li
                            class="my-4"
                            v-for="(medic, index) in medics"
                            :key="index"
                        >
                            {{ medic }}
                        </li>
                    </ol>
                </b-modal>
            </div>
            <div v-else class="text-center text-secondary">
                <h1>
                    <i class="d-block fa fa-2x fa-exclamation-triangle"></i>
                    Vous n'avez aucune prescription pour l'instant !
                </h1>
            </div>
        </div>
    </div>
</template>

<script>
import { jsPDF } from "jspdf";
import lato from "@/services/lato.js";

export default {
    components: {},
    props: ["patient", "user"],
    data() {
        return {
            perPage: 10,
            currentPage: 1,
            isBusy: false,
            fields: [
                { key: "index", class: "text-center" },
                {
                    key: "date_prescription",
                    sortable: true,
                    class: "text-center"
                },
                "Medicaments",
                "Imprimer",
                "Supprimer"
            ],
            prescriptions: [],
            medics: []
        };
    },
    methods: {
        /*
         * Show all prescriptions
         */
        fetchPrescriptions() {
            if (this.patient.prescriptions)
                this.prescriptions = this.patient.prescriptions;
        },
        getPrescription(prescription) {
            this.prescriptions.push(prescription);
        },
        /*
         * Show list of Drugs
         */
        show(medicaments) {
            this.medics = this.splitMedics(medicaments);

            this.$refs["modal-medics"].show();
        },
        print(prescription) {
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
            doc.setFont("MyFont", "normal");
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
            doc.setFont("MyFont", "bold");
            doc.setTextColor(35, 188, 126);
            doc.text("ORDONNANCE", 70, 82);

            doc.setDrawColor(35, 188, 126);
            doc.setLineWidth(0.5);
            doc.line(135, 80, 200, 80);

            doc.setFontSize(17);
            doc.setFont("MyFont", "normal");
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
        remove(id, index) {
            if (
                confirm("Vous confirmer la suppression de cette Ordonnance ?")
            ) {
                const response = this.removePrescription(id);
                response
                    .then(result => {
                        // remove row
                        this.prescriptions.splice(index, 1);
                        this.$toaster.success(
                            "Ordonnance supprimée avec succés!"
                        );
                    })
                    .catch(err => {
                        this.$toaster.error(err);
                    });
            }
        },
        removePrescription(id) {
            return axios.delete(`/patients/prescription/${id}`);
        },
        splitMedics(meds) {
            return meds.split(",");
        }
    },
    computed: {
        rows() {
            return this.prescriptions.length;
        }
    },
    watch: {},
    mounted() {
        this.fetchPrescriptions();
    }
};
</script>
