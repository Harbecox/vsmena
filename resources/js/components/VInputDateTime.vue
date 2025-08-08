<template>
    <div class="input__with_label">
        <label>{{ label }}</label>
        <input
            ref="datepicker"
            :readonly="locked"
            class="form-input"
            :type="type"
            :placeholder="placeholder"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :name="name"
        >
        <div ref="customCalendarContainer"></div>
        <v-icon v-if="icon" :name="icon"/>
        <div v-if="errors.length" class="error text-danger">{{ errors[0] }}</div>
    </div>
</template>

<script>
import flatpickr from "flatpickr"
import { Russian } from "flatpickr/dist/l10n/ru.js"

export default {
    name: "VInputDateTime",
    props: {
        modelValue: String,
        label: String,
        errors: { type: Array, default: () => [] },
        locked: { type: Boolean, default: false },
        type: { type: String, default: 'text' },
        placeholder: String,
        icon: [String, Boolean],
        name: String
    },
    emits: ['update:modelValue'],
    mounted() {
        this.initCalendar()
    },
    methods: {
        initCalendar() {
            let flatpick = flatpickr(this.$refs.datepicker, {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: Russian,
                defaultDate: this.modelValue,
                onChange: (selectedDates, dateStr) => {
                    this.$emit('update:modelValue', dateStr)
                },
                appendTo: this.$refs.customCalendarContainer
            })
        }
    }
}
</script>
