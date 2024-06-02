// main.js
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from './axios' // Import the axios configuration
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.css'
import store from './components/store'


// Make Axios available globally
const app = createApp(App);
app.config.globalProperties.$axios = axios;

// Use the router
app.use(router);
app.use(store);

// Mount the app
app.mount('#app');
