import { createRouter, createWebHistory } from 'vue-router'
// import App from '../App.vue'
// import Dashboard from '../components/Dashboard.vue'
// import Student from ''

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
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
