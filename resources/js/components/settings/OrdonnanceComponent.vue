<template>
    <div>
        <div class="row mb-1">
            <div class="col-sm-9 h5">Ordonnances type</div>
            <div class="col-sm-3">
                <button
                    class="btn btn-primary mt-1 mb-1   pull-right"
                    v-b-modal="'prescription_modal'"
                >
                    Ajouter
                </button>
            </div>
        </div>

        <table class="mb-0 table">
            <thead>
                <tr>
                    <td>#</td>
                    <th>Ordonnance</th>
                    <th>Médicaments</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(val, index) in ordonnances" :key="index">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ val.nom }}</td>
                    <td>{{ val.imploded }}</td>
                    <td>
                        <button
                            class="btn"
                            @click="update(val.id)"
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
                            @click="removeOrdonnance(val.id, index)"
                            title="Supprimer"
                        >
                            <b-icon
                                icon="trash"
                                class="rounded"
                                scale="2"
                                variant="danger"
                            ></b-icon>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <b-modal
            ref="prescription_modal"
            id="prescription_modal"
            hide-footer
            title="Ordonnance Type"
            size="xl"
            @hidden="hideModal"
        >
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-7">
                        <!-- Formulaire  -->
                        <b-form>
                            <b-form-group
                                label="Nom:"
                                label-for="input-1"
                                class="font-weight-bold"
                            >
                                <b-form-input
                                    class=" "
                                    id="input-1"
                                    v-model="ordonnance.nom"
                                    type="text"
                                    placeholder="Donnez un nom à l'odonnance type"
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group
                                label="Médicament:"
                                :description="medicament.medicament"
                                label-for="input-2"
                                class="font-weight-bold"
                            >
                                <autocomplete
                                    ref="autocomplete"
                                    placeholder="Renseigner un médicament"
                                    :source="search"
                                    input-class="form-control  "
                                    results-property="data"
                                    :results-display="formattedDisplay"
                                    resultsValue="id"
                                    @selected="addDistributionGroup"
                                ></autocomplete>
                            </b-form-group>
                            <b-form-group
                                label="Nombre de prises:"
                                label-for="input-3"
                                class="font-weight-bold"
                            >
                                <b-form-input
                                    class=" "
                                    id="input-3"
                                    v-model="medicament.nb_prise"
                                    type="number"
                                    placeholder="Ex : 2"
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group
                                label="Pendant:"
                                label-for="input-4"
                                class="font-weight-bold"
                            >
                                <b-form-input
                                    class=" "
                                    id="input-4"
                                    v-model="medicament.frequence"
                                    type="number"
                                    placeholder="Ex : 10"
                                ></b-form-input>
                            </b-form-group>

                            <div>
                                <b-form-textarea
                                    class=" "
                                    v-model="textPreview"
                                    placeholder="Ici l'affichage de l'odonnance...."
                                    rows="3"
                                    max-rows="6"
                                ></b-form-textarea>
                            </div>
                            <div class="float-right mt-2">
                                <input
                                    type="button"
                                    value="Ajouter"
                                    class="btn btn-primary  "
                                    @click="addToList"
                                    v-if="!editItem"
                                />
                                <input
                                    type="button"
                                    value="Modifier"
                                    class="btn btn-success  "
                                    @click="updatedItem"
                                    v-else
                                />
                            </div>
                        </b-form>
                    </div>

                    <div class="col-xs-12 col-sm-5">
                        <!-- Liste des médicaments -->
                        <b-list-group>
                            <b-list-group-item
                                v-if="ordonnance.medicaments.length > 0"
                                v-for="(val, index) in ordonnance.medicaments"
                                :key="index"
                                class=" "
                            >
                                <span v-html="val.preview"></span>
                                <input
                                    class="btn btn-sm btn-success    update"
                                    type="button"
                                    value="Modifier"
                                    @click="updateItem(index)"
                                />
                                <input
                                    class="btn btn-sm btn-danger    delete"
                                    type="button"
                                    value="Supprimer"
                                    @click="removeItem(index)"
                                />
                            </b-list-group-item>

                            <div
                                class="alert alert-info d-flex justify-content-center"
                                v-else
                            >
                                Aucun médicament ajouté
                            </div>
                        </b-list-group>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    type="reset"
                    class="btn btn-secondary  "
                    @click="hideModal"
                >
                    Fermer
                </button>
                <input
                    type="button"
                    value="Valider"
                    class="btn btn-success  "
                    @click="storeOrdonnanceType"
                    v-if="!editMode"
                />
                <input
                    type="button"
                    value="Modifier"
                    class="btn btn-success  "
                    @click="updateOrdonnanceType"
                    v-else
                />
            </div>
        </b-modal>
    </div>
</template>

