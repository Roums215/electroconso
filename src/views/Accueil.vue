<template>
    <div class="accueil-body">
        <Navbar></Navbar>
        <section class="accueil-background">
            <div class="accueil-container">
                <h1 class="accueil-totalPrix">{{ totalPrice.toFixed(2) }} €</h1>
                <h3 class="accueil-TTC">TTC</h3>
            </div>
            <div class="accueil-container">
                <h1 class="accueil-totalKwh">{{ totalKwh.toFixed(2) }}</h1>
                <h3 class="accueil-KHW">kWh</h3>
            </div>
        </section>
        <section>
            <div class="accueil-container">
                <h1 class="accueil-info">Gardez un œil pour être au courant en tout temps.</h1>
            </div>
        </section>
    </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue';
import axios from 'axios';
import '@/assets/css/styles.css'; 

export default {
    name: 'Accueil',
    components: {
        Navbar,
    },
    data() {
        return {
            totalPrice: 0,
            totalKwh: 0
        };
    },
    methods: {
        async fetchConsommation() {
            try {
                const response = await axios.get('https://electroconso.alwaysdata.net/api/getConsommation.php', { withCredentials: true });
                if (response.data.success) {
                    const consommations = response.data.consommations;
                    this.totalKwh = consommations.reduce((total, consommation) => total + consommation.W / 1000, 0);
                    this.totalPrice = consommations.reduce((total, consommation) => total + consommation.Cout, 0);
                } else {
                    console.error('Erreur:', response.data.message);
                }
            } catch (error) {
                console.error('Erreur lors de la récupération des consommations:', error);
            }
        }
    },
    mounted() {
        this.fetchConsommation();
    }
};
</script>

<style scoped>
</style>
