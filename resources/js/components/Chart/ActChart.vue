<template>
    <div>
        <bar-chart v-if="loaded" :chart-data="datacollection"></bar-chart>
    </div>
</template>

<script>
import BarChart from "@/components/Chart/BarChart.vue";
import statisticApi from "@/services/api/statisticApi.js";
// import "../../i18n/times.js";
export default {
    components: {
        BarChart
    },
    data() {
        return {
            loaded: false,
            datacollection: null
        };
    },

    methods: {
        async fetchActs(period = "current-month") {
            const response = await statisticApi.countActsGroupByTime(period);
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
            this.datacollection = {
                labels: obj.map(o => o.month),
                datasets: [
                    {
                        label: "NOMBRE D'ACTES FAITS",
                        backgroundColor: "#f87979",
                        data: obj.map(o => o.nbrActs)
                    }
                ]
            };
        },
        getRandomInt() {
            return Math.floor(Math.random() * (50 - 5 + 1)) + 5;
        }
    },
    mounted() {
        this.fetchActs();
    }
};
</script>
