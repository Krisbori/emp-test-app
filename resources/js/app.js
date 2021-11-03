require('./bootstrap');

import Vue from "vue"
import VueRouter from "vue-router"

Vue.use(VueRouter)

import App from './components/App'
import EmployeesTree from './components/EmployeesTree'
import EmployeesTable from './components/EmployeesTable'

import 'bootstrap/dist/css/bootstrap.css'

const router  = new VueRouter({
    mode: 'history',
    routes:[
        {
            path:'/',
            name: 'EmployeesTree',
            component: EmployeesTree
        },
        {
            path:'/list',
            name: 'EmployeesTable',
            component: EmployeesTable
        }
    ]
})

const app = new Vue({
    el: '#app',
    components: {App},
    router
})
