<template>
  <div>
    <form @submit.prevent="handleLogin">
      <input v-model="email" placeholder="Email" />
      <input v-model="password" type="password" placeholder="Password" />
      <button type="submit">Login</button>
      <p v-if="errorMessage">{{ errorMessage }}</p>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      errorMessage: ''
    };
  },
  methods: {
    async handleLogin() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/login', {
          email: this.email,
          password: this.password
        }, {
          withCredentials: true // Ensure cookies are included in the request
        });

        console.log('Logged in successfully:', response.data);
      } catch (error) {
        if (error.response) {
          this.errorMessage = error.response.data.error || 'Login failed';
        } else {
          this.errorMessage = 'An error occurred';
        }
        console.error('Login failed:', error);
      }
    }
  }
};
</script>
<style >

</style>
