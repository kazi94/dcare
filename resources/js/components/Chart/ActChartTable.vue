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
        ></b-table>
    </div>
</template>

<script>
import statisticApi from "@/services/api/statisticApi.js";
export default {
    components: {},
    data() {
        return {
            loaded: false,
            fields: [
                {
                    key: "act",
                    label: "Acte",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "nbrActsDone",
                    label: "Nombre actes fait",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "actsDoneRatio",
                    label: "Pourcentage %",
                    sortable: true,
                    class: "text-center"
                }
            ],
            acts: []
        };
    },

    methods: {
        async fetchActs(period = "current-month") {
            const response = await statisticApi.countActsDone(period);
            if (response.data.acts) {
                this.fillData(response.data.acts);
            }
            this.loaded = true;
        },
        updateChart(args) {
            const period = args[0] || "";
            this.fetchActs(period);
        },

        fillData(obj) {
            this.acts = obj;
        }
    },
    mounted() {
        this.fetchActs();
    }
};
</script>
