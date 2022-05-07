<template>
    <div>
        <div class="app-main__inner" id="patients">
            <div class="row">
                <div class="col-sm-11 col-md-10">
                    <h3>MES PATIENTS</h3>
                </div>

                <div class="col-sm-2 pl-md-5"></div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-body">
                        <patient-table
                            @get-patients="patients = $event"
                            :user="user"
                            :csrf="csrf"
                        ></patient-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PatientTable from "@/Components/Patient/PatientTable";

export default {
    props: ["user", "csrf"],
    data() {
        return {
            patients: []
        };
    },
    watch: {},
    components: {
        PatientTable
    },
    methods: {}
};
</script>

<style lang="scss"></style>
