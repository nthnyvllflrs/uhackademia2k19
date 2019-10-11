import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Landing from '../components/LandingComponent.vue'

const routes = [
    { path: '/', name: 'landing', component: Landing},
]

export default new VueRouter({mode: 'history', routes})