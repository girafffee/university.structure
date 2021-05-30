import Vue from 'vue'
import App from './App.vue'
import { ModalPlugin } from 'bootstrap-vue';

Vue.use( ModalPlugin );

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

new Vue({
  el: '#app',
  render: h => h(App)
})
