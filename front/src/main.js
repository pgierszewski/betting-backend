import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store/index'
import Antd from 'ant-design-vue';
import ApiService from "./common/api.service";

import './registerServiceWorker'
import 'ant-design-vue/dist/antd.css';

ApiService.init();

Vue.config.productionTip = false

Vue.use(Antd);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
