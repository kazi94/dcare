<template>
    <div>
        <div class="row border-alternate justify-content-between">
            <div class="col-md-6 card">
                <!-- <b-skeleton-wrapper :loading="loading">
                    <template #loading>
                        <b-card>
                            <b-skeleton-table
                                :rows="5"
                                :columns="4"
                                :table-props="{ bordered: true, striped: true }"
                            ></b-skeleton-table>
                        </b-card>
                    </template> -->
                <div class="mt-2">
                    <take-note-modal :patient="patient"></take-note-modal>
                    <payment-modal
                        ref="payment_modal"
                        button-title="Encaisser"
                        :patient="patient"
                        @payment-done="onPaymentDone"
                        :total-to-pay="totalToPay"
                        :quot_id="quot_id"
                    ></payment-modal>
                    <!-- ------------------------ "Actes fait" Section ------------------------- -->
                    <the-act-done-button
                        ref="TheActDoneButton"
                        :actsDoneItems="actsDoneItems"
                        :total_done="total_done"
                        @act-done-undo="onUndoActDone"
                    ></the-act-done-button>
                </div>
                <!-- ---------------------- "End Actes fait" Section ----------------------- -->

                <!-- ----------------------------- Tratment PLan table ------------------------------ -->
                <div v-if="acceptedQuotation.length > 0">
                    <b-table
                        bordered
                        responsive="sm"
                        small
                        head-variant="light"
                        :items="acceptedQuotation"
                        :fields="acceptedQuotationFields"
                        class="text-center"
                    >
                        <template v-slot:cell(act)="data"
                            >{{ data.value.nom }}
                            <video-demo-player
                                v-if="data.item.act.videos"
                                :act="data.item.act"
                                :videos="data.item.act.videos"
                            ></video-demo-player>
                        </template>
                        <template v-slot:cell(price)="data">
                            <b-form-group
                                id="priceid-1"
                                description="Tapez sur Entrée pour modifier le prix."
                                v-show="edit == data.item.id"
                            >
                                <b-form-input
                                    type="text"
                                    v-model="data.item.price"
                                    @keyup.enter="
                                        handlePriceOnKeyUpEnterEvent(
                                            $event,
                                            data
                                        )
                                    "
                                    trim
                                ></b-form-input>
                            </b-form-group>
                            <span
                                v-show="edit != data.item.id"
                                @click="onPriceCellClick(data)"
                            >
                                <b class="text-info">
                                    {{ numberWithSpaces(data.item.price) }}
                                    DA
                                </b>
                            </span>
                        </template>
                        <template v-slot:cell(state)="data">
                            <!-- data = acceptedQuotation -->
                            <b-badge
                                pill
                                v-if="data.item.state == 'En cours'"
                                variant="secondary"
                                class="text-light"
                                @click="handleState(data.item, data.index)"
                                style="cursor: pointer"
                                >{{ data.item.state }}</b-badge
                            >
                            <b-badge
                                pill
                                v-if="data.item.state == 'A faire'"
                                variant="danger"
                                class="text-light"
                                @click="handleState(data.item, data.index)"
                                style="cursor: pointer"
                                >{{ data.item.state }}
                                <i class="fa fa-exclamation-circle"></i>
                            </b-badge>
                            <b-badge
                                pill
                                v-if="data.item.state == 'fait'"
                                variant="success"
                                class="text-light"
                                @click="handleState(data.item, data.index)"
                                style="cursor: pointer"
                                >{{ data.item.state }}
                                <i class="fa fa-check-fill"></i
                            ></b-badge>
                        </template>
                        <template v-slot:cell(delete)="data">
                            <b-icon
                                v-b-tooltip.hover.bottom
                                tiltle="Supprimer l'acte dentaire"
                                icon="x-circle"
                                scale="2"
                                variant="danger"
                                style="cursor: pointer"
                                class="text-center"
                                @click="removeLine(data.item)"
                            ></b-icon>
                        </template>
                    </b-table>
                </div>
                <!-- --------------------------- End Table Plan ---------------------------- -->
                <div class="row col-12 align-items-center" v-else>
                    <div class="col">
                        <p class="h2 mb-2 text-center text-secondary">
                            Sélectionner un ou plusieurs actes à faire
                            <b-icon
                                icon="arrow-right"
                                class="rounded-circle bg-success p-2 ml-4"
                                variant="light"
                                font-scale="1.5"
                            ></b-icon>
                        </p>
                    </div>
                </div>
                <!-- </b-skeleton-wrapper> -->
            </div>

            <div class="col-md-6">
                <!-- <b-skeleton-wrapper :loading="loading">
                    <template #loading>
                        <b-card>
                            <b-skeleton-img></b-skeleton-img>
                        </b-card>
                    </template> -->
                <b-card>
                    <schema-component
                        :selectedTooth="selectedTooth"
                        :patient="patient"
                        isToothVisible="true"
                        ref="schema"
                    ></schema-component>
                    <category
                        ref="categories"
                        @select-acts="addActsToPlan"
                    ></category>
                </b-card>
                <!-- </b-skeleton-wrapper> -->
                <!-- <b-skeleton-wrapper :loading="loading">
                    <template #loading>
                        <b-card>
                            <b-skeleton
                                width="55%"
                                class="text-center"
                            ></b-skeleton>
                            <b-skeleton
                                width="55%"
                                class="text-center"
                            ></b-skeleton>
                        </b-card>
                    </template> -->
                <!-- Display Informations about quotation  -->
                <div class="mt-2" v-if="total_to_do || total_paid">
                    <b-card>
                        <b-col class="text-center h6">
                            <p v-if="total_to_do">
                                <span class="font-weight-bolder text-info"
                                    >TOTAL :
                                </span>
                                <span
                                    >{{
                                        numberWithSpaces(total_to_do)
                                    }}
                                    DA</span
                                >
                            </p>
                            <p v-if="total_paid">
                                <span class="font-weight-bolder text-success"
                                    >TOTAL VERSEMENTS :
                                </span>
                                <span
                                    >{{ numberWithSpaces(total_paid) }} DA</span
                                >
                            </p>
                            <p v-if="reste > 0">
                                <span class="font-weight-bolder">RESTE : </span>
                                <span>
                                    {{ numberWithSpaces(reste) }}
                                    DA
                                </span>
                            </p>
                        </b-col>
                    </b-card>
                </div>
                <!-- End Display Informations about quotation -->
                <!-- </b-skeleton-wrapper> -->
            </div>
        </div>
    </div>
