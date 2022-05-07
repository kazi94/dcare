<template>
    <b-tab
        title="Radiographies"
        title-link-class="h6"
        v-if="user.role_id == 1 || user.role_id == 2"
    >
        <div v-viewer="options" class="images clearfix">
            <template v-for="(source, idx) in images">
                <img
                    :src="source.img_url"
                    :data-source="source.img_url"
                    class="image"
                    :key="idx"
                />
                <button
                    class="btn btn-danger  "
                    @click="removeImage(idx, source.id)"
                >
                    Supprimer
                </button>
            </template>
        </div>
    </b-tab>
</template>

<script>
import "viewerjs/dist/viewer.css";
import Viewer from "v-viewer";
import Vue from "vue";
Vue.use(Viewer, {
    debug: true,
    defaultOptions: {
        zIndex: 9999
    }
});

export default {
    data() {
        return {
            options: {
                toolbar: true,
                url: "data-source"
            },
            images: []
        };
    },
    computed: {},
    props: ["patient", "user"],
    methods: {
        addToGallery(url) {
            this.imgs.push(url);
        },
        remove() {
            this.images.pop();
        },
        removeImage(index, id) {
            axios
                .delete("/patients/radiographies/" + id)
                .then(res => {
                    this.$toaster.success(
                        "Image radiographique supprimée avec succés!"
                    );

                    this.imgs.splice(index, 1);
                })
                .catch(err => {
                    console.error(err);
                });
        }
    },
    mounted() {
        if (this.patient.radios) this.images = this.patient.radios;
    }
};
</script>

<style lang="scss" rel="stylesheet/scss" scoped>
.image {
    width: calc(20% - 10px);
    cursor: pointer;
    margin: 5px;
    display: inline-block;
}
</style>
