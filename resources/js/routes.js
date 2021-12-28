import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from './views/Home.vue'
import CreateEmail from "./views/CreateEmail";
import ShowEmail from "./views/ShowEmail";

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/emails/create',
        name: 'CreateEmail',
        component: CreateEmail
    },
    {
        path: '/emails/:id',
        name: 'ShowEmail',
        component: ShowEmail
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router
