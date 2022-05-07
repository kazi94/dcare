<template>
    <div style="position:relative">
        <b-button
            :pressed.sync="sectionsBtn[num].state"
            variant="outline-primary"
            class="mb-1 rounded-circle font-weight-bold "
            :class="classBtn"
            @click="$emit('click')"
            size="sm"
        >
            {{ sectionsBtn[num].caption }}
        </b-button>
    </div>
</template>

<script>
export default {
    name: "SectorButton",
    props: ["num"],
    data() {
        return {
            sectionsBtn: [
                { caption: "S1", state: false },
                { caption: "S2", state: false },
                { caption: "S3", state: false },
                { caption: "S4", state: false }
            ]
        };
    },
    methods: {},
    computed: {
        classBtn: function() {
            switch (this.num) {
                case "0":
                    return "button-sector-1";
                    break;
                case "1":
                    return "button-sector-2";
                    break;
                case "2":
                    return "button-sector-3";
                    break;
                case "3":
                    return "button-sector-4";
                    break;
            }
        }
    }
};
</script>

<style>
.button-sector-1 {
    top: 2px;
    left: 5px;
    z-index: 999999;
    position: absolute;
}
.button-sector-2 {
    top: 2px;
    right: 5px;
    z-index: 999999;
    position: absolute;
}
.button-sector-3 {
    position: absolute;
    bottom: 3px;
    z-index: 999999;
}
.button-sector-4 {
    position: absolute;
    bottom: 3px;
    right: 5px;
    z-index: 999999;
}
</style>
