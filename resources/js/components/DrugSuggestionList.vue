<template>
    <div class="bg-light card card-body mt-3">
        <b-form-group
            label="Liste des médicaments"
            class="text-uppercase text-break"
            v-if="drugs.length > 0"
        >
            <b-form-checkbox-group
                v-model="selectedDrugs"
                :options="drugs"
                stacked
            ></b-form-checkbox-group>
            <b-button
                variant="primary"
                size="sm"
                href="javascript:void(0);"
                v-b-modal.modal-add-new-medic
                class="mt-2 pull-right"
            >
                <i class="fa fa-plus"></i> médicament
            </b-button>
            <b-modal
                id="modal-add-new-medic"
                title="Ajouter un nouveau médicament"
                no-fade
                button-size="sm"
                ok-title="Rajouter"
                cancel-title="Annuler"
                @ok="addnewDrug"
                @hidden="resetModal"
            >
                <vue-bootstrap-typeahead
                    v-model="newDrug"
                    :data="suggestedDrugs"
                    placeholder="Renseigner le médicament"
                    @hit="onSelectedDrug"
                />
            </b-modal>
        </b-form-group>

        <div v-else class="text-center h6">
            <i class="d-block fa fa-3x fa-pills mb-2 text-secondary"></i>
            Aucun médicament! Veuillez sélectionner une ordonnance type.
        </div>
    </div>
</template>
<script>
import VueBootstrapTypeahead from "vue-bootstrap-typeahead";

const API_URL = `/medicament/:query`;

export default {
    components: {
        VueBootstrapTypeahead
    },
    props: {},
    data() {
        return {
            selectedDrugs: [],
            drugs: [],
            newDrug: "",
            suggestedDrugs: []
        };
    },
    methods: {
        /**
         * Add the new drug to the list of drugs
         */
        addnewDrug() {
            return this.newDrug ? this.selectedDrugs.push(this.newDrug) : false;
        },
        onSelectedDrug() {},
        /**
         * on Hide the modal add new medic
         */
        resetModal() {
            this.newDrug = "";
        },
        async getSuggestedDrugs(drug) {
            const res = await axios.get(API_URL.replace(":query", drug));
            this.suggestedDrugs = res.data;
        }
    },
    watch: {
        drugs: {
            handler: function(newV) {
                this.selectedDrugs = newV;
            }
        },
        suggestedDrugs: _.debounce(function(drug) {
            this.getSuggestedDrugs(drug);
        }, 500)
    }
};
</script>
