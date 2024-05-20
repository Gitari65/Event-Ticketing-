// main.js
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from './axios' // Import the axios configuration

// Make Axios available globally
const app = createApp(App);
app.config.globalProperties.$axios = axios;

// Use the router
app.use(router);

// Mount the app
app.mount('#app');
