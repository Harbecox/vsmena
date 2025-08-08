<template>
    <div class="input__with_label">
        <label>{{ label }}</label>
        <input
            :readonly="locked"
            class="form-input"
            :type="type"
            :placeholder="placeholder"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :name="name"
        >
        <v-icon :name="icon"/>
        <div v-if="errors.length" class="error text-danger">{{ errors[0] }}</div>
    </div>
</template>

<script>
export default {
    name: "VInput",
    props: {
        modelValue: {
            type: [String],
        },
        label: {
            type: String,
            default: '',
        },
        errors: {
            type: Array,
            default: () => ([]),
        },
        locked: {
            type: Boolean,
            default: false,
        },
        type: {
            type: String,
            default: 'text',
        },
        placeholder: {
            type: String,
            default: '',
        },
        icon: {
            type: [String, Boolean],
            default: false,
        },
        name: {
            type: String,
            default: '',
        }
    },
    emits: ['update:modelValue'],
    data: () => ({
        opened: false,
    }),
    created() {
    },
    mounted() {
    },
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
