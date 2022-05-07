<template>
    <div>
        <b-row>
            <b-col cols="10"><h2>Règlements</h2></b-col>
            <b-col cols="2">
                <b-button size="sm" variant="primary" v-b-modal.cach-modal
                    >Nouveau</b-button
                ></b-col
            >
        </b-row>

        <b-table
            :items="payments"
            :fields="fields"
            :per-page="perPage"
            :current-page="currentPage"
            bordered
            responsive="sm"
            small
            head-variant="light"
        >
            <template v-slot:cell(index)="data">
                <!-- data = acceptedQuotation -->
                {{ data.index + 1 }}
            </template>

            <template v-slot:cell(total_paid)="data">
                <!-- data = acceptedQuotation -->
                {{ data.item.total_paid }} DA
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
        <div>
            <b-modal
                id="cach-modal"
                ref="modal"
                title="Versement"
                header-bg-variant="success"
                header-text-variant="light"
                no-fade
                button-size="sm"
                modal-ok="Valider"
                ok-title="Encaisser"
                @show="resetModal"
                @hidden="resetModal"
                @ok="verify"
            >
                <form ref="form">
                    <b-form-group
                        :state="nameState"
                        label="Total encaissé"
                        description="Une somme inférieur au total est acceptable."
                        label-for="name-input"
                        invalid-feedback="Name is required"
                    >
                        <b-form-input
                            id="name-input"
                            v-model="total_paid"
                            :state="nameState"
                            required
                        ></b-form-input>
                    </b-form-group>
                </form>
            </b-modal>
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    props: {
        patient: {
            type: Object
        }
    },
    data() {
        return {
            fields: [
                {
                    key: "index",
                    label: "#",
                    sortable: false
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
                }
            ],
            perPage: 10,
            currentPage: 1,
            payments: new Array()
        };
    },
    methods: {
        /**
         * Add new Payment to table
         * @param Object newPayment
         */
        updateTable(newPayment) {
            this.payments.push(newPayment);
        },
        resetModal() {
            this.total_paid = this.total_accept;
            this.nameState = null;
        },
        /*
         * Encaisser btn
         */
        verify(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            if (!this.isQuotation)
                // isPlan
                this.validatePayements();
            else this.validateCach();
        },
        checkFormValidity() {
            const valid = this.$refs.form.checkValidity();
            this.nameState = valid;
            return valid;
        },
        validateCach() {
            // Exit when the form isn't valid
            if (!this.checkFormValidity()) {
                return;
            }
            // Create Form
            let form = this.createForm("onDay");
            // Send data to the server
            axios
                .post("/patients/devis", form)
                .then(response => {
                    // reset to default data
                    Object.assign(this.$data, initialState());

                    this.$bvModal.hide("cach-modal");
                    this.$toaster.success("Versement fait !");
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
            // Hide the modal manually
            this.$nextTick(() => {
                this.$bvModal.hide("modal-prevent-closing");
            });
        },
        // Confirm Payement(s) of the created quotation
        validatePayements() {
            /**
             * get the ID of Plan
             */
            let devis_id = this.acceptedQuotation[0].devis_id;
            let data = [
                {
                    key: "devis_id",
                    value: devis_id
                },
                {
                    key: "total_paid",
                    value: this.total_paid
                }
            ];
            let form = this.createForm(data);
            axios
                .post("/patients/devis/create-payement-by-devis", form)
                .then(response => {
                    this.$toaster.success("Versement fait !");
                    this.$bvModal.hide("cach-modal");
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, "0");
                    var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
                    var yyyy = today.getFullYear();

                    today = yyyy + "-" + mm + "-" + dd;
                    let payment = {
                        total_paid: this.total_paid,
                        paid_at: today
                    };
                    this.$emit("payment-done", payment);
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });

            // Hide the modal manually
            this.$nextTick(() => {
                this.$bvModal.hide("modal-prevent-closing");
            });
        }
    },
    computed: {
        rows() {
            return this.payments.length;
        }
    },
    mounted() {
        if (
            this.patient.last_schema != null &&
            this.patient.last_schema.last_quotation != null &&
            this.patient.last_schema.last_quotation.payments != null
        ) {
            this.payments = this.patient.last_schema.last_quotation.payments;
        }
    }
};
</script>

<style lang="scss" scoped></style>
