<template>
    <div>
        <b-button
            size="sm"
            v-b-modal="modal_id"
            class="mb-1 pull-right ml-1 bg-midnight-bloom text-white"
            >{{ buttonTitle }}</b-button
        >
        <b-modal
            :id="modal_id"
            ref="modal"
            :title="title"
            no-fade
            :hideFooter="true"
            header-bg-variant="midnight-bloom"
            header-text-variant="white"
        >
            <form @submit.prevent="submitPayment">
                <input v-model="form._method" type="hidden" />
                <input type="hidden" name="patient_id" :value="patient.id" />
                <input type="hidden" name="devis_id" :value="quot_id" />
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
                    :state="nameState"
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
                        :state="nameState"
                        v-model="form.total_paid"
                        name="total_paid"
                        required
                        :class="{
                            'is-invalid': form.errors.has('total_paid')
                        }"
                    ></b-form-input>
                    <has-error :form="form" field="total_paid"></has-error>
                </b-form-group>

                <div class="mt-2 modal_footer pull-right">
                    <button
                        type="button"
                        class="btn btn-secondary text-uppercase"
                        @click="hideModal"
                    >
                        Annuler
                    </button>
                    <input
                        :disabled="form.busy"
                        type="submit"
                        value="Encaisser"
                        class="btn text-uppercase"
                        :class="editMode ? ' btn-success' : ' btn-primary '"
                    />
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
// import { ValidationProvider, extend } from "vee-validate";
// import { numeric } from "vee-validate/dist/rules";

// No message specified.
// extend('digits', digits);

// Override the default message.
// extend("numeric", {
//     ...numeric,
//     message: "le montant du règlement doit ètre des chiffres"
// });
// Add a rule.
// extend("secret", {
//     validate: value => value === "example",
//     message: "This is not the magic word"
// });

// Register it globally
// Vue.component("ValidationProvider", ValidationProvider);
export default {
    props: {
        buttonTitle: {
            type: String,
            default: "Nouveau"
        },
        patient: {
            type: Object,
            required: true
        },
        totalToPay: {
            type: Number
        },
        quot_id: {
            type: Number,
            default: null
        }
    },
    watch: {
        editMode: function(val) {
            this.title = val ? "Modifier le règlement " : "Nouveau Règlement";
            this.form._method = val ? "put" : "";
        }
    },
    data() {
        return {
            nameState: null,
            title: "Nouveau Règlement",
            total_paid: null,
            modal_id: null,
            form: new Form({
                id: null,
                paid_at: new Date().toISOString().substring(0, 10),
                total_paid: null,
                patient_id: this.patient.id
            }),
            editMode: false,
            busy: false,
            oldPayment: ""
        };
    },
    methods: {
        updatePayment(payment) {
            // open the modal for update
            this.editMode = true;
            this.form.fill(payment.item);
            this.$bvModal.show(this.modal_id);
            this.oldPayment = payment.item.total_paid;
        },
        hideModal() {
            this.editMode = false;
            this.form.reset();
            this.nameState = null;
            this.$bvModal.hide(this.modal_id);
        },
        /**
         * @desc Submit Payment
         * @return void
         */
        async submitPayment() {
            const URL = this.editMode
                ? "/api/patients/payments/" + this.form.id
                : "/api/patients/payments";
            const response = await this.form.post(URL);

            const newPayment = response.data.total_paid;

            if (!this.editMode) {
                // Add new Payment
                this.$store.commit("updateTotalPaid", {
                    operation: "increase",
                    payment: newPayment
                });
            } else {
                // Update the exesting Payment
                if (this.oldPayment > newPayment)
                    this.$store.commit("updateTotalPaid", {
                        operation: "decrease",
                        payment: this.oldPayment - newPayment
                    });
                else
                    this.$store.commit("updateTotalPaid", {
                        operation: "increase",
                        payment: newPayment - this.oldPayment
                    });
            }

            // emit the update event to the table
            this.$emit("payment-done", response.data);

            // Display Message
            this.$toaster.success(
                this.editMode
                    ? "Versement modifié avec succès ! "
                    : "Versement effectué avec succès ! "
            );

            // Hide and Reset the Modal
            this.hideModal();
        },
        numberWithSpaces(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
    },
    computed: {
        total_to_pay_info: function() {
            // if (this.totalToPay > 0)
            //     return `Reste à payer : ${this.totalToPay} DA.`;
        }
    },
    mounted() {
        this.modal_id = this._uid.toString();
    }
};
</script>
