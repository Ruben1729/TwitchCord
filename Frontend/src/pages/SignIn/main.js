import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false
//in the future: Set to false if in production
Vue.config.devtools = true

//Bootstrap Vue imports
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue)

new Vue({
  render: h => h(App),
}).$mount('#app')
