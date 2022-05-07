<template>
    <div>
        <b-button
            v-b-modal="modal_id"
            size="sm"
            variant="success"
            :disabled="btnDisabled"
            class="btn-block"
            >Choisir les Actes</b-button
        >

        <b-modal
            :id="modal_id"
            size="lg"
            title="Choisir les actes"
            cancel-title="Fermer"
            ok-title="Ajouter"
            @ok="addActs"
        >
            <b-row class="mb-1 text-center">
                <b-col><h5>Catégories</h5> </b-col>
                <b-col><h5>Actes</h5></b-col>
            </b-row>
            <b-row class="mb-1">
                <b-col>
                    <b-form-checkbox-group
                        v-model="selectedCat"
                        :options="categories"
                        name="flavour-2a"
                        value-field="id"
                        text-field="name"
                        stacked
                    >
                    </b-form-checkbox-group>
                </b-col>
                <b-col>
                    <b-form-checkbox-group v-model="selectedActs" stacked>
                        <b-form-checkbox
                            v-for="(act, index) in newActs"
                            :value="act"
                        >
                            {{ act.nom }}</b-form-checkbox
                        >
                    </b-form-checkbox-group>
                </b-col>
            </b-row>
            <template #modal-footer>
                <button
                    type="button"
                    class="btn btn-secondary  "
                    @click="hideModal"
                >
                    Fermer
                </button>
                <button class="btn btn-primary  " @click="addActs">
                    Ajouter
                </button>
            </template>
        </b-modal>
    </div>
</template>

<script>
//import Multiselect from "vue-multiselect";
export default {
    watch: {
        selectedCat: function(newValue, oldValue) {
            this.newActs = [];
            const selectedCategs = newValue;
            selectedCategs.forEach(selectedCategoryID => {
                this.acts.forEach(act => {
                    if (act.category_id == selectedCategoryID) {
                        this.newActs.push(act);
                        this.selectedActs.push(act).id;
                    }
                });
            });
        }
    },
    props: [],
    components: {
        // Multiselect
    },
    data() {
        return {
            categories: new Array(),
            selectedCat: new Array(),
            selectedActs: new Array(),
            acts: new Array(),
            newActs: new Array(),
            modal_id: null,
            btnDisabled: true
        };
    },
    methods: {
        hideModal() {
            this.$bvModal.hide(this.modal_id);
        },
        showModal() {
            this.$bvModal.show(this.modal_id);
        },
        getActs() {
            axios
                .get("/admin/act/get-categories-with-acts")
                .then(response => {
                    this.categories = response.data;
                    this.categories.forEach(category => {
                        category.acts.forEach(act => {
                            this.acts.push(act);
                        });
                    });
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
        },
        addActs() {
            this.$emit("select-acts");
            this.$bvModal.hide(this.modal_id);
        }
    },
    mounted() {
        this.modal_id = this._uid.toString();
        this.getActs();
    }
};
</script>
