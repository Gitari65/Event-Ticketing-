
import LoginPage from '../components/LoginPage.vue'
import AddEvent from '../components/AddEvent.vue'
import { createRouter,createWebHistory } from 'vue-router';



const router=createRouter({
    history:createWebHistory(),
    routes:[
        {path:'/',name:"login",component:LoginPage},
        {path:'/event/create',name:"addevent",component:AddEvent}
    ]
})

export default router;