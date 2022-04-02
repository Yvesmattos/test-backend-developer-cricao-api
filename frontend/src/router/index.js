import {
  createRouter,
  createWebHistory
} from 'vue-router'
import HomeVue from '../views/Home.vue'
import PropostaVue from '../views/Proposta.vue'
import ConsultaVue from '../views/Consulta.vue'

const router = createRouter({
  history: createWebHistory(
    import.meta.env.BASE_URL),
  routes: [{
      path: '/',
      name: 'home',
      component: HomeVue
    },
    {
      path: '/proposta',
      name: 'proposta',
      component: PropostaVue
    },
    {
      path: '/consulta',
      name: 'consulta',
      component: ConsultaVue
    },

  ]
})

export default router