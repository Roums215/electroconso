import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';
// import './assets/css/CSS.css'; // Inclure les styles globaux

// Configurer axios pour inclure les cookies avec chaque requête
axios.defaults.withCredentials = true;

createApp(App).use(router).mount('#app');
