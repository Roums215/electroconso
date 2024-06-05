<template>
    <div class="fournisseur-card">
      <h3>{{ fournisseur.Fnom }}</h3>
      <p>Tarif: {{ fournisseur.TarifElect }} €/kWh</p>
      <button @click="$emit('select', fournisseur.Id_Fournisseur)" :class="{ selected: fournisseur.Id_Fournisseur === currentFournisseur }">
        Choisir
      </button>
    </div>
  </template>
  
  <script>
  export default {
    name: 'FournisseurCard',
    props: {
      fournisseur: {
        type: Object,
        required: true
      },
      currentFournisseur: {
        type: Number,
        required: true
      }
    }
  };
  </script>
  
  <style scoped>
  .fournisseur-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      margin: 20px;
      padding: 20px;
      text-align: center;
      width: 300px;
  }
  .fournisseur-card h3 {
      margin: 10px 0;
  }
  .fournisseur-card p {
      margin: 10px 0;
  }
  .fournisseur-card button {
      background: #283C81;
      border: none;
      border-radius: 5px;
      color: white;
      padding: 10px 15px;
      cursor: pointer;
  }
  .fournisseur-card button.selected {
      background: #f0ad4e;
  }
  .fournisseur-card button:hover {
      background: #1f2d66;
  }
  </style>
  