import { createApp } from 'vue'
import App from './App.vue'

// Vuetify
import vuetify from './plugins/vuetify'

// Toast
import VueToast from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-sugar.css'


const app = createApp(App)

app.use(vuetify);
app.use(VueToast);
app.mount('#app');