<template>
  <div class="navbar">
    <ul>
      <li><router-link to="/">Accueil</router-link></li>
      <li><router-link to="/fournisseur">Fournisseur</router-link></li>
      <li class="logo"><router-link to="/"><img src="@/assets/img/logo-png.png" alt="Logo"></router-link></li>
      <li><router-link to="/page-prise">Ajouter une prise</router-link></li>
      <li><button @click="deco">Déconnexion</button></li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';
import '@/assets/css/styles.css'; 

export default {
  name: 'Navbar',
  methods: {
    async deco() {
      try {
        const response = await axios.post('https://electroconso.alwaysdata.net/api/deconnexion.php', {}, { withCredentials: true });
        if (response.data.success) {
          alert('Déconnexion réussie');
          this.$router.push('/login'); 
        } else {
          alert('Erreur: ' + response.data.message);
        }
      } catch (error) {
        console.error('Erreur lors de la déconnexion:', error);
        alert('Erreur lors de la déconnexion');
      }
    }
  }
};
</script>

<style scoped>
</style>
