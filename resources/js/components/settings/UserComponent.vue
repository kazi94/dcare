<template>
    <div>
        <div class="row mb-1">
            <div class="col-sm-9 h5">Utilisateurs</div>
            <div class="col-sm-3">
                <button
                    class="btn btn-primary mt-1 mb-1 pull-right"
                    v-b-modal="'user_modal'"
                >
                    Ajouter
                </button>
            </div>
        </div>

        <table class="mb-0 table">
            <thead>
                <tr>
                    <td>#</td>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Profession</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(val, index) in users" :key="index">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>Dr. {{ val.name }} {{ val.prenom }}</td>
                    <td>{{ val.email }}</td>
                    <td>{{ val.profession }}</td>
                    <td>{{ val.role.nom }}</td>
                    <td>
                        <button
                            class="btn m-1"
                            @click="updateModal(val)"
                            title="Modifier"
                        >
                            <b-icon
                                icon="pencil-square"
                                class="rounded"
                                scale="2"
                                variant="success"
                            ></b-icon>
                        </button>
                        <button
                            class="btn border border-info m-1"
                            @click="openPasswordModal(val)"
                            title="Changer mot de passe"
                        >
                            <b-icon
                                icon="key-fill"
                                class=""
                                scale="2"
                                variant="info"
                            ></b-icon>
                        </button>
                        <button
                            class="btn m-1"
                            @click="remove(val.id, index)"
                            title="Supprimer"
                        >
                            <b-icon
                                icon="trash"
                                class="rounded"
                                scale="2"
                                variant="danger"
                            ></b-icon>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <b-modal
            ref="user_modal"
            id="user_modal"
            hide-footer
            :title="title"
            size="md"
            @hidden="hideModal"
            class="mt-5"
        >
            <form
                @submit.stop.prevent="editMode ? updateUser() : createUser()"
                enctype="multipart/form-data"
                autocomplete="off"
            >
                <input
                    autocomplete="off"
                    name="hidden"
                    type="text"
                    style="display: none"
                />
                <div class="modal-body">
                    <div class="form-row">
                        <b-form-group class="font-weight-bold" label="Nom*">
                            <b-form-input
                                v-model="form.name"
                                type="text"
                                required
                                placeholder="Nom..."
                            ></b-form-input>
                            <div
                                class="text-danger"
                                v-if="form.errors.has('name')"
                                v-html="form.errors.get('name')"
                            />
                        </b-form-group>
                        <b-form-group class="font-weight-bold" label="Prénom*">
                            <b-form-input
                                v-model="form.prenom"
                                type="text"
                                required
                                placeholder="Prénom..."
                            ></b-form-input>
                            <div
                                class="text-danger"
                                v-if="form.errors.has('prenom')"
                                v-html="form.errors.get('prenom')"
                            />
                        </b-form-group>
                        <b-form-group class="font-weight-bold" label="Email*">
                            <b-form-input
                                v-model="form.email"
                                type="email"
                                required
                                autocomplete="off"
                                placeholder="Example : user@email.dz"
                            ></b-form-input>
                            <div
                                class="text-danger"
                                v-if="form.errors.has('email')"
                                v-html="form.errors.get('email')"
                            />
                        </b-form-group>
                        <b-form-group
                            class="font-weight-bold"
                            label="Profession"
                        >
                            <b-form-input
                                v-model="form.profession"
                                type="text"
                                placeholder="Nom..."
                            ></b-form-input>
                            <div
                                class="text-danger"
                                v-if="form.errors.has('profession')"
                                v-html="form.errors.get('profession')"
                            />
                        </b-form-group>

                        <b-form-group
                            class="font-weight-bold ml-1 mr-5"
                            label="Couleur*"
                        >
                            <b-form-input
                                v-model="form.color"
                                type="color"
                                required
                            ></b-form-input>
                        </b-form-group>
                        <b-form-group
                            class="font-weight-bold ml-1 ml-2"
                            label="Role*"
                        >
                            <b-form-select v-model="form.role" required
                                ><b-form-select-option
                                    v-for="(role, idx) in roles"
                                    :key="idx"
                                    :value="role.id"
                                    selected
                                    >{{ role.nom }}</b-form-select-option
                                >
                            </b-form-select>
                            <div
                                class="text-danger"
                                v-if="form.errors.has('role')"
                                v-html="form.errors.get('role')"
                            />
                        </b-form-group>
                        <b-form-group
                            class="font-weight-bold"
                            label="Mot de passe*"
                            v-if="!editMode"
                        >
                            <b-form-input
                                v-model="form.password"
                                type="password"
                                required
                                min="5"
                            ></b-form-input>
                            <div
                                class="text-danger"
                                v-if="form.errors.has('password')"
                                v-html="form.errors.get('password')"
                            />
                        </b-form-group>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        @click="hideModal"
                    >
                        Fermer
                    </button>
                    <input
                        :disabled="form.busy"
                        type="submit"
                        value="Ajouter"
                        class="btn btn-primary"
                        v-if="!editMode"
                    />
                    <input
                        :disabled="form.busy"
                        type="submit"
                        value="Modifier"
                        class="btn btn-success"
                        v-else
                    />
                </div>
            </form>
        </b-modal>
        <b-modal
            ref="password_modal"
            id="password_modal"
            hide-footer
            title="Changer le mots de passe"
            size="sm"
            @hidden="hidePasswordModal"
        >
            <form @submit.stop.prevent="updatePassword" autocomplete="off">
                <div class="modal-body">
                    <div class="form-row">
                        <b-form-group
                            class="font-weight-bold"
                            label="Nouveau mots de passe*"
                        >
                            <b-form-input
                                v-model="form.password"
                                type="password"
                                required
                                placeholder="Mots de passe..."
                            ></b-form-input>
                            <div
                                class="text-danger"
                                v-if="form.errors.has('password')"
                                v-html="form.errors.get('password')"
                            />
                        </b-form-group>
                        <b-form-group
                            class="font-weight-bold"
                            label="Confirmer mots de passe"
                        >
                            <b-form-input
                                v-model="form.password_confirmation"
                                type="password"
                                required
                                placeholder="Mots de passe..."
                            ></b-form-input>
                            <div
                                class="text-danger"
                                v-if="form.errors.has('password')"
                                v-html="form.errors.get('password')"
                            />
                        </b-form-group>
                    </div>
                </div>
                <div class="modal-footer">
                    <input
                        :disabled="form.busy"
                        type="submit"
                        value="Changer le mots de passe"
                        class="btn btn-danger"
                    />
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
// import ColourPicker from "vue-colour-picker";

