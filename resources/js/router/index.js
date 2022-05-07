import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const DEFAULT_TITLE = 'Some Default Title';

const routes = [{
    path: '/acceuil',
    name: 'home',
    component: () => import('../views/Home.vue'),
    meta: {
        title: 'DCare | Page d\'acceuil',
    }
},
{
    path: '/patients',
    name: 'patients',
    component: () => import('../views/Patients.vue'),
    meta: {
        title: 'DCare | Mes Patients',
    }
},
{
    path: '/patients?page=:page',
    name: 'patients',
    component: () => import('../views/Patients.vue'),
    meta: {
        title: 'DCare | Mes Patients',
    }
},
{
    path: '/patients/:id',
    name: 'patient',
    component: () => import('../views/Patient.vue'),
    meta: {
        title: 'DCare | Dossier Patient',
    },
    // children: [
    //     {
    //         path: 'page',
    //         component: () => import('../components/Patient/PatientTable.vue'),
    //     },
    // ]
},

{
    path: '/mes-prescriptions',
    name: 'prescriptions',
    component: () => import('../views/Prescriptions.vue'),
    meta: {
        title: 'DCare | Mes Prescriptions',
    }
},
{
    path: '/admin/reglages',
    name: 'settings',
    component: () => import('../views/Settings.vue'),
    meta: {
        title: 'DCare | Réglages',
    }
},
{
    path: '/mes-honoraires',
    name: 'payments',
    component: () => import('../views/Payments.vue'),
    meta: {
        title: 'DCare | Mes Honoraires',
    }
},
{
    path: '/mes-videos',
    name: 'videos',
    component: () => import('../views/Videos.vue'),
    meta: {
        title: 'DCare | Videos Demo',
    }
},
{
    path: '/mon-cabinet',
    name: 'dashboard',
    component: () => import('../views/Dashboard.vue'),
    meta: {
        title: 'DCare | Mon Cabinet',
    }
},
{
    path: '/mon-cabinet/statistiques',
    name: 'statistics',
    component: () => import('../views/Statistics.vue'),
    meta: {
        title: 'DCare | Statistiques',
    }
},
    // {
    //     path: '/mes-photos',
    //     name: 'photos',
    //     component: Photos,
    //        meta: {
    //        title: 'DCare | Dossier Patient',
    //    }
    // },
];


const router = new VueRouter({
    mode: 'history',
    routes,

});
router.afterEach((to, from) => {
    // Use next tick to handle router history correctly
    // see: https://github.com/vuejs/vue-router/issues/914#issuecomment-384477609
    Vue.nextTick(() => {
        document.title = to.meta.title || DEFAULT_TITLE;
    });
});
export default router;
