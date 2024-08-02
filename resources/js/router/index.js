import { createRouter,createWebHistory } from "vue-router";

import JobVacancy from '../components/JobVacancy.vue';
import about from '../components/AboutPage.vue';
import notfound from '../components/Notfound.vue';
const routes=[

    {
         path:'/',
         component:JobVacancy

    },
    {
        path:'/about',
        component:about

   },{
    path:'/:pathMatch(.*)*',
    component:notfound

},
]

const router=createRouter({
history:createWebHistory(),
routes,

})

export default router
