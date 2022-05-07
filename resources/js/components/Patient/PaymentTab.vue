<template>
    <div>
        <b-row>
            <b-col cols="10"><h2>Règlements</h2></b-col>
            <b-col cols="2">
                <payment-modal
                    ref="payment_modal"
                    button-title="Nouveau"
                    :patient="patient"
                    @payment-done="onPaymentDone"
                    v-on="$listeners"
                ></payment-modal>
            </b-col>
        </b-row>
        <div v-if="payments.length > 0">
            <b-row>
                <div class="col-md-3 col-xl-3" v-if="credit >= 2000">
                    <div class="card mb-1 widget-content bg-success">
                        <div class="widget-content-outer text-white">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading opacity-10">
                                        CREDITEUR
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers">
                                        +
                                        {{ numberWithSpaces(credit) }}
                                        DA
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xl-3" v-if="debtor <= -2000">
                    <div class="card mb-1 widget-content bg-danger">
                        <div class="widget-content-outer text-white">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading opacity-10">
                                        DEBITEUR
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers">
                                        {{ numberWithSpaces(debtor) }} DA
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xl-3" v-if="reste > 0">
                    <div class="card mb-1 widget-content bg-secondary">
                        <div class="widget-content-outer text-white">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading opacity-10">
                                        RESTE A PAYER
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers">
                                        {{ numberWithSpaces(reste) }} DA
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </b-row>

            <b-table
                :items="payments"
                :fields="computedFields"
                :per-page="perPage"
                :current-page="currentPage"
                responsive="sm"
                small
                head-variant="light"
                caption-top
            >
                <template #table-caption
                    >Vous avez au total:
                    {{ payments.length }}
                    Versements.</template
                >
                <template #table-busy>
                    <div class="text-center text-primary my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Chargement...</strong>
                    </div>
                </template>
                <template #cell(index)="{ item }">
                    {{ payments.indexOf(item) + 1 }}
                </template>

                <template v-slot:cell(total_paid)="data">
                    {{ numberWithSpaces(data.item.total_paid) }} DA
                </template>
                <template v-slot:cell(update)="data">
                    <b-button
                        variant="success"
                        size="sm"
                        @click="updatePayment(data)"
                        ><i class="fa fa-edit"></i
                    ></b-button>
                </template>
                <template v-slot:cell(delete)="data" v-if="user.role_id == 1">
                    <b-button
                        variant="danger"
                        size="sm"
                        @click="deletePayment(data.index, data)"
                        ><i class="fa fa-trash"></i
                    ></b-button>
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
        <div v-else class="text-center text-secondary">
            <h1>
                <i class="d-block fa fa-2x fa-exclamation-triangle"></i>
                Vous n'avez effectué aucun règlement pour l'instant !
            </h1>
        </div>
    </div>
</template>

<script>
import PaymentModal from "../PaymentModal.vue";
export default {
    components: { PaymentModal },
    props: {
        user: {
            type: Object,
            required: false
        },
        patient: {
            type: Object,
            required: true
        },
        newPayment: {
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
                    key: "paid_at",
                    label: "Date de règlement",
                    sortable: true
                },
                {
                    key: "total_paid",
                    label: "Montant",
                    sortable: true
                },
                {
                    key: "update",
                    label: "Modifier",
                    sortable: false
                },
                {
                    key: "delete",
                    label: "Supprimer",
                    sortable: false
                }
            ],
            perPage: 10,
            currentPage: 1,
            payments: new Array()
        };
    },
    methods: {
        numberWithSpaces(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        },
        updatePayment(payment) {
            this.$refs.payment_modal.updatePayment(payment);
        },
        onPaymentUpdated(newPayment) {
            this.payments.splice(index, 1);
        },
        deletePayment(index, payment) {
            this.boxOne = "";
            this.$bvModal
                .msgBoxConfirm("Voulez vous supprimer le règlement?", {
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
                            .delete("/api/payments/" + payment.item.id)
                            .then(response => {
                                if (response) {
                                    this.payments.splice(index, 1);
                                    this.$toaster.success(
                                        response.data.success
                                    );
                                    const totalPaid = parseInt(
                                        payment.item.total_paid
                                    );
                                    this.$store.commit("updateTotalPaid", {
                                        operation: "decrease",
                                        payment: totalPaid
                                    });
                                }
                            })
                            .catch(exception => {
                                this.$toaster.error(exception);
                            });
                })
                .catch(err => {
                    this.$toaster.error(err);
                });
        },
        onPaymentDone(evt) {
            this.updateTable(evt);
        },
        /**
         * Add new Payment to table
         * @param Object newPayment
         */
        updateTable(newPayment) {
            const isNotFound = payementIndex => payementIndex == -1;

            const findIndexById = id =>
                this.payments.findIndex(p => p.id === id);

            const payementIndex = findIndexById(newPayment.id);
            newPayment._rowVariant = "success";
            if (isNotFound(payementIndex)) {
                this.payments.unshift(newPayment);
            } else {
                this.payments[payementIndex] = newPayment;
            }
            this.payments.sort(
                (a, b) => new Date(b.paid_at) - new Date(a.paid_at)
            );
        },
        numberWithSpaces(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
    },
    computed: {
        rows() {
            return this.payments.length;
        },
        credit: {
            get: function() {
                const val =
                    this.$store.state.totalPaid - this.$store.state.totalDone;
                if (val >= 2000) return val;
            },
            set: function(newValue) {
                return newValue;
            }
        },
        debtor: {
            get: function() {
                const val =
                    this.$store.state.totalPaid - this.$store.state.totalDone;
                if (val <= -2000) return val;
            },
            set: function(newValue) {
                return newValue;
            }
        },
        reste() {
            return this.$store.state.reste;
        },
        computedFields() {
            if (this.user.role_id == 1) return this.fields;
            else return this.fields.filter(filter => filter.key != "delete");
        }
    },
    watch: {
        newPayment: {
            handler: function(newV) {
                this.updateTable(newV);
            }
        }
    },
    mounted() {
        this.payments = this.patient.payments;
    }
};
</script>

<style lang="scss" scoped></style>
