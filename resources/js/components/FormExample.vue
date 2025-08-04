<template>
    <form @submit.prevent="onSubmit" class="pb-5">
        <v-select v-model="form.restaurant_id" @update:modelValue="onChangeOneSelect($event)" label="Select 1" :items="select_1_items" :errors="form_errors.restaurant_id"/>
        <v-select v-model="form.position_id" label="Select 2" :items="select_2_items" :errors="form_errors.position_id"/>
        <div class="text-end pt-3">
            <button class="btn btn-success">Submit</button>
        </div>
    </form>
</template>

<script>

export default {
    name: "FormExample",
    data: () => ({
        form: {
            restaurant_id: null,
            position_id: null,
        },
        form_errors: {
            restaurant_id: [],
            position_id: [],
        },
        select_1_items: [],
        select_2_items: [],
    }),
    created() {},
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

                })
                .catch(err => {
                    if (err.response) this.onRequestError(err.response.data.errors);
                })
        },
        onRequestError(errors = {}) {
            Object.keys(errors).forEach(key => this.form_errors[key] = errors[key]);
        },
    },
    computed: {},
}
</script>
