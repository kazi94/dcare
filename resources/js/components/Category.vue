<template>
    <div>
        <b-button
            v-b-modal="modal_id"
            variant="success"
            :disabled="btnDisabled"
            class="btn-block mt-3 text-uppercase"
            >Choisir les Actes</b-button
        >

        <b-modal
            :id="modal_id"
            size="lg"
            style="margin: 57px 5px 5px 18px"
            title="Choisir les actes"
            cancel-title="Fermer"
            ok-title="Ajouter"
            @ok="addActs"
        >
            <b-row class="mb-1">
                <b-col>
                    <h5 class="text-center mb-1">Catégories</h5>
                    <div class="accordion" role="tablist">
                        <b-card
                            no-body
                            class="mb-1"
                            v-for="(category, idx) in categories"
                            :key="idx"
                        >
                            <b-card-header
                                header-tag="header"
                                class="p-1"
                                role="tab"
                            >
                                <b-button
                                    block
                                    v-b-toggle="'category-' + idx"
                                    variant="info"
                                    >{{ category.name }}</b-button
                                >
                            </b-card-header>
                            <b-collapse
                                :id="'category-' + idx"
                                visible
                                accordion="my-accordion"
                                role="tabpanel"
                            >
                                <b-card-body>
                                    <b-card-text>
                                        <b-form-checkbox-group
                                            v-model="selectedActs"
                                            stacked
                                            v-slot="{ ariaDescribedby }"
                                        >
                                            <b-form-checkbox
                                                v-for="(
                                                    act, index
                                                ) in category.acts"
                                                :key="index"
                                                :value="act"
                                                :aria-describedby="
                                                    ariaDescribedby
                                                "
                                                size="lg"
                                            >
                                                {{ act.nom }}</b-form-checkbox
                                            >
                                        </b-form-checkbox-group>
                                    </b-card-text>
                                </b-card-body>
                            </b-collapse>
                        </b-card>
                    </div>
                </b-col>
                <b-col>
                    <h5 class="text-center mb-1">Actes</h5>
                    <vue-instant
                        :suggestOnAllWords="true"
                        :suggestion-attribute="suggestionAttribute"
                        v-model="value"
                        :disabled="false"
                        @input="changed"
                        @click-input="clickInput"
                        @click-button="clickButton"
                        @selected="selected"
                        @enter="enter"
                        @key-up="keyUp"
                        @key-down="keyDown"
                        @key-right="keyRight"
                        @clear="clear"
                        @escape="escape"
                        :show-autocomplete="true"
                        :autofocus="false"
                        :suggestions="suggestions"
                        placeholder="Rechercher un acte..."
                        type="google"
                    ></vue-instant>
                    <button
                        class="btn btn-success float-right mt-1"
                        @click="addActs"
                    >
                        Ajouter
                    </button>
                    <b-form-group
                        class="mt-1"
                        label="Liste des actes à sélectionner :"
                        v-slot="{ ariaDescribedby }"
                    >
                        <b-form-checkbox-group v-model="validatedActs" stacked>
                            <b-form-checkbox
                                v-for="(act, index) in selectedActs"
                                :key="index"
                                :value="act"
                                :aria-describedby="ariaDescribedby"
                            >
                                {{ act.nom }}</b-form-checkbox
                            >
                        </b-form-checkbox-group>
                    </b-form-group>
                </b-col>
            </b-row>
            <template #modal-footer>
                <button
                    type="button"
                    class="btn btn-secondary"
                    @click="hideModal"
                >
                    Fermer
                </button>
                <button class="btn btn-success" @click="addActs">
                    Ajouter
                </button>
            </template>
        </b-modal>
    </div>
</template>

<script>
import Vue from "vue";
import VueInstant from "vue-instant";
import "vue-instant/dist/vue-instant.css";
Vue.use(VueInstant);
export default {

   
    props: [],
    components: {
        // VueInstant
    },
    data() {
        return {
            categories: new Array(),
            selectedActs: new Array(),
            validatedActs: new Array(),
            acts: new Array(),
            modal_id: null,
            btnDisabled: true,
            value: "",
            suggestionAttribute: "nom",
            suggestions: [],
            selectedEvent: "",
        };
    },
    methods: {
        clickInput() {
            this.selectedEvent = "click input";
        },
        clickButton() {
            this.selectedEvent = "click button";
        },
        selected() {
            this.selectedEvent = "selection changed";
            this.suggestions = [];
        },
        enter() {
            this.suggestions = [];
            this.selectedEvent = "enter";
        },
        keyUp() {
            this.selectedEvent = "keyup pressed";
        },
        keyDown() {
            this.selectedEvent = "keyDown pressed";
        },
        keyRight() {
            this.selectedEvent = "keyRight pressed";
        },
        clear() {
            this.selectedEvent = "clear input";
        },
        escape() {
            this.selectedEvent = "escape";
        },
        changed() {
            this.suggestions = [];
            this.acts.forEach((act) => {
                this.suggestions.push(act);
            });
        },
        hideModal() {
            this.$bvModal.hide(this.modal_id);
        },
        showModal() {
            this.$bvModal.show(this.modal_id);
        },
        getActs() {
            axios
                .get("/admin/category/get-categories-with-acts")
                .then((response) => {
                    this.categories = response.data;
                    this.categories.forEach((category) => {
                        category.acts.forEach((act) => {
                            this.acts.push(act);
                        });
                    });
                    this.$store.commit("affect", this.categories);
                })
                .catch((exception) => {
                    this.$toaster.error(exception);
                });
        },
        addActs() {
            this.$emit("select-acts");
            this.$bvModal.hide(this.modal_id);
        },
    },
    mounted() {
        this.modal_id = this._uid.toString();
        if (this.$store.state.globalCategories.length == 0) this.getActs();
        else this.categories = this.$store.state.globalCategories;
    },
};
</script>
