<template>
    <div>
        <div class="text-center">
            <b-button
                variant="success"
                class="ml-3 p-1"
                v-b-toggle.sidebar-footer
                title="Liste des rendez-vous"
            >
                <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                <b-badge variant="light" v-if="lenAppointements != 0">
                    {{ lenAppointements }}
                </b-badge>
            </b-button>
        </div>

        <b-sidebar
            id="sidebar-footer"
            aria-label="Liste des rendez-vous"
            no-header
            right
            shadow
            backdrop
        >
            <div>
                <b-card no-body>
                    <b-tabs
                        no-fade
                        align="center"
                        justified
                        active-nav-item-class="font-weight-bold text-uppercase"
                    >
                        <b-tab title="A venir" active>
                            <div class="">
                                <b-list-group>
                                    <b-list-group-item
                                        class="flex-column align-items-start"
                                        v-for="(appointement,
                                        idx) in appointements"
                                        :key="idx"
                                    >
                                        <div
                                            class="
                                                d-flex
                                                w-100
                                                justify-content-between
                                            "
                                        >
                                            <h6 class="mb-1">
                                                {{ appointement.category.name }}
                                            </h6>
                                            <small
                                                class="text-muted"
                                                v-if="
                                                    appointement.remaining_days !=
                                                        0
                                                "
                                                >Dans
                                                {{
                                                    appointement.remaining_days +
                                                        1
                                                }}
                                                jours</small
                                            >
                                            <small class="text-muted" v-else>
                                                Aujourdh'ui à
                                                {{
                                                    appointement.hour_appointement
                                                }}
                                            </small>
                                        </div>

                                        <p class="mb-1">
                                            <strong class="text-info text-bold"
                                                >FAUTEUIL :{{
                                                    appointement.fauteuil
                                                }}
                                            </strong>
                                            {{ appointement.text }}
                                        </p>
                                        <div
                                            class="
                                                d-flex
                                                w-100
                                                justify-content-between
                                            "
                                        >
                                            <small class="text-muted"
                                                >Assigner à :
                                                {{
                                                    appointement.assigned_to
                                                        .doctor
                                                }}</small
                                            >
                                            <b-badge
                                                pill
                                                :variant="
                                                    appointement.stateVariant
                                                "
                                                class="text-light"
                                                style="cursor: pointer"
                                                @click="
                                                    changeState(appointement)
                                                "
                                                >{{ appointement.stateTitle }}
                                            </b-badge>
                                        </div>
                                    </b-list-group-item>
                                </b-list-group>
                            </div>
                        </b-tab>
                        <b-tab title="Historique">
                            <div class="">
                                <b-list-group>
                                    <b-list-group-item
                                        href="#"
                                        class="flex-column align-items-start"
                                        v-for="(appointement,
                                        idx) in appointementsHistory"
                                        :key="idx"
                                    >
                                        <div
                                            class="
                                                d-flex
                                                w-100
                                                justify-content-between
                                            "
                                        >
                                            <h6 class="mb-1">
                                                {{ appointement.category.name }}
                                            </h6>
                                            <small
                                                class="text-muted"
                                                v-if="
                                                    appointement.remaining_days <
                                                        0
                                                "
                                            >
                                                Il y a
                                                {{
                                                    -appointement.remaining_days
                                                }}
                                                jours</small
                                            >
                                        </div>

                                        <p class="mb-1">
                                            <strong class="text-info text-bold"
                                                >FAUTEUIL :{{
                                                    appointement.fauteuil
                                                }}
                                            </strong>
                                            {{ appointement.text }}
                                        </p>

                                        <small class="text-muted"
                                            >Assigner à :
                                            {{
                                                appointement.assigned_to.doctor
                                            }}</small
                                        >
                                    </b-list-group-item>
                                </b-list-group>
                            </div>
                        </b-tab>
                    </b-tabs>
                </b-card>
            </div>

            <template #footer="{ hide }">
                <div
                    class="
                        d-flex
                        bg-dark
                        text-light
                        align-items-center
                        px-3
                        py-2
                    "
                >
                    <button class="btn mr-auto btn-light">
                        <a href="/rendez-vous">Ouvrir mon agenda</a>
                    </button>
                    <b-button size="sm" @click="hide">Fermer</b-button>
                </div>
            </template>
        </b-sidebar>
    </div>
</template>

<script>
export default {
    components: {},
    props: {
        patient: {
            type: Object,
            required: true
        }
    },
    methods: {
        handleState(appointement) {
            switch (appointement.state) {
                case "validate": {
                    appointement.stateTitle = "Reporter";
                    appointement.stateVariant = "warning";
                    appointement.state = "report";

                    break;
                }
                case "report": {
                    appointement.stateTitle = "Annuler";
                    appointement.stateVariant = "secondary";
                    appointement.state = "cancel";

                    break;
                }
                case "cancel": {
                    appointement.stateTitle = "Valider";
                    appointement.stateVariant = "success";
                    appointement.state = "validate";
                    break;
                }
                default: {
                    appointement.stateTitle = "Valider";
                    appointement.stateVariant = "success";
                    appointement.state = "validate";
                    break;
                }
            }
            return appointement.state;
        },
        changeState(appointement) {
            let newState = this.handleState(appointement);

            axios
                .post(`/api/appointements/${appointement.id}/update-state`, {
                    state: newState
                })
                .then(response => {});
        }
    },
    data() {
        return {};
    },
    computed: {
        appointements() {
            return this.patient.appointements.map(el => {
                switch (el.state) {
                    case "validate":
                        el["stateTitle"] = "Valider";
                        el["stateVariant"] = "success";
                        break;
                    case "report":
                        el["stateTitle"] = "Reporter";
                        el["stateVariant"] = "warning";
                        break;
                    case "cancel":
                        el["stateTitle"] = "Annuler";
                        el["stateVariant"] = "secondary";
                        break;

                    default:
                        el["stateTitle"] = "Valider ?";
                        el["stateVariant"] = "primary";
                        break;
                }
                return el;
            });
        },
        isAppointements() {
            return this.appointements.length > 0 ? true : false;
        },
        lenAppointements() {
            return this.appointements.length;
        },
        appointementsHistory() {
            return this.patient.appointements_history;
        },
        isAppointementsHistory() {
            return this.appointementsHistory.length > 0 ? true : false;
        },
        lenAppointementsHistory() {
            return this.appointementsHistory.length;
        }
    },
    mounted() {}
};
</script>

<style lang="scss" scoped></style>
