// router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import LoginPage from '../components/LoginPage.vue';
import AddEvent from '../components/AddEvent.vue';
import RegisterPage from '../components/RegisterPage.vue';
import MainLayout from '../components/MainLayout.vue';
import AuthLayout from '../components/AuthLayout.vue';
import EventsHome from '../components/EventsHome.vue';
import Dashboard from '@/components/DashboardPage.vue';
import TicketInfo from '../components/TicketInfo.vue'
import store from '../components/store'; // Assuming your Vuex store is in the root

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
    component: MainLayout,
    children: [
      { path: 'event/create', name: 'addevent', component: AddEvent, meta: { requiresAuth: true } },
      { path: 'events', name: 'viewevents', component: EventsHome, meta: { requiresAuth: true } },
      { path: 'dashboard', name: 'dashboard', component: Dashboard, meta: { requiresAuth: true } },
      { path: '/ticket-info/:eventId',  name: 'TicketInfo',component: TicketInfo,  props: true, meta: { requiresAuth: true } }
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const isLoggedIn = store.state.user.userId !== null; // Check if userId is not null or undefined

  if (to.matched.some(record => record.meta.requiresAuth) && !isLoggedIn) {
    next({ name: 'login' }); // Redirect to login if route requires authentication and user is not logged in
  } else {
    next(); // Continue to the requested route
  }
});

export default router;
