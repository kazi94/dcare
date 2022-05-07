<template>
    <div>
        <div class="row border-alternate pb-1">
            <div class="col-md-6">
                <!-- Tabs Section -->
                <div>
                    <b-card no-body class="mb-2">
                        <b-tabs card ref="tab" @activate-tab="getActiveTabID">
                            <!-- Render Tabs, supply a unique `key` to each tab -->
                            <b-tab
                                v-for="i in tabs"
                                :key="'dyn-tab-' + i"
                                :title="'Devis ' + (i + 1)"
                                :active="tabIndex === i"
                            >
                                <!-- Table quotation -->
                                <div v-if="quotations.length > 0">
                                    <b-row class="mb-1" v-if="isQuotation">
                                        <b-col sm="6">
                                            <b-button
                                                size="sm"
                                                @click="selectAllRows"
                                                >Tout selectionner</b-button
                                            >
                                            <b-button
                                                size="sm"
                                                @click="clearSelected(tabIndex)"
                                                >Vider la selection</b-button
                                            >
                                        </b-col>
                                        <b-col sm="6">
                                            <b-button
                                                size="sm"
                                                :disabled="paidBtnDisabled"
                                                class="float-right"
                                                variant="success"
                                                @click="acceptQuotation"
                                                v-if="isQuotation"
                                                >Accepter</b-button
                                            >
                                        </b-col>
                                    </b-row>
                                    <quotation-table
                                        :ref="'table-' + tabIndex"
                                        :isQuotation="isQuotation"
                                        :quotation.sync="quotations[i]"
                                        :selected.sync="selected"
                                        @removed-line="onRemovedLine"
                                        @price-updated="onPriceUpdated"
                                    ></quotation-table>
                                    <b-row class="m-0" v-if="isQuotation">
                                        <b-col sm="6">
                                            <b-button
                                                size="sm"
                                                @click="selectAllRows"
                                                >Tout selectionner</b-button
                                            >
                                            <b-button
                                                size="sm"
                                                @click="clearSelected(tabIndex)"
                                                >Vider la selection</b-button
                                            >
                                        </b-col>
                                        <b-col sm="6">
                                            <b-button
                                                size="sm"
                                                :disabled="paidBtnDisabled"
                                                class="float-right"
                                                variant="success"
                                                @click="acceptQuotation"
                                                v-if="isQuotation"
                                                >Accepter</b-button
                                            >
                                        </b-col>
                                    </b-row>
                                </div>
                                <div class="align-items-center" v-else>
                                    <div class="col">
                                        <p
                                            class="
                                                h2
                                                mb-2
                                                text-center text-secondary
                                            "
                                        >
                                            Commencer par sélectionner les actes
                                            à faire
                                            <b-icon
                                                icon="arrow-right"
                                                class="
                                                    rounded-circle
                                                    bg-success
                                                    p-2
                                                    ml-4
                                                "
                                                variant="light"
                                                font-scale="1.5"
                                            ></b-icon>
                                        </p>
                                    </div>
                                </div>
                            </b-tab>

                            <!-- New Tab Button (Using tabs-end slot) -->
                            <template v-slot:tabs-end>
                                <b-nav-item
                                    role="presentation"
                                    @click.prevent="newTab"
                                    href="#"
                                    :disabled="plusBtn"
                                    v-if="isQuotation"
                                >
                                    <b>+</b>
                                </b-nav-item>
                                <li class="nav-item nav-item-header">
                                    <b-icon-printer
                                        style="cursor: pointer"
                                        scale="2"
                                        title="Imprimer le devis courant"
                                        class="mr-3"
                                        @click="printQuotation"
                                    ></b-icon-printer>
                                    <b-icon-newspaper
                                        style="cursor: pointer"
                                        scale="2"
                                        title="Dupliquer le devis courant"
                                        @click="duplicateQuotation"
                                        v-if="isQuotation"
                                        variant="success"
                                        class="mr-3"
                                    ></b-icon-newspaper>
                                    <b-icon-trash
                                        style="cursor: pointer"
                                        scale="2"
                                        tittle="Supprimer le devis courant"
                                        v-if="isQuotation"
                                        @click="deleteTab"
                                        variant="danger"
                                    ></b-icon-trash>
                                </li>
                            </template>
                        </b-tabs>
                    </b-card>
                </div>
                <!-- End Tabs Section -->
            </div>
            <div class="col-md-6">
                <b-card>
                    <schema-component
                        :selectedTooth="selectedTooth"
                        :isToothVisible="isQuotation"
                        ref="schema_1"
                        :patient="patient"
                        :p_class="!isQuotation ? 'mb-2' : ''"
                        @load="onImageLoaded"
                    >
                    </schema-component>
                    <category
                        ref="categories"
                        v-if="isQuotation"
                        @select-acts="selectedActs"
                    ></category>
                </b-card>
                <total-informations-component
                    :total="total"
                    :total_accept="total_accept"
                ></total-informations-component>
            </div>
        </div>
    </div>
