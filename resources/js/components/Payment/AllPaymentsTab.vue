<template>
    <div>
        <div class="col-6">
            <download-excel
                :data="paymentsToExport"
                class="d-inline mb-1"
                name="Tableau de mes règlements"
            >
                <button
                    class="btn btn-success"
                    title="Exporter le tableau en format Excel"
                >
                    <b-icon-file-earmark-spreadsheet-fill></b-icon-file-earmark-spreadsheet-fill>
                    Exporter
                </button>
            </download-excel>
        </div>
        <b-table
            striped
            hover
            :items="payments"
            :fields="fields"
            foot-clone
            responsive="sm"
            :per-page="perPage"
            :current-page="currentPage"
            :busy.sync="isBusy"
            :filter="filter"
            :filterIncludedFields="filterOn"
            bordered
            id="payments-table"
            caption-top
        >
            <template #table-caption
                >Vous avez au total: {{ payments.length }} versements.</template
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
            <template v-slot:cell(total_paid)="data"
                ><span class="text-success font-weight-bold"
                    >{{ numberWithSpaces(data.item.total_paid) }} DA</span
                ></template
            >
            <template v-slot:cell(created_to)="data"
                >{{ data.value.nom }} {{ data.value.prenom }}</template
            >
            <template v-slot:cell(validated_payment_by)="data"
                >Dr.{{ data.value.name }} {{ data.value.prenom }}</template
            >
            <template v-slot:cell(actions)="data" v-if="user.role_id == 1">
                <b-button
                    variant="outline-danger"
                    @click="removePayment(data.index, data.item.id)"
                    ><b-icon-trash class="mr-1"></b-icon-trash>
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
            aria-controls="payments-table"
        ></b-pagination>
    </div>
</template>
<script>
import Vue from "vue";
import JsonExcel from "vue-json-excel";
Vue.component("download-excel", JsonExcel);

export default {
    props: ["user"],
    data() {
        return {
            paymentsInfo: null,
            fields: [
                "index",
                {
                    key: "created_to",
                    label: "Patient",
                    sortable: true
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
                },
                {
                    key: "validated_payment_by",
                    label: "Validé par",
                    sortable: true
                },
                "Actions"
            ],
            dailyData: {
                actesNumber: "",
                prescriptionsNumber: "",
                patientsNumber: "",
                totalPayments: ""
            },
            payments: [],
            paymentsToExport: [],
            boxOne: "",
            perPage: 10,
            currentPage: 1,
            isBusy: false,
            filter: null,
            filterOn: [],
            today: "",
            totalRows: null
        };
    },
    methods: {
        //remove removePayment
        removePayment(index, id) {
            this.boxOne = "";
            this.$bvModal
                .msgBoxConfirm("Voulez vous supprimer le règlement ?", {
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
                            .delete("/api/payments/" + id)
                            .then(response => {
                                this.payments.splice(index, 1);
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
        fetchAllPayments() {
            this.isBusy = true;
            let url =
                this.user.role_id === 3
                    ? "/api/payments/paid-by/" + this.user.id
                    : "/api/payments/";

            // on mounted page, display all payments
            axios.get(url).then(response => {
                this.payments = response.data;
                this.paymentsToExport = this.payments.map((p, idx) => {
                    return {
                        index: ++idx,
                        Patient: p.created_to?.nom + " " + p.created_to?.prenom,
                        Montant: p.total_paid + " DA",
                        "Date de règlement": p.paid_at,
                        "Validé par": p.validated_payment_by.doctor
                    };
                });
                this.isBusy = false;
            });
        },
        numberWithSpaces(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
    },
    computed: {
        rows() {
            return this.payments.length;
        }
    },
    watch: {},
    mounted() {
        //* GET THE DAY DATA

        this.fetchAllPayments(); // Show the list of my payments
    }
};
</script>