<script>
import Autocomplete from "vuejs-auto-complete";
export default {
    components: {
        Autocomplete
    },
    props: [],
    data() {
        return {
            editMode: false,
            editItem: false,
            ordonnances: [],
            medicament: {
                medicament: null,
                medicament_id: null,
                forme: null,
                nb_prise: null,
                frequence: null,
                preview: null
            },
            id: "",
            ordonnance: {
                nom: "Ordonnance sans nom",
                medicaments: []
            },
            indexToUpdate: null,
            textPreview: null
        };
    },
    watch: {
        medicament: {
            handler(newVal) {
                if (Object.keys(this.medicament).length === 0) return 0;
                return (this.textPreview = `${this.medicament.medicament} qsp (pendant ${this.medicament.frequence} jours). ${this.medicament.nb_prise} ${this.medicament.forme}/jour `);
            },
            deep: true
        }
    },
    methods: {
        hideModal() {
            this.$bvModal.hide("prescription_modal");
            this.editMode = false;
            this.ordonnance.medicaments = "";
        },
        search(input) {
            return "/medicament/" + input;
        },

        addDistributionGroup(medicament) {
            this.medicament.medicament = medicament.display.toLowerCase(); // Doliprane 500mg....
            this.medicament.medicament_id =
                medicament.selectedObject.sp_code_sq_pk; // 152
            this.medicament.forme = medicament.selectedObject.unite_nom.toLowerCase();

            // access the autocomplete component methods from the parent
            //this.$refs.autocomplete.clear();
        },

        formattedDisplay(result) {
            return result.sp_nom;
        },
        // remove medicament from table
        removeItem(index) {
            this.ordonnance.medicaments.splice(index, 1);
        },
        updateItem(index) {
            this.medicament = this.ordonnance.medicaments[index];

            this.editItem = true;

            this.indexToUpdate = index;
        },
        updatedItem() {
            this.ordonnance.medicaments[
                this.indexToUpdate
            ] = this.getJsonMedicament();

            this.editItem = false;

            this.onReset();
        },
        showModal() {
            this.$bvModal.show("prescription_modal");
        },
        addToList() {
            this.ordonnance.medicaments.push(this.getJsonMedicament());

            // Reset Forms
            this.onReset();
        },
        getJsonMedicament() {
            const formatedTextPreview = this.formatTextPreview();
            return {
                medicament: this.medicament.medicament,
                medicament_id: this.medicament.medicament_id,
                forme: this.medicament.forme,
                nb_prise: this.medicament.nb_prise,
                frequence: this.medicament.frequence,
                preview: formatedTextPreview
            };
        },

        formatTextPreview() {
            let previewToFormat = this.textPreview;

            // format the fiexed elements
            previewToFormat.replace(
                this.medicament.medicament,
                "<b>" + this.medicament.medicament + "</b>"
            );
            previewToFormat.replace(
                this.medicament.frequence,
                "<b>" + this.medicament.frequence + "</b>"
            );
            previewToFormat.replace(
                this.medicament.nb_prise + " " + this.medicament.forme,
                "<b>" +
                    this.medicament.nb_prise +
                    " " +
                    this.medicament.forme +
                    "</b>"
            );

            return previewToFormat;
        },
        onReset() {
            this.medicament.medicament = "";
            this.medicament.medicament_id = "";
            this.medicament.frequence = "";
            this.medicament.nb_prise = "";
            this.medicament.preview = "";
        },
        storeOrdonnanceType() {
            // Sent Ordonnance to the Server
            const data = this.ordonnance;
            axios
                .post("/admin/ordonnance-type", data) // Send Ordonnance to server
                .then(response => {
                    //add Ordonnance to list
                    this.fetchOrdonnancesType();

                    //Reset Forms
                    this.onReset();
                    // Reset Ordonnance type Object

                    this.$bvModal.hide("prescription_modal");

                    this.$toaster.success("Ordonnance ajoutée !");
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
        },
        removeOrdonnance(id, index) {
            if (confirm("Vous confirmer la suppression de l'ordonnance type ?"))
                axios
                    .delete("/admin/ordonnance-type/" + id)
                    .then(response => {
                        this.ordonnances.splice(index, 1);
                    })
                    .catch(exception => {
                        this.$toaster.error(exception);
                    });
        },

        update(ordonnance_id) {
            this.id = ordonnance_id;
            axios
                .get("/admin/ordonnance-type/" + ordonnance_id)
                .then(response => {
                    this.ordonnance = response.data;
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
            this.showModal();

            this.editMode = true;
        },

        updateOrdonnanceType() {
            const data = this.ordonnance;
            axios
                .put("/admin/ordonnance-type/" + this.id, data)
                .then(response => {
                    this.fetchOrdonnancesType();

                    this.$bvModal.hide("prescription_modal");

                    this.editMode = false;

                    this.$toaster.success(response.data.success);
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
        },
        fetchOrdonnancesType() {
            axios
                .get("/admin/ordonnance-type")
                .then(response => {
                    this.ordonnances = response.data;
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
        }
    },
    mounted() {

        this.fetchOrdonnancesType();
    }
};
</script>

<style scoped>
.list-group-item input {
    position: absolute;
    display: none;
}

.list-group-item input.update {
    top: 25%;
    left: 55%;
}
.list-group-item input.delete {
    top: 25%;
    left: 35%;
}
.list-group-item:hover {
    background-color: rgba(0, 0, 0, 0.1803921568627451);
}
.list-group-item:hover input {
    display: block;
}
</style>