</template>

<script>
import SchemaComponent from "@/Components/Schema/SchemaComponent";
import TotalInformationsComponent from "./TotalInformationsComponent.vue";
import Category from "@/Components/Category";

import utilities from "@/services/utilities.js";
import QuotationTable from "./QuotationTable.vue";
import jsPDF from "jspdf";
import lato from "@/services/lato.js";
import "jspdf-autotable";
const MOUTH =
    "11,12,13,14,15,16,17,18,21,22,23,24,25,26,27,28,41,42,43,44,45,46,47,48,31,32,33,34,35,36,37,38";
const SECTORS = ["s1", "s2", "s3", "s4"];

// COMPONENT
export default {
    props: {
        patient: {
            type: Object,
            required: true
        },
        user: {
            type: Object,
            required: true
        }
    },

    components: {
        SchemaComponent,
        TotalInformationsComponent,
        Category,
        QuotationTable
    },
    data() {
        return {
            tabs: [0],
            tabCounter: 1,
            selectedTooth: new Array(),
            quotations: [],
            quotation: [],
            isQuotation: true,
            total: 0,
            total_accept: 0,
            paidBtnDisabled: true,
            tabIndex: 0,
            quotsID: [],
            selected: []
        };
    },

    methods: {
        /* -------------------------------------------------------------------------- */
        /*                                TABS SECTION                                */
        /* -------------------------------------------------------------------------- */
        closeTab(x) {
            for (let i = 0; i < this.tabs.length; i++) {
                if (this.tabs[i] === x) {
                    this.tabs.splice(i, 1);
                }
            }
        },
        newTab() {
            this.tabs.push(this.tabCounter++);
        },
        getActiveTabID(tabIndex) {
            // get the current tab index
            this.tabIndex = tabIndex;
            //? How to get the quot id of the current quotation
        },
        /* -------------------------------------------------------------------------- */

        clearSelected(tabIndex) {
            this.$refs["table-" + tabIndex][0].clearSelected();
        },
        selectAllRows() {
            this.$refs["table-" + this.tabIndex][0].selectAllRows();
        },
        /**
         * get the new acts and put them in array
         *
         * @param null
         * @returns {Array} lines
         * @returns {Number} lines[].act_id
         * @returns {Number} lines[].num_dent
         * @returns {String} lines[].acte name of the act
         * @returns {Number} lines[].prix price of the act
         */
        generateLines() {
            const lines = [];
            this.$refs.categories.validatedActs.forEach(act => {
                const type = act.type;
                switch (type) {
                    case "mouth":
                        lines.push(createLine(act));
                        break;
                    case "teeth":
                        this.selectedTooth.forEach(teeth => {
                            if (SECTORS.includes(teeth))
                                // is Sector
                                // extract tooth from Sector and create line before push to lines
                                utilities
                                    .getToothFrom(teeth)
                                    .forEach(t =>
                                        lines.push(createLine(act, t))
                                    );
                            // is Teeth
                            else lines.push(createLine(act, teeth));
                        });
                        break;
                    case "sector":
                        const _sectors = () => {
                            let tmp = [];
                            this.selectedTooth.forEach(teeth => {
                                if (SECTORS.includes(teeth)) tmp.push(teeth);
                            });
                            return tmp;
                        };
                        var sectors = _sectors(); // filter the sectors from the selected tooth
                        if (sectors.length > 0)
                            // if sectors are selectionned
                            for (let i = 0; i < sectors.length; i++)
                                lines.push(createLine(act, sectors[i]));

                        // else
                        //     lines.push(createLine(act));
                        break;
                }
            });

            function createLine(act, tooth = MOUTH) {
                let line = {
                    act_id: act.id,
                    tooth: tooth,
                    num_dent: utilities.getAreaFromTooth(tooth),
                    acte: act.nom,
                    videos: act.videos.map(v => v.url),
                    price: act.price
                };
                return line;
            }

            return lines;
        },
        /**
         * @description Handle "Ajouter" button
         * Create new quotation and Add acts
         * or Add Acts to the current quotation
         */
        async selectedActs() {
            var currTabID = this.tabIndex;
            var that = this;

            //* GENERATE LINES
            const lines = that.generateLines();

            //* CREATE A NEW FORM
            const form = populateForm(lines);

            //* SEND FORM TO THE SERVER
            const response = await axios.post("/patients/devis", form);

            // response.data = response.data.map(l => {
            //     return {
            //         ...l,
            //         acte: l.act.nom,
            //         state: l.accepted_state ? "Accepter" : "Rejeter"
            //     };
            // });
            console.log("response : " + response.data);

            //* IF: QUOTATION IS EXIST, PUSH THE NEW LINES TO THE EXISTING QUOTATION OF THE CURRENT TAB QUOTATION
            if (quotationExistInTab(currTabID)) {
                that.quotations[currTabID] = [
                    ...that.quotations[currTabID],
                    ...response.data
                ];
            } else {
                //* ELSE: CREATE NEW QUOTATION WITH THE NEW LINES AND DISPLAY TOTAL
                that.quotations.push(response.data);
            }

            //* CALCULATE OR UPDATE THE TOTAL
            that.calculateTotal(that.quotations[currTabID]);

            //* DRAW LINES INTO DENTAL SCHEMA
            that.quotsID[currTabID] = response.data[0].devis_id;

            response.data.forEach(line => {
                that.drawLines(line);
            });

            //* RESET SELECTED TEETH AND ACTS
            resetSchema();

            function populateForm(lines) {
                let data = [
                    {
                        key: "lines",
                        value: JSON.stringify(lines)
                    },
                    {
                        key: "quotID",
                        value: that.quotsID[currTabID]
                    },
                    {
                        key: "patient_id",
                        value: that.patient.id
                    }
                ];
                // Create form data
                return utilities.createForm(data);
            }

            function quotationExistInTab(tabID) {
                if (that.quotations[tabID] != undefined) return true;
                return false;
            }

            function resetSchema() {
                // * Uncheck selected acts
                that.$refs.categories.validatedActs = [];
                that.$refs.categories.selectedActs = [];

                //* Uncheck Selected tooth
                that.selectedTooth = [];
                that.$refs.schema_1.resetTooth();
            }
        },
        drawQuotation(quotation) {
            quotation.forEach(line => {
                this.drawLines(line);
            });
        },
        drawLines(row) {
            const tooth = row.teeth.split(",");
            row.act.coords.forEach(coord => {
                tooth.forEach(teeth => {
                    if (teeth == coord.teeth) {
                        coord.quot_id = row.devis_id;
                        this.$refs.schema_1.$refs.schema_layer.createShape(
                            coord
                        );
                    }
                });
            });
        },
        calculateTotal(quot) {
            let total = 0;
            //* get the quotation of current active tab
            quot.forEach(myfunction);

            function myfunction(value) {
                total += parseInt(value.price);
            }

            this.total = total;
        },
        /**
         * Button Accepter
         */
        acceptQuotation() {
            if (confirm("Vous confirmer votre action ?")) {
                let data = [
                    {
                        key: "total",
                        value: this.total
                    },
                    {
                        key: "total_accept",
                        value: this.total_accept
                    },
                    {
                        key: "_method",
                        value: "put"
                    },
                    {
                        key: "acceptedLines",
                        value: JSON.stringify(this.selected)
                    },
                    {
                        key: "patient_id",
                        value: this.patient.id
                    }
                ];
                // Create form data
                let form = utilities.createForm(data);
                const quotID = this.quotsID[this.tabIndex];
                // Send data to the server
                axios
                    .post(`/patients/devis/${quotID}`, form)
                    .then(response => {
                        // Remove All action buttons
                        this.switchToReadOnlyMode();
                        // Send schema and created quotation to "Plan" tab
                        this.$emit("validated-quotation", response.data);
                        // switch to "Plan" this
                    })
                    .catch(exception => {
                        this.$toaster.error(exception);
                    });
            }
        },
        displayInitialSchema(coords) {
            coords.forEach(coord => {
                this.$refs.schema_1.$refs.schema_layer.actShapes.push(coord);
            });
        },
        switchToTab(tabIdx) {
            this.tabIndex = 9999;
            this.tabIndex = tabIdx;
        },
        deleteTab() {
            if (confirm("Vous confirmez la suppression du devis en cours ?")) {
                const tabIdx = this.tabIndex;
                const getCurrentQuotationID = tabIdx =>
                    this.quotations[tabIdx][0].devis_id;

                async function deleteQuotation(quotID) {
                    return await axios.delete(`/patients/devis/${quotID}`);
                }

                const removeTab = tabIdx => {
                    this.tabs.splice(tabIdx, 1);

                    this.tabs = this.tabs.map((item, idx) => idx);

                    //* DECREMENT TAB COUNTER
                    this.tabCounter--;
                };

                const removeCurrentQuotationTable = tabIdx =>
                    this.quotations.splice(tabIdx, 1);

                const removeSchemaOfQuotation = quotID =>
                    this.$refs.schema_1.$refs.schema_layer.removeShapesByQuotation(
                        quotID
                    );

                //* GET THE QUOT ID FROM THE CURRENT TAB
                const quotID = getCurrentQuotationID(tabIdx);

                //* DELETE QUOT FROM THE SERVER
                const response = deleteQuotation(quotID);

                //* REMOVE CURRENT TAB
                removeTab(tabIdx);

                //* REMOVE CURRENT QUOT TABLE
                removeCurrentQuotationTable(tabIdx);

                //* REMOVE SHAPES OF THE DELETED QUOT
                removeSchemaOfQuotation(quotID);

                //* SWITCH TO THE FIRST ACTIVE TAB
                this.switchToTab(0);

                //* DELETE DELETED QUOT ID FROM QUOTS ID LIST
                this.quotsID.splice(
                    this.quotsID.findIndex(q => q == quotID),
                    1
                );
            }
        },
        onRemovedLine(line) {
            this.$refs.schema_1.$refs.schema_layer.removeShapesByLine(line);
            this.total -= line.price;
        },
        /**
         * Duplicate the current Quotation table
         */
        duplicateQuotation(tabID = this.tabIndex) {
            const getCurrentQuotation = () => this.quotations[this.tabIndex];

            async function saveClonedQuotation(quotationID) {
                return await axios.post(
                    "/patients/devis/" + currentQuotationID + "/duplicate"
                );
            }
            //* GET THE CURRENT QUOTATION
            const currentQuotation = getCurrentQuotation();

            //* GET THE CURRENT QUOTATION ID
            const currentQuotationID = currentQuotation[0].devis_id;

            //* CLONE THE CURRENT QUOTATION
            const cloneCurrentQuotation = currentQuotation;

            //* SAVE THE CLONE QUOTATION INTO THE SERVER
            const response = saveClonedQuotation(cloneCurrentQuotation.id);

            //* ADD THE CLONED QUOT TO THE LIST OF QUOTATIONS
            this.quotations.push(cloneCurrentQuotation);

            //* ADD THE CLONED QUOTATION ID TO THE LIST OF IDS
            response.then(res => this.quotsID.push(res.data));

            //* CREATE A NEW TAB
            this.newTab(tabID++);

            //* DRAW SHAPES FOR THE CLONED QUOTATION
            this.drawQuotation(cloneCurrentQuotation);

            //* SWITCH TO THE NEW TAB
            // this.switchToTab(tabID++);
        },
        onImageLoaded() {
            //* DRAW SHAPES FOR EACH QUOTATIONS
            this.quotations.forEach(quotation => {
                this.drawQuotation(quotation);
            });
            this.switchToTab(0);
        },
        /**
         * Handle on price updated
         *
         */
        onPriceUpdated({ newPrice, oldPrice }) {
            if (newPrice > oldPrice) {
                const diff = newPrice - oldPrice;
                this.total += diff;
            } else {
                const diff = oldPrice - newPrice;
                this.total -= diff;
            }
        },
        switchToReadOnlyMode() {
            this.isQuotation = !this.isQuotation;
        },
        printQuotation() {
            const tabIdx = this.tabIndex;

            const getCurrentDate = () => {
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, "0");
                var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
                var yyyy = today.getFullYear();

                today = mm + "/" + dd + "/" + yyyy;
                return today;
            };
            const getCurrentQuotation = tabIdx => this.quotations[tabIdx];

            var currentQuotation = getCurrentQuotation(tabIdx);
            var currentQuotationData = currentQuotation.map(item => {
                const el = {
                    act: item.act.nom,
                    tooth: item.num_dent,
                    price: `${item.price} DA`
                };
                return Object.values(el);
            });
            currentQuotationData[currentQuotationData.length - 1] = [
                "",
                "TOTAL",
                this.total + " DA"
            ];
            const doc = new jsPDF();
            // var pageWidth = 8.5,
            //     lineHeight = 1.2,
            //     margin = 0.5,
            //     maxLineWidth = pageWidth - margin * 2,
            //     fontSize = 24,
            //     ptsPerInch = 72,
            //     oneLineHeight = (fontSize * lineHeight) / ptsPerInch;
            const myFont = lato;

            doc.addFileToVFS("MyFont.ttf", myFont);
            doc.addFont("MyFont.ttf", "MyFont", "normal");
            doc.setFont("MyFont");
            // doc.setFont("helvetica", "normal");

            doc.setDrawColor(28, 178, 107);
            doc.setLineWidth(1.5);
            doc.line(10, 10, 200, 10);

            doc.setFontSize(20);
            doc.setTextColor(28, 178, 107);
            doc.text("CABINET DENTAIRE", 10, 22);

            doc.addImage(this.user.cabinet.logo, "JPEG", 11, 27, 30, 30);

            doc.setFontSize(25);
            doc.setTextColor(0, 0, 0);
            doc.text("DEVIS DE \nSOINS", 11, 70);

            doc.setFontSize(16);

            doc.text("Cabinet dentaire ", 11, 90);
            doc.text("055213167", 11, 98);
            doc.text(this.user.email, 11, 105);

            doc.text(
                "Bloc C etage 2,\n" + "Résidence des oliviers -\n" + "Oran",
                11,
                125
            );

            doc.text(
                "A l'intention de : " +
                    this.patient.nom +
                    " " +
                    this.patient.prenom +
                    " \n" +
                    "Date de naissance : " +
                    this.patient.date_naissance +
                    " \n" +
                    "Numéro de Tel : " +
                    this.patient.num_tel +
                    " \n" +
                    "Date : " +
                    getCurrentDate(),
                70,
                85
            );

            doc.setFont("MyFont", "normal");
            doc.setTextColor(28, 178, 107);
            doc.text("DEVIS POUR SOINS DENTAIRES", 70, 120);

            doc.setTextColor(0, 0, 0);
            doc.setFont("MyFont", "normal");
            doc.text(
                "Numéro de devis : " + currentQuotation[0].devis_id,
                70,
                135
            );
            doc.text("Termes 30 jours", 70, 142);

            doc.autoTable({
                head: [["Description", "Dent", "Prix"]],
                columnStyles: {
                    0: { halign: "left" },
                    1: { halign: "left" },
                    2: { halign: "left" }
                },
                startY: 145,
                margin: { left: 70, right: 5 },
                pageBreak: "auto",
                body: currentQuotationData
            });

            let finalY = doc.lastAutoTable.finalY; // The y position on the page
            doc.setFontSize(14);
            doc.text(
                70,
                finalY + 10,
                "Ce devis de soins dentaires est établi à l’intention de Mr\n" +
                    this.patient.prenom +
                    " " +
                    this.patient.nom +
                    ", pour validation dans un délai n’excédant pas\nles 30 jours\n\nCordialement,\n\n" +
                    this.user.prenom +
                    " " +
                    this.user.name
            );

            // Footer
            doc.setDrawColor(28, 178, 107);
            doc.setLineWidth(0.5);
            doc.line(10, 290, 200, 290);
            doc.autoPrint();
            window.open(doc.output("bloburl"), "_blank");
        },
        hasAcceptedQuotation() {
            const arr = this.patient.quotations.filter(
                quot => quot.line_accepted
            );
            if (arr.length > 0) return true;
            return false;
        }
    },

    watch: {
        /**
         * handle Switch of TABS
         */
        tabIndex: {
            handler: function(newV, oldV) {
                const currentQuotation = this.quotations[newV];
                const svg_id = this.$refs.schema_1.$refs.schema_layer.id;
                var shapes = document.getElementById(svg_id).childNodes;
                this.clearSelected(oldV);
                this.total = 0;
                if (currentQuotation == undefined) {
                    // NEW EMPTY TAB
                    for (let index = 0; index < shapes.length; index++) {
                        if (shapes[index].getAttribute("formula") != "basic")
                            shapes[index].style.display = "none";
                    }
                } else {
                    const currQuotID = currentQuotation[0].devis_id;
                    //* Calculate Total related to the current tab
                    this.calculateTotal(currentQuotation);

                    // show schema of the current tab
                    for (let index = 0; index < shapes.length; index++) {
                        const devisAttr = shapes[index].getAttribute("devis");
                        if (devisAttr == currQuotID) {
                            // hide them
                            shapes[index].style.display = "block";
                        } else if (
                            shapes[index].getAttribute("formula") != "basic"
                        ) {
                            // display them
                            shapes[index].style.display = "none";
                        } else {
                        }
                    }
                }
            },
            deep: true
        },
        selected: {
            handler: function(newVal, old) {
                this.total_accept = 0;
                // Enable 'Accepter' && 'Versement' buttons
                this.paidBtnDisabled = this.selected.length != 0 ? false : true;
                // Calculate total_accept
                $.each(
                    newVal,
                    (i, e) => (this.total_accept += parseInt(e.price))
                );
            },
            deep: true
        },
        selectedTooth: {
            handler: function(newVal) {
                if (newVal.length) this.$refs.categories.btnDisabled = false;
                else this.$refs.categories.btnDisabled = true;
            },
            deep: true
        }
    },

    computed: {
        discount: function() {
            return this.total - this.total_accept;
        },
        plusBtn: function() {
            if (
                this.quotations[this.tabIndex]?.length > 0 ||
                this.quotations.length === 0
            )
                return false;
            else return true;
        }
    },

    mounted() {
        if (this.patient.quotations.length != 0) {
            //* Check if there is treatment plan
            if (this.hasAcceptedQuotation()) {
                //* Switch to readonly mode
                this.switchToReadOnlyMode();
            }
            this.patient.quotations.forEach((quot, idx) => {
                this.quotations.push(quot.lines);
                //* STORE QUOTS ID
                this.quotsID.push(quot.id);
                if (idx == 0) this.calculateTotal(quot.lines);
                // this.isQuotation = false;
                if (idx >= 1) this.newTab();
            });
        }
        if (this.patient.initial_schema)
            this.displayInitialSchema(this.patient.initial_schema.traitements);
    }
};
</script>

<style></style>