</template>

<script>
import Category from "@/Components/Category";
import PaymentModal from "@/Components/PaymentModal";
import SchemaComponent from "@/Components/Schema/SchemaComponent";
import VideoDemoPlayer from "@/Components/VideoDemo/VideoDemoPlayer";
import TheActDoneButton from "@/Components/PlanSchema/TheActDoneButton";
import TakeNoteModal from "@/Components/PlanSchema/TakeNoteModal";
import axios from "axios";
// CONSTANTS
const MOUTH =
    "11,12,13,14,15,16,17,18,21,22,23,24,25,26,27,28,41,42,43,44,45,46,47,48,31,32,33,34,35,36,37,38";
const SECTORS = ["s1", "s2", "s3", "s4"];

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
        Category,
        PaymentModal,
        VideoDemoPlayer,
        TheActDoneButton,
        TakeNoteModal
    },
    data() {
        return {
            acceptedQuotationFields: [
                {
                    key: "num_dent",
                    sortable: true
                },
                {
                    key: "act",
                    sortable: true,
                    label: "Acte"
                },
                {
                    key: "price",
                    sortable: true,
                    label: "Prix"
                },
                {
                    key: "state",
                    sortable: true,
                    label: "Status"
                },
                {
                    key: "delete",
                    sortable: false,
                    label: "Action"
                }
            ],
            actsDoneItems: [],
            selectedTooth: [],
            quotation: [],
            acceptedQuotation: [],
            id: "",
            total_done: 0,
            total_to_do: 0,
            edit: false,
            btnDone: false,
            quot_id: null,
            isPlan: false,
            loading: true,
            total_rest: 0,
            oldPrice: ""
        };
    },

    methods: {
        onPaymentDone(payment) {
            this.total_paid =
                parseInt(this.total_paid) + parseInt(payment.total_paid);
            return this.$emit("payment-done", payment);
        },
        /**
         * Btn AJouter
         * Add acts to the current Plan (Devis en cours de traitement)
         * And Send new acts to the server
         */
        addActsToPlan() {
            // get Additional Acts
            let additionalQuotation = this.createLines();

            this.calculateTotal(additionalQuotation);

            let data = [
                {
                    key: "lignes",
                    value: JSON.stringify(additionalQuotation)
                },
                {
                    key: "quot_id",
                    value: this.quot_id
                },
                {
                    key: "patient_id",
                    value: this.patient.id
                },
                {
                    key: "total",
                    value: this.total_to_do
                }
            ];
            let form = this.createForm(data);

            // Send new acts to the server

            axios
                .post("/patients/devis/add-acts", form)
                .then(response => {
                    const quotation = response.data;
                    //* Add the new acts to the current table
                    quotation.forEach(row => {
                        //* create new shapes for each row
                        this.drawLines(row);

                        this.acceptedQuotation.push(row);

                        //this.total_to_do += row.price;
                    });
                    //* Reset selected tooth and selected acts
                    this.resetSchema();

                    this.isPlan = true;
                    this.quot_id = quotation[0].devis_id;
                })
                .catch(exception => {
                    console.log(exception);
                });
        },
        /**
         * Create new quotation line
         * @param {Object} act
         * @param {String} area list of teeth or tooth
         * @returns {Object} newLine
         */
        createLine(act, area = MOUTH) {
            let line = {
                act_id: act.id,
                num_dent: area,
                acte: act.nom,
                videos: act.videos.map(v => v.url),
                price: act.price
            };

            return line;
        },
        /**
         * Get tooth from SECTORS
         * @param {String} sector Selected sector from schema
         * @returns {Array} tooth list of tooth from the selected sector
         */
        getToothFrom(sector) {
            switch (sector) {
                case "s1":
                    return [11, 12, 13, 14, 15, 16, 17, 18];

                case "s2":
                    return [21, 22, 23, 24, 25, 26, 27, 28];

                case "s3":
                    return [41, 42, 43, 44, 45, 46, 47, 48];

                case "s4":
                    return [31, 32, 33, 34, 35, 36, 37, 38];
            }
        },
        /**
         * get the new acts and put them in array
         *
         * @param null
         * @returns {Array} lines
         */
        createLines() {
            const lines = [];
            this.$refs.categories.validatedActs.forEach(act => {
                const type = act.type;
                switch (type) {
                    case "mouth":
                        lines.push(this.createLine(act));
                        break;
                    case "teeth":
                        this.selectedTooth.forEach(teeth => {
                            if (SECTORS.includes(teeth))
                                // is Sector
                                // extract tooth from Sector and create line before push to lines
                                this.getToothFrom(teeth).forEach(teeth =>
                                    lines.push(this.createLine(act, teeth))
                                );
                            // is Teeth
                            else lines.push(this.createLine(act, teeth));
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
                        const sectors = _sectors(); // filter the sectors from the selected tooth
                        if (sectors.length > 0)
                            // if sectors are selectionned
                            for (let i = 0; i < sectors.length; i++)
                                lines.push(this.createLine(act, sectors[i]));

                        // else
                        //     lines.push(this.createLine(act));
                        break;
                }
            });

            return lines;
        },
        /**
         * Reset Dental Schema
         */
        resetSchema() {
            // * Uncheck selected acts
            this.$refs.categories.validatedActs = [];
            this.$refs.categories.selectedActs = [];

            //* Uncheck Selected tooth
            this.selectedTooth = [];
            this.$refs.schema.resetTooth();
        },
        /**
         * Generate Form Data
         *
         * @param {Array} [items] array of key/value object
         * @return {FormData} FormData
         */
        createForm(items) {
            let form = new FormData();

            items.forEach(item => {
                form.set(item["key"], item["value"]);
            });

            return form;
        },
        /**
         * @description Handle onChange states of the ACT
         * @param {Object} row  line quotation
         */
        handleState(row, index) {
            const currState = this.updateState(row.id, row.state);
            // Modify && Lock State button
            if (currState == "A faire") row.state = "En cours";
            if (currState == "En cours") {
                row.state = "fait";
                this.$refs.TheActDoneButton.actsDoneItems.push(row);
                this.acceptedQuotation.splice(index, 1);
                this.total_done += row.price;
                this.total_to_do -= row.price;
            }
            if (currState == "fait") {
                row.state = "A faire";
                this.actsDoneItems = this.actsDoneItems.filter(
                    r => r.id != row.id
                );
                this.total_done -= row.price;
                this.total_to_do += row.price;
            }
        },
        /**
         * Upadte the state of the current act
         * @param {String} currState CURRENT STATE OF THE ACT
         */
        updateState(id, currState) {
            axios
                .post(
                    `/patients/devis/lines/${id}`,
                    {
                        state: currState,
                        _method: "patch"
                    },
                    {
                        headers: {
                            _method: "patch"
                        }
                    }
                )
                .then(() => {
                    // this.$toaster.info(`Validation de l'acte.`);
                })
                .catch(error => {
                    const res = error.response;
                    const status = res.status;
                    const isError = status == 422;
                    if (res && isError) {
                        const errors = res.data.errors;
                        for (const [key, value] of Object.entries(errors)) {
                            value.forEach(val => {
                                this.$toaster.error(`${key} : ${val}`);
                            });
                        }
                    }
                });
            return currState;
        },

        /**
         * Calculate Total price of the current quotation
         * @param {Object} quotation THE created quotation
         */
        calculateTotal(quotation) {
            let total = 0;
            //* get the quotation of current active tab
            quotation.forEach(myfunction);

            function myfunction(value) {
                total += parseInt(value.price);
            }

            this.total_to_do += total;
        },
        /**
         * Handle on click on price cell
         * for editing a new price
         */
        onPriceCellClick(data) {
            this.edit = data.item.id;
            this.oldPrice = data.item.price;
        },
        /**
         * Handle onChange price of the act
         * @param {Object} $event Enter keyboard event
         * @param {*} data
         */
        handlePriceOnKeyUpEnterEvent($event, data) {
            const line_id = data.item.id,
                // oldPrice = parseInt(data.item.price),
                newPrice = parseInt($event.target.value),
                API_URL = `/api/patients/plan/lines/${line_id}`;
            let formData = new FormData();

            data.item.price = newPrice;
            this.edit = false;

            formData.set("price", newPrice);
            axios
                .post(API_URL, formData)
                .then(res => {
                    if (res.status == 200)
                        this.total_to_do =
                            this.oldPrice >= newPrice
                                ? this.total_to_do - (this.oldPrice - newPrice)
                                : this.total_to_do + (newPrice - this.oldPrice);
                })
                .catch(err => {
                    this.$toaster.error(err);
                });
        },
        /**
         * Create or Update Plan Schema if EXIST
         * @param {Object} quotation The validated quotation from Devis tabs
         */
        updatePlan(quotation) {
            // Update Plan Table
            if (this.acceptedQuotation.length == 0)
                this.acceptedQuotation = quotation;
            else
                this.acceptedQuotation = [
                    ...this.acceptedQuotation,
                    ...quotation
                ];

            this.isPlan = true;
            // Update Schema
            // this.$refs.schema.coords = quotation;
            quotation.forEach(row => {
                this.drawLines(row);
            });
        },

        drawLines(row) {
            const tooth = row.teeth.split(",");
            row.act.coords.forEach(coord => {
                tooth.forEach(teeth => {
                    if (teeth == coord.teeth) {
                        this.$refs.schema.$refs.schema_layer.createShape(coord);
                    }
                });
            });
        },
        /**
         * Render quotations to table
         */
        displayPlan() {
            let plan = this.patient.plan;
            if (plan != null) this.displayQuotation(plan);
        },
        /**
         * Add the quotation to the table
         * @param {Object} quot Quotation with type "draft" or "plan"
         */
        displayQuotation(quot) {
            this.quot_id = quot.id;
            this.isPlan = true;

            // Display Total amount
            const total_paid =
                this.patient.total_paid != null
                    ? this.patient.total_paid.value
                    : 0;
            this.$store.commit("updateTotalPaid", {
                operation: "increase",
                payment: total_paid
            });

            quot.lines.forEach(line => {
                if (line.state == "fait") {
                    this.btnDone = true;
                    this.actsDoneItems.push(line);
                    this.total_done += line.price;
                } else {
                    this.acceptedQuotation.push(line);
                    this.total_to_do += line.price;
                }
                //* DRAW SHAPES
                const tooth = line.teeth.split(",");
                line.act.coords.forEach(coord => {
                    tooth.forEach(teeth => {
                        if (teeth == coord.teeth) {
                            this.$refs.schema.$refs.schema_layer.actShapes.push(
                                coord
                            );
                        }
                    });
                });
            });
        },

        displayInitialSchema(coords) {
            coords.forEach(coord => {
                this.$refs.schema.$refs.schema_layer.actShapes.push(coord);
            });
        },
        /**
         * Remove the line from the treatment plan
         */
        removeLine(line) {
            if (confirm("Vous ètes sûr de supprimer l'acte ?"))
                axios.delete(`/patients/devis/lines/${line.id}`).then(() => {
                    // remove line from the table
                    this.acceptedQuotation = this.acceptedQuotation.filter(
                        l => l.id != line.id
                    );

                    // remove act from the dental schema
                    this.$refs.schema.$refs.schema_layer.removeShapesByLine(
                        line
                    );

                    // Update Total
                    this.total_to_do -= line.price;
                });
        },
        numberWithSpaces(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        },
        /**
         * Handle when an act done was undo
         */
        onUndoActDone(item) {
            // Add the act to the table
            item.state = "En cours";
            this.acceptedQuotation.push(item);

            // Design the act into Schema
            // this.drawLines(item);

            // Update Total TODO and Total Reste to Pay
            this.total_to_do += item.price;
            this.$store.commit("updateTotalToDo", this.total_to_do);
        }
    },

    watch: {
        selectedTooth: {
            handler(newVal) {
                if (newVal.length) this.$refs.categories.btnDisabled = false;
                else this.$refs.categories.btnDisabled = true;
            },
            deep: true
        },
        // acceptedQuotation: {
        // handler(newVal, oldVal) {
        //     console.log("New val : " + JSON.stringify(newVal));
        //     console.log("old val : " + JSON.stringify(oldVal));
        // },
        // deep: true
        // },
        total_to_do(newVal) {
            // this.$emit("total-to-do-updated", newVal);
            this.$store.commit("updateTotalToDo", newVal);
        },
        total_done(newVal) {
            // this.$emit("total-done-updated", newVal);
            this.$store.commit("updateTotalDone", newVal);
        }
        // total_paid(newVal) {
        //     // this.$emit("total-paid-updated", newVal);
        //     this.$store.commit("updateTotalPaid", newVal);
        // }
    },

    computed: {
        totalToPay() {
            if (this.patient.plan && this.patient.total_paid)
                return this.patient.plan.total - this.patient.total_paid.value;
        },
        total_paid: {
            get: function() {
                return this.$store.state.totalPaid;
            },
            set: function(newV) {
                return newV;
            }
        },
        reste() {
            // this.$store.commit(
            //     "updateReste",
            //     this.total_to_do + this.total_done - this.$store.state.totalPaid
            // );
            // return (
            //     this.total_to_do + this.total_done - this.$store.state.totalPaid
            // );

            return this.$store.state.reste;
        }
    },

    mounted() {
        this.displayPlan();

        if (this.patient.initial_schema)
            this.displayInitialSchema(this.patient.initial_schema.traitements);

        this.$emit("mounted");
        // setTimeout(() => {
        //     this.loading = false;
        // }, 500);
    }
};
</script>

<style></style>
