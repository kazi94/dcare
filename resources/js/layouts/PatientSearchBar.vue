<template>
    <div>
        <div class="mr-2">
            <div class="">
                <div class="">
                    <vue-instant
                        :suggestOnAllWords="false"
                        :suggestion-attribute="suggestionAttribute"
                        v-model="value"
                        :disabled="false"
                        @input="changed"
                        @click-input="clickInput"
                        @click-button="clickButton"
                        @enter="enter"
                        @key-up="keyUp"
                        @key-down="keyDown"
                        @key-right="keyRight"
                        @clear="clear"
                        @escape="escape"
                        :show-autocomplete="true"
                        :autofocus="false"
                        :suggestions="suggestions"
                        placeholder="Rechercher un patient..."
                        type="google"
                    ></vue-instant>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// import Autocomplete from "vuejs-auto-complete";
// import "../assets/architect/main.js";
import Vue from "vue";
import VueInstant from "vue-instant";
import "vue-instant/dist/vue-instant.css";
Vue.use(VueInstant);
export default {
    components: {
        // Autocomplete,
    },
    data() {
        return {
            suggestionAttribute: "fullName",
            suggestions: [],
            selectedEvent: "",
            value: ""
        };
    },
    methods: {
        clickInput() {
            this.selectedEvent = "click input";
            //console.log("click input: ");
        },
        clickButton() {
            this.selectedEvent = "click button";
            //console.log("click button: ");
            const patient = this.suggestions.filter(
                s => s.fullName === this.value
            );

            if (patient.length > 0) {
                const patientID = patient[0].id;
                this.$router.push({
                    name: "patient",
                    params: { id: patientID }
                });
                this.value = "";
                this.suggestions = [];
            }
        },
        selected() {
            this.selectedEvent = "selected";
            //console.log("selected");
            const patient = this.suggestions.filter(
                s => s.fullName === this.value
            );

            // if (patient.length > 0) {
            const patientID = patient[0].id;
            this.$router.push({
                name: "patient",
                params: { id: patientID }
            });
            this.value = "";
            this.suggestions = [];
            // }
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
        changed: function() {
            this.selectedEvent = "changed";
            //console.log("changed: ");
            var that = this;
            // that.suggestions = [];
            axios
                .get("/api/patients/search/" + this.value)
                .then(function(response) {
                    if (response.data)
                        response.data.forEach(function(a) {
                            that.suggestions.push(
                                Object.assign(a, {
                                    fullName: a.nom + " " + a.prenom
                                })
                                // fullName:`<router-link :to="{ name : 'patient' , params : { 'id' : ${a.id} } }" class='decoration-none'> ${a.nom} ${a.prenom}</router-link>`,
                            );
                        });
                });
        }
    },
    watch: {
        // value: function(newValue, oldValue) {
        //     const searchAct = newValue;
        //     this.acts.forEach(act => {
        //         if (act.nom == searchAct) {
        //             // check if searched act don't exist in selected acts array
        //             if (!this.selectedActs.some(act => act.nom == searchAct))
        //                 this.selectedActs.push(act);
        //         }
        //     });
        // }
    },
    mounted() {}
};
</script>

<style lang="css">
form.searchbox.sbx-google {
    width: 300px;
}
</style>
