<template>
    <div>
        <a
            v-for="(video_url, idx) in videos"
            :key="idx"
            class="mr-1"
            @click="readTheVideo(video_url, act.nom)"
        >
            <b-icon-camera-video-fill></b-icon-camera-video-fill>
        </a>
        <b-modal
            :id="modal_id"
            :title="titleVideo"
            size="lg"
            ok-title="Fermer"
            :ok-only="onlyOk"
        >
            <div style="width: auto; height: auto">
                <video
                    oncontextmenu="return false;"
                    controls
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
    props: {
        videos: {
            type: Array,
            default: null,
        },
        act: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            onlyOk: true,
            videoToRead: "",
            titleVideo: "",
            modal_id: "",
        };
    },
    methods: {
        /**
         * @description Open and read the video
         */
        readTheVideo(video, acte) {
            this.videoToRead = "/" + video.url;
            this.titleVideo = "Vidéo démo acte : " + acte;
            this.$bvModal.show(this.modal_id);
        },
    },
    mounted() {
        this.modal_id = `video-player-${this._uid.toString()}`;
    },
};
</script>
