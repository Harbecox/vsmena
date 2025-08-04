import axios from 'axios';
import { createApp } from 'vue';
import VSelect from "@/components/VSelect.vue";
import FormExample from "@/components/FormExample.vue";

const axiosInstance = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
});

const vueApp = createApp({
    // delimiters: ['{[', ']}'],
    data: () => ({

    }),
});

vueApp.config.compilerOptions.delimiters = ['{[', ']}'];
vueApp.config.globalProperties.axios = axiosInstance;
vueApp.component('VSelect', VSelect);
vueApp.component('FormExample', FormExample);

vueApp.mount('#app');
