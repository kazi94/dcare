<template>
    <div>
        <bar-chart v-if="loaded" :chart-data="datacollection"></bar-chart>
    </div>
</template>

<script>
import BarChart from "@/components/Chart/BarChart.vue";
import statisticApi from "@/services/api/statisticApi.js";

export default {
    components: {
        BarChart
    },
    data() {
        return {
            patients: [],
            labels: [],
            loaded: false,
            datacollection: null
        };
    },

    methods: {
        async fetchPatients(period = "current-month") {
            const response = await statisticApi.countPatientsGroupByAge(period);
            if (response.data.patients) {
                // this.patients = response.data.patients.map(
                //     patient => patient.nbr
                // );
                // this.labels = response.data.patients.map(
                //     patient => patient.range
                // );
                this.fillData(response.data.patients);
            }
            this.loaded = true;
        },
        updateChart(args) {
            const period = args[0] || "";
            this.fetchPatients(period);
        },

        fillData(obj) {
            this.datacollection = {
                labels: obj.map(o => o.range),
                datasets: [
                    {
                        label: "NOMBRE DE PATIENTS",
                        backgroundColor: "#f87979",
                        data: obj.map(o => o.nbr)
                    }
                ]
            };
        },
        getRandomInt() {
            return Math.floor(Math.random() * (50 - 5 + 1)) + 5;
        }
    },
    mounted() {
        this.fetchPatients();
    }
};
</script>
