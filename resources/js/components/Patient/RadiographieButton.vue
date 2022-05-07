<template>
    <div v-if="user.role_id == 1 || user.role_id == 2">
        <input
            id="radioFile"
            type="file"
            ref="radioFile"
            accept=".png, .jpg, .jpeg"
            hidden
            v-on:change="uploadRadio"
        />
        <a
            href="javascript:void(0);"
            class="nav-link"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Ajouter une image radiographique"
            onclick="document.getElementById('radioFile').click()"
        >
            <i class="nav-link-icon fa fa-plus icon-gradient bg-primary"></i>
            Radiographie
        </a>
    </div>
</template>

<script>
export default {
    props: ["patient", "user"],
    data() {
        return {};
    },
    methods: {
        uploadRadio() {
            const file = this.$refs.radioFile.files[0];
            const formData = new FormData();
            formData.append("file", file);
            formData.append("patient_id", this.patient.id);
            axios
                .post("/patients/radiographies", formData)
                .then(res => {
                    this.$toaster.success("Image radiographique Ajoutée.");

                    this.$emit("get-image", res.data);
                })
                .catch(err => {
                    this.$toaster.error(err);
                });
        }
    },
    computed: {},
    mounted() {}
};
</script>
