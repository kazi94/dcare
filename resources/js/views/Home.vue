<template>
    <div>
        <div class="app-main__inner">
            <div class="row">
                <div class="col-md-9">
                    <h3>APPLICATIONS</h3>
                    <div class="row">
                        <div class="col-md-3 mr-3" style="cursor: pointer;">
                            <div
                                class="mb-3 text-center card card-body card-patient"
                            >
                                <router-link
                                    :to="{ name: 'dashboard' }"
                                    class="text-dark text-decoration-none"
                                >
                                    <i
                                        class=" pe-7s-home icon-gradient bg-asteroid fa-5x mb-2"
                                    >
                                    </i>

                                    <h5 class="card-title">MON CABINET</h5>
                                    Consulter le tableau de bord du jour.
                                </router-link>
                            </div>
                        </div>
                        <div class="col-md-3 mr-3" style="cursor: pointer;">
                            <div
                                class="mb-3 text-center card card-body card-patient"
                            >
                                <router-link
                                    :to="{ name: 'patients' }"
                                    class="text-dark text-decoration-none"
                                >
                                    <i
                                        class=" pe-7s-id icon-gradient bg-happy-itmeo fa-5x mb-2"
                                    >
                                    </i>

                                    <h5 class="card-title">MES PATIENTS</h5>
                                    Gérez vos patients et leurs dossiers
                                    médicales.
                                </router-link>
                            </div>
                        </div>

                        <div
                            class="col-md-3 mr-3"
                            style="cursor: pointer;"
                            v-if="user.role_id == 1 || user.role_id == 2"
                        >
                            <div class="mb-3 text-center card card-body">
                                <router-link
                                    :to="{ name: 'prescriptions' }"
                                    class="text-dark text-decoration-none"
                                >
                                    <i
                                        class=" pe-7s-note2 icon-gradient bg-happy-fisher fa-5x mb-2"
                                    >
                                    </i>
                                    <h5 class="card-title">MES ORDONNANCES</h5>
                                    Gérez vos les ordonnances de vos patients.
                                </router-link>
                            </div>
                        </div>

                        <div class="col-md-3 mr-3" style="cursor: pointer;">
                            <div class="mb-3 text-center card card-body">
                                <router-link
                                    :to="{ name: 'payments' }"
                                    class="text-dark text-decoration-none"
                                >
                                    <i
                                        class=" pe-7s-cash icon-gradient bg-grow-early fa-5x mb-2"
                                    >
                                    </i>

                                    <h5 class="card-title">MES HONORAIRES</h5>
                                    Gérez les honoraires de vos patients .
                                </router-link>
                            </div>
                        </div>

                        <div class="col-md-3 mr-3" style="cursor: pointer;">
                            <div
                                class="mb-3 text-center card card-body"
                                onclick="location.href = '/rendez-vous'"
                            >
                                <i
                                    class=" pe-7s-date icon-gradient bg-plum-plate fa-5x mb-2"
                                >
                                </i>

                                <h5 class="card-title">AGENDA</h5>
                                Gestion de rendez-vous pour patients
                            </div>
                        </div>
                        <div
                            class="col-md-3 mr-3"
                            style="cursor: pointer;"
                            v-if="user.role_id == 1"
                        >
                            <div class="mb-3 text-center card card-body">
                                <router-link
                                    :to="{ name: 'settings' }"
                                    class="text-dark text-decoration-none"
                                >
                                    <i
                                        class=" pe-7s-config  icon-gradient bg-mean-fruit fa-5x mb-2"
                                    >
                                    </i>

                                    <h5 class="card-title">REGLAGES</h5>
                                    Gérez les réglages de votre cabinet.
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div v-if="user.role_id == 1 || user.role_id == 2">
                        <h3>EXTRAS</h3>

                        <div class="row">
                            <div class="col-md-3 mr-3" style="cursor: pointer;">
                                <div class="mb-3 text-center card card-body">
                                    <router-link
                                        :to="{ name: 'videos' }"
                                        class="text-dark text-decoration-none"
                                    >
                                        <i
                                            class=" pe-7s-video icon-gradient bg-dark fa-5x mb-2"
                                        >
                                        </i>

                                        <h5 class="card-title">VIDEOS DEMOS</h5>
                                        Gérez votre bibliothèque de vidéos.
                                    </router-link>
                                </div>
                            </div>
                            <div class="col-md-3 mr-3" style="cursor: pointer;">
                                <div class="mb-3 text-center card card-body">
                                    <router-link
                                        :to="{ name: 'statistics' }"
                                        class="text-dark text-decoration-none"
                                    >
                                        <i
                                            class=" pe-7s-display1 icon-gradient bg-info fa-5x mb-2"
                                        >
                                        </i>

                                        <h5 class="card-title">STATISTIQUES</h5>
                                        Consultez les rapports de statistiques
                                        de votre cabinet.
                                    </router-link>
                                </div>
                            </div>

                            <!-- <div class="col-md-3 mr-3" style="cursor: pointer;">
                                <div
                                    class="mb-3 text-center card card-body"
                                    onclick="window.location.href = '/ma-bibliotheque'"
                                >
                                    <i
                                        class=" pe-7s-photo icon-gradient bg-alternate fa-5x mb-2"
                                    >
                                    </i>

                                    <h5 class="card-title">MES PHOTOS</h5>
                                    Gérez votre bibliothèque de photos.
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-1 text-center card card-body">
                        <i
                            class="fa fa-user-md icon-gradient bg-mean-fruit fa-5x mb-2"
                        >
                        </i>

                        <h3 class="text-center">
                            Bienvenue Dr.{{ user.name }}
                            {{ user.prenom }}
                        </h3>
                        <p class="text-center">
                            Votre dernière connexion
                            {{ user.last_login }}
                        </p>
                        <p><b>Profile : </b>{{ user.role.nom }} <br /></p>
                        <div class="divider"></div>
                        <img
                            :src="user.cabinet.logo"
                            alt=""
                            class="mb-2"
                            width="94"
                            height="94"
                            style="margin : auto"
                        />

                        <h3 class="text-center">
                            {{ user.cabinet.nom }}
                        </h3>
                        <p class="text-center">
                            {{ user.cabinet.adresse }}
                        </p>
                    </div>
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
