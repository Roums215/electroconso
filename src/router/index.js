import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Accueil.vue';
import Login from '../components/Login.vue';
import Fournisseur from '../views/Fournisseur.vue';
import PagePrise from '../views/PagePrise.vue';


const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/fournisseur',
    name: 'Fournisseur',
    component: Fournisseur
  },
  {
    path: '/page-prise',
    name: 'PagePrise',
    // Ajouter le composant PagePrise ici
    component: PagePrise
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

export default router;
