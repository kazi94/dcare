<template>
    <div>
        <bar-chart
            v-if="loaded"
            label="DA"
            :chart-data="datacollection"
        ></bar-chart>
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
        async fetchRevenue(period = "current-month") {
            const response = await statisticApi.countTotalRevenuByMonth(period);
            if (response.data.total) {
                this.fillData(response.data.total);
            }
            this.loaded = true;
        },
        updateChart(args) {
            const period = args[0] || "";
            this.fetchRevenue(period);
        },

        fillData(obj) {
            this.datacollection = {
                labels: obj.map(o => o.month),
                datasets: [
                    {
                        label: "TOTAL DES REVENUES",
                        backgroundColor: "#f87979",
                        data: obj.map(o => o.amount)
                    }
                ]
            };
        },
        getRandomInt() {
            return Math.floor(Math.random() * (50 - 5 + 1)) + 5;
        }
    },
    mounted() {
        this.fetchRevenue();
    }
};
</script>
