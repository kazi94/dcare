<template>
    <div>
        <div class="text-center" v-show="isNotLoaded">
            <b-spinner variant="primary" label="Text Centered"></b-spinner>
        </div>
        <div
            class="row border-bottom border-alternate pb-1"
            v-show="!isNotLoaded"
        >
            <div class="col-md-6" v-if="isPlan">
                <payment-modal
                    ref="payment-modal"
                    button-title="Versement"
                    :patient="patient"
                    @payment-done="onPaymentDone"
                ></payment-modal>
                <!-- ------------------------ "Actes fait" Section ------------------------- -->
                <b-button
                    size="sm"
                    variant="success"
                    :hidden="btnDone"
                    class="pull-right mb-1"
                    v-b-modal.modal-acts-done
                >
                    <b-icon
                        icon="check-circle-fill"
                        aria-hidden="true"
                    ></b-icon>
                    Actes fait
                </b-button>
                <!-- Acts done Model -->
                <b-modal
                    id="modal-acts-done"
                    title="Liste des Actes fait"
                    size="lg"
                    ok-title="Fermer"
                    :ok-only="onlyOk"
                    header-bg-variant="success"
                    header-text-variant="white"
                >
                    <b-table
                        bordered
                        responsive="sm"
                        small
                        head-variant="light"
                        :items="actsDoneItems"
                        :fields="actsDoneFields"
                    >
                        <template v-slot:cell(index)="data">
                            <!-- data = acceptedQuotation -->
                            {{ data.index + 1 }}
                        </template>
                        <template v-slot:cell(act)="data">{{
                            data.value.nom
                        }}</template>
                        <template v-slot:cell(price)="data">
                            {{ data.item.price }} DA
                        </template>
                    </b-table>
                </b-modal>
                <!-- END Acts done Model -->

                <!-- ---------------------- "End Actes fait" Section ----------------------- -->

                <!-- ----------------------------- PLan table ------------------------------ -->
                <div>
                    <b-table
                        bordered
                        responsive="sm"
                        small
                        head-variant="light"
                        :items="acceptedQuotation"
                        :fields="acceptedQuotationFields"
                    >
                        <template v-slot:cell(index)="data">
                            <!-- data = acceptedQuotation -->
                            {{ data.index + 1 }}
                        </template>
                        <template v-slot:cell(act)="data"
                            >{{ data.value.nom }}
                        </template>
                        <template v-slot:cell(price)="data">
                            <b-form-group
                                id="priceid-1"
                                description="Tapez sur Entrée pour modifier le prix."
                                v-if="edit == data.item.id"
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
                            <p v-else @click="edit = data.item.id">
                                <b class="text-info">
                                    {{ data.item.price }} DA
                                </b>
                            </p>
                        </template>
                        <template v-slot:cell(state)="data">
                            <!-- data = acceptedQuotation -->
                            <b-badge
                                pill
                                v-if="data.item.state == 'En cours'"
                                variant="secondary"
                                @click="handleState(data.item)"
                                style="cursor:pointer"
                                >{{ data.item.state }}</b-badge
                            >
                            <b-badge
                                pill
                                v-else
                                variant="success"
                                @click="handleState(data.item)"
                                style="cursor:pointer"
                                >{{ data.item.state }}</b-badge
                            >
                        </template>
                    </b-table>
                </div>
                <!-- --------------------------- End Table Plan ---------------------------- -->

                <!-- Display Informations about quotation  -->
                <b-row class="m-0">
                    <b-col sm="12">
                        <h5 class="text-center font-weight-bold alert-dark">
                            TOTAL :
                            <span>{{ display_total }} DA</span>
                        </h5>
                        <!-- <p
                            class="text-center font-weight-bold alert-info border-bottom border-alternate"
                        >
                            Total accepté :
                            <span>{{ total_accept }} DA</span>
                        </p> -->
                    </b-col>
                </b-row>
                <!-- End Display Informations about quotation -->
            </div>
            <div class="row col-md-6 align-items-center" v-else>
                <div class="col">
                    <p class="h1 mb-2 text-center text-secondary">
                        Commencer par sélectionner les actes à faire
                        <b-icon
                            icon="arrow-right"
                            class="rounded-circle bg-success p-2 ml-4"
                            variant="light"
                            animation="cylon"
                            font-scale="1.5"
                        ></b-icon>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <schema-component
                    :selectedTooth="selectedTooth"
                    isToothVisible="true"
                    ref="schema"
                    img_id="plan-image"
                    schema_id="plan-schema"
                    p_class="mb-2"
                ></schema-component>
                <category
                    ref="categories"
                    @select-acts="addActsToPlan"
                ></category>
            </div>
        </div>
    </div>
