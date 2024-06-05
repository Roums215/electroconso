<template>
    <div class="home">
      <h1>Home</h1>
      <router-link to="/login">Go to Login</router-link>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Home',
  };
  </script>
  
  <style scoped>
  .home {
    padding: 20px;
  }
  </style>
  