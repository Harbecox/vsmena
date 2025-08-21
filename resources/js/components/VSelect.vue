<template>
    <div class="input__with_label v-select x-select" :class="{ open: opened }">
        <label>{{ label }}</label>
        <div @click="opened = !opened" class="form-input">
            <input type="hidden" :name="name" :value="selectedId">
            <span class="selected_value">{{ activeItem?.name || '---' }}</span>
            <v-icon name="arrow_down"></v-icon>
        </div>
        <div class="list">
            <div
                v-for="(item, i) in items"
                :key="i"
                :data-id="item.id"
                class="item"
                :class="{ selected: item.id === selectedId }"
                @click="onSelect(item)"
            >
                {{ item.name }}
            </div>
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
        name: {
            type: String,
            default: '',
        },
    },
    emits: ['update:modelValue'],
    data() {
        return {
            opened: false,
            selectedId: this.modelValue,
        };
    },
    watch: {
        modelValue(newVal) {
            this.selectedId = newVal;
        },
        selectedId(newVal) {
            this.$emit('update:modelValue', newVal);
        }
    },
    computed: {
        activeItem() {
            return this.items.find(item => item.id === this.selectedId) || null;
        }
    },
    methods: {
        onSelect(item) {
            this.selectedId = item.id;
            this.opened = false;
        },
    }
}
</script>
