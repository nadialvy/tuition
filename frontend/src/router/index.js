import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/login',
    name: 'login',
    component: () => import('../components/Login.vue')
  },
  {
    path: '',
    component: () => import('../components/Template.vue'),
    children: [
      {
        path: '/dashboard',
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
    ],
    meta: {
      requireAuth: true
    }
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requireAuth)) {
    if (localStorage.getItem('Authorization')) {
      next()
      return
    }
    next('/login') 
  } else {
    next() 
  }
})

export default router
