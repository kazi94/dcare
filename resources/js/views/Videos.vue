<template>
    <div>
        <div class="app-main__inner">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-11">
                    <h3>VIDEOS DEMOS</h3>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-1">
                    <b-button
                        class="btn   mb-1"
                        variant="primary"
                        v-b-modal.modal-video
                        title="Ajouter une nouvelle vidéo"
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
                            label="Catégories d'actes"
                            class="font-weight-bold"
                            label-for="input-3"
                        >
                            <b-form-select
                                id="input-3"
                                v-model="selectedCategory"
                                required
                            >
                                <b-form-select-option :value="null"
                                    >Veuillez sélectionner une
                                    catégorie</b-form-select-option
                                >
                                <b-form-select-option
                                    v-for="category in categories"
                                    :key="category.id"
                                    :value="category.id"
                                >
                                    {{ category.name }}
                                </b-form-select-option>
                            </b-form-select>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col
                        v-for="(video, index) in videos"
                        :key="index"
                        class="col-xs-12 col-sm-3"
                    >
                        <b-col cols="12">
                            <a :href="video.url" target="_blank"
                                ><video width="320" height="240" controls>
                                    <source :src="video.url" type="video/mp4" />
                                    Your browser does not support the video tag.
                                </video></a
                            ></b-col
                        >
                        <b-col cols="12" class="text-center">
                            <h6>{{ video.act.nom }}</h6>
                            <button
                                class="btn btn-danger  "
                                @click="removeVideo(index, video.id)"
                            >
                                Supprimer
                            </button>
                        </b-col>
                    </b-col>
                </b-row>
            </div>
            <b-modal id="modal-video" hide-footer title="Nouvelle vidéo démo">
                <b-form
                    @submit.prevent="onSubmit"
                    @keydown="form.onKeydown($event)"
                    @reset="onReset"
                    enctype="multipart/form-data"
                >
                    <b-form-group
                        id="input-group-3"
                        label="Sélectionner l'acte"
                        class="font-weight-bold"
                        label-for="input-3"
                    >
                        <b-form-select id="input-3" v-model="form.act" required>
                            <optgroup
                                v-for="category in categories"
                                :key="category.id"
                                :label="category.name"
                            >
                                <option
                                    v-for="(act, idx) in category.acts"
                                    :key="idx"
                                    :value="act.id"
                                >
                                    {{ act.nom }}
                                </option>
                            </optgroup>
                        </b-form-select>
                        <has-error :form="form" field="act"></has-error>
                    </b-form-group>

                    <b-form-group
                        label="Sélectionner la vidéo"
                        class="font-weight-bold"
                        label-for="input-3"
                    >
                        <b-form-file
                            class="mt-3"
                            accept=".mp4, .mov, .flv"
                            plain
                            required
                            @change="handleFile"
                        ></b-form-file>
                        <has-error :form="form" field="video_url"></has-error>
                    </b-form-group>
                    <b-progress
                        :value="progress"
                        max="100"
                        :label="label"
                        show-value
                        variant="success"
                        :animated="true"
                        class="mb-3"
                        v-if="progress != 0"
                    ></b-progress>
                    <b-button
                        type="submit"
                        variant="primary"
                        :disabled="form.busy"
                        class="pull-right"
                    >
                        Ajouter</b-button
                    >
                    <b-button type="reset" variant="secondary">Fermer</b-button>
                </b-form>
            </b-modal>
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    props: ["user"],
    data() {
        return {
            form: new Form({
                act: null,
                video_url: null
            }),
            categories: new Array(),
            videos: new Array(),
            selectedCategory: null,
            progress: 0,
            label: null
        };
    },
    methods: {
        onReset() {
            this.$bvModal.hide("modal-video");
        },
        handleFile(event) {
            // We'll grab just the first file...
            // You can also do some client side validation here.
            const file = event.target.files[0];

            // Set the file object onto the form...
            this.form.video_url = file;
        },
        onSubmit() {
            let formData = new FormData();
            formData.append("video_url", this.form.video_url);
            formData.append("act", this.form.act);
            //             const response = await this.form.post("/api/videos-demo" , {
            //     headers : {
            //         'Content-Type': 'multipart/form-data'
            //     }
            // });
            axios
                .post("/api/videos-demo", formData, {
                    onUploadProgress: progressEvent => {
                        this.progress =
                            (progressEvent.loaded / progressEvent.total) * 100;
                        this.label = this.progress + "%";
                    },
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(response => {
                    this.videos.push(response.data);
                    this.onReset();
                    this.$toaster.success("La vidéo est ajouté avec succés !");
                    this.progress = 0;
                })
                .catch(error => {
                    const that = this;
                    if (error.response) {
                        if (error.response.status == 422) {
                            const errors = error.response.data.errors;
                            for (const [key, value] of Object.entries(errors)) {
                                value.forEach(val => {
                                    this.$toaster.error(`${key} : ${val}`);
                                });
                            }
                        }
                    }
                });
        },
        fetchVideos() {
            axios
                .get("/api/videos-demo")
                .then(res => {
                    this.videos = res.data;
                })
                .catch(err => {
                    console.error(err);
                });
        },
        fetchCategories() {
            axios
                .get("/admin/act/get-acts-by-category")
                .then(res => {
                    this.categories = res.data;
                })
                .catch(err => {
                    console.error(err);
                });
        },
        removeVideo(idx, video_id) {
            if (confirm("Voulez vous supprimer la vidéo ?"))
                axios
                    .delete("/api/videos-demo/" + video_id)
                    .then(res => {
                        this.videos.splice(idx, 1);
                    })
                    .catch(err => {
                        console.error(err);
                    });
        }
    },
    computed: {},
    watch: {
        selectedCategory: {
            handler: function(nVal) {
                if (nVal)
                    axios
                        .get("/api/videos-demo/get-by-category/" + nVal)
                        .then(res => {
                            this.videos = res.data;
                        })
                        .catch(err => {
                            console.error(err);
                        });
            }
        }
    },

    mounted() {
        this.fetchCategories();
        this.fetchVideos();
    }
};
</script>
