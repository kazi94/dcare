<template>
    <div>
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-11">
                <h3>MA BIBLIOTHEQUE</h3>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-1">
                <b-button
                    class="btn   mb-1"
                    variant="primary"
                    v-b-modal.modal-photo
                    title="Ajouter une nouvelle image radiographique"
                >
                    <b-icon-plus></b-icon-plus>
                    Nouveau
                </b-button>
            </div>
        </div>

        <div class="card card-body">
            <b-row align-h="center">
                <b-col lg="5">
                    <b-form-group
                        label-cols-lg="4"
                        label-cols-md="12"
                        id="input-group-3"
                        label="Sélectionner le patient"
                        class="font-weight-bold"
                        label-for="input-3"
                    >
                        <!-- <b-form-select id="input-3" v-model="selectedPatient" required>
                             <b-form-select-option :value="null">Veuillez sélectionner un patient</b-form-select-option>
                            <b-form-select-option
                                v-for="patient in patients"
                                :key="patient.id"
                                :value="patient.id"
                            >
                                    {{ patient.nom }} {{ patient.prenom }}
                                </b-form-select-option>
                            </option>
                        </b-form-select> -->
                        <multiselect
                            v-model="selectedPatient"
                            :options="patients"
                            placeholder="Sélectionner un patient"
                            selectLabel="Tapez Entrée pour sélectionner le patient"
                            selectedLabel="Ajouté"
                            deselectLabel="Tapez Entrée pour déselectionner"
                            openDirection="bottom"
                            track-by="id"
                            :custom-label="customLabel"
                            ><span slot="noResult"
                                >Oops! Aucun patient trouvé !</span
                            ></multiselect
                        >
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col
                    v-for="(photo, index) in photos"
                    :key="index"
                    class="col-xs-12 col-sm-3"
                >
                    <b-col cols="12">
                        <a
                            :href="photo.img_url"
                            target="_blank"
                            :title="photo.patient.nom + photo.patient.prenom"
                            ><b-img
                                thumbnail
                                fluid
                                :src="photo.img_url"
                                alt="Image 1"
                            ></b-img></a
                    ></b-col>
                    <b-col cols="12" class="text-center">
                        <button
                            class="btn btn-danger  "
                            @click="removePhoto(index, photo.id)"
                        >
                            Supprimer
                        </button>
                    </b-col>
                </b-col>
            </b-row>
        </div>
        <b-modal
            id="modal-photo"
            hide-footer
            title="Nouvelle image radiographique"
        >
            <b-form
                @submit="onSubmit"
                @reset="onReset"
                enctype="multipart/form-data"
            >
                <b-form-group
                    id="input-group-3"
                    label="Sélectionner le patient"
                    class="font-weight-bold"
                    label-for="input-3"
                >
                    <multiselect
                        v-model="form.patient_id"
                        :options="patients"
                        placeholder="Sélectionner un patient"
                        selectLabel="Tapez Entrée pour sélectionner le patient"
                        selectedLabel="Ajouté"
                        deselectLabel="Tapez Entrée pour déselectionner"
                        openDirection="bottom"
                        track-by="id"
                        :custom-label="customLabel"
                        ><span slot="noResult"
                            >Oops! Aucun patient trouvé !</span
                        ></multiselect
                    >
                </b-form-group>

                <b-form-group
                    label="Sélectionner l'image radiographique"
                    class="font-weight-bold"
                    label-for="input-3"
                >
                    <b-form-file
                        v-model="form.img_url"
                        class="mt-3"
                        accept=".jpg, .png, .jpeg"
                        plain
                        required
                    ></b-form-file>
                </b-form-group>
                <b-button type="submit" variant="primary" class="pull-right"
                    >Ajouter</b-button
                >
                <b-button type="reset" variant="secondary">Fermer</b-button>
            </b-form>
        </b-modal>
    </div>
</template>

<script>
export default {
    components: {},
    props: ["user"],
    data() {
        return {
            form: {
                patient_id: null,
                img_url: null
            },
            patients: new Array(),
            photos: new Array(),
            selectedPatient: null
        };
    },
    methods: {
        customLabel({ nom, prenom }) {
            return `${nom} ${prenom}`;
        },
        onReset() {
            this.$bvModal.hide("modal-photo");
        },
        onSubmit(e) {
            e.preventDefault();
            let formData = new FormData();
            formData.set("img_url", this.form.img_url);
            formData.set("patient_id", this.form.patient_id.id);
            axios.post("/api/my-photos", formData).then(res => {
                this.photos.push(res.data);
                this.onReset();
            });
        },
        fetchPhotos() {
            axios
                .get("/api/my-photos")
                .then(res => {
                    this.photos = res.data;
                })
                .catch(err => {
                    console.error(err);
                });
        },
        fetchPatients() {
            axios
                .get("/api/patients")
                .then(res => {
                    this.patients = res.data;
                })
                .catch(err => {
                    console.error(err);
                });
        },
        removePhoto(idx, photo_id) {
            if (confirm("Voulez vous supprimer l'image radiographique ?"))
                axios
                    .delete("/patients/radiographies/" + photo_id)
                    .then(res => {
                        this.photos.splice(idx, 1);
                    })
                    .catch(err => {
                        console.error(err);
                    });
        }
    },
    computed: {},
    watch: {
        selectedPatient: {
            handler: function(nVal) {
                if (nVal)
                    axios
                        .get("/api/my-photos/get-by-patient/" + nVal.id)
                        .then(res => {
                            this.photos = res.data;
                        })
                        .catch(err => {
                            console.error(err);
                        });
            }
        }
    },

    mounted() {
        this.fetchPatients();
        this.fetchPhotos();
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
