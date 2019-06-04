import Zondicon from 'vue-zondicons';
import Inertia from 'inertia-vue'
import Vue from 'vue'

Vue.mixin({ methods: { route: (...args) => window.route(...args).url() } })
Vue.use(Inertia)
Vue.component('Zondicon', Zondicon);

const app = document.getElementById('app')

new Vue({
  render: h => h(Inertia, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => import(`@/Pages/${name}`).then(module => module.default),
    },
  }),
}).$mount(app)
