/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';


import Vue from 'vue';
import { Form, HasError, AlertError } from 'vform';


//import Vue from 'vue';



window.Fire=new Vue();




//import swal from 'sweetalert2'
import swal from 'sweetalert2';
window.swal = swal;
const toast =swal.mixin({
    toast:true,
    position:'top-end',
    showConfirmButton: false,
    timer:3000

});


//Vue.use(VueSweetalert2);



  window.toast = toast;


window.Form= Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination',require('laravel-vue-pagination'));

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  })


let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default},
    { path: '/staff', component: require('./components/Staff.vue').default},
    { path: '/profile', component: require('./components/Profile.vue').default},
    //{ path: '/userprofile', component: require('./components/customer/Profile.vue').default},
   // { path: '/customers', component: require('./components/Customers.vue').default},
    { path: '/viewcustomers', component: require('./components/ManageCustomer.vue').default},
    { path: '/branch', component: require('./components/Branch.vue').default},
    { path: '/Company', component: require('./components/Company.vue').default},
   // { path: '/Company-edit', component: require('./components/CompanyEdit.vue').default},
    //{ path: '/Company1', component: require('./components/Company.vue').default},
    //{ path: '/customer', component: require('./components/customer/Customer.vue').default},
    { path: '/package', component: require('./components/Packages.vue').default},
    { path: '/packageorder', component: require('./components/ViewOrder.vue').default},
    { path: '/manageitem', component: require('./components/Manageitem.vue').default},
   // { path: '/manageroute', component: require('./components/Manageroute.vue').default},
    { path: '/packagemanage', component: require('./components/ManageOrder.vue').default},
    //{ path: '/userpackage', component: require('./components/customer/Package.vue').default},
    { path: '/company', component: require('./components/Company.vue').default},
    { path: '/blog', component: require('./components/Blog.vue').default},
    { path: '/report', component: require('./components/Report.vue').default},
    { path: '/contactus', component: require('./components/Contact.vue').default},
    { path: '/aboutus', component: require('./components/About.vue').default},
    { path: '/services', component: require('./components/Service.vue').default}


  ]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })



  Vue.filter('upText',function (value){
    return value.charAt(0).toUpperCase() + value.slice(1)
  });

  Vue.filter('myDate',function (value){
    return moment(value).format('llll');
  });

  window.Refresh= new Vue();
  //window.Fire= new Vue();






/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data:{
      search:'',
    },
    methods:{
        searchit:_.debounce(() =>{
            Fire.$emit('searching');
        },200)
    }


});
