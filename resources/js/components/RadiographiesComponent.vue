<template>
    <div>
        <!-- <div class="card-header">
            <h5 class="card-title">Radiographies</h5>
        </div> -->
        <!-- <div class="card-body"> -->
        <div v-if="showradios">
            <gallery-component :patient="patient"></gallery-component>
            <input
                type="file"
                id="file"
                ref="file"
                v-on:change="handleFileUpload()"
                style="width: 50%;"
            />
            <button
                v-on:click="submitFile()"
                class="btn btn-primary pull-right  "
            >
                AJOUTER
            </button>
        </div>
        <div v-else>
            <div class="alert alert-info">
                <i class="b badge-pill fa fa-info"></i>Aucune Radiographie
                enregistrée.
            </div>
        </div>
        <!-- </div> -->
    </div>
</template>

<script>
import GalleryComponent from "./GalleryComponent";
export default {
    components: {
        GalleryComponent
    },
    props: ["patient", "showradios"],
    data() {
        return {
            file: ""
        };
    },
    methods: {
        /*
                Submits the file to the server
            */
        submitFile() {
            /*
                    Initialize the form data
                */
            let formData = new FormData();

            /*
                    Add the form data we need to submit
                */
            formData.append("file", this.file);
            formData.append("id", this.patient.id);

            /*
                  Make the request to the POST /single-file URL
                 */
            axios
                .post("/patients/radiographies", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(response => {
                    this.file = "";
                    console.log(response.data);
                    this.patient.radios.push(response.data);
                    lightGallery(document.getElementById("lightgallery"), {
                        thumbnail: true
                    });
                    this.$toaster.success("Radiographie ajouter avec succés!");
                })
                .catch(exception => {
                    this.$toaster.error(exception);
                });
        },
        /*
                get the uploaded file
             */
        handleFileUpload() {
            this.file = this.$refs.file.files[0];
        }
    },
    mounted() {
    }
};
</script>
