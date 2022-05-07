<template>
    <div>
        <pie-chart v-if="loaded" :chart-data="datacollection"></pie-chart>
    </div>
</template>

<script>
import PieChart from "@/components/Chart/PieChart.vue";
import statisticApi from "@/services/api/statisticApi.js";

export default {
    components: {
        PieChart
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
            const response = await statisticApi.countPatientsGroupByMotivations(
                period
            );
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
                labels: obj.map(o => o.motivationFr),
                // labels: ["Motivé", "Moyennemnt motivé", "Non motivé"],
                datasets: [
                    {
                        label: "NOMBRE DE PATIENTS",
                        backgroundColor: ["#f0cc02", "#28a745", "#ff0000"],
                        hoverOffset: 4,
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
