<template>
  <div class="fournisseur-body">
    <Navbar></Navbar>
    <h1>Choisir un Fournisseur</h1>
    <div class="fournisseur-card-container">
      <template v-if="fournisseurs.length > 0">
        <FournisseurCard 
          v-for="fournisseur in fournisseurs" 
          :key="fournisseur.Id_Fournisseur" 
          :fournisseur="fournisseur" 
          :currentFournisseur="currentFournisseur" 
          @select="selectFournisseur"
        />
      </template>
      <template v-else>
        <p>Aucun fournisseur disponible.</p>
      </template>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Navbar from '@/components/Navbar.vue';
import FournisseurCard from '@/components/FournisseurCard.vue';
import '@/assets/css/styles.css'; // Importer le fichier CSS global

export default {
  name: 'Fournisseur',
  components: {
    Navbar,
    FournisseurCard,
  },
  data() {
    return {
      fournisseurs: [],
      currentFournisseur: null,
    };
  },
  methods: {
    async fetchFournisseurs() {
      try {
        const response = await axios.get('https://electroconso.alwaysdata.net/api/getFournisseurs.php', { withCredentials: true });
        if (response.data.success) {
          this.fournisseurs = response.data.fournisseurs;
          this.currentFournisseur = response.data.currentFournisseur;
        } else {
          console.error('Erreur:', response.data.message);
          this.$router.push('/login'); // Rediriger vers la page de connexion si non autorisé
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des fournisseurs:', error);
        this.$router.push('/login'); // Rediriger vers la page de connexion en cas d'erreur
      }
    },
    async selectFournisseur(fournisseurId) {
      try {
        const response = await axios.post('https://electroconso.alwaysdata.net/api/changeFournisseur.php', {
          new_fournisseur: fournisseurId,
        }, { withCredentials: true });
        if (response.data.success) {
          this.currentFournisseur = fournisseurId;
        } else {
          console.error('Erreur:', response.data.message);
        }
      } catch (error) {
        console.error('Erreur lors du changement de fournisseur:', error);
      }
    },
  },
  mounted() {
    this.fetchFournisseurs();
  },
};
</script>

<style scoped>
/* Styles spécifiques supplémentaires si nécessaire */
</style>
