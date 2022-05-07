import SectorButton from "./SectorButton.vue";
import SchemaLayer from "./SchemaLayer.vue";
export default {
    components: {SectorButton, SchemaLayer},

    props: [
        "selectedTooth",
        "isToothVisible",
        "p_class",
        "img_id",
        "schema_id",
        "patient"
    ],
    data() {
        return {
            coords: [],
        };
    },
    methods: {
        selectSection: function(sector) {
            let section = [];
            let  vm = this;
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
            this.$refs.schema_layer.svg.each(function(i, children) {
                section.forEach(teeth => {
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
        handleSelectedTooth(num)
        {
            let index = this.selectedTooth.indexOf(parseInt(num));

            if (index == -1) this.selectedTooth.push(parseInt(num));
            else this.selectedTooth.splice(index, 1);
            this.$emit("selectedTooth", this.selectedTooth);
        },
        resetTooth() {
            this.$refs.sector_button.sectionsBtn.map(t => (t.state = false));
            
            this.$refs.schema_layer.resetSVG();
        }
    },
    watch: {},
    mounted() {
        console.log(
            "%cSchema Component Mounted !",
            "color : red; font-seize : 8px;"
        );
        // render and config mounted schema
        // this.initSchema();
    }
};