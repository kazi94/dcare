<template>
    <div>
        <b-row>
            <b-col lg="11" sm="8">
                <b-form-group
                    label="Filtrer"
                    label-cols-md="1"
                    label-cols-sm="2"
                    label-align-sm="right"
                    label-size="sm"
                    label-for="filterInput"
                    class="mb-0"
                >
                    <b-input-group size="sm" class="col-sm-8 col-lg-4">
                        <b-form-input
                            v-model="filter"
                            type="search"
                            id="filterInput"
                            placeholder="Rechercher un patient"
                        ></b-form-input>
                        <b-input-group-append>
                            <b-button :disabled="!filter" @click="filter = ''"
                                >Annuler</b-button
                            >
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>
            <b-col lg="1" sm="4">
                <patient-modal
                    :csrf="csrf"
                    :user="user"
                    :patients="patients"
                    :patientTable="true"
                >
                </patient-modal>
            </b-col>

            <!-- <b-col lg="6" class="my-1">
                <b-form-group
                    label="Filtres"
                    label-cols-sm="3"
                    label-align-sm="right"
                    label-size="sm"
                    description="déselectionner tout les filtres pour afficher tout les patients"
                    class="mb-0"
                >
                    <b-form-checkbox-group v-model="filterOn" class="mt-1">
                        <b-form-checkbox value="nom">Nom</b-form-checkbox>
                        <b-form-checkbox value="prenom">Age</b-form-checkbox>
                    </b-form-checkbox-group>
                </b-form-group>
            </b-col> -->
        </b-row>
        <b-table
            striped
            hover
            :items="patients"
            :fields="fields"
            foot-clone
            responsive="sm"
            :per-page="perPage"
            :current-page="currentPage"
            :busy.sync="isBusy"
            :filter="filter"
            :filterIncludedFields="filterOn"
            @filtered="onFiltered"
            caption-top
        >
            <template #table-caption
                >Vous avez au total: {{ rows }} patients.</template
            >
            <template #table-busy>
                <div class="text-center text-primary my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Chargement...</strong>
                </div>
            </template>
            <template #cell(index)="{ item }">
                {{ patients.indexOf(item) + 1 }}
            </template>
            <template v-slot:cell(age)="data"
                >{{ data.item.age ? data.item.age + " ans " : "\/" }}
            </template>
            <template v-slot:cell(num_tel)="data"
                >{{ data.item.num_tel ? data.item.num_tel : "\/" }}
            </template>
            <template v-slot:cell(actions)="data">
                <div style="font-size: 1em">
                    <router-link
                        :to="{
                            name: 'patient',
                            params: { id: data.item.id }
                        }"
                        class="mr-5"
                        v-b-tooltip.hover.left
                        title="Accéder au dossier patient"
                    >
                        <b-icon
                            icon="folder-fill"
                            scale="2"
                            variant="primary"
                            style="cursor: pointer"
                        ></b-icon>
                    </router-link>
                    <b-icon
                        icon="trash"
                        class="rounded"
                        scale="2"
                        style="cursor: pointer"
                        variant="danger"
                        @click="removePatient(data.index, data.item.id)"
                        title="Suprrimer le dossier patient"
                    ></b-icon>
                </div>
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
    </div>
</template>

<script>
import PatientModal from "@/Components/Patient/PatientModal";
import patientApi from "@/services/api/patientsApi";
export default {
    props: ["user", "csrf"],
    components: {
        PatientModal
    },
    data() {
        return {
            paginateData: null,
            fields: [
                { key: "id", label: "Num", sortable: true },
                { key: "nom", sortable: true },
                { key: "prenom", sortable: true },
                { key: "age", label: "Age", sortable: true },
                { key: "num_tel", label: "Téléphone" },
                "actions"
            ],
            patients: [],
            boxOne: "",
            perPage: 10,
            currentPage: 1,
            isBusy: false,
            filter: null,
            filterOn: []
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

        showSelectedPatient(patient, modal = false) {
            if ((modal = "true")) $("#liste_patients_modal").modal("hide");
            this.activeClass = patient.id;
            axios.get("/patients/" + patient.id).then(response => {
                this.response = response.data;

                this.$emit("patient-folder", this.response);
            });
        },
        //remove removePatient
        removePatient(index, id) {
            this.boxOne = "";
            this.$bvModal
                .msgBoxConfirm("Voulez vous supprimer le patient?", {
                    title: "Confirmer la suppresion",
                    size: "sm",
                    buttonSize: "sm",
                    okVariant: "success",
                    okTitle: "Oui",
                    cancelTitle: "Non",
                    footerClass: "p-2",
                    hideHeaderClose: false,
                    centered: true
                })
                .then(value => {
                    this.boxOne = value;
                    if (this.boxOne == true)
                        axios
                            .delete("/api/patients/" + id)
                            .then(response => {
                                this.patients.splice(index, 1);
                                this.$toaster.success(response.data.success);
                            })
                            .catch(exception => {
                                this.$toaster.error(exception);
                            });
                })
                .catch(err => {
                    console.log(err);
                });
        },
        fetchPatients(curr = 1) {
            // this.isBusy = true;
            // on mounted page, display all patients
            axios.get("/api/patients?page=" + curr).then(response => {
                this.patients = response.data;
                // this.rows = response.data.total;
                // this.$store.commit("storePatients", this.patients);
                // this.isBusy = !this.isBusy;
                this.$emit("get-patients", this.patients);
            });
        },
        loadPage(page) {
            axios.get("/api/patients?page=" + page).then(res => {
                this.patients = res.data;
                //this.paginateData = res.data;
            });
        },

        linkGen(pageNum) {
            return { path: `/patients?pages=${pageNum}` };
        }
    },
    computed: {
        rows() {
            return this.patients.length;
        }
    },
    watch: {
        currentPage: function(val) {
            this.fetchPatients(val);
        }
    },
    mounted() {
        // this.fetchPatients();
        this.loadPage(1);
    }
};
</script>

<style lang="scss">
/* Busy table styling */
// table.b-table[aria-busy="true"] {
//     opacity: 0.6;
// }
</style>
