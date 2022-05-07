<template>
    <div>
        <div
            class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header closed-sidebar"
        >
            <Header :user="user" :csrf="csrf"></Header>
            <div class="app-main">
                <Aside :user="user"></Aside>

                <div class="app-main__outer">
                    <router-view
                        :user="user"
                        :csrf="csrf"
                        :key="$route.fullPath"
                    ></router-view>

                    <Footer></Footer>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "./layouts/Header.vue";
import Aside from "./layouts/Aside.vue";
import Footer from "./layouts/Footer.vue";
export default {
    props: ["user", "csrf"],
    components: {
        Header,
        Aside,
        Footer
    },
    data() {
        return {};
    },
    methods: {},

    mounted() {}
};
</script>
