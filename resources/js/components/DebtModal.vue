<template>
    <div>
        <b-button variant="danger" class="mr-1" @click="showModal">
            <i class="fa fa-hand-holding-usd"></i>
            Créance
        </b-button>
        <b-modal
            id="modal-dept"
            title="Créance des patients"
            size="lg"
            ok-title="Fermer"
            :ok-only="onlyOk"
            header-bg-variant="danger"
            header-text-variant="white"
        >
            <div class="h5 pull-right">
                Total créance : {{ numberWithSpaces(totalDebt) }} DA
            </div>
            <b-table
                bordered
                responsive="sm"
                small
                striped
                head-variant="light"
                :items="patientsInDebt"
                :fields="fields"
                :per-page="perPage"
                :current-page="currentPage"
                :busy.sync="isBusy"
                :filter="filter"
                :filterIncludedFields="filterOn"
                @filtered="onFiltered"
                caption-top
            >
                <template #table-caption
                    >Vous avez au total: {{ patientsInDebt.length }} patients en
                    débiteur.</template
                >
                <template #cell(index)="{ item }">
                    {{ patientsInDebt.indexOf(item) + 1 }}
                </template>
                <template v-slot:cell(total_debt)="data">
                    <div
                        :class="
                            data.item.total_debt ? 'font-weight-bolder' : ''
                        "
                    >
                        {{ data.item.total_debt }}
                    </div>
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
        </b-modal>
        <!-- END Acts done Model -->
    </div>
</template>

<script>
import patientsApi from "@/services/api/patientsApi.js";
export default {
    components: {},
    props: {},
    data() {
        return {
            onlyOk: true,
            patientsInDebt: [],
            totalDebt: 0,
            fields: [
                {
                    key: "index",
                    sortable: true,
                    label: "#"
                },
                {
                    key: "patient",
                    sortable: true,
                    label: "Patient"
                },
                {
                    key: "num_tel",
                    sortable: true,
                    label: "Téléphone"
                },
                {
                    key: "total_debt",
                    sortable: true,
                    label: "Débiteur",
                    class: "text-center"
                },
                {
                    key: "date_debt",
                    sortable: true,
                    label: "Date créance",
                    class: "text-center"
                }
            ],
            perPage: 10,
            currentPage: 1,
            isBusy: false,
            filter: null,
            filterOn: []
        };
    },
    computed: {
        rows() {
            return this.patientsInDebt.length;
        }
    },
    methods: {
        showModal() {
            this.fetchPatientsInDebt();
            this.$bvModal.show("modal-dept");
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        async fetchPatientsInDebt() {
            const formatToPrice = p => {
                return p ? `${this.numberWithSpaces(p)} DA` : "";
            };

            const response = await patientsApi.fetchPatientsWithDebt();

            this.patientsInDebt = response.data.patientsInDebt;
            this.totalDebt = response.data.totalDebt;

            this.patientsInDebt = this.patientsInDebt.map(p => ({
                ...p,
                total_debt: formatToPrice(p.total_debt),
                _cellVariants: { total_debt: p.total_debt ? "danger" : "" }
            }));
        },
        numberWithSpaces(x) {
            return x ? x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") : x;
        }
    },
    mounted() {}
};
</script>
