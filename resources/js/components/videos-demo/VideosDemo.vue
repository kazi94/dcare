<template>
    <div>
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
                        <b-form-select id="input-3" v-model="selectedCategory" required>
                             <b-form-select-option :value="null">Veuillez sélectionner une catégorie</b-form-select-option>
                            <b-form-select-option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                    {{ category.name }}
                                </b-form-select-option>
                            </option>
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
                            ><video style="position: relative;
                                                    top: 0;
                                                    left: 0;
                                                    width: 100%;
                                                    height: 100%;" controls>
                                <source :src="video.url" type="video/mp4" />
                                Your browser does not support the video tag.
                            </video></a
                        ></b-col
                    >
                    <b-col cols="12" class="text-center">
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
                @submit="onSubmit"
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
                </b-form-group>

                <b-form-group
                    label="Sélectionner la vidéo"
                    class="font-weight-bold"
                    label-for="input-3"
                >
                    <b-form-file
                        v-model="form.video_url"
                        class="mt-3"
                        accept=".mp4, .mov, .flv"
                        plain
                        required
                    ></b-form-file>
                </b-form-group>
                <b-button
                    type="submit"
                    variant="primary"
                     
                    class="pull-right"
                    >Ajouter</b-button
                >
                <b-button type="reset"   variant="secondary"
                    >Fermer</b-button
                >
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
                act: null,
                video_url: null
            },
            categories: new Array(),
            videos: new Array(),
            selectedCategory : null,
        };
    },
    methods: {
        onReset() {
            this.$bvModal.hide("modal-video");
        },
        onSubmit(e) {
            e.preventDefault();
            let formData = new FormData();
            formData.set("video_url", this.form.video_url);
            formData.set("act_id", this.form.act);
            axios.post("/api/videos-demo", formData).then(res => {
                this.videos.push(res.data);
                this.onReset();
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
        removeVideo(idx,video_id) {
            if(confirm('Voulez vous supprimer la vidéo ?'))
                axios
                .delete("/api/videos-demo/" + video_id)
                .then(res => {
                    this.videos.splice(idx, 1);
                })
                .catch(err => {
                    console.error(err);
                });
        },       
    },
    computed: {},
    watch: {
        selectedCategory : {
            handler : function(nVal)
            {
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
