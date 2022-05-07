<template>
    <div>
        <button
            v-if="patientTable"
            v-b-modal.modal_patient
            href="javascript:void(0);"
            class="btn btn-primary"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Ajouter un nouveau patient"
        >
            <i class="bg-white fa fa-plus icon-gradient bg-primary"> </i>
            Patient
        </button>
        <a
            v-else
            v-b-modal.modal_patient
            href="javascript:void(0);"
            class="nav-link"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Ajouter un nouveau patient"
        >
            <i class="nav-link-icon fa fa-plus icon-gradient bg-primary"> </i>
            Patient
        </a>
        <b-modal
            id="modal_patient"
            :title="title"
            size="xl"
            :hideFooter="hideFooter"
            :header-bg-variant="editMode ? 'success' : 'primary'"
            header-text-variant="white"
        >
            <form
                id="myPatientForm"
                @submit.prevent="editMode ? updatePatient() : addPatient()"
                enctype="multipart/form-data"
            >
                <input type="hidden" name="_token" :value="csrf" />
                <input v-model="form._method" type="hidden" />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="main-card card">
                            <div class="card-body">
                                <h5 class="h5 card-title">
                                    Informations Personnels
                                </h5>
                                <div class="form-row">
                                    <div class="col-sm-6 mt-2">
                                        <label
                                            class="font-weight-bold"
                                            for="nom"
                                            >Nom
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="nom"
                                            placeholder="Nom du patient..."
                                            required
                                            name="nom"
                                            v-model="form.nom"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'nom'
                                                )
                                            }"
                                            v-if="editMode"
                                        />
                                        <vue-bootstrap-typeahead
                                            v-model="form.nom"
                                            :data="infoPatients"
                                            :serializer="item => item"
                                            placeholder="Nom du patient..."
                                            @hit="onSelectedPatient"
                                            v-else
                                        />

                                        <has-error
                                            :form="form"
                                            field="nom"
                                        ></has-error>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <label
                                            class="font-weight-bold"
                                            for="prenom"
                                            >Prénom
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'prenom'
                                                )
                                            }"
                                            id="prenom"
                                            placeholder="Prénom du patient..."
                                            required="true"
                                            name="prenom"
                                            v-model="form.prenom"
                                        />
                                        <has-error
                                            :form="form"
                                            field="prenom"
                                        ></has-error>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <label
                                            class="font-weight-bold"
                                            for="date_naissance"
                                            >Date de naissance
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <div class="input-group">
                                            <input
                                                id="date_naissance"
                                                type="date"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'date_naissance'
                                                    )
                                                }"
                                                placeholder="Date de Naissance"
                                                required
                                                name="date_naissance"
                                                v-model="form.date_naissance"
                                            />
                                            <has-error
                                                :form="form"
                                                field="date_naissance"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <label
                                            class="font-weight-bold"
                                            for="validationCustomUsername"
                                            >Numéro du téléphone</label
                                        >
                                        <div class="input-group">
                                            <input
                                                type="tel"
                                                class="form-control"
                                                max="9999999999999999"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'num_tel'
                                                    )
                                                }"
                                                placeholder="Ex : 0661000000"
                                                name="num_tel"
                                                v-model="form.num_tel"
                                            />
                                            <has-error
                                                :form="form"
                                                field="num_tel"
                                            ></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-6 mt-2">
                                        <label
                                            class="font-weight-bold"
                                            for="profession"
                                            >Profession</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'profession'
                                                )
                                            }"
                                            id="profession"
                                            placeholder="Profession..."
                                            name="profession"
                                            v-model="form.profession"
                                        />
                                        <has-error
                                            :form="form"
                                            field="profession"
                                        ></has-error>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <label
                                            class="font-weight-bold"
                                            for="adresse"
                                            >Adresse Physique</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'adresse'
                                                )
                                            }"
                                            id="adresse"
                                            placeholder="Adresse physique..."
                                            name="adresse"
                                            v-model="form.adresse"
                                        />
                                        <has-error
                                            :form="form"
                                            field="adresse"
                                        ></has-error>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <label
                                            class="font-weight-bold"
                                            for="validationCustom04"
                                            >Sexe</label
                                        >
                                        <div
                                            class="position-relative form-group"
                                        >
                                            <fieldset>
                                                <div>
                                                    <div
                                                        class="
                                                            custom-radio
                                                            custom-control
                                                        "
                                                    >
                                                        <input
                                                            type="radio"
                                                            id="sexe"
                                                            name="sexe"
                                                            class="
                                                                custom-control-input
                                                            "
                                                            v-model="form.sexe"
                                                            value="M"
                                                        />
                                                        <label
                                                            class="
                                                                custom-control-label
                                                            "
                                                            for="sexe"
                                                            >HOMME</label
                                                        >
                                                    </div>
                                                    <div
                                                        class="
                                                            custom-radio
                                                            custom-control
                                                        "
                                                    >
                                                        <input
                                                            type="radio"
                                                            id="sexe2"
                                                            name="sexe"
                                                            class="
                                                                custom-control-input
                                                            "
                                                            v-model="form.sexe"
                                                            value="F"
                                                        />
                                                        <label
                                                            class="
                                                                custom-control-label
                                                            "
                                                            for="sexe2"
                                                            >FEMME</label
                                                        >
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <label class="font-weight-bold" for=""
                                            >Fumeur</label
                                        >
                                        <div
                                            class="position-relative form-group"
                                        >
                                            <fieldset>
                                                <div>
                                                    <div
                                                        class="
                                                            custom-radio
                                                            custom-control
                                                        "
                                                    >
                                                        <input
                                                            type="radio"
                                                            id="exampleCustomRadio"
                                                            name="fumeur"
                                                            class="
                                                                custom-control-input
                                                            "
                                                            value="Oui"
                                                            v-model="
                                                                form.fumeur
                                                            "
                                                        />
                                                        <label
                                                            class="
                                                                custom-control-label
                                                            "
                                                            for="exampleCustomRadio"
                                                            >OUI</label
                                                        >
                                                    </div>
                                                    <div
                                                        class="
                                                            custom-radio
                                                            custom-control
                                                        "
                                                    >
                                                        <input
                                                            type="radio"
                                                            id="exampleCustomRadio2"
                                                            name="fumeur"
                                                            class="
                                                                custom-control-input
                                                            "
                                                            value="Non"
                                                            v-model="
                                                                form.fumeur
                                                            "
                                                            checked
                                                        />
                                                        <label
                                                            class="
                                                                custom-control-label
                                                            "
                                                            for="exampleCustomRadio2"
                                                            >NON</label
                                                        >
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="main-card card">
                            <div class="card-body">
                                <h5 class="h5 card-title">
                                    Informations médicales
                                </h5>
                                <div class="form-row">
                                    <div
                                        class="col-md-12"
                                        v-if="user.role_id == 3"
                                    >
                                        <label
                                            class="font-weight-bold"
                                            for="validationCustom02"
                                            >Praticien</label
                                        >
                                        <select
                                            type="text"
                                            v-model="form.medecin_externe"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'adresse'
                                                )
                                            }"
                                        >
                                            <option
                                                v-for="_user in users"
                                                :key="_user.id"
                                                :value="_user.id"
                                            >
                                                {{ _user.name }}
                                                {{ _user.prenom }}
                                            </option>
                                        </select>
                                        <has-error
                                            :form="form"
                                            field="medecin_externe"
                                        ></has-error>
                                    </div>

                                    <div class="col-md-12">
                                        <div
                                            class="position-relative form-group"
                                        >
                                            <label
                                                for="exampleCustomSelect"
                                                class="font-weight-bold"
                                                >Motivation du patient</label
                                            >
                                            <select
                                                v-model="form.motivation"
                                                class="form-control"
                                            >
                                                <option disabled selected>
                                                    Choisir profil patient
                                                </option>
                                                <option value="motivate">
                                                    Motivé
                                                </option>
                                                <option value="less_motivate">
                                                    Moyennement motivé
                                                </option>
                                                <option value="no_motivate">
                                                    Non motivé
                                                </option>
                                            </select>
                                            <has-error
                                                :form="form"
                                                field="pathologies"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div
                                            class="position-relative form-group"
                                        >
                                            <label
                                                for="exampleCustomSelect"
                                                class="font-weight-bold"
                                                >Pathologies</label
                                            >
                                            <multiselect
                                                v-model="form.pathologies"
                                                :options="pathologies"
                                                :multiple="true"
                                                :close-on-select="false"
                                                :clear-on-select="false"
                                                :preserve-search="true"
                                                placeholder="Sélectionner les pathologies"
                                                label="pathologie"
                                                track-by="id"
                                                :preselect-first="false"
                                            >
                                                <template
                                                    slot="selection"
                                                    slot-scope="{
                                                        values,
                                                        isOpen
                                                    }"
                                                >
                                                    <span
                                                        class="
                                                            multiselect__single
                                                        "
                                                        v-if="
                                                            values.length &&
                                                                !isOpen
                                                        "
                                                        >{{
                                                            values.length
                                                        }}
                                                        pathologies
                                                        sélectionnées</span
                                                    >
                                                </template>
                                            </multiselect>
                                            <has-error
                                                :form="form"
                                                field="pathologies"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div
                                            class="position-relative form-group"
                                        >
                                            <label
                                                for=""
                                                class="font-weight-bold"
                                                >Antécédents
                                                Stomatologiques</label
                                            >
                                            <multiselect
                                                v-model="form.antecedents"
                                                :options="antecedents"
                                                :multiple="true"
                                                :close-on-select="false"
                                                :clear-on-select="false"
                                                :preserve-search="true"
                                                placeholder="Sélectionner les antécédents stomatologiques"
                                                label="nom"
                                                track-by="id"
                                                :preselect-first="false"
                                            >
                                                <template
                                                    slot="selection"
                                                    slot-scope="{
                                                        values,

                                                        isOpen
                                                    }"
                                                >
                                                    <span
                                                        class="
                                                            multiselect__single
                                                        "
                                                        v-if="
                                                            values.length &&
                                                                !isOpen
                                                        "
                                                        >{{
                                                            values.length
                                                        }}
                                                        antécédents
                                                        selectionnées</span
                                                    >
                                                </template>
                                            </multiselect>
                                            <has-error
                                                :form="form"
                                                field="antecedents"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="font-weight-bold" for=""
                                            >Motif de consultation</label
                                        >
                                        <div class="input-group">
                                            <textarea
                                                name="motif"
                                                cols="30"
                                                rows="3"
                                                placeholder="Renseigner le motif de consultation..."
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'motif'
                                                    )
                                                }"
                                                v-model="form.motif"
                                            ></textarea>

                                            <has-error
                                                :form="form"
                                                field="motif"
                                            ></has-error>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2 modal_footer pull-right">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        @click="hideModal"
                    >
                        Annuler
                    </button>
                    <input
                        :disabled="form.busy"
                        type="submit"
                        :value="editMode ? 'Modifier' : 'Ajouter'"
                        class="btn"
                        :class="editMode ? ' btn-success' : ' btn-primary '"
                    />
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import VueBootstrapTypeahead from "vue-bootstrap-typeahead";
export default {
    components: {
        Multiselect,
        VueBootstrapTypeahead
    },
    props: {
        patientTable: {
            type: Boolean,
            required: false
        },
        user: {
            type: Object
        },
        csrf: {
            type: String
        }
        // patients: {
        //     type: Array
        // }
    },
    data() {
        return {
            pathologies: [],
            antecedents: [],
            users: [],
            editMode: false,
            title: "Nouveau Patient",
            hideFooter: true,
            // Create a new form instance
            form: new Form({
                id: "",
                nom: "",
                prenom: "",
                date_naissance: "",
                num_tel: "",
                motivation: "",
                motif: "",
                profession: "",
                adresse: "",
                sexe: "M",
                fumeur: "Non",
                medecin_externe: "",
                pathologies: [],
                antecedents: []
            }),
            patients: [],
            infoPatients: [],
            sugg: ""
        };
    },
    methods: {
        hideModal() {
            this.$bvModal.hide("modal_patient");
            this.form.reset();
            this.editMode = false;
            this.title = "Nouveau Patient";
        },
        getValue(selectedOption, id) {
            this.form.pathologies.push(selectedOption.id);
        },
        async addPatient() {
            const response = await this.form.post("/api/patients/");

            const patient = response.data;

            //* Add the new patient to global patient via store
            this.$store.commit("addPatient", patient);

            //* Reset DEBTOR AND CREDIT
            this.$store.state.totalPaid = "";
            this.$store.state.totalDone = "";
            this.$store.state.totalToDo = "";

            //* Redirect to "patient" route
            this.$router.push({ name: "patient", params: { id: patient.id } });

            this.hideModal();

            this.$toaster.success("Un nouveau patient est ajouté !");
        },
        /**
         * Open and Update MODAL PATIENT
         */
        updateModal(patient) {
            this.title = "Modifier Patient";
            this.editMode = true;
            this.form.fill(patient);
            this.$bvModal.show("modal_patient");
        },

        /**
         * Update Patient
         */
        async updatePatient() {
            const response = await this.form.post(
                "/api/patients/" + this.form.id
            );

            const patient = response.data.patient;

            this.$emit("patient-updated", patient);

            this.hideModal();

            this.$toaster.success("Le Patient est modifié !");
        },
        fetchPathologies() {
            const URL = "/api/utils";
            axios
                .get(URL)
                .then(response => {
                    this.pathologies = response.data.pathologies;
                    this.antecedents = response.data.antecedents;
                })
                .catch(error => {
                    this.toaster.error(error);
                });
        },
        fetchUsers() {
            const URL = "/api/users";
            axios
                .get(URL)
                .then(response => {
                    this.users = response.data;
                })
                .catch(error => {
                    this.toaster.error(error);
                });
        },
        async fetchPatients() {
            // this.patients = this.$store.state.patients;
            // if (this.patients.length == 0) {
            //     const response = await axios.get("/api/patients");
            //     this.patients = response.data;
            //     this.$store.commit("storePatients", response.data);
            // }
            // this.infoPatients = this.patients.map(p => p.nom + " " + p.prenom);
        },
        async onSelectedPatient(patient) {
            console.log(patient);
            const patientId = this.patients.filter(
                p => p.nom + " " + p.prenom == patient
            )[0].id;
            this.$router.push({ name: "patient", params: { id: patientId } });
        }
    },
    watch: {
        "form.nom": function(newVal, oldVal) {
            axios.get(`/api/patients/search/${newVal}`).then(res => {
                if (res.data.length > 0) {
                    this.patients = res.data;
                    this.infoPatients = this.patients.map(
                        p => p.nom + " " + p.prenom
                    );
                }
            });
        },
        editMode(nval) {
            this.form._method = nval ? "put" : "";
        }
    },
    computed: {
        // infoPatients() {
        //     return this.patients.map(p => p.nom + " " + p.prenom);
        // }
    },
    mounted() {
        this.fetchPathologies();
        this.fetchUsers();
        this.fetchPatients();

        this.$root.$on("bv::modal::hidden", (bvEvent, modalId) => {
            this.editMode = false;
        });
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
