<template>
    <div>
        <b-table
            striped
            hover
            bordered
            sticky-header
            head-variant="light"
            :items="acts"
            :fields="fields"
        >
            <template #cell(total)="data">
                {{ numberWithSpaces(data.item.total) }} DA
            </template>
        </b-table>
    </div>
</template>

<script>
import statisticApi from "@/services/api/statisticApi.js";
import { numberWithSpaces } from "@/utils/priceFormatter.js";
export default {
    components: {},
    data() {
        return {
            loaded: false,
            fields: [
                {
                    key: "name",
                    label: "Acte",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "nbrActs",
                    label: "Nombre actes fait",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "total",
                    label: "Total",
                    sortable: true,
                    class: "text-center"
                }
            ],
            acts: []
        };
    },

    methods: {
        numberWithSpaces(val) {
            return numberWithSpaces(val);
        },
        async fetchActsDoneRevenu(period = "current-month") {
            const response = await statisticApi.getTotalRevenuPerActDone(
                period
            );
            if (response.data.acts) {
                this.fillData(response.data.acts);
            }
            this.loaded = true;
        },
        updateChart(args) {
            const period = args[0] || "";
            this.fetchActsDoneRevenu(period);
        },

        fillData(obj) {
            this.acts = obj;
        }
    },
    mounted() {
        this.fetchActsDoneRevenu();
    }
};
</script>
