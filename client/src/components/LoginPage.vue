<template>
  <div>
    <form @submit.prevent="handleLogin">
      <input v-model="email" placeholder="Email" />
      <input v-model="password" type="password" placeholder="Password" />
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async handleLogin() {
    await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie').then(response=> {
       console.log('csrf data:',response.data) 
        axios.post('http://127.0.0.1:8000/login', {
          email: this.email,
          password: this.password
        },{
         headers: {
          Accept:"application/json",
            'X-XSRF-TOKEN': response.data.csrfToken,
             'X-CSRF-TOKEN': response.data.csrfToken,
          },
          withCredentials: true // Ensure cookies are included in the request,
      
        })
        .then(response => {
          console.log('Logged in successfully:', response.data);
        })
        .catch(error => {
          console.error('Login failed:', error);
        });
      });
    }
  }
};
</script>
