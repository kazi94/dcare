<template>
    <div v-if="this.quotation.length > 0">
        <b-table
            ref="selectableTable"
            selectable
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
        >
            <template v-slot:cell(prix)="data">
                <input
                    type="text"
                    v-if="edit"
                    v-model="data.item.prix"
                    @keyup.enter="
                        data.item.prix = parseInt($event.target.value);
                        edit = false;
                    "
                />
                <p v-else @click="edit = true">
                    <b class="text-info">{{ data.item.prix }}</b>
                </p>
            </template>

            <template v-slot:cell(selected)="{ rowSelected }">
                <template v-if="rowSelected">
                    <span aria-hidden="true">&check;</span>
                    <span class="sr-only">Selected</span>
                </template>
                <template v-else>
                    <span aria-hidden="true">&nbsp;</span>
                    <span class="sr-only">Not selected</span>
                </template>
            </template>
        </b-table>
    </div>
</template>

<script>
export default {
    props: ['quotation'],

    data() {
        return {

        };
    },

    methods: {

    },

    mounted() {}
};
</script>
