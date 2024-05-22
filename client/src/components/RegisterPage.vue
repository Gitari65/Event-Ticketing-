<template>
    <div>
      <form @submit.prevent="handleRegister">
        <input v-model="username" placeholder="Name" />
        <input v-model="email" placeholder="Email" />
        <input v-model="password" type="password" placeholder="Password" />
        <button type="submit">Register</button>
        <p v-if="errorMessage">{{ errorMessage }}</p>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        username:'',
        email: '',
        password: '',
        errorMessage: ''
      };
    },
    methods: {
      async handleRegister() {
        try {
          const response = await axios.post('http://127.0.0.1:8000/register', {
            email: this.email,
            password: this.password,
            name:this.username
          }, {
            withCredentials: true // Ensure cookies are included in the request
          });
  
          console.log('Signup successful:', response.data);
        } catch (error) {
          if (error.response) {
            this.errorMessage = error.response.data.error || 'Signup failed';
          } else {
            this.errorMessage = 'An error occurred';
          }
          console.error('Signup failed:', error);
        }
      }
    }
  };
  </script>
  