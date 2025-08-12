<template>
    <form @submit.prevent="onSubmit" class="pb-5" data-class="null" :action="action" method="POST" ref="nativeForm">
        <input type="hidden" name="_token" :value="csrfToken">
        <input type="hidden" name="_method" :value="method">
        <v-choice name="user_id" v-model="form.user_id" label="ФИО сотрудника" placeholder="Поиск..." :items="select_1_items" :errors="form_errors.user_id" />
        <v-input-date-time format="Y-m-d" name="date" v-model="form.date" label="Дата выдачи" :errors="form_errors.date" icon="calendar"/>
        <v-select name="type" v-model="form.type" :items="select_2_items" label="Выберите тип" :errors="form_errors.type"/>
        <v-input name="amount" v-model="form.amount" label="Сумма" placeholder="Сумма..." :errors="form_errors.amount"/>
        <v-input name="comment" v-model="form.comment" label="Комментарий" placeholder="Комментарий..." :errors="form_errors.comment"/>
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
            user_id: [],
            date: [],
            type: [],
            amount: [],
            comment: [],
        },
        select_1_items: [],
        select_2_items: [],
    }),
    props: {
        formData: {
            type: Object,
            required: false,
            default: () => ({
                user_id: null,
                date: null,
                type: null,
                amount: null,
                comment: null,
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
        this.getSelectTwoItems();
    },
    methods: {
        getSelectOneItems() {
            this.axios.get('/users')
                .then(({ data }) => {
                    this.select_1_items = data || [];
                })
                .catch(err => {})
        },
        getSelectTwoItems() {
            this.select_2_items = [
                {
                    'id': 'reward',
                    'name': 'Премия',
                },
                {
                    'id': 'penalty',
                    'name': 'Штраф',
                },
            ]
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
