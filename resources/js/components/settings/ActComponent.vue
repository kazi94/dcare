<template>
    <div>
        <div class="row mb-1">
            <div class="col-sm-9 h5">Liste des actes dentaires</div>
            <div class="col-sm-3">
                <button
                    class="btn btn-primary mt-1 mb-1 pull-right"
                    v-b-modal="'act_modal'"
                >
                    Ajouter
                </button>
            </div>
        </div>
        <b-col lg="6" class="my-1">
            <b-form-group
                label="Filtrer"
                label-cols-sm="3"
                label-align-sm="right"
                label-size="sm"
                label-for="filterInput"
                class="mb-0"
            >
                <b-input-group size="sm">
                    <b-form-input
                        v-model="filter"
                        type="search"
                        id="filterInput"
                        placeholder="Rechercher un acte dentaire"
                    ></b-form-input>
                    <b-input-group-append>
                        <b-button :disabled="!filter" @click="filter = ''"
                            >Annuler</b-button
                        >
                    </b-input-group-append>
                </b-input-group>
            </b-form-group>
        </b-col>
        <b-table
            striped
            hover
            :items="acts"
            :fields="fields"
            foot-clone
            responsive="sm"
            :per-page="perPage"
            :current-page="currentPage"
            :busy.sync="isBusy"
            caption-top
            :filter="filter"
            :filterIncludedFields="filterOn"
            @filtered="onFiltered"
        >
            <template #table-caption
                >Vous avez au total: {{ rows }} actes.</template
            >
            <template #table-busy>
                <div class="text-center text-primary my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Chargement...</strong>
                </div>
            </template>
            <template #cell(index)="{ item }">
                {{ acts.indexOf(item) + 1 }}
            </template>
            <template #cell(category)="data">
                {{ data.item.category.name }}
            </template>
            <template v-slot:cell(actions)="data">
                <button
                    class="btn"
                    @click="updateModal(data.item)"
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
                    @click="removeAct(data.item.id, data.index)"
                    title="Supprimer"
                >
                    <b-icon
                        icon="trash"
                        class=""
                        scale="2"
                        variant="danger"
                    ></b-icon>
                </button>
            </template>
        </b-table>
        <b-pagination
            pills
            align="center"
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            aria-controls="my-table"
        ></b-pagination>

        <b-modal
            ref="act_modal"
            id="act_modal"
            hide-footer
            title="Nouvel Acte"
            size="xl"
            @hidden="hideModal"
            :static="true"
        >
            <form
                @submit.stop.prevent="editMode ? updateAct() : createAct()"
                enctype="multipart/form-data"
                autocomplete="off"
            >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="">
                                <b-form-group
                                    class="font-weight-bold"
                                    label="Nom d'Acte :"
                                >
                                    <b-form-input
                                        v-model="form.nom"
                                        type="text"
                                        required
                                        placeholder="Ex: Traitement Endodentique"
                                    ></b-form-input>
                                    <div
                                        class="text-danger"
                                        v-if="form.errors.has('nom')"
                                        v-html="form.errors.get('nom')"
                                    />
                                </b-form-group>
                                <b-form-group
                                    class="font-weight-bold"
                                    label="Code CNAS :"
                                >
                                    <b-form-input
                                        v-model="form.code_cnas"
                                        type="text"
                                        placeholder="Codification Cnas..."
                                    ></b-form-input>
                                    <div
                                        class="text-danger"
                                        v-if="form.errors.has('code_cnas')"
                                        v-html="form.errors.get('code_cnas')"
                                    />
                                </b-form-group>
                                <b-form-group
                                    class="font-weight-bold"
                                    label="Famille :"
                                >
                                    <b-form-select
                                        v-model="form.category"
                                        required
                                        ><b-form-select-option
                                            v-for="(category,
                                            idx) in categories"
                                            :key="idx"
                                            :value="category.id"
                                            selected
                                            >{{
                                                category.name
                                            }}</b-form-select-option
                                        >
                                    </b-form-select>
                                    <div
                                        class="text-danger"
                                        v-if="form.errors.has('category')"
                                        v-html="form.errors.get('category')"
                                    />
                                </b-form-group>
                                <b-form-group
                                    class="font-weight-bold"
                                    label="Type d'Acte :"
                                >
                                    <b-form-select v-model="form.type" required>
                                        <b-form-select-option
                                            value="teeth"
                                            selected
                                            >Dent</b-form-select-option
                                        >
                                        <b-form-select-option value="sector"
                                            >Secteur</b-form-select-option
                                        >
                                        <b-form-select-option value="mouth"
                                            >Bouche</b-form-select-option
                                        >
                                    </b-form-select>
                                    <div
                                        class="text-danger"
                                        v-if="form.errors.has('type')"
                                        v-html="form.errors.get('type')"
                                    />
                                </b-form-group>
                                <b-form-group
                                    class="font-weight-bold"
                                    label="Raccourci :"
                                >
                                    <b-form-input
                                        v-model="form.shortcut"
                                        type="text"
                                        placeholder="Raccourci clavier..."
                                        maxlength="7"
                                    ></b-form-input>
                                    <div
                                        class="text-danger"
                                        v-if="form.errors.has('shortcut')"
                                        v-html="form.errors.get('shortcut')"
                                    />
                                </b-form-group>
                                <b-form-group
                                    class="font-weight-bold"
                                    label="Prix(DA) :"
                                >
                                    <b-form-input
                                        v-model="form.price"
                                        type="number"
                                        placeholder="Ex: 1000 DA"
                                        required
                                        min="100"
                                    ></b-form-input>
                                    <div
                                        class="text-danger"
                                        v-if="form.errors.has('price')"
                                        v-html="form.errors.get('price')"
                                    />
                                </b-form-group>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="text-center font-weight-bold">
                                Formes Dentaire
                            </h4>
                            <div
                                id="forms-container"
                                class="justify-content-around row"
                                onload="formsLoaded"
                            >
                                <div
                                    class="form-container"
                                    style="position: relative"
                                    v-for="idx in 11"
                                    :key="idx"
                                >
                                    <div class="form__input">
                                        <v-swatches
                                            v-model="colors[idx]"
                                            popover-x="left"
                                            swatches="text-advanced"
                                        ></v-swatches>
                                    </div>
                                    <div
                                        class="d-inline-flex"
                                        :id="'form-container-' + idx"
                                    >
                                        <img src="/img/teeth.png" />
                                    </div>
                                </div>
                            </div>

                            <h4 class="mt-4 text-center font-weight-bold">
                                Aperçu
                            </h4>
                            <div class="row justify-content-center">
                                <img
                                    src="/img/teeth.png"
                                    alt="Forme de l'acte dentaire"
                                />
                                <svg
                                    id="schema_act"
                                    style="position: absolute"
                                    xmlns="http://www.w3.org/2000/svg"
                                    version="1.1"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="45"
                                    height="143"
                                />
                            </div>

                            <div
                                class="
                                    font-weight-bold
                                    h5
                                    text-center text-danger
                                "
                                v-if="form.errors.has('formes')"
                                v-html="form.errors.get('formes')"
                            />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        @click="hideModal"
                    >
                        Fermer
                    </button>
                    <input
                        :disabled="form.busy"
                        type="submit"
                        value="Ajouter"
                        class="btn btn-primary"
                        v-if="!editMode"
                    />
                    <input
                        :disabled="form.busy"
                        type="submit"
                        value="Modifier"
                        class="btn btn-success"
                        v-else
                    />
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
import { SVG } from "@svgdotjs/svg.js";
import VSwatches from "vue-swatches";

