import { createRouter,createWebHistory } from "vue-router";

import JobVacancy from '../components/JobVacancy.vue';

import notfound from '../components/Notfound.vue';
const routes=[

    {
         path:'/',
         component:JobVacancy

    },
    {
    path:'/:pathMatch(.*)*',
    component:notfound

},
]

const router=createRouter({
history:createWebHistory(),
routes,

})

export default router
