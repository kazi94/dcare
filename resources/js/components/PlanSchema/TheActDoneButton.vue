<template>
    <div v-show="actsDoneItems.length > 0">
        <b-button
            size="sm"
            variant="success"
            class="pull-right mb-1"
            v-b-modal.modal-acts-done
        >
            <!-- <b-icon icon="check-circle-fill" aria-hidden="true"></b-icon> -->
            Actes fait
        </b-button>
        <!-- Acts done Model -->
        <b-modal
            id="modal-acts-done"
            title="Liste des Actes fait"
            size="lg"
            ok-title="Fermer"
            ok-variant="secondary"
            :ok-only="onlyOk"
            header-bg-variant="success"
            header-text-variant="white"
        >
            <div class="h5 pull-right text-info">
                Total des actes faits : {{ numberWithSpaces(total_done) }} DA
            </div>
            <b-table
                bordered
                responsive="sm"
                small
                head-variant="light"
                :items="actsDoneItemsLocal"
                :fields="actsDoneFields"
                :per-page="perPage"
                :current-page="currentPage"
                :busy.sync="isBusy"
                :filter="filter"
                :filterIncludedFields="filterOn"
                @filtered="onFiltered"
            >
                <template v-slot:cell(index)="data">
                    <!-- data = acceptedQuotation -->
                    {{ data.index + 1 }}
                </template>
                <template v-slot:cell(act)="data">{{
                    data.value.nom
                }}</template>
                <template v-slot:cell(price)="data">
                    {{ numberWithSpaces(data.item.price) }} DA
                </template>
                <template v-slot:cell(state)="data">
                    <b-badge
                        pill
                        v-if="data.item.state == 'fait'"
                        variant="success"
                        class="text-light"
                        @click="handleState(data)"
                        style="cursor: pointer"
                        >{{ data.item.state }} <i class="fa fa-check-fill"></i
                    ></b-badge>
                </template>
            </b-table>
            <div class="h5 pull-right text-info">
                Total des actes faits : {{ numberWithSpaces(total_done) }} DA
            </div>
        </b-modal>
        <!-- END Acts done Model -->
    </div>
</template>

<script>
import { numberWithSpaces } from "@/utils/priceFormatter";
export default {
    props: {
        actsDoneItems: {
            type: Array,
            default: []
        }
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
                },
                {
                    key: "state",
                    sortable: true,
                    label: "Status"
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
            return this.actsDoneItemsLocal.length;
        },
        actsDoneItemsLocal: {
            get: function() {
                return this.actsDoneItems;
            },
            set: function(newV) {
                return newV;
            }
        },
        total_done: {
            get: function() {
                var cost = 0;
                this.actsDoneItemsLocal.forEach(e => {
                    cost += e.price;
                });
                return cost;
            },
            set: function(newV) {
                return newV;
            }
        }
    },
    methods: {
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        numberWithSpaces(v) {
            return numberWithSpaces(v);
        },
        /**
         * @description Handle onChange states of the ACT
         * @param {Object} row  line quotation
         */
        handleState(row) {
            const currState = this.updateState(row.item.id, row.item.state);

            // Remove the line from the acts done table
            this.actsDoneItemsLocal = this.actsDoneItemsLocal.splice(
                row.item.index,
                1
            );

            // Update Total Price of Acts Done
            this.total_done -= row.item.price;

            // Add the Act into Plan Schema
            this.$emit("act-done-undo", row.item);
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
        }
    },
    mounted() {}
};
</script>
