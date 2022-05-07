import Category from "@/Components/Category.vue";
import PaymentModal from "@/Components/PaymentModal.vue";
import SchemaComponent from "@/Components/Schema/SchemaComponent.vue";
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
        PaymentModal
    },
    data() {
        return {
            onlyOk: true,
            actsDoneFields: [
                {
                    key: "index",
                    sortable: true,
                    label: "#"
                },
                {
                    key: "num_dent",
                    sortable: true,
                    label: "Dent"
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
                    key: "date_done",
                    sortable: true,
                    label: "Date de réalisation"
                }
            ],
            actsDoneItems: [],
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
            selectedTooth: [],
            schema_id: "",
            quotation: [],
            acceptedQuotation: [],
            id: "",
            total_done: 0,
            total_paid: 0,
            total_to_do: 0,
            edit: false,
            btnDone: true,
            videoToRead: null,
            quot_id: null,
            isPlan: false,
            isNotLoaded: true,
            total_rest: 0,
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

            items.forEach((item) => {
                form.set(item["key"], item["value"]);
            });

            return form;
        },
        /**
         * @description Handle onChange states of the ACT
         * @param {Object} row  line quotation
         */
        handleState(row) {
            const currState = this.updateState(row.id, row.state);
            // Modify && Lock State button
            if (currState == "A faire") row.state = "En cours";
            if (currState == "En cours") row.state = "fait";
            if (currState == "fait") row.state = "A faire";
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
         * Handle onChange price of the act
         * @param {Object} $event Enter keyboard event
         * @param {*} data
         */
        handlePriceOnKeyUpEnterEvent($event, data) {
            const line_id = data.item.id;
            const newPrice = parseInt($event.target.value);

            data.item.prix = newPrice;
            this.edit = false;

            let formData = new FormData();

            formData.set("price", newPrice);
            const url = `/api/patients/plan/lines/${line_id}`;

            axios.post(url, formData);
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
            // this.total_to_do = quot.total;
            this.total_paid =
                this.patient.total_paid != null
                    ? this.patient.total_paid.value
                    : 0;
            quot.lines.forEach(line => {
                if (line.state == "fait") {
                    this.btnDone = false;
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
            if (confirm('Vous ètes sûr de supprimer l\'acte ?'))
                axios.delete(`/patients/devis/lines/${line.id}`)
                    .then(() => {
                        // remove line from the table
                        this.acceptedQuotation = this.acceptedQuotation.filter(l => l.id != line.id);

                        // remove act from the dental schema
                        this.$refs.schema.$refs.schema_layer.removeShapesByLine(line);
                    });
        }
    },

    watch: {
        selectedTooth: {
            handler: function (newVal) {
                if (newVal.length) this.$refs.categories.btnDisabled = false;
                else this.$refs.categories.btnDisabled = true;
            },
            deep: true
        }
    },

    computed: {
        totalToPay() {
            if (this.patient.plan && this.patient.total_paid)
                return this.patient.plan.total - this.patient.total_paid.value;
        }
    },

    mounted() {

        this.displayPlan();

        if (this.patient.initial_schema)
            this.displayInitialSchema(this.patient.initial_schema.traitements);

        this.isNotLoaded = false;

        this.$emit("mounted");
    }
};
