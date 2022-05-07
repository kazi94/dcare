<template>
    <div>
        <div class="app-sidebar sidebar-shadow">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button
                            type="button"
                            class="hamburger close-sidebar-btn hamburger--elastic"
                            data-class="closed-sidebar"
                        >
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
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
                        class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav"
                    >
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="scrollbar-sidebar">
                <div class="app-sidebar__inner">
                    <ul class="vertical-nav-menu">
                        <li class="app-sidebar__heading">APPLICATIONS</li>
                        <li>
                            <router-link :to="{ name: 'home' }"
                                ><i
                                    class="bg-primary icon-gradient metismenu-icon pe-7s-home"
                                ></i>
                                Acceuil</router-link
                            >
                        </li>
                        <li>
                            <router-link :to="{ name: 'dashboard' }">
                                <i class="metismenu-icon pe-7s-graph2"></i>
                                Mon cabinet
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'patients' }">
                                <i
                                    class="metismenu-icon icon-gradient bg-happy-itmeo pe-7s-id"
                                ></i>
                                Mes patients
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'payments' }">
                                <i
                                    class="metismenu-icon icon-gradient bg-grow-early pe-7s-cash"
                                ></i>
                                Mes honoraires
                            </router-link>
                        </li>
                        <li v-if="user.role_id == 1 || user.role_id == 2">
                            <router-link
                                :to="{ name: 'prescriptions' }"
                                class="text-dark text-decoration-none"
                            >
                                <i
                                    class="metismenu-icon icon-gradient bg-happy-fisher pe-7s-note2"
                                ></i>
                                Mes ordonnances
                            </router-link>
                        </li>
                        <li>
                            <a href="/rendez-vous" class="">
                                <i
                                    class="metismenu-icon icon-gradient bg-plum-plate pe-7s-date"
                                ></i>
                                Mon agenda
                            </a>
                        </li>
                        <li v-if="user.role_id == 1">
                            <router-link :to="{ name: 'settings' }">
                                <i
                                    class="metismenu-icon icon-gradient bg-mean-fruit font-weight-bold pe-7s-config"
                                ></i>
                                Réglages
                            </router-link>
                        </li>
                        <div v-if="user.role_id == 1 || user.role_id == 2">
                            <li class="app-sidebar__heading">MEDIAS</li>
                            <li>
                                <router-link :to="{ name: 'videos' }">
                                    <i
                                        class="metismenu-icon icon-gradient bg-mean-fruit font-weight-bold pe-7s-video"
                                    ></i>
                                    Mes videos
                                </router-link>
                            </li>
                            <li>
                                <a href="/ma-bibliotheque" class="">
                                    <i
                                        class="metismenu-icon icon-gradient bg-mean-fruit font-weight-bold pe-7s-photo"
                                    ></i>
                                    Mes photos
                                </a>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["user"]
};
</script>
