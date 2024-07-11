<template>
  <div class="login container-fluid">
    <div class="row align-items-center">
      <div v-if="successMessage" class="align-items-center align-text-center"><SuccessPage/></div>
      <div v-if="errorMessage"><ErrorPage/></div>
      <div v-if="loading"> <SpinnerPage /></div>
    </div>
    <div class="row">
      <div class="first-col col-sm-1 col-md-6 col-lg-8">
        <img src="../assets/images/backphoto.png" alt="logo"/>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-4">
        <form @submit.prevent="handleLogin">
          <h1>Sign in</h1><br>
          <input v-model="email" placeholder="Email" />
          <input v-model="password" type="password" placeholder="Password" />
          <button type="submit">Login</button>
          <p>Forgot password?</p>
          <p>Don't have an account? <router-link to="/register">Register</router-link></p>
          <p v-if="errorMessage">{{ errorMessage }}</p>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import SuccessPage from '../assets/constants/SuccessPage.vue'
import ErrorPage from '../assets/constants/ErrorPage.vue'
import SpinnerPage from '../assets/constants/SpinnerPage.vue'
import { useRouter } from 'vue-router';

export default {
  components: {
    SuccessPage,
    ErrorPage,
    SpinnerPage
  },
  setup() {
    const router = useRouter();

    return {
      router,
    };
  },
  data() {
    return {
      email: '',
      password: '',
      errorMessage: '',
      successMessage: '',
      loading: false
    };
  },
  methods: {
    async handleLogin() {
      this.loading = true;
      this.errorMessage = '';
      this.successMessage = '';

      try {
        const response = await axios.post('http://127.0.0.1:8000/login', {
          email: this.email,
          password: this.password,
          token_name: 'MyAppToken'
        }, {
          withCredentials: true // Ensure cookies are included in the request
        });

        console.log('Logged in successfully:', response.data);

        this.successMessage = "Logged in Successfully";
        this.loading = false;

        if (response.data.token) {
          const userId = response.data.userId;
          const userEmail = response.data.email;
          const userName = response.data.name;

          // Store the token in localStorage
          localStorage.setItem('authToken', response.data.token);

          // Store user data separately
          localStorage.setItem('userId', userId);
          localStorage.setItem('userName', userName);
          localStorage.setItem('userEmail', userEmail);

          // Store user in Vuex state
          this.$store.dispatch('setUser', { id: userId, email: userEmail, name: userName });

          // Redirect to dashboard route
          this.router.push({ name: 'dashboard' });
        }
      } catch (error) {
        if (error.response) {
          this.errorMessage = error.response.data.error || 'Login failed';
        } else {
          this.errorMessage = 'An error occurred';
        }
        console.error('Login failed:', error);
        this.loading = false;
      }
    }
  }
};
</script>