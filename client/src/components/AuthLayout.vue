<template>
    <div>
        <NavBar/>
      <router-view />
    </div>
  </template>
  
  <script>
 import NavBar from './NavBar.vue';
  export default {
    name: 'AuthLayout',
    components:{NavBar}
  };
  </script>
  
  <style scoped>
  /* Add any specific styles for the auth layout here */
  </style>
  