</template>

<script>
import SchemaComponent from "./SchemaComponent.vue";
import Category from "./PlanSchema/Category.vue";
import PaymentModal from "./PaymentModal.vue";

// outside of the component:
function initialState() {
    return {
        onlyOk: true,
        actsDoneFields: [
            { key: "index", sortable: true, label: "#" },
            { key: "num_dent", sortable: true, label: "Dent" },
            { key: "act", sortable: true, label: "Acte" },
            { key: "price", sortable: true, label: "Prix" },
            { key: "date_done", sortable: true, label: "Date de réalisation" }
        ],
        actsDoneItems: [],
        acceptedQuotationFields: [
            { key: "index", sortable: true },
            { key: "num_dent", sortable: true },
            { key: "act", sortable: true, label: "Acte" },
            { key: "price", sortable: true, label: "Prix" },
            { key: "state", sortable: true, label: "Status" }
        ],
        selectedTooth: new Array(),
        schema_id: "",
        quotation: [],
        acceptedQuotation: new Array(),
        id: "",
        total: 0,
        total_accept: 0,
        total_paid: 0,
        display_total: 0,
        paidBtnDisabled: true,
        sortBy: "num_dent",
        sortDesc: false,
        edit: false,
        btnDone: true,
        videoToRead: null,
        titleVideo: null,
        quot_id: null,
        isPlan: false,
        isNotLoaded: true
    };
}

