<template>
    <div class="login">
      <div class="form-container">
        <h2>Créer un compte administrateur</h2>
        <form @submit.prevent="registerAdmin">
          <label for="firstName">Prénom:</label>
          <input type="text" v-model="firstName" required>
          
          <label for="lastName">Nom:</label>
          <input type="text" v-model="lastName" required>
          
          <label for="email">Email:</label>
          <input type="email" v-model="email" required>
          
          <label for="password">Mot de passe:</label>
          <input type="password" v-model="password" required>
          
          <button type="submit">Créer un compte administrateur</button>
        </form>
        <a href="/admin-login">Déjà un compte admin ? Connectez-vous</a>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'AdminCreation',
    data() {
      return {
        firstName: '',
        lastName: '',
        email: '',
        password: ''
      };
    },
    methods: {
      async registerAdmin() {
        try {
          const response = await axios.post('https://electroconso.alwaysdata.net/api/creationCompte.php', {
            firstName: this.firstName,
            lastName: this.lastName,
            email: this.email,
            password: this.password
          }, {
            withCredentials: true,
            headers: {
              'Content-Type': 'application/json'
            }
          });
          if (response.data.success) {
            alert('Compte administrateur créé avec succès');
            this.$router.push('/admin-login');
          } else {
            alert('Erreur: ' + response.data.message);
          }
        } catch (error) {
          console.error('Erreur lors de la création du compte administrateur:', error);
          alert('Erreur lors de la création du compte administrateur');
        }
      }
    }
  };
  </script>
  
  <style scoped>
  @import '../assets/css/Login.css';
  </style>
