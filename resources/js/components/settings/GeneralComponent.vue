<template>
    <div>
        <form
            class="needs-validation"
            novalidate=""
            @submit.prevent="createCabinet"
            enctype="multipart/form-data"
        >
            <div class="position-relative form-group">
                <label for="cabinet" class="">Cabinet</label>
                <input
                    name="nom"
                    v-model="nom"
                    placeholder="Renseigner le nom de votre cabinet"
                    type="text"
                    class="form-control"
                />
            </div>
            <div class="position-relative form-group">
                <label for="adresse" class="">Adresse</label>
                <input
                    name="adresse"
                    v-model="adresse"
                    placeholder="Renseigner l'adresse de votre cabinet"
                    type="text"
                    class="form-control"
                />
            </div>
            <div class="position-relative form-group">
                <img
                    :src="logo"
                    alt=""
                    width="70"
                    height="70"
                    v-show="typeof logo === 'string'"
                />
            </div>

            <div class="position-relative form-group">
                <label for="logo" class="">Logo</label>
                <input
                    name="logo"
                    type="file"
                    ref="file"
                    v-on:change="handleFileUpload()"
                    class="form-control-file"
                />
                <small class="form-text text-muted"
                    >Ajouter le logo de votre cabinet pour l'entête de la page
                    d'impression.</small
                >
            </div>

            <button class="mt-1 btn btn-primary  ">Sauvegarder</button>
        </form>
    </div>
</template>

<script>
export default {
    props: [],
    data() {
        return {
            nom: undefined,
            adresse: undefined,
            logo: undefined
        };
    },
    methods: {
        /*
                Submits the file to the server
            */
        createCabinet() {
            /*
                    Initialize the form data
                */
            let formData = new FormData();

            /*
                    Add the form data we need to submit
                */
            formData.append("nom", this.nom);
            formData.append("adresse", this.adresse);
            formData.append("logo", this.logo);

            /*
                  Make the request to the POST /single-file URL
                 */
            axios
                .post("/admin/reglages", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(response => {
                    console.log(response.data);
                    this.logo = response.data;
                    this.$toaster.success("Sauvegardé !");
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
        },
        /*
                get the uploaded file
             */
        handleFileUpload() {
            this.logo = this.$refs.file.files[0];
        }
    },
    computed: {},
    mounted() {
        axios
            .get("/admin/reglages/general")
            .then(response => {
                this.nom = response.data.nom;
                this.adresse = response.data.adresse;
                this.logo = response.data.logo;
            })
            .catch(exception => {
                this.$toaster.error(exception);
            });
    }
};
</script>
