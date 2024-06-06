<template>
    <div class="prise-card">
      <h3>{{ prise.NomP }}</h3>
      <p>Code de Connexion: {{ prise.CodeConnexion }}</p>
      <p>Coût par heure : {{ coutParHeure.toFixed(2) }} €</p>
      <p>Coût par jour : {{ coutParJour.toFixed(2) }} €</p>
    </div>
  </template>
  
  <script>
  import '@/assets/css/styles.css'; 
  
  export default {
    name: 'PriseCard',
    props: {
      prise: {
        type: Object,
        required: true
      },
      consommations: {
        type: Array,
        required: true
      }
    },
    computed: {
      totalWatts() {
        return this.consommations
          .filter(consommation => consommation.Id_Prise === this.prise.Id_Prise)
          .reduce((total, consommation) => total + consommation.W, 0);
      },
      coutParHeure() {
        const consommation = this.consommations.find(consommation => consommation.Id_Prise === this.prise.Id_Prise);
        if (consommation) {
          const tarif = consommation.TarifElect;
          return (this.totalWatts / 1000) * tarif;
        }
        return 0;
      },
      coutParJour() {
        return this.coutParHeure * 24;
      }
    }
  };
  </script>
  
  <style scoped>
  .prise-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    margin: 20px;
    padding: 20px;
    text-align: center;
    width: 300px;
  }
  .prise-card h3 {
    margin: 10px 0;
  }
  .prise-card p {
    margin: 10px 0;
  }
  </style>
  