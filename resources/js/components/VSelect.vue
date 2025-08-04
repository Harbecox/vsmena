<template>
    <div class="input__with_label x-select" :class="{ open: opened }">
        <label class="">{{ label }}</label>
        <div @click="opened = !opened" class="form-input">
            <input type="hidden" name="name" value="value">
            <span class="selected_value">{{ activeItem?.name || '---' }}</span>
<!--            <x-icon name="arrow_down"></x-icon>-->
        </div>
        <div class="list">
            <div v-for="(item, i) in items" @click="onSelect(item)" :key="i" :data-id="item.id" class="item" :class="{ selected: item.id === modelValue }">{{ item.name }}</div>
        </div>
        <div v-if="errors.length" class="error text-danger">{{ errors[0] }}</div>
    </div>
</template>

<script>

export default {
    name: "VSelect",
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
        errors: {
            type: Array,
            default: () => ([]),
        },
    },
    emits: ['update:modelValue'],
    data: () => ({
        opened: false,
    }),
    created() {},
    mounted() {},
    methods: {
        onSelect(item) {
            this.$emit('update:modelValue', item.id);
            this.opened = false;
        },
    },
    computed: {
        activeItem() {
            return (this.items || []).find(item => item.id === this.modelValue) || null;
        },
    },
}
</script>