// Import the styles too, typically in App.vue or main.js
import "vue-swatches/dist/vue-swatches.css";
export default {
    components: {
        VSwatches
    },
    props: [],
    data() {
        return {
            fields: [
                { key: "code_cnas", label: "Num", sortable: true },
                { key: "nom", label: "Nom", sortable: true },
                { key: "type", label: "Type", sortable: true },
                { key: "category", label: "Catégorie", sortable: true },
                { key: "shortcut", label: "Raccourci clavier", sortable: true },
                { key: "price", label: "Prix" },
                "actions"
            ],
            filter: null,
            filterOn: [],
            perPage: 10,
            currentPage: 1,
            isBusy: false,
            editMode: false,
            acts: [],
            categories: [],
            basicForms: [],
            id: "",
            form: new Form({
                code_cnas: "",
                nom: "",
                category: "",
                type: "teeth",
                shortcut: "",
                price: "",
                formes: []
            }),
            selected: "",
            colors: [
                "#1CA085",
                "#1CA085",
                "#1CA085",
                "#1CA085",
                "#1CA085",
                "#1CA085",
                "#1CA085",
                "#1CA085",
                "#1CA085",
                "#1CA085",
                "#1CA085",
                "#1CA085"
            ]
        };
    },
    methods: {
        /**
         * Handle the filtered rows
         */
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        hideModal() {
            this.editMode = false;
            this.form.reset();
            this.$bvModal.hide("act_modal");
            SVG("#schema_act").clear();
        },
        /**
         * Create Array of objects of the chooses Formes
         * @returns {Array} List of selected Formes (formulas , color)
         */
        generateFormes() {
            let svg = SVG("#schema_act");
            let forms_arr = [];
            // loop through svg elements
            var that = this;
            svg.children().forEach((child, i) => {
                // child.forEach(child => {
                forms_arr.push({
                    formulas: child.attr("formulas"),
                    color: child.attr("fill")
                });
                // });
            });

            return forms_arr;
        },
        /**
         * @description submit act to the SERVER
         */
        async createAct() {
            // Generate Array of selectioned formes
            let finaleFormes = this.generateFormes();

            // Append to our form
            this.form.formes = finaleFormes;

            // Send Act to The SERVER
            const response = await this.form.post("/admin/act");

            this.acts.push(response.data);

            this.hideModal();

            this.$toaster.success("Nouvel acte créer avec succés !");
        },
        /**
         * @description remove act
         */
        removeAct(id, index) {
            if (confirm("Vous confirmer la suppression de l'acte ?"))
                axios
                    .delete("/admin/act/" + id)
                    .then(response => {
                        this.acts.splice(index, 1);
                    })
                    .catch(exception => {
                        this.$toaster.error(exception);
                    });
        },
        /**
         * @description on click on "Modifier" button
         * @param {Object} act
         */
        updateModal(act) {
            this.form.reset();
            this.editMode = true;
            this.form.fill({
                code_cnas: act.code_cnas,
                nom: act.nom,
                category: act.category.id,
                type: act.type,
                shortcut: act.shortcut,
                price: act.price
                // formes: act.formes
                //     .map(coord => {
                //         return {
                //             formulas: coord.formulas,
                //             color: coord.pivot.color
                //         };
                //     })
                //     .filter(
                //         (v, i, a) =>
                //             a.findIndex(t => t.formulas === v.formulas) === i
                //     )
            });
            this.id = act.id;
            this.$bvModal.show("act_modal");
        },

        async updateAct() {
            // Generate Array of selectioned formes
            let finaleFormes = this.generateFormes();

            // Append to our form
            this.form.formes = finaleFormes;

            // Send Act to The SERVER
            const response = await this.form.put("/admin/act/" + this.id);

            this.acts.forEach((index, val) => {
                if (val.id == response.data.id)
                    this.acts[index] = response.data;
            });
            this.hideModal();

            this.$toaster.success("Acte modifier avec succés !");
        },
        /**
         * Draw Shapes on Dental Schema
         * @param {Array} coords list of lines with coord Object on each line
         */
        createShapes() {
            let coords = this.basicForms;
            var that = this;
            coords.forEach((c, idx) => {
                var element = document.getElementById(
                    "form-container-" + ++idx
                );
                element.setAttribute("formulas", c.formulas);
                // Create SVG DOM CONTAINER
                let initDraw = SVG()
                    .addTo(element)
                    .size(42, 143)
                    .css({
                        position: "absolute"
                    });

                let convertTo = this.convertCoord(c.coord);

                let shape = this.drawShape(
                    initDraw,
                    convertTo,
                    c.formulas,
                    idx
                );

                shape.on("click", function() {
                    const color = this.attr("fill");
                    const points = this.attr("points");
                    const formulas = this.attr("formulas");
                    const polygonID = this.attr("polygon-id");
                    let draw = SVG("#schema_act");
                    if (color == "#07bfff") {
                        // unselect
                        draw.each(function(i, children) {
                            if (this.attr("formulas") == formulas)
                                this.remove();
                        });
                        this.fill({
                            color: "#000",
                            opacity: 1
                        });
                    } else {
                        // select
                        let convertTo = [];
                        if (points == undefined) {
                            let shape = that.drawShape(
                                draw,
                                [this.attr("r"), this.cx(), this.cy()],
                                formulas,
                                polygonID
                            );
                        } else {
                            convertTo = that.convertCoord(points);
                            let shape = that.drawShape(
                                draw,
                                convertTo,
                                formulas,
                                polygonID
                            );
                        }

                        this.fill({ color: "#07bfff", opacity: 1 }).stroke({
                            width: 2
                        });
                    }
                });
            });
        },
        drawShape(initDraw, coords, formulas, idx) {
            let polygonID;
            if (formulas == "kyste") {
                polygonID = initDraw.circle(coords[2] * 2).fill("black");
            } else {
                polygonID = initDraw
                    .polygon(coords.toString())
                    .fill("black")
                    .stroke({ width: 1 });
            }
            // Set attributes to our created shape
            polygonID.attr("formulas", formulas);
            polygonID.attr("polygon-id", idx);

            return polygonID;
        },
        convertCoord(coord) {
            return coord.split(",");
        },

        formsLoaded(e) {
            console.log("e :>> ", e);
        }
    },
    watch: {
        colors: function(newColors) {
            let draw = SVG("#schema_act");
            console.log("New Colors : ", newColors);
            newColors.forEach((newColor, key) => {
                if (newColor) {
                    console.log(" New color %s : %s", key, newColor);
                    draw.children().forEach((child, i) => {
                        if (child.attr("polygon-id") == key) {
                            console.log(
                                " Form Matcheed : %s",
                                child.attr("formulas")
                            );
                            child.fill({ color: newColor });
                        }
                    });
                }
            });
        }
    },
    computed: {
        rows() {
            return this.acts.length;
        }
    },
    mounted() {
        // this.$bvModal.show("act_modal");
        axios
            .get("/admin/act")
            .then(response => {
                this.acts = response.data;
            })
            .catch(exception => {
                this.$toaster.error(exception);
            });
        axios
            .get("/admin/act/get_categories")
            .then(response => {
                this.categories = response.data;
                this.form.category = this.categories[0].id;
            })
            .catch(exception => {
                this.$toaster.error(exception);
            });
        axios
            .get("/schema/get-basic-forms")
            .then(response => {
                this.basicForms = response.data;
                this.createShapes();
            })
            .catch(exception => {
                // this.$toaster.error(exception);
            });
    }
};
</script>
<style scoped>
.custom-ui-class {
    width: 348px;
    height: 320px;
    margin-left: auto;
    margin-right: auto;
}
</style>
