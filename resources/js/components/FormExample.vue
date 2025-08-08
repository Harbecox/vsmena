<template>
    <form @submit.prevent="onSubmit" class="pb-5" :action="action" method="POST" ref="nativeForm">
        <input type="hidden" name="_token" :value="csrfToken">
        <input type="hidden" name="_method" :value="method">
        <v-select name="restaurant_id" v-model="form.restaurant_id" @update:modelValue="onChangeOneSelect($event)" label="Название ресторана" :items="select_1_items" :errors="form_errors.restaurant_id"/>
        <v-select name="position_id" v-model="form.position_id" label="Выберите должность" :items="select_2_items" :errors="form_errors.position_id"/>
        <v-input-date-time name="start_date" v-model="form.start_date" label="Время начала смены" :errors="form_errors.start_date" icon="calendar"/>
    </form>
</template>

<script>

export default {
    name: "FormExample",
    data: (vm) => ({
        form: { ...vm.formData },
        form_errors: {
            restaurant_id: [],
            position_id: [],
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
                position_id: null,
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
            this.axios.get('/restaurants')
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
            Object.keys(this.form_errors).forEach(key => this.form_errors[key] = []);
            this.axios.post('/post_test', this.form)
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
