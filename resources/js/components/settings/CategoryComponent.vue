<template>
    <div>
        <div class="row mb-1">
            <div class="col-sm-9 h5">Categories</div>
            <div class="col-sm-3">
                <button
                    class="btn btn-primary mt-1 mb-1   pull-right"
                    v-b-modal="'category_modal'"
                >
                    Ajouter
                </button>
            </div>
        </div>

        <table class="mb-0 table">
            <thead>
                <tr>
                    <td>#</td>
                    <th>Nom</th>
                    <th>Code couleur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(val, index) in categories" :key="index">
                    <th>{{ index + 1 }}</th>
                    <td>{{ val.name }}</td>
                    <td
                        v-bind:style="{ color: val.color }"
                        style="font-weight : 700"
                    >
                        {{ val.color }}
                    </td>
                    <td>
                        <button
                            class="btn"
                            @click="update(val)"
                            title="Modifier"
                        >
                            <b-icon
                                icon="pencil-square"
                                class=""
                                scale="2"
                                variant="success"
                            ></b-icon>
                        </button>
                        <button
                            class="btn"
                            @click="removeCategory(val.id, index)"
                            title="Supprimer"
                        >
                            <b-icon
                                icon="trash"
                                class=""
                                scale="2"
                                variant="danger"
                            ></b-icon>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <b-modal
            ref="category_modal"
            id="category_modal"
            hide-footer
            title="Catégorie"
            size="sm"
            @hidden="hideModal"
        >
            <form
                @submit.stop.prevent="
                    editMode ? updateCategory() : createCategory()
                "
                enctype="multipart/form-data"
                autocomplete="off"
            >
                <input
                    autocomplete="off"
                    name="hidden"
                    type="text"
                    style="display:none;"
                />
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm-12">
                            <b-form-group class="font-weight-bold" label="Nom*">
                                <b-form-input
                                    v-model="form.name"
                                    type="text"
                                    required
                                    placeholder="Nom..."
                                ></b-form-input>
                                <div
                                    class="text-danger"
                                    v-if="form.errors.has('name')"
                                    v-html="form.errors.get('name')"
                                />
                            </b-form-group>
                        </div>
                        <div class="col-sm-12">
                            <b-form-group
                                class="font-weight-bold ml-1"
                                label="Couleur*"
                            >
                                <b-form-input
                                    v-model="form.color"
                                    type="color"
                                    required
                                ></b-form-input>
                            </b-form-group>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary  "
                        @click="hideModal"
                    >
                        Fermer
                    </button>
                    <input
                        :disabled="form.busy"
                        type="submit"
                        value="Ajouter"
                        class="btn btn-primary  "
                        v-if="!editMode"
                    />
                    <input
                        :disabled="form.busy"
                        type="submit"
                        value="Modifier"
                        class="btn btn-success  "
                        v-else
                    />
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
// import ColourPicker from "vue-colour-picker";
export default {
    name: "CategoryComponent",
    components: {
        // "colour-picker": ColourPicker
    },
    props: [],
    data() {
        return {
            colour: "red",
            editMode: false,
            categories: [],
            id: "",
            form: new Form({
                name: "",
                color: ""
            })
        };
    },
    methods: {
        hideModal() {
            this.editMode = false;
            this.form.reset();
            this.$bvModal.hide("category_modal");
        },
        createCategory() {
            axios
                .post("/admin/category", this.form) // Send Ordonnance to server
                .then(response => {
                    this.categories.push(response.data);

                    this.hideModal();
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
        },
        removeCategory(id, index) {
            if (
                confirm(
                    "ATTENTION ! La suppression de la catégorie va aussi supprimer les actes qui sont assigner à cette catégorie"
                )
            ) {
                axios
                    .delete("/admin/category/" + id)
                    .then(response => {
                        this.categories.splice(index, 1);
                    })
                    .catch(exception => {
                        this.$toaster.error(exception);
                    });
            }
        },

        update(act) {
            this.form.reset();
            this.editMode = true;
            this.form.fill(act);
            this.id = act.id;
            this.$bvModal.show("category_modal");
        },

        updateCategory() {
            let categories = this.categories;
            axios
                .put("/admin/category/" + this.id, this.form)
                .then(response => {
                    categories.forEach((val, idx) => {
                        if (val.id == response.data.id)
                            categories[idx] = response.data;
                    });
                    this.hideModal();
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
        }
    },
    watch: {
        // form: {
        //     handler: function(val) {
        //         this.$refs.colorPicker.setColor(val.color);
        //     },
        //     deep: true
        // }
    },
    mounted() {
        axios
            .get("/admin/category")
            .then(response => {
                this.categories = response.data;
            })
            .catch(exception => {
                this.$toaster.error(exception);
            });
    }
};
</script>
