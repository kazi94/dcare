<template>
    <div>
        <div class="main-card mb-3 card">
            <div class="card-header">Patients par sexe</div>
            <div class="card-body">
                <div class="d-flex mb-1">
                    <datepicker
                        placeholder="Date Début"
                        v-model="startDate"
                        name="start-date"
                        class="mr-2"
                    ></datepicker>
                    <datepicker
                        placeholder="Date Fin"
                        v-model="endDate"
                        name="end-date"
                        class="mr-2"
                    ></datepicker>

                    <b-button
                        variant="outline-success"
                        size="sm"
                        class="rounded-pill font-weight-bolder mr-2"
                        @click="updateChart"
                        >Filtrer</b-button
                    >
                </div>
                <pie-chart
                    v-if="loaded"
                    :chart-data="patients"
                    :chart-labels="labels"
                ></pie-chart>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    methods: {
        fn() {
            this.$emit("clicks");
        }
    }
};
</script>
