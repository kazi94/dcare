<template>
    <div class="bg-deep-blue card card-body">
        <b-form-group
            id="input-group-ordonnance"
            label="Sélectionner l'ordonnance type"
            label-for="input-ordonnance"
            class="text-uppercase w-75 font-weight-bold"
        >
            <b-form-select
                v-model="selectedPrescriptionType"
                :options="prescriptionsType"
            ></b-form-select>
        </b-form-group>
    </div>
</template>

<script>
export default {
    props: {},
    data() {
        return {
            prescriptionsType: [],
            selectedPrescriptionType: "",
        };
    },
    methods: {
        /*
         * Get the list of ordonnances type
         */
        fetchOrdonnancesType() {
            axios
                .get("/admin/ordonnance-type/get-ordonnances-type")
                .then((response) => {
                    this.prescriptionsType = response.data;
                })
                .catch((exception) => {
                    console.log(exception);
                });
        },
    },
    watch: {
        /*
         * Show the list of medocs when ordonnance type is selected
         */
        selectedPrescriptionType: {
            handler: function (newV) {
                let vm = this,
                    drugs = [];
                console.log(newV);
                let selectedOrdonnance = newV; // Ex : 4 or 5 , 6 , {id}
                vm.prescriptionsType.forEach(function (value, index) {
                    if (value.value === newV) {
                        value.medicaments.forEach((med) => {
                            drugs.push(med);
                        });
                    }
                });
                this.$emit("selected-prescription", drugs);
                // vm.selectedMeds = vm.medics; // check all medics
            },
        },
    },
    mounted() {
        this.fetchOrdonnancesType();
    },
};
</script>
