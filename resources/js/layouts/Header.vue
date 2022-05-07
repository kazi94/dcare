<template>
    <div>
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="" style="display: block; height: 23px; width: 97px">
                    <!-- <img src="" style="height: 23px; width: 97px;" /> -->
                </div>
                <!-- <div class="header__pane ml-auto">
                    <div>
                        <button
                            type="button"
                            class="hamburger close-sidebar-btn hamburger--elastic is-active"
                            data-class="closed-sidebar"
                        >
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div> -->
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button
                        type="button"
                        class="hamburger hamburger--elastic mobile-toggle-nav"
                    >
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button
                        type="button"
                        class="
                            btn-icon btn-icon-only btn btn-primary btn-sm
                            mobile-toggle-header-nav
                        "
                    >
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="app-header__content">
                <portal-target name="header"> </portal-target>
                <div class="app-header-right">
                    <patient-search-bar></patient-search-bar>

                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a
                                            id="btnGroupDrop1"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                            class="p-0 btn"
                                        >
                                            <!-- <img src="/img/user.png" /> -->
                                            <i
                                                class="
                                                    fa fa-angle-down
                                                    ml-2
                                                    opacity-8
                                                "
                                            ></i>
                                        </a>
                                        <div
                                            aria-labelledby="btnGroupDrop1"
                                            tabindex="-1"
                                            role="menu"
                                            aria-hidden="true"
                                            class="
                                                dropdown-menu
                                                dropdown-menu-right
                                            "
                                            x-placement="bottom-end"
                                            style="
                                                position: absolute;
                                                will-change: transform;
                                                top: 0px;
                                                left: 0px;
                                                transform: translate3d(
                                                    -180px,
                                                    44px,
                                                    0px
                                                );
                                            "
                                        >
                                            <button
                                                type="button"
                                                tabindex="0"
                                                class="dropdown-item"
                                            >
                                                <router-link
                                                    :to="{ name: 'settings' }"
                                                    clas="text-decoration-none"
                                                    >Paramètres</router-link
                                                >
                                            </button>
                                            <button
                                                type="button"
                                                tabindex="0"
                                                class="dropdown-item"
                                                @click.prevent="logout"
                                            >
                                                Déconnexion
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="
                                        widget-content-left
                                        ml-3
                                        header-user-info
                                    "
                                >
                                    <div class="widget-heading">
                                        <span v-if="user.role_id == 3"
                                            >Md.</span
                                        >
                                        <span v-else>Dr.</span>
                                        {{ user.name }} {{ user.prenom }}
                                    </div>
                                    <div class="widget-subheading">
                                        {{ user.profession }}
                                    </div>
                                </div>
                                <portal-target
                                    name="header-right"
                                ></portal-target>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PatientSearchBar from "./PatientSearchBar.vue";

export default {
    components: {
        PatientSearchBar
    },
    props: ["user", "csrf"],
    methods: {
        logout(evt) {
            if (confirm("Vous ète sûr de vous déconnecter?")) {
                axios
                    .get("/api/logout")
                    .then(response => {
                        localStorage.removeItem("auth_token");
                        // remove any other authenticated user data you put in local storage
                        // Assuming that you set this earlier for subsequent Ajax request at some point like so:
                        // axios.defaults.headers.common['Authorization'] = 'Bearer ' + auth_token ;
                        delete axios.defaults.headers.common["Authorization"];
                        // If using 'vue-router' redirect to login page
                        this.$router.go("/login");
                    })
                    .catch(error => {
                        // If the api request failed then you still might want to remove
                        // the same data from localStorage anyways
                        // perhaps this code should go in a finally method instead of then and catch
                        // methods to avoid duplication.
                        localStorage.removeItem("auth_token");
                        delete axios.defaults.headers.common["Authorization"];
                        this.$router.go("/login");
                    });
            }
        }
    }
};
</script>
