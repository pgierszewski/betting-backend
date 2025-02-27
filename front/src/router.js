import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import Register from './views/Register.vue'
import Leaderboards from './views/Leaderboards.vue'
import History from './views/History.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/register',
      name: 'register',
      component: Register
    },
    {
      path: '/history',
      name: 'history',
      component: History
    },
    {
      path: '/leaderboards',
      name: 'leaderboards',
      component: Leaderboards
    }
  ]
})