export default {
    props: {},
    components: {
        // "colour-picker": ColourPicker
    },
    data() {
        return {
            editMode: false,
            title: "Nouvelle utilisateur",
            roles: [],
            users: [],
            id: "",
            // Create a new form instance
            form: new Form({
                name: "",
                prenom: "",
                profession: "",
                email: "",
                color: "green",
                password: "",
                role: ""
            })
        };
    },
    methods: {
        hideModal() {
            this.editMode = false;
            this.form.reset();
            this.$bvModal.hide("user_modal");
        },
        showModal() {
            if (this.editMode) this.editMode = false;
            axios.get("/admin/role").then(response => {
                this.roles = response.data;
            });
            this.form.reset();
            $("#user_modal")
                .appendTo("body")
                .modal("show");
        },
        async createUser() {
            const response = await this.form.post("/admin/user");

            this.users.push(response.data);

            this.hideModal();

            this.$toaster.success("Utilisateur ajoutée !");
        },
        remove(id, index) {
            if (confirm("Vous confirmer la suppression de l'utilisateur ?")) {
                axios
                    .delete("/admin/user/" + id)
                    .then(response => {
                        this.users.splice(index, 1);
                    })
                    .catch(exception => {
                        this.$toaster.error(exception);
                    });
            }
        },
        /**
         * @description on click on "Modifier" button
         * @param {Object} user
         */
        updateModal(user) {
            this.form.reset();
            this.editMode = true;
            this.form.fill({
                name: user.name,
                prenom: user.prenom,
                email: user.email,
                profession: user.profession,
                color: user.color,
                role: user.role.id
            });
            this.id = user.id;
            this.$bvModal.show("user_modal");
        },

        async updateUser() {
            const response = await this.form.put("/admin/user/" + this.id);

            this.users.forEach((val, index) => {
                if (val.id == this.id) this.users[index] = response.data;
            });

            this.hideModal();

            this.$toaster.success("Utilisateur modifier avec succés !");
        },
        openPasswordModal(user) {
            this.id = user.id;
            this.$bvModal.show("password_modal");
        },
        async updatePassword() {
            const response = await this.form.post(
                "/admin/user/" + this.id + "/reset-password/"
            );

            this.$bvModal.hide("password_modal");

            this.$toaster.success("Changement de mots de passe effectué");
        },

        hidePasswordModal() {
            this.$bvModal.hide("password_modal");
        }
    },
    watch: {
        // form: {
        //     handler: function(val) {
        //         this.$refs.colorPicker.setColor(val.color);
        //     },
        //     deep: true
        // }
    },
    computed: {},
    mounted() {
        axios.get("/admin/role").then(response => {
            this.roles = response.data;
        });
        axios
            .get("/admin/user")
            .then(response => {
                this.users = response.data;
            })
            .catch(exception => {
                this.$toaster.error(exception);
            });
    }
};
</script>
