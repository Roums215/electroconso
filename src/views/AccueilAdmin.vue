<template>
    <div class="fournisseur-body">
      <Navbar></Navbar>
      <h1>Modifier les Fournisseurs</h1>
      <div class="fournisseur-card-container">
        <FournisseurCard 
          v-for="fournisseur in fournisseurs" 
          :key="fournisseur.Id_Fournisseur" 
          :fournisseur="fournisseur"
          :isAdmin="true"
        />
      </div>
      <div class="form-container">
        <h2>Modifier le Prix du Fournisseur</h2>
        <form @submit.prevent="updateTarif">
          <label for="selectFournisseur">Sélectionner un Fournisseur :</label>
          <select v-model="selectedFournisseur" id="selectFournisseur" required>
            <option v-for="fournisseur in fournisseurs" :key="fournisseur.Id_Fournisseur" :value="fournisseur.Id_Fournisseur">
              {{ fournisseur.Fnom }}
            </option>
          </select>
  
          <label for="newTarif">Nouveau Tarif (€/kWh) :</label>
          <input type="number" v-model="newTarif" id="newTarif" step="0.01" required>
  
          <button type="submit">Mettre à jour</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Navbar from '@/components/Navbar.vue';
  import FournisseurCard from '@/components/FournisseurCard.vue';
  import '@/assets/css/styles.css'; 
  
  export default {
    name: 'AccueilAdmin',
    components: {
      Navbar,
      FournisseurCard,
    },
    data() {
      return {
        fournisseurs: [],
        selectedFournisseur: null,
        newTarif: null
      };
    },
    methods: {
      async fetchFournisseurs() {
        try {
          const response = await axios.get('https://electroconso.alwaysdata.net/api/getFournisseurs.php', { withCredentials: true });
          if (response.data.success) {
            this.fournisseurs = response.data.fournisseurs;
          } else {
            console.error('Erreur:', response.data.message);
          }
        } catch (error) {
          console.error('Erreur lors de la récupération des fournisseurs:', error);
        }
      },
      async updateTarif() {
        try {
          const response = await axios.post('https://electroconso.alwaysdata.net/api/updateTarif.php', {
            id_fournisseur: this.selectedFournisseur,
            new_tarif: this.newTarif
          }, { withCredentials: true, headers: { 'Content-Type': 'application/json' } });
          if (response.data.success) {
            alert('Tarif mis à jour avec succès');
            this.fetchFournisseurs();
          } else {
            alert('Erreur: ' + response.data.message);
          }
        } catch (error) {
          console.error('Erreur lors de la màj du tarif:', error);
          alert('Erreur lors de la màj du tarif');
        }
      }
    },
    mounted() {
      this.fetchFournisseurs();
    },
  };
  </script>
  
  <style scoped>
  </style>
  