import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Dashboard',
    component: () => import('../components/Dashboard.vue')
  },
  {
    path: '/student',
    name: 'student',
    component: () => import('../components/Student.vue')
  },
  {
    path: '/tuition',
    name: 'tuition',
    component: () => import('../components/Tuition.vue')
  },
  {
    path: '/payment',
    name: 'payment',
    component: () => import('../components/Payment.vue')
  },
  {
    path: '/grade',
    name: 'grade',
    component: () => import('../components/Grade.vue')
  },
  {
    path: '/officer',
    name: 'officer',
    component: () => import('../components/Officer.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
