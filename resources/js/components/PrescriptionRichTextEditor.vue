<template>
    <div>
        <!-- <q-page class="page-quasar-tiptap-basic">
            <quasar-tiptap v-bind="options" @update="onUpdate" />
        </q-page> -->
    </div>
</template>

<script>
// import { QuasarTiptap, RecommendedExtensions } from "quasar-tiptap";
// import "quasar-tiptap/lib/index.css";

export default {
    data() {
        return {
            options: {
                content: "<h2>ffsdfdsfdsfdsf</h2>",
                editable: true,
                showToolbar: true,
                showBubble: true,
                extensions: [
                    //...RecommendedExtensions
                    // other extenstions
                    // name string, or custom extension
                ],
                toolbar: [
                    "add-more",
                    "separator",
                    "bold",
                    "italic",
                    "underline",
                    // other toolbar buttons
                    // name string
                ],
            },
            json: "",
            html: "",
        };
    },
    components: {
        // QuasarTiptap,
        // RecommendedExtensions
    },
    methods: {
        onUpdate({ getJSON, getHTML }) {
            this.json = getJSON();
            this.html = getHTML();
            console.log("html", this.html);
        },
    },
    mounted() {
        // set language dynamically
        this.$o.lang.set("en-us");
    },
};
</script>
