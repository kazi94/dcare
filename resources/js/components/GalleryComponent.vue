<template>
    <div class="demo-gallery">
        <ul
            id="lightgallery"
            class="list-unstyled row"
            style="overflow-y: scroll; height: 200px"
        >
            <li
                class="col-xs-6 col-sm-4 col-md-3"
                v-for="(radio, index) in patient.radios"
                :key="index"
                style="padding-left: 0px; padding-right: 0px;"
                :data-src="radio.img_url"
                data-sub-html="text here"
            >
                <a href>
                    <img
                        class="img-responsive"
                        :src="radio.img_url"
                        :alt="radio.id"
                    />
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ["patient"],
    data() {
        return {};
    },
    methods: {},

    mounted() {
        lightGallery(document.getElementById("lightgallery"), {
            thumbnail: true
        });
    }
};
</script>
