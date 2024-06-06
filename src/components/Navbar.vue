<template>
  <div class="navbar">
    <ul>
      <li><router-link to="/">Accueil</router-link></li>
      <li><router-link to="/fournisseur">Fournisseur</router-link></li>
      <li class="logo"><router-link to="/"><img src="@/assets/img/logo-png.png" alt="Logo"></router-link></li>
      <li><router-link to="/page-prise">Ajouter une prise</router-link></li>
      <li><a href="https://electroconso.alwaysdata.net/api/deconnexion.php">Déconnexion</a></li>
    </ul>
  </div>
</template>

<script>
import '@/assets/css/styles.css'; // Importer le fichier CSS global

export default {
  name: 'Navbar',
};
</script>

<style scoped>
</style>
