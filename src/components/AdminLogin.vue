<template>
  <div class="login">
    <div class="form-container">
      <h2>Connexion Administrateur</h2>
      <form @submit.prevent="login">
        <label for="email">Email:</label>
        <input type="email" v-model="email" required>
        
        <label for="password">Mot de passe:</label>
        <input type="password" v-model="password" required>
        
        <button type="submit">Connexion</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AdminLogin',
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('https://electroconso.alwaysdata.net/api/adminLogin.php', {
          email: this.email,
          password: this.password
        }, {
          withCredentials: true,
          headers: {
            'Content-Type': 'application/json'
          }
        });
        console.log(response.data); //  journal
        if (response.data.success) {
          alert('Connexion réussie');
          this.$router.push('/admin');
        } else {
          alert('Erreur: ' + response.data.message);
        }
      } catch (error) {
        console.error('Erreur lors de la connexion:', error);
        alert('Erreur lors de la connexion');
      }
    }
  }
};
</script>

<style scoped>
</style>
