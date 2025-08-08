<template>
    <div class="input__with_label x-select with-search" :class="{ open: opened }">
        <label class="">{{ label }}</label>
        <div class="form-input">
            <input @focus="opened = true" :placeholder="placeholder" v-model="word" >
            <input type="hidden" :name="name" :value="this.modelValue">
        </div>
        <div class="list" v-if="word.length > 0">
            <div v-for="(item, i) in selected" @click="onSelect(item)" :key="i" :data-id="item.id" class="item" :class="{ selected: item.id === modelValue }">{{ item.name }}</div>
        </div>
        <div v-if="errors.length" class="error text-danger">{{ errors[0] }}</div>
    </div>
</template>

<script>

export default {
    name: "VChoice",
    props: {
        modelValue: {
            type: [String, Number],
        },
        items: {
            type: Array,
            default: () => ([]),
        },
        label: {
            type: String,
            default: '',
        },
        placeholder: {
            type: String,
            default: '',
        },
        errors: {
            type: Array,
            default: () => ([]),
        },
        name: {
            type: String,
            default: '',
        }
    },
    emits: ['update:modelValue'],
    data: () => ({
        opened: false,
        selected: [],
        word: ""
    }),
    created() {

    },
    mounted() {},
    methods: {
        onSelect(item) {
            this.$emit('update:modelValue', item.id);
            this.word = item.name;
            this.opened = false;
        },
    },
    computed: {
        activeItem() {
            return (this.items || []).find(item => item.id === this.modelValue) || null;
        },
        selected() {
            if (!this.word) {
                return this.items;
            }
            const w = this.word.toLowerCase();
            return this.items.filter(item => item.name.toLowerCase().includes(w));
        }
    }
}
</script>
