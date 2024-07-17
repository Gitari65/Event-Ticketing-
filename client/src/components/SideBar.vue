<template>
  <div class="main-container d-flex">
    <div class="sidebar" id="side_nav" :class="{ active: isSidebarActive }">
      <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between">
        <h1 class="fs-4" v-if="!isSidebarActive">
          <a class="navbar-brand" href="#" style="display: inline-block; background: linear-gradient(45deg, #24c7ef, #f6a926); padding: 10px; border-radius: 20px; text-decoration: none; color: black;">
  <img src="../assets/images/KonaLogo.png" class="logo" alt="logo" style="height: 40px; vertical-align: middle; margin-right: 10px;" />
  <span style="font-size: 1.2rem;">Ticket</span><span style="font-size: 1.2rem; color: #ffcc00;">Kona</span>
</a>

         </h1>

        </div>
      <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between">
        <h1 class="fs-4" v-if="isSidebarActive">
          <span class="bg-white text-dark rounded shadow px-2 me-2">
            <a class="navbar-brand" href="#"><img src="../assets/images/ticketlogo1.png" class="logo" alt="logo" /></a>
          </span>
        </h1>
        <button class="btn close-btn px-1 py-0 text-white" @click="toggleSidebar">
          <font-awesome-icon :icon="['fas', isSidebarActive ? 'bars' : 'times']" />
        </button>
      </div>
      <ul class="list-unstyled px-2">
        <li :class="{ active: activeTab === 'dashboard' }" @click="activateTab('dashboard')">
           <router-link class="routerlink" to="/dashboard">
             <a href="#" class="text-decoration-none px-3 py-2 d-block">
          
             <font-awesome-icon :icon="['fas', 'home']" /> <span v-if="!isSidebarActive">Dashboard</span>
            </a>
           </router-link>
         
        </li>
        <li :class="{ active: activeTab === 'events' }" @click="activateTab('events')">
          <router-link class="routerlink" to="/events">  <a href="#" class="text-decoration-none px-3 py-2 d-block">
           
               <font-awesome-icon :icon="['fas', 'calendar-alt']" /> <span v-if="!isSidebarActive">Events</span>
           </a>
          </router-link>
         
        </li>
        <li :class="{ active: activeTab === 'payments' }" @click="activateTab('payments')">
          <a href="#" class="text-decoration-none px-3 py-2 d-block">
            <font-awesome-icon :icon="['fas', 'credit-card']" /> <span v-if="!isSidebarActive">Payments</span>
          </a>
        </li>
        <li :class="{ active: activeTab === 'settings' }" @click="activateTab('settings')">
          <a href="#" class="text-decoration-none px-3 py-2 d-block">
            <font-awesome-icon :icon="['fas', 'cog']" /> <span v-if="!isSidebarActive">Settings</span>
          </a>
        </li>
        <li :class="{ active: activeTab === 'logout' }" @click="activateTab('logout')">
          <a href="#" @click="logout" class="text-decoration-none px-3 py-2 d-block">
            <font-awesome-icon :icon="['fas', 'sign-out-alt']" /> <span v-if="!isSidebarActive">Logout</span>
          </a>
        </li>
        <hr class="h-color mx-2">
      </ul>
    </div>
    <div class="content">
      <nav class="navbar navbar-expand-md navbar-light bg-light">
        <!-- Navbar content -->
      </nav>
      <div class="logout container-fluid">
    <div class="row align-items-center">
      <div v-if="successMessage" class="align-items-center text-center"><SuccessPage /></div>
      <div v-if="errorMessage"><ErrorPage /></div>
      <div v-if="loading"><SpinnerPage /></div>
    </div>
    <!-- <div class="row">
      <div class="col-12 text-center">
        <button @click="handleLogout" class="btn btn-primary">Logout</button>
      </div>
    </div> -->
  </div>
      <!-- <div class="dashboard-content px-3 pt-4">
        <h2 class="fs-5">Dashboard</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum, totam? Sequi alias eveniet ut quas ullam delectus et quasi incidunt rem deserunt asperiores reiciendis assumenda doloremque provident, dolores aspernatur neque.</p>
      </div> -->
    </div>
  </div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faHome, faCalendarAlt, faCreditCard, faCog, faSignOutAlt, faBars, faTimes } from '@fortawesome/free-solid-svg-icons';
import axios from 'axios';
import SuccessPage from '../assets/constants/SuccessPage.vue';
import ErrorPage from '../assets/constants/ErrorPage.vue';
import SpinnerPage from '../assets/constants/SpinnerPage.vue';
import { useRouter } from 'vue-router';
import { mapActions } from 'vuex';
library.add(faHome, faCalendarAlt, faCreditCard, faCog, faSignOutAlt, faBars, faTimes);

export default {
  setup() {
    const router = useRouter();
    return {
      router
    };
  },
  components: {
    SuccessPage,
    ErrorPage,
    SpinnerPage,
    FontAwesomeIcon  },
  data() {
    return {
      errorMessage: '',
      successMessage: '',
      loading: false,
      isSidebarActive: false,
      activeTab: 'dashboard'
    };
  },
  

  methods: {
    toggleSidebar() {
      this.isSidebarActive = !this.isSidebarActive;
    },
    activateTab(tabName) {
      this.activeTab = tabName;
    },
    ...mapActions(['logout']),
    async handleLogout() {
      this.loading = true;
      this.errorMessage = '';
      this.successMessage = '';
      try {
        await axios.post('http://127.0.0.1:8000/api/logout', {}, {
          withCredentials: true // Ensure cookies are included in the request
        });

        this.successMessage = "Logged out successfully";
        this.loading = false;
        this.logout(); // Vuex action to clear user state and token
        this.$router.push({ name: 'login' });
      } catch (error) {
        if (error.response) {
          this.errorMessage = error.response.data.error || 'Logout failed';
        } else {
          this.errorMessage = 'An error occurred';
        }
        console.error('Logout failed:', error);
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
body {
  background: #eee;
}

#side_nav {
  background: #07407b;
  min-width: 250px;
  max-width: 250px;
  transition: all 0.3s ease-in-out;
}

#side_nav.active {
  min-width: 70px;
  max-width: 70px;
}

#side_nav .logo {
  height: 60px;
}

.content {
  min-height: 100vh;
  width: 100%;
}

hr.h-color {
  background: #eee;
}

.sidebar li.active {
  background: #eee;
  border-radius: 8px;
}

.sidebar li.active a,
.sidebar li.active a:hover {
  color: #000;
}

.sidebar li a {
  color: #fff;
}

.sidebar li a:hover {
  color: #f6a926;
}

.sidebar li a .fa {
  width: 20px;
}

.header-box .btn {
  display: flex;
  align-items: center;
  justify-content: center;
}

.header-box .btn .fa {
  font-size: 1.5em;
}

@media (max-width: 767px) {
  #side_nav {
    margin-left: -250px;
    position: absolute;
    min-height: 100vh;
    z-index: 1;
  }

  #side_nav.active {
    margin-left: 0;
  }
}

#side_nav.active .header-box h1 {
  display: none;
}

.header-box .btn {
  transition: all 0.3s ease-in-out;
}

.header-box .btn .fa {
  transition: all 0.3s ease-in-out;
}

 .routerlink {
  text-decoration: none;
}
</style>
