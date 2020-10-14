require('./bootstrap');
window.Vue = require('vue');
import router from './router';
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI);
import commonajax from './comonajax';
Vue.mixin(commonajax);


Vue.component('mainapp', require('./mainapp').default);

const app = new Vue({
    el: '#app',
    router,
});
