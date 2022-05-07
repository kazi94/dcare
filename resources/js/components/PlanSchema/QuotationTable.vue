<template>
    <div v-if="this.quotation.length > 0">
        <b-table
            ref="selectableTable"
            selectable
            select-mode="multi"
            @row-selected="onRowSelected"
            :items="quotation"
            :fields="fields"
            bordered
            responsive="sm"
            small
            head-variant="light"
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
        >
            <template v-slot:cell(prix)="data">
                <input
                    type="text"
                    v-if="edit"
                    v-model="data.item.prix"
                    @keyup.enter="
                        data.item.prix = parseInt($event.target.value);
                        edit = false;
                    "
                />
                <p v-else @click="edit = true">
                    <b class="text-info">{{ data.item.prix }}</b>
                </p>
            </template>

            <template v-slot:cell(selected)="{ rowSelected }">
                <template v-if="rowSelected">
                    <span aria-hidden="true">&check;</span>
                    <span class="sr-only">Selected</span>
                </template>
                <template v-else>
                    <span aria-hidden="true">&nbsp;</span>
                    <span class="sr-only">Not selected</span>
                </template>
            </template>
        </b-table>
        <b-modal
            id="modal-video-player"
            :title="titleVideo"
            size="lg"
            ok-title="Fermer"
            :ok-only="onlyOk"
        >
            <div style="width: auto; height: auto">
                <video
                    controls
                    autoplay
                    style="
                        position: relative;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                    "
                >
                    <source :src="videoToRead" type="video/mp4" />
                    Your browser does not support the video tag.
                </video>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {
    props: ["quotation"],

    data() {
        return {};
    },

    methods: {
        /**
         * @description Open and read the video
         */
        readTheVideo(video_url, acte) {
            this.videoToRead = "/" + video_url;
            this.titleVideo = "Vidéo démo acte : " + acte;
            this.$bvModal.show("modal-video-player");
        },
    },

    mounted() {},
};
</script>
