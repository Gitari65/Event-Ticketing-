<template>
  <div class="register-container">
    <form @submit.prevent="handleRegister" class="register-form">
      <h2>Register</h2>
      <input v-model="username" placeholder="Name" class="form-control" />
      <input v-model="email" placeholder="Email" class="form-control" />
      <input v-model="password" type="password" placeholder="Password" class="form-control" />
      <button type="submit" class="btn btn-primary">Register</button>
      <p>Already have an account? <router-link to="/login">Login</router-link></p>
      <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      username: '',
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
          name: this.username
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

<style scoped>
.register-container {
  display: flex;
  justify-content: center;

  height: 100vh;

}

.register-form {
  background: white;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 400px;
  margin-top: 2%;
  height: 400px;
}

.register-form h2 {
  margin-bottom: 20px;
  text-align: center;
}

.form-control {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ced4da;
  border-radius: 4px;
}

.btn {
  width: 100%;
  padding: 10px;
}

.error-message {
  color: red;
  text-align: center;
  margin-top: 10px;
}
</style>
