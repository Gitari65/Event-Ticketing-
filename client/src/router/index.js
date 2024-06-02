import { createRouter, createWebHistory } from 'vue-router';
import LoginPage from '../components/LoginPage.vue';
import AddEvent from '../components/AddEvent.vue';
import RegisterPage from '../components/RegisterPage.vue';
import MainLayout from '../components/MainLayout.vue'; // New layout component
import AuthLayout from '../components/AuthLayout.vue';
import EventsHome from '../components/EventsHome.vue';
const routes = [
  {
    path: '/',
    component: AuthLayout,
    children: [
      { path: 'login', name: 'login', component: LoginPage },
      { path: 'register', name: 'register', component: RegisterPage },
    ],
  },
  {
    path: '/',
    name: 'main',
    components: {
      default: MainLayout,
    },
    children: [
      
      { path: 'event/create', name: 'addevent', component: AddEvent },
     { path: 'events', name: 'viewevents', component: EventsHome },
   
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