// COMPONENT
export default {
    props: {
        patient: {
            type: Object,
            required: true
        }
    },

    components: {
        SchemaComponent,
        Category,
        PaymentModal
    },
    data() {
        return initialState();
    },

    methods: {
        onPaymentDone(payment) {
            return this.$emit("payment-done", payment);
        },
        /*
         * Btn AJouter
         * Add acts to the current Plan (Devis en cours de traitement)
         * And Send new acts to the server
         */
        addActsToPlan(quotation = null) {
            // get Additional Acts
            let additionalQuotation = this.getAdditionalActs();
            let data = [
                { key: "lignes", value: JSON.stringify(additionalQuotation) },
                {
                    key: "quot_id",
                    value: this.quot_id
                },
                {
                    key: "patient_id",
                    value: this.patient.id
                },
                { key: "total", value: this.display_total }
            ];
            let form = this.createForm(data);

            this.calculateTotal(additionalQuotation);

            // Send new acts to the server
            axios
                .post("/patients/devis/add-acts", form)
                .then(response => {
                    //* Reset selected tooth and selected acts
                    this.resetSchema();

                    //* create new shapes
                    this.$refs.schema.createShapes(response.data);

                    //* Add the new acts to the current table
                    response.data.forEach(row => {
                        this.acceptedQuotation.push(row);
                    });
                    this.isPlan = true;
                    this.quot_id = response.data[0].devis_id;
                })
                .catch(exception => {
                    console.log(exception);
                });
        },
        /**
         * get the new acts and put them in array
         *
         * @param null
         * @returns {Array} acts
         * @returns {Number} acts[].act_id
         * @returns {Number} acts[].num_dent
         * @returns {String} acts[].acte name of the act
         * @returns {Number} acts[].prix price of the act
         */
        getAdditionalActs() {
            let data = [];
            $.each(this.selectedTooth, (index, el) => {
                // For each selected acts , Create new Quotation Row
                $.each(this.$refs.categories.selectedActs, (i, e) => {
                    data.push({
                        act_id: e.id,
                        num_dent: el,
                        acte: e.nom,
                        videos: e.videos.map(v => v.url),
                        prix: e.price
                    });
                });
            });

            return data;
        },
        resetSchema() {
            // * Uncheck selected acts
            this.$refs.categories.selectedActs = [];

            //* Uncheck Selected tooth
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

            items.forEach(function(item) {
                form.set(item["key"], item["value"]);
            });

            return form;
        },
        handleState(row) {
            this.$bvModal
                .msgBoxConfirm("Vous confirmez avoir fait l'acte ?", {
                    title: "SVP confirmer l'acte",
                    size: "sm",
                    buttonSize: "sm",
                    okVariant: "success",
                    okTitle: "OUI",
                    cancelTitle: "NON",
                    footerClass: "p-2",
                    hideHeaderClose: false,
                    centered: true
                })
                .then(value => {
                    if (value) {
                        // update the state of the act
                        if (row.state == "En cours") {
                            row.state = "Fait";
                            this.total_accept += row.price; // Calculé la somme total faite
                            this.total_paid = this.total_accept;
                        } else if (row.state == "Fait" && !row.lock) {
                            row.state = "En cours";
                            this.total_accept -= row.price; // Calculé la somme total faite
                            this.total_paid = this.total_accept;
                        }
                        axios
                            .get(
                                "/patients/devis/update-ligne/" +
                                    row.state +
                                    "&&" +
                                    row.id
                            )
                            .catch(exception => {
                                this.$toaster.error(exception);
                            });
                        // * Handle payement button
                        this.paidBtnDisabled =
                            this.total_paid != 0 ? false : true;
                    }
                })
                .catch(err => {
                    // An error occurred
                });
        },
        /**
         * Remove all shapes from plan schema
         * @return void
         */
        removeShapes() {
            // find shape elements by teeth attribute
            var shapes = document.getElementById("plan_schema_canvas")
                .childNodes;
            for (let index = 0; index < shapes.length; index++) {
                shapes[index].remove();
            }
        },
        initialState() {
            this.acceptedQuotation = [];
            this.remise = 0;
            this.display_total = 0;
        },
        calculateTotal(quotation) {
            let total = 0;
            //* get the quotation of current active tab
            quotation.forEach(myfunction);

            function myfunction(value) {
                total += parseInt(value.prix);
            }

            this.display_total += total;
        },
        handlePriceOnKeyUpEnterEvent($event, data) {
            const line_id = data.item.id;
            const newPrice = parseInt($event.target.value);

            data.item.prix = newPrice;
            this.edit = false;

            let formData = new FormData();

            formData.set("price", newPrice);

            axios.post("/api/patients/plan/lines/" + line_id, formData);
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
            this.$refs.schema.coords = quotation;
            this.$refs.schema.createShapes(quotation);
        }
    },

    watch: {
        selectedTooth: {
            handler: function(newVal) {
                if (newVal.length) this.$refs.categories.btnDisabled = false;
                else this.$refs.categories.btnDisabled = true;
            },
            deep: true
        }
    },

    computed: {},

    mounted() {
        let inProgressLines = [];
        console.log("Plan schema Component");

        if (this.patient.quotations.length != 0) {
            this.patient.quotations.forEach(quot => {
                if (quot.state == "plan" || quot.state == "draft") {
                    this.quot_id = quot.id;
                    this.isPlan = true;
                    // Display Total amount
                    this.display_total = quot.total;
                    quot.lines.forEach(line => {
                        if (line.state == "Fait") {
                            this.btnDone = false;
                            this.actsDoneItems.push(line);
                        } else {
                            this.acceptedQuotation.push(line);
                        }
                    });
                }
            });
            // create shapes
            this.$refs.schema.coords = this.acceptedQuotation;
        }
        this.isNotLoaded = false;
        this.$emit("mounted");
    }
};
</script>

<style></style>
