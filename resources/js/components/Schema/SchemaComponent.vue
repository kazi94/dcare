<template>
    <div>
        <sector-button
            num="0"
            @click="selectSection('s1')"
            v-show="isToothVisible"
            ref="sector_button_1"
        >
        </sector-button>
        <sector-button
            num="1"
            @click="selectSection('s2')"
            v-show="isToothVisible"
            ref="sector_button_2"
        >
        </sector-button>
        <div style="position: relative" :class="p_class">
            <schema-layer
                ref="schema_layer"
                @selected-tooth="handleSelectedTooth"
                v-on="$listeners"
            />
        </div>
        <sector-button
            num="2"
            @click="selectSection('s3')"
            v-show="isToothVisible"
            ref="sector_button_3"
        >
        </sector-button>
        <sector-button
            num="3"
            @click="selectSection('s4')"
            v-show="isToothVisible"
            ref="sector_button_4"
        >
        </sector-button>
        <slot name="formules"></slot>
    </div>
</template>

<script>
import SectorButton from "./SectorButton";
import SchemaLayer from "./SchemaLayer";
export default {
    components: { SectorButton, SchemaLayer },

    props: ["selectedTooth", "isToothVisible", "p_class", "patient"],
    data() {
        return {
            coords: [],
        };
    },
    methods: {
        /**
         * Handle select sector
         */
        selectSection: function (sector) {
            let section = [];
            let vm = this;
            let index = this.selectedTooth.indexOf(sector);

            if (index == -1) this.selectedTooth.push(sector);
            else this.selectedTooth.splice(index, 1);
            switch (sector) {
                case "s1":
                    section = [11, 12, 13, 14, 15, 16, 17, 18];
                    break;
                case "s2":
                    section = [21, 22, 23, 24, 25, 26, 27, 28];
                    break;
                case "s3":
                    section = [41, 42, 43, 44, 45, 46, 47, 48];
                    break;
                case "s4":
                    section = [31, 32, 33, 34, 35, 36, 37, 38];
                    break;
            }
            this.$refs.schema_layer.svg.each(function (i, children) {
                section.forEach((teeth) => {
                    const polyTeeth = this.attr("tooth");
                    if (polyTeeth == teeth) {
                        vm.$refs.schema_layer.handleClickTooth(this, false);
                    }
                });
            });

            this.$emit("selectedTooth", this.selectedTooth);
        },
        /**
         * Handle selection of one tooth
         * Add the tooth to the selected teeth array
         * && emit to the parent
         * @param {Number} num number of tooth
         */
        handleSelectedTooth(num) {
            let index = this.selectedTooth.indexOf(parseInt(num));

            if (index == -1) this.selectedTooth.push(parseInt(num));
            else this.selectedTooth.splice(index, 1);
            this.$emit("selectedTooth", this.selectedTooth);
        },
        /**
         * Reset Section buttons to deactivate
         * Reset select teeth shape to initial state
         */
        resetTooth() {
            //Reset Section buttons to deactivate
            this.$refs.sector_button_1.sectionsBtn.map(
                (t) => (t.state = false)
            );
            this.$refs.sector_button_2.sectionsBtn.map(
                (t) => (t.state = false)
            );
            this.$refs.sector_button_3.sectionsBtn.map(
                (t) => (t.state = false)
            );
            this.$refs.sector_button_4.sectionsBtn.map(
                (t) => (t.state = false)
            );
            //Reset select teeth shape to initial state
            this.$refs.schema_layer.resetSVG();
        },
    },
    watch: {},
    mounted() {},
};
</script>

<style></style>
