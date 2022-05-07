<template>
    <!-- Table quotation -->
    <div>
        <b-table
            :ref="uid"
            :selectable="true"
            select-mode="multi"
            @row-selected="onRowSelected"
            :items="quotation"
            :fields="fields"
            bordered
            responsive="sm"
            small
            head-variant="light"
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            class="text-center"
        >
            <template #cell(acte)="data">
                {{ data.item.act.nom }}
                <video-demo-player
                    v-if="data.item.act.videos"
                    :act="data.item.act"
                    :videos="data.item.act.videos"
                ></video-demo-player>
            </template>
            <template v-slot:cell(price)="data">
                <input
                    type="text"
                    v-if="edit && isQuotation"
                    v-model="data.item.price"
                    @keyup.enter="handlePriceOnKeyUpEnterEvent(data)"
                />
                <p v-else @click="edit = true">
                    <b class="text-info"> {{ data.item.price }} DA </b>
                </p>
            </template>

            <template
                v-slot:cell(selected)="{ rowSelected }"
                v-if="isQuotation"
            >
                <template v-if="rowSelected">
                    <span aria-hidden="true">&check;</span>
                    <span class="sr-only">Selected</span>
                </template>
                <template v-else>
                    <span aria-hidden="true">&nbsp;</span>
                    <span class="sr-only">Not selected</span>
                </template>
            </template>
            <template v-slot:cell(delete)="data" v-if="isQuotation">
                <b-icon
                    v-b-tooltip.hover.bottom
                    tiltle="Supprimer l'acte dentaire"
                    icon="x-circle"
                    scale="2"
                    variant="danger"
                    style="cursor: pointer"
                    @click="removeLine(data.item)"
                ></b-icon>
            </template>
            <template
                v-slot:cell(accepted_state_title)="data"
                v-if="!isQuotation"
            >
                <p
                    class="text-danger font-weight-bold"
                    v-if="data.item.accepted_state_title == 'Rejeter'"
                >
                    {{ data.item.accepted_state_title }}
                </p>
                <p v-else class="text-success font-weight-bold">
                    {{ data.item.accepted_state_title }}
                </p>
            </template>
        </b-table>
    </div>
</template>

<script>
import VideoDemoPlayer from "@/Components/VideoDemo/VideoDemoPlayer";
export default {
    components: {
        VideoDemoPlayer,
    },
    props: {
        quotation: {
            type: Array,
            required: true,
            default: function () {
                return [];
            },
        },
        selected: {
            type: Array,
            default: function () {
                return [];
            },
        },
        isQuotation: {
            type: Boolean,
            required: true,
        },
    },

    data() {
        return {
            onlyOk: true,
            fields: [
                { key: "selected", sortable: false, label: "#" },
                { key: "num_dent", sortable: true },
                { key: "acte", sortable: true },
                { key: "price", sortable: true, label: "Prix" },
                { key: "delete", sortable: false, label: "Action" },
            ],
            sortBy: "num_dent",
            sortDesc: false,
            videoToRead: null,
            titleVideo: null,
            edit: false,
            uid: this._uid,
        };
    },

    methods: {
        clearSelected() {
            this.$refs[this.uid].clearSelected();
        },
        selectAllRows() {
            this.$refs[this.uid].selectAllRows();
        },
        onRowSelected(items) {
            this.$emit("update:selected", items);
        },

        /**
         *
         */
        handlePriceOnKeyUpEnterEvent($event, data) {
            const line_id = data.item.id;
            const newPrice = parseInt($event.target.value);
            const currentPrice = data.item.price;
            data.item.price = newPrice;
            this.edit = false;

            let formData = new FormData();

            formData.set("price", newPrice);

            this.$emit("price-updated", {
                newPrice: newPrice,
                oldPrice: currentPrice,
            });
            axios.post("/api/patients/plan/lines/" + line_id, formData);
        },
        removeLine(line) {
            if (confirm("Vous ètes sûr de supprimer l'acte ?"))
                axios.delete(`/patients/devis/lines/${line.id}`).then(() => {
                    // remove line from the table
                    const updatedQuotation = this.quotation.filter(
                        (l) => l.id != line.id
                    );
                    this.$emit("update:quotation", updatedQuotation);

                    //update total

                    // remove act from the dental schema
                    this.$emit("removed-line", line);
                });
        },
        handleReadOnlyMode(newVal) {
            if (!newVal) {
                this.fields.push({
                    key: "accepted_state_title",
                    sortable: true,
                    label: "Status",
                });
                const indexDelete = this.fields.findIndex(
                    (ele) => ele.key == "delete"
                );
                const indexSelected = this.fields.findIndex(
                    (ele) => ele.key == "selected"
                );
                this.fields.splice(indexDelete, 1);
                this.fields.splice(indexSelected, 1);
            }
        },
    },
    watch: {
        isQuotation: {
            handler: function (newVal) {
                this.handleReadOnlyMode(newVal);
            },
        },
    },
    mounted() {
        this.handleReadOnlyMode(this.isQuotation);
    },
};
</script>

<style></style>
