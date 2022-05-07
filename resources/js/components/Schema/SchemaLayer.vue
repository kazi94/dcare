<template>
    <div>
        <svg
            :id="id"
            style="position: absolute; 
            left: 0px; top: 0px; 
            padding: 0px; 
            border: 0px;"
            xmlns="http://www.w3.org/2000/svg"
            version="1.1"
            xmlns:xlink="http://www.w3.org/1999/xlink"
        />
        <schema-img
            ref="schema_img"
            @load="handleImgLoaded"
            v-on="$listeners"
        />
    </div>
</template>

<script>
import { SVG } from "@svgdotjs/svg.js";
import SchemaImg from "./SchemaImg";
export default {
    components: { SchemaImg },
    props: [],
    data() {
        return {
            id: "svg-" + this._uid,
            svg: Object,
            actShapes: [],
            initSchemaShapes: []
        };
    },
    methods: {
        /**
         * Handle on complete Image load
         * @param {Objects} e Load event
         */
        handleImgLoaded(e) {
            // config SVG Container
            this.configSVG();

            // Draw Basic Tooth Shapes
            this.initDentalSchema();

            // Draw Acts shapes if exist
            if (this.actShapes.length) this.createShapes(this.actShapes);

            // Draw Initial Schema shapes
            if (this.initSchemaShapes.length)
                this.createShapes(this.initSchemaShapes);
            this.$parent.$parent.$emit("img-fully-loaded");
        },
        /**
         * Config SVG Container
         */
        configSVG() {
            const w = this.$refs.schema_img.width;
            const h = this.$refs.schema_img.height;
            this.svg.size(w, h);
        },
        /**
         * initiate dental schema &&
         * Draw first basic tooth shapes
         */
        initDentalSchema() {
            let basicCoords = this.$store.state.GlobalBasicCoords;

            if (basicCoords.length == 0) {
                axios
                    .get("/patients/schema-dentaire")
                    .then(response => {
                        this.$store.commit("storeBasicCoords", response.data);

                        this.createShapes(response.data);
                    })
                    .catch(error => {
                        this.$toaster.error(error);
                    });
            }
            this.createShapes(basicCoords);
        },
        /**
         * Get basic shapes
         */
        async getBasicShapes() {
            let res = "";
            axios
                .get("/patients/schema-dentaire")
                .then(response => {
                    this.$store.commit("storeBasicCoords", response.data);

                    res = response.data;
                })
                .catch(error => {
                    this.$taster.error(error);
                });
            return res;
        },
        /**
         * create and draw shapes elements
         * @param {Array} shapes List of shapes to draw
         */
        createShapes(shapes) {
            // Draw The Basic Elements
            shapes.forEach(shape => {
                this.createShape(shape);
            });
        },
        /**
         * Create new shape
         * @param {String} shape
         */
        createShape({
            coord,
            teeth,
            formulas,
            pivot,
            color,
            opacity,
            quot_id = null
        }) {
            let polygon;
            // get the coords convert adapat to actual media
            let convertTo = this.$refs.schema_img.convertCoord(coord);

            polygon = this.drawShape(convertTo, { formulas, color, opacity });

            document.getElementById(polygon).setAttribute("tooth", teeth);
            document.getElementById(polygon).setAttribute("formula", formulas);
            if (pivot?.acte_id != undefined)
                document
                    .getElementById(polygon)
                    .setAttribute("acte_id", pivot.acte_id);
            if (quot_id)
                document.getElementById(polygon).setAttribute("devis", quot_id);
            if (formulas == "basic")
                document.getElementById(polygon).classList.add("initial");

            polygon.on("click", this.handleClickTooth);
        },
        /**
         * Draw new shape
         * @param {Array} coord Coordinates
         * @param {Object} shape
         * @return {Rect|Circle|Polygon|Polyline} shape
         */
        drawShape(coord, shape) {
            let draw = this.svg;
            let createdShape = "";
            switch (shape.formulas) {
                case "kyste":
                case "abc":
                    createdShape = draw
                        .circle(coord[2] * 2)
                        .fill(shape.color)
                        .move(coord[0] - 10, coord[1] - 10)
                        .back();
                    break;
                case "frac-cour":
                case "frac-rac":
                    createdShape = draw
                        .polyline(coord.toString())
                        .fill("none")
                        .stroke({
                            color: shape.color || "black",
                            width: 1,
                            linecap: "round",
                            linejoin: "round"
                        })
                        .back();
                    break;
                case "abs":
                case "rac-resid":
                    createdShape = draw
                        .rect(coord[2] - coord[0], coord[3] - coord[1])
                        .fill(shape.color)
                        .move(coord[0], coord[1])
                        .back();
                    break;

                case "basic":
                    createdShape = draw
                        .polygon(coord.toString())
                        .fill({ color: shape.color, opacity: shape.opacity })
                        .stroke({ width: 1 });
                    break;
                default:
                    createdShape = draw
                        .polygon(coord.toString())
                        .fill({ color: shape.color, opacity: shape.opacity })
                        .stroke({ width: 1 })
                        .back();
                    break;
            }
            return createdShape;
        },
        /**
         * Handle click on tooth
         * @param {Object} e Click event
         */
        handleClickTooth: function(e, flag = true) {
            const polygonID = e.type == "polygon" ? e : SVG(e.currentTarget);
            const color = polygonID.attr("fill");
            const numTooth = polygonID.attr("tooth");
            if (color == "#ffffff") {
                // select
                polygonID.fill({
                    color: "#007bff",
                    opacity: 0.6
                });
            }
            if (color == "#007bff") {
                // unselect
                polygonID.fill({ color: "#fff", opacity: 0 });
            }
            if (flag) this.$emit("selected-tooth", numTooth);
        },
        resetSVG() {
            this.svg.each(function(i, children) {
                if (this.hasClass("initial"))
                    this.fill({ color: "#fff", opacity: 0 });
            });
        },
        /**
         * Remove Shapes from the schema for a list of teeth
         * @param {Array} teeth list of teeth numbers
         */
        removeShapesByTeeth(teeth = [], formula) {
            teeth.forEach(teeth => {
                this.svg.each(function(i, children) {
                    const teethAttr = this.attr("tooth");
                    const titleAttr = this.attr("formula");
                    if (teeth == teethAttr && titleAttr == formula)
                        this.remove();
                });
            });
        },

        removeShapesByLine(line) {
            var teeth = line.teeth.split(",");
            teeth.forEach(teeth => {
                this.svg.each(function(i, children) {
                    const teethAttr = this.attr("tooth");
                    const titleAttr = this.attr("acte_id");
                    if (
                        parseInt(teeth) == teethAttr &&
                        titleAttr == line.acte_id
                    )
                        this.remove();
                });
            });
        },
        removeShapesByQuotation(quotID) {
            this.svg.each(function(i, children) {
                const quotAttr = this.attr("devis");
                if (quotID === quotAttr) this.remove();
            });
        }
    },
    mounted() {
        this.svg = SVG("#svg-" + this._uid);
    }
};
</script>

<style></style>
