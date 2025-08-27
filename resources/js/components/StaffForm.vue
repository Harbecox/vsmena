<template>
    <form @submit.prevent="onSubmit" class="pb-5" :action="action" method="POST" ref="nativeForm">
        <input type="hidden" name="_token" :value="csrfToken">
        <input type="hidden" name="_method" :value="method">
        <v-select name="restaurant_id" v-model="form.restaurant_id" @update:modelValue="onChangeOneSelect($event)" label="Название ресторана" :items="select_1_items" :errors="form_errors.restaurant_id"/>
        <v-select name="positions_id" v-model="form.positions_id" label="Выберите должность" :items="select_2_items" :errors="form_errors.positions_id"/>
        <v-choice name="user_id" v-model="form.user_id" label="ФИО сотрудника" placeholder="Поиск..." :items="select_1_items" :errors="form_errors.user_id" />
        <v-input-date-time name="start_date" v-model="form.start_date" label="Время начала смены" :errors="form_errors.start_date" icon="calendar"/>
        <button type="submit" class="btn btn-primary mt-30">Сохранить</button>
    </form>
</template>

<script>

import VChoice from "@/components/VChoise.vue";
import VSelect from "@/components/VSelect.vue";
import VInput from "@/components/VInput.vue";

export default {
    name: "RewardForm",
    components: {VInput, VSelect, VChoice},
    data: (vm) => ({
        form: { ...vm.formData },
        form_errors: {
            restaurant_id: [],
            positions_id: [],
            user_id: [],
            start_date: [],
        },
        select_1_items: [],
        select_2_items: [],
    }),
    props: {
        formData: {
            type: Object,
            required: false,
            default: () => ({
                restaurant_id: null,
                positions_id: null,
                user_id: null,
                start_date: null,
            }),
        },
        action: {
            type: String,
            default: '/',
        },
        method: {
            type: String,
            required: false,
            default: 'POST',
        },
    },
    created() {},
    computed: {
        csrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        }
    },
    mounted() {
        this.getSelectOneItems();
    },
    methods: {
        getSelectOneItems() {
            this.axios.get('/users')
                .then(({ data }) => {
                    this.select_1_items = data || [];
                })
                .catch(err => {})
        },
        getSelectTwoItems(restaurantId) {
            this.axios.get(`/positions/${restaurantId}`)
                .then(({ data }) => {
                    this.select_2_items = data || [];
                })
                .catch(err => {})
        },
        onChangeOneSelect(value) {
            this.getSelectTwoItems(value);
        },

        onSubmit() {
            console.log(this.form)
            Object.keys(this.form_errors).forEach(key => this.form_errors[key] = []);
            this.axios.post('/validator/RewardRequest', this.form)
                .then(({ data }) => {
                    this.$refs.nativeForm.submit()
                })
                .catch(err => {
                    if (err.response) this.onRequestError(err.response.data.errors);
                })
        },
        onRequestError(errors = {}) {
            Object.keys(errors).forEach(key => this.form_errors[key] = errors[key]);
        },
    }
}
</script>
