<template>
    <div>
        <div class="row">
            <div class="col-md-8 card card-body">
                <schema-component
                    :selectedTooth="selectedTeeth"
                    :isToothVisible="false"
                    ref="initial_schema"
                ></schema-component>
            </div>
            <div class="col-md-4">
                <b-card>
                    <h4>Etat initial</h4>
                    <b-button
                        v-for="(btn, idx) in buttons"
                        :key="idx"
                        :pressed.sync="btn.state"
                        @click="detachFormula(btn)"
                        class="mr-3 mb-3"
                        variant="outline-info"
                        >{{ btn.nom }}</b-button
                    >
                    <button
                        class="btn btn-success btn-block"
                        @click="sendToServer"
                        :disabled="btnDisabled"
                    >
                        Ajouter la(les) formule(s) au schéma
                    </button>
                </b-card>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from "vue";
import SchemaComponent from "@/Components/Schema/SchemaComponent";
// Vue.use(require("vue-shortkey"), { prevent: ["input", "textarea"] });
export default {
    components: { SchemaComponent },
    props: ["patient", "user"],
    data() {
        return {
            btnDisabled: true,
            buttons: [
                { caption: "abs", nom: "Absente (a)", state: false },
                { caption: "obt", nom: "Obturée (o)", state: false },
                { caption: "d-mortif", nom: "Dent mortifiée", state: false },
                { caption: "kyste", nom: "Kyste", state: false },
                { caption: "couronne", nom: "Courônne", state: false },
                { caption: "carie-p", nom: "Carie prof.", state: false },
                { caption: "carie-pp", nom: "Carie sup.", state: false },
                { caption: "carie-d", nom: "Carie-D", state: false },
                { caption: "carie-m", nom: "Carie-M", state: false },
                {
                    caption: "rac-resid",
                    nom: "Racines résiduelles",
                    state: false
                },
                {
                    caption: "frac-rac",
                    nom: "Fracture racine (r)",
                    state: false
                },
                {
                    caption: "frac-cour",
                    nom: "Fracture couronne (c)",
                    state: false
                }
            ],
            selectedTeeth: [],
            schema_id: "",
            formData: [],
            form: new Form(),
            initSchemaData: []
        };
    },
    methods: {
        /**
         * Send list of selected tooth with the clikced formulas to the server
         */
        sendToServer() {
            let formules = this.buttons
                .filter(b => b.state)
                .map(b => b.caption);
            let form = this.createFormData(formules, this.selectedTeeth);

            axios
                .post("/patients/schema-dentaire", form)
                .then(response => {
                    const coords = response.data.coords;

                    // Set Schema ID
                    this.schema_id = response.data.schema_id;

                    // Create shapes
                    this.$refs.initial_schema.$refs.schema_layer.createShapes(
                        coords
                    );

                    // uncheck the selected teeth from the schema
                    this.$refs.initial_schema.$refs.schema_layer.resetSVG();

                    // empty selected teeth
                    this.selectedTeeth = [];

                    // update init schema data
                    this.initSchemaData = [...this.initSchemaData, ...coords];

                    // reset formules buttons
                    this.buttons.map(b => (b.state = false));

                    // emit updates to devis and plan schema
                    this.$emit("initial-formulas-drawed", coords);
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
        },
        /**
         * Detach formula from the selected tooth
         */
        detachFormula(btn) {
            if (!btn.state) {
                axios
                    .delete("/patients/schema-dentaire/" + this.schema_id, {
                        data: {
                            formula: btn.caption,
                            tooth: JSON.stringify(this.selectedTeeth)
                        }
                    })
                    .then(response => {
                        // uncheck the selected teeth from the schema
                        this.$refs.initial_schema.$refs.schema_layer.removeShapesByTeeth(
                            this.selectedTeeth,
                            btn.caption
                        );

                        // remove formula assoc to selected teeth from initial schema data
                        this.initSchemaData = this.initSchemaData.filter(
                            data =>
                                data.formulas != btn.caption ||
                                !this.selectedTeeth.includes(data.teeth)
                        );

                        // uncheck the selected teeth from the schema
                        this.$refs.initial_schema.$refs.schema_layer.resetSVG();

                        // emit updates to devis and plan schema
                        this.$emit("initial-formula-removed", {
                            teeth: this.selectedTeeth,
                            formula: btn.caption
                        });
                        // empty selected teeth
                        this.selectedTeeth = [];
                    })
                    .catch(exception => {
                        if (exception.response)
                            this.$toaster.error(exception.response.data);
                        else this.$toaster.error(exception);
                    });
            }
        },

        createFormData: function(formula, tooth) {
            let formData = new FormData();
            formData.append("tooth", JSON.stringify(tooth));
            formData.append("formula", JSON.stringify(formula)); //array
            formData.append("patient_id", this.patient.id);
            formData.append("schema_id", this.schema_id);
            formData.append("type", "initial");
            return formData;
        },
        /**
         * Listen to keyboard shortcut for:
         * Dent obturer , absente, couronne, and racine
         * @param
         */
        // onKeyDown(e) {
        //     if (!this.selectedTeeth.length) {
        //         this.$toaster.error("Veuillez sélectionner une dent!");
        //         return;
        //     }
        //     var state = true;
        //     switch (e.key) {
        //         case "a": // 'a' key
        //             // Handle for the keyboard shortcut of 'Absente' teeth
        //             this.buttons.forEach(formulaBtn => {
        //                 if (formulaBtn.caption == "abs") {
        //                     state = formulaBtn.state;
        //                     formulaBtn.state = !state;
        //                 }
        //             });
        //             this.sendToServer("abs", !state);
        //             break;
        //         case "o": // 'o' key
        //             // Handle for the keyboard shortcut of 'Obturer' teeth
        //             this.buttons.forEach(formulaBtn => {
        //                 if (formulaBtn.caption == "obt") {
        //                     state = formulaBtn.state;
        //                     formulaBtn.state = !state;
        //                 }
        //             });
        //             this.sendToServer("obt", !state);
        //             break;
        //         case "c": // 'c' key
        //             // Handle for the keyboard shortcut of 'Couronne' teeth
        //             this.buttons.forEach(formulaBtn => {
        //                 if (formulaBtn.caption == "frac-cour") {
        //                     state = formulaBtn.state;
        //                     formulaBtn.state = !state;
        //                 }
        //             });
        //             this.sendToServer("frac-cour", !state);
        //             break;
        //         case "r": // 'r' key
        //             //Handle for the keyboard shortcut of 'Racine' teeth
        //             this.buttons.forEach(formulaBtn => {
        //                 if (formulaBtn.caption == "frac-rac") {
        //                     state = formulaBtn.state;
        //                     formulaBtn.state = !state;
        //                 }
        //             });
        //             this.sendToServer("frac-rac", !state);
        //             break;
        //     }
        //     //TODO Handle keyboards tape when it pressed 2nd time
        // },
        displayInitialSchema(coords) {
            coords.forEach(coord => {
                this.$refs.initial_schema.$refs.schema_layer.actShapes.push(
                    coord
                );
            });
        }
    },
    watch: {
        buttons: {
            handler: function(buttons) {
                this.btnDisabled = buttons.some(button => button.state == true)
                    ? false
                    : true;
            },
            deep: true
        },

        selectedTeeth: {
            /**
             * @description When the teeth is check we get the formulas from server
             * get all the selected tooth and send to the server
             * if no teeth is check then uncheck all formulas
             */
            handler: function(newselectedTeeth) {
                this.buttons.map(formula => {
                    formula.state = false;
                });
                if (newselectedTeeth.length != 0) {
                    this.initSchemaData.forEach(data => {
                        const formule = data.formulas;

                        // iterate into each selected teeth
                        newselectedTeeth.forEach(tooth => {
                            // foreach selected tooth, check if it exist on stored data
                            if (tooth == data.teeth) {
                                // if exists, check the associate formula buttons
                                this.buttons.map(b =>
                                    b.caption == formule ? (b.state = true) : ""
                                );
                            }
                        });
                    });
                }
            },
            deep: true
        }
    },
    mounted() {
        if (
            this.patient.initial_schema != undefined &&
            this.patient.initial_schema.traitements != undefined
        ) {
            this.initSchemaData = this.patient.initial_schema.traitements;
            this.displayInitialSchema(this.patient.initial_schema.traitements);
            this.schema_id = this.patient.initial_schema.id;
        }
        // register keydown event to vue object
        // this.onKeyDown = this.onKeyDown.bind(this);
        // document.addEventListener("keydown", this.onKeyDown);
    }
};
</script>

<style>
#btn-container {
    background-color: #e0e0e0;
    display: inline-block;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    width: 708px;
    margin-left: -3px;
}
</style>
