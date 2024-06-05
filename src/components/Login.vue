<template>
  <div class="login">
    <div class="form-container">
      <h2>Connexion</h2>
      <form @submit.prevent="login">
        <label for="email">Email:</label>
        <input type="email" v-model="email" required>
        
        <label for="password">Mot de passe:</label>
        <input type="password" v-model="password" required>
        
        <button type="submit">Connexion</button>
      </form>
      <a href="#">Mot de passe oublié ?</a>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import '@/assets/css/styles.css'; // Importer le fichier CSS global

export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('https://electroconso.alwaysdata.net/api/connexion.php', {
          email: this.email,
          password: this.password
        }, {
          withCredentials: true,
          headers: {
            'Content-Type': 'application/json'
          }
        });
        if (response.data.success) {
          alert('Connexion réussie');
          this.$router.push('/');
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
/* Styles spécifiques supplémentaires si nécessaire */
</style>
