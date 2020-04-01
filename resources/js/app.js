import Zondicon from 'vue-zondicons';
import { InertiaApp } from '@inertiajs/inertia-vue'
import Vue from 'vue'

Vue.mixin({ methods: { route: (...args) => window.route(...args).url() } })
Vue.use(InertiaApp)
Vue.component('Zondicon', Zondicon);

const app = document.getElementById('app')

new Vue({
  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => require(`./Pages/${name}`).default,
    },
  }),
}).$mount(app)
