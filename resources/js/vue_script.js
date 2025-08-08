import axios from 'axios';
import { createApp } from 'vue';
import VSelect from "@/components/VSelect.vue";
import FormExample from "@/components/FormExample.vue";
import Vicon from "@/components/Vicon.vue";
import VInput from "@/components/VInput.vue";
import VInputDateTime from "@/components/VInputDateTime.vue";
import VChoise from "@/components/VChoise.vue";

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
vueApp.component('VInputDateTime', VInputDateTime);
vueApp.component('VChoice', VChoise);

vueApp.mount('#app');


const vueApp_header_modal = createApp({
    // delimiters: ['{[', ']}'],
    data: () => ({

    }),
});

vueApp_header_modal.config.compilerOptions.delimiters = ['{[', ']}'];
vueApp_header_modal.config.globalProperties.axios = axiosInstance;
vueApp_header_modal.component('VSelect', VSelect);
vueApp_header_modal.component('FormExample', FormExample);
vueApp_header_modal.component('VIcon', Vicon);
vueApp_header_modal.component('VInput', VInput);
vueApp_header_modal.component('VInputDateTime', VInputDateTime);

vueApp_header_modal.mount('#app_header_modal');
