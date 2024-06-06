import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Accueil.vue';
import Login from '../components/Login.vue';
import Fournisseur from '../views/Fournisseur.vue';
import PagePrise from '../views/PagePrise.vue';
import AdminLogin from '@/views/AdminLogin.vue';
import AccueilAdmin from '@/views/AccueilAdmin.vue';
import CreationCompte from '@/components/CreationCompte.vue';  



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
    component: PagePrise
  },
  { path: '/admin-login', name: 'AdminLogin', component: AdminLogin },
  { path: '/admin', name: 'AccueilAdmin', component: AccueilAdmin },
  {
    path: '/register',  
    name: 'CreationCompte',
    component: CreationCompte
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

export default router;
