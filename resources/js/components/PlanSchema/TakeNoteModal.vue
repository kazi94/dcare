<template>
    <div>
        <b-button
            variant="outline-secondary"
            class="pull-right mb-1 btn-sm ml-1"
            @click="showModal"
            title="Prendre des notes"
        >
            <i class="fa fa-pen"></i>
        </b-button>
        <b-modal
            id="modal-bloc-note"
            title="Prise de notes"
            size="lg"
            hide-footer
        >
            <!-- Two-way Data-Binding -->
            <quill-editor
                ref="myQuillEditor"
                v-model="content"
                :options="editorOption"
                @blur="onEditorBlur($event)"
                @focus="onEditorFocus($event)"
                @ready="onEditorReady($event)"
            />
            <!-- <quill-editor
                :content="content"
                :options="editorOption"
                @change="onEditorChange($event)"
                @blur="onEditorBlur($event)"
            /> -->
            <b-button
                class="mt-3"
                variant="outline-success"
                block
                @click="hideModal"
                >Sauvegarder</b-button
            >
        </b-modal>
        <!-- END Acts done Model -->
    </div>
</template>

<script>
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";

import { quillEditor } from "vue-quill-editor";
export default {
    components: { quillEditor },
    props: {
        patient: Object,
    },
    data() {
        return {
            onlyOk: true,
            content: "<h2>I am Example</h2>",
            editorOption: {
                placeholder: "Prenez vos notes ici....",
                theme: "snow",
            },
            memo: "",
        };
    },
    watch: {
        content: {
            handler: function (newV) {},
        },
    },
    computed: {},
    methods: {
        showModal() {
            this.$bvModal.show("modal-bloc-note");
        },
        onEditorBlur(quill) {
            //console.log("editor blur!", quill);
            // axios
            //     .post("/api/memo" + (this.memo ? "/" + this.memo.id : ""), {
            //         content: this.content,
            //         _method: this.memo ? "put" : "post",
            //         patient_id: this.patient.id,
            //     })
            //     .then((res) => {
            //         this.memo = res.data;
            //     });
        },
        hideModal() {
            this.$bvModal.hide("modal-bloc-note");
            axios
                .post("/api/memo" + (this.memo ? "/" + this.memo.id : ""), {
                    content: this.content,
                    _method: this.memo ? "put" : "post",
                    patient_id: this.patient.id,
                })
                .then((res) => {
                    this.memo = res.data;
                });
        },
        onEditorFocus(quill) {
            //console.log("editor focus!", quill);
        },
        onEditorReady(quill) {
            //console.log("editor ready!", quill);
        },
        onEditorChange({ quill, html, text }) {
            //console.log("editor change!", quill, html, text);
        },
    },
    computed: {
        editor() {
            return this.$refs.myQuillEditor.quill;
        },
    },
    mounted() {
        this.memo = this.patient.memo;
        this.content = this.memo ? this.memo.content : "";
    },
};
</script>
