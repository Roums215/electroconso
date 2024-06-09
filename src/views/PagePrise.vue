<template>
  <div class="prise-body">
    <Navbar></Navbar>
    <div class="form-container">
      <h2>Ajouter une Prise</h2>
      <form @submit.prevent="ajouterPrise">
        <label for="nom_prise">Nom de la Prise :</label>
        <input type="text" v-model="nom_prise" id="nom_prise" required>
        
        <label for="code_connexion">Code de Connexion :</label>
        <input type="text" v-model="code_connexion" id="code_connexion" required>
        
        <button type="submit">Ajouter</button>
      </form>
    </div>
    <div class="prises-container">
      <h2>Vos Prises</h2>
      <div v-if="prises.length > 0">
        <PriseCard v-for="prise in prises" :key="prise.Id_Prise" :prise="prise" :consommations="filteredConsommations(prise.Id_Prise)" />
      </div>
      <p v-else>Vous n'avez aucune prise ajoutée.</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Navbar from '@/components/Navbar.vue';
import PriseCard from '@/components/PriseCard.vue';
import '@/assets/css/styles.css'; 

export default {
  name: 'PagePrise',
  components: {
    Navbar,
    PriseCard,
  },
  data() {
    return {
      nom_prise: '',
      code_connexion: '',
      prises: [],
      consommations: []
    };
  },
  methods: {
    async fetchPrises() {
      try {
        const response = await axios.get('https://electroconso.alwaysdata.net/api/getPrises.php', { withCredentials: true });
        if (response.data.success) {
          this.prises = response.data.prises;
        } else {
          console.error('Erreur:', response.data.message);
          this.$router.push('/login'); 
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des prises:', error);
        this.$router.push('/login'); 
      }
    },
    async fetchConsommation() {
      try {
        const response = await axios.get('https://electroconso.alwaysdata.net/api/getConsommation.php', { withCredentials: true });
        if (response.data.success) {
          this.consommations = response.data.consommations;
        } else {
          console.error('Erreur:', response.data.message);
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des consommations:', error);
      }
    },
    filteredConsommations(idPrise) {
      return this.consommations.filter(consommation => consommation.Id_Prise === idPrise);
    },
    async ajouterPrise() {
      try {
        const response = await axios.post('https://electroconso.alwaysdata.net/api/addPrise.php', {
          nom_prise: this.nom_prise,
          code_connexion: this.code_connexion
        }, { withCredentials: true, headers: { 'Content-Type': 'application/json' } });
        if (response.data.success) {
          alert('Prise ajoutée avec succès');
          this.fetchPrises();
          this.fetchConsommation();
          this.nom_prise = '';
          this.code_connexion = '';
        } else {
          alert('Erreur: ' + response.data.message);
        }
      } catch (error) {
        console.error('Erreur lors de l ajout de la prise:', error);
        alert('Erreur : Ajout de la prise');
      }
    }
  },
  mounted() {
    this.fetchPrises();
    this.fetchConsommation();
  },
};
</script>

<style scoped>
</style>
