import Vue from 'vue'
import VueRouter from 'vue-router'
import Signup from '../views/Signup.vue'
import Login from '../views/Login.vue'
import Contacts from '../views/Contacts.vue'
import Add from '../components/Add.vue'
import Edit from '../components/Edit.vue'
const { store } = require('../stores')

Vue.use(VueRouter)

const routes = [
  {
    path: '/signup',
    name: 'signup',
    component: Signup
    // meta: { requiresLogin: true }
  },
  {
    path: '/login',
    name: 'login',
    alias: ['/', '/home'],
    component: Login
  },
  {
    path: '/contacts',
    name: 'contacts',
    component: Contacts,
    meta: { requiresLogin: true }
  },
  {
    path: '/add',
    name: 'add',
    component: Add,
    meta: { requiresLogin: true }
  },
  {
    path: '/edit',
    name: 'edit',
    component: Edit,
    meta: { requiresLogin: true }
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresLogin) && !store.state.user.isLoggedIn) {
    // You can use store variable here to access globalError or commit mutation
    next('/login')
  } else if (store.state.user.isLoggedIn && (to.name === 'login' || to.name === 'signup')) {
    next('/contacts')
  } else {
    next()
  }
})
export default router
