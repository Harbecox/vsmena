<template>
    <div class="input__with_label x-select with-search flex_1" :class="{ open: opened }">
        <label>{{ label }}
            <span v-if="required" class="required">*</span>
        </label>
        <div class="form-input">
            <input @focus="opened = true" :placeholder="placeholder" v-model="word">
            <v-icon name="search" />
            <input type="hidden" :name="name" :value="selectedId">
        </div>

        <div class="list" v-if="opened">
            <div v-for="(item, i) in filteredItems"
                 :key="i"
                 @click="onSelect(item)"
                 :data-id="item.id"
                 class="item"
                 :class="{ selected: item.id === selectedId }">
                {{ item.name }}
            </div>
        </div>

        <div v-if="errors.length" class="error text-danger">{{ errors[0] }}</div>
    </div>
</template>

<script>
export default {
    name: "VChoice",
    props: {
        modelValue: {
            type: [String, Number, null],
            default: null
        },
        value: {
            type: [String, Number, null],
            default: null
        },
        items: {
            type: Array,
            default: () => []
        },
        label: {
            type: String,
            default: ''
        },
        placeholder: {
            type: String,
            default: ''
        },
        errors: {
            type: Array,
            default: () => []
        },
        name: {
            type: String,
            default: ''
        },
        required: {
            type: Boolean,
            default: false
        }
    },
    emits: ['update:modelValue'],
    data() {
        return {
            opened: false,
            word: "",
            selectedId: null
        };
    },
    created() {
        this.selectedId = this.modelValue ?? this.value ?? null;
        if (this.selectedId) {
            const found = this.items.find(item => item.id === this.selectedId);
            if (found) {
                this.word = found.name;
            }
        }
    },
    watch: {
        modelValue(newVal) {
            this.selectedId = newVal;
            const found = this.items.find(item => item.id === newVal);
            this.word = found ? found.name : "";
        }
    },
    methods: {
        onSelect(item) {
            if (!item) return;
            this.selectedId = item.id;
            this.$emit('update:modelValue', item.id);
            this.word = item.name;
            this.opened = false;
        }
    },
    computed: {
        filteredItems() {
            if (!this.word) {
                return this.items;
            }
            const w = this.word.toLowerCase();
            return this.items.filter(item => item.name.toLowerCase().includes(w));
        }
    }
};
</script>
