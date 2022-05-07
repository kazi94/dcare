<template>
    <div>
        <div class="app-main__inner" id="admin_app">
            <h3>REGLAGES</h3>

            <div class="row">
                <div class="col-sm-12">
                    <b-card no-body class="mb-2">
                        <b-tabs
                            card
                            ref="tab"
                            justified
                            active-nav-item-class="font-weight-bold text-uppercase"
                        >
                            <b-tab title="Générals" title-link-class="h6">
                                <general-component></general-component>
                            </b-tab>
                            <b-tab title="Utilisateurs" title-link-class="h6">
                                <user-component></user-component>
                            </b-tab>
                            <b-tab
                                title="Ordonnances Type"
                                title-link-class="h6"
                            >
                                <ordonnance-component></ordonnance-component>
                            </b-tab>
                            <b-tab title="Catégories" title-link-class="h6">
                                <category-component></category-component>
                            </b-tab>
                            <b-tab title="Actes" title-link-class="h6" lazy>
                                <act-component></act-component>
                            </b-tab>
                        </b-tabs>
                    </b-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ActComponent from "@/Components/Settings/ActComponent";
import UserComponent from "@/Components/Settings/UserComponent";
import CategoryComponent from "@/Components/Settings/CategoryComponent";
import OrdonnanceComponent from "@/Components/Settings/OrdonnanceComponent";
import GeneralComponent from "@/Components/Settings/GeneralComponent";

export default {
    props: [],
    watch: {},
    components: {
        UserComponent,
        ActComponent,
        CategoryComponent,
        OrdonnanceComponent,
        GeneralComponent
    },
    methods: {}
};
</script>

<style lang="scss"></style>
