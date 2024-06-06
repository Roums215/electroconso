<template>
  <div class="fournisseur-body">
    <Navbar></Navbar>
    <h1>Choisir un Fournisseur</h1>
    <div v-if="currentFournisseur" class="current-fournisseur">
      <h2>Fournisseur actuel: {{ currentFournisseur.Fnom }} - {{ currentFournisseur.TarifElect }} €/kWh</h2>
    </div>
    <div class="fournisseur-card-container">
      <template v-if="fournisseurs.length > 0">
        <FournisseurCard 
          v-for="fournisseur in fournisseurs" 
          :key="fournisseur.Id_Fournisseur" 
          :fournisseur="fournisseur" 
          :currentFournisseur="currentFournisseur.Id_Fournisseur" 
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
import '@/assets/css/styles.css'; 

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
          this.$router.push('/login'); 
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des fournisseurs:', error);
        this.$router.push('/login'); 
      }
    },
    async selectFournisseur(fournisseurId) {
      try {
        const response = await axios.post('https://electroconso.alwaysdata.net/api/changeFournisseur.php', {
          new_fournisseur: fournisseurId,
        }, { withCredentials: true });
        if (response.data.success) {
          this.currentFournisseur = this.fournisseurs.find(fournisseur => fournisseur.Id_Fournisseur === fournisseurId);
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
.current-fournisseur {
  text-align: center;
  margin-bottom: 20px;
  font-size: 1.2em;
  color: #283C81;
}
</style>
