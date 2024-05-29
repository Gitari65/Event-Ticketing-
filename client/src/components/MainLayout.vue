<template>
    <div class="main-container d-flex">
      <SideBar />
      <div class="content-container">
        <!-- <NavBar /> -->
        <div class="content">
          <router-view />
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import SideBar from './SideBar.vue';

  
  export default {
    components: {
      SideBar,
     
    },
  };
  </script>
  
  <style scoped>
  .main-container {
    display: flex;
  }
  
  .content-container {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    margin-left: 5%; /* Adjust based on sidebar width */
  }
  
  .content {
    flex-grow: 1;
    padding: 20px;
    margin-top: 60px; /* Adjust based on navbar height */
  }
  </style>
  