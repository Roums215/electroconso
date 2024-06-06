<template>
    <div class="login">
      <div class="form-container">
        <h2>Créer un compte</h2>
        <form @submit.prevent="register">
          <label for="nom">Nom:</label>
          <input type="text" v-model="nom" required>
          
          <label for="prenom">Prénom:</label>
          <input type="text" v-model="prenom" required>
          
          <label for="email">Email:</label>
          <input type="email" v-model="email" required>
          
          <label for="password">Mot de passe:</label>
          <input type="password" v-model="password" required>
          
          <button type="submit">Créer un compte</button>
        </form>
        <a href="/login">Déjà un compte? Connectez-vous</a>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'CreationCompte',
    data() {
      return {
        nom: '',
        prenom: '',
        email: '',
        password: ''
      };
    },
    methods: {
      async register() {
        try {
          const response = await axios.post('https://electroconso.alwaysdata.net/api/register.php', {
            nom: this.nom,
            prenom: this.prenom,
            email: this.email,
            password: this.password
          }, {
            withCredentials: true,
            headers: {
              'Content-Type': 'application/json'
            }
          });
          if (response.data.success) {
            alert('Compte créé avec succès');
            this.$router.push('/login');
          } else {
            alert('Erreur: ' + response.data.message);
          }
        } catch (error) {
          console.error('Erreur lors de la création du compte:', error);
          alert('Erreur lors de la création du compte');
        }
      }
    }
  };
  </script>
  
  <style scoped>
  @import '../assets/css/Login.css';
  </style>
  