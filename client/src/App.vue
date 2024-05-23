<template>
  <div class="main-container d-flex">
    <router-view name="sidebar" />
    <div class="content-container">
      <router-view name="navbar" />
      <div class="content">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
import  '../src/assets/styles/styles.css'
export default {
  name: 'App',
};
</script>

<style>
.main-container {
  display: flex;
}
.content-container {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}
.content {
  flex-grow: 1;
  padding: 20px;
}
</style>
