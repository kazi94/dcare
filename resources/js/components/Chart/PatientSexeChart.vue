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
            const response = await statisticApi.countPatientsGroupBySex(period);
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
                labels: obj.map(o => o.sexe),
                datasets: [
                    {
                        label: "NOMBRE DE PATIENTS",
                        backgroundColor: [
                            "rgb(255, 99, 132)",
                            "rgb(54, 162, 235)"
                        ],
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
