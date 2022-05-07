<template>
    <div>
        <b-modal ref="modal-medics" ok-only title="Liste des médicaments">
            <ol>
                <li class="my-4" v-for="(medic, index) in medics" :key="index">
                    {{ medic }}
                </li>
            </ol>
        </b-modal>
    </div>
</template>

<script>
export default {
    props: ["medics"],

    methods: {
        splitMedics(meds) {
            return meds.split(",");
        },
        /*
         * Show list of Drugs
         */
        show() {
            this.medics = this.splitMedics(this.medics);

            this.$refs["modal-medics"].show();
        }
    }
};
</script>
