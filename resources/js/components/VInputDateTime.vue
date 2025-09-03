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
        name: String,
        format: {
            type: String,
            default: 'Y-m-d H:i',
        }
    },
    emits: ['update:modelValue'],
    mounted() {
        this.initCalendar()
    },
    methods: {
        initCalendar() {
            let flatpick = flatpickr(this.$refs.datepicker, {
                enableTime: /[Hgis]/.test(this.format),
                dateFormat: this.format,
                locale: Russian,
                defaultDate: this.modelValue,
                onChange: (selectedDates, dateStr) => {
                    this.$emit('update:modelValue', dateStr)
                },
                appendTo: this.$refs.customCalendarContainer,
                altInput: true,
                altFormat: "d M Y, H:i", // 28 авг 2025, 16:48
                minuteIncrement: 1,
            })
            let m_prev = this.$refs.customCalendarContainer.querySelector('.flatpickr-prev-month');
            let m_next = this.$refs.customCalendarContainer.querySelector('.flatpickr-next-month');
            let m_sel = this.$refs.customCalendarContainer.querySelector('.flatpickr-monthDropdown-months');
            let month_el = document.createElement('div');
            month_el.classList.add('flatpickr-month_el');

            if(m_next){
                m_next.parentNode.insertBefore(month_el, m_next);
                month_el.textContent = m_sel.querySelector('option:checked').textContent;
                m_prev.addEventListener('click', function () {
                    m_sel.dispatchEvent(new Event('change', { bubbles: true }))
                    setTimeout(function () {
                        month_el.textContent = m_sel.querySelector('option:checked').textContent;
                    },1);
                });
                m_next.addEventListener('click', function () {
                    m_sel.dispatchEvent(new Event('change', { bubbles: true }))
                    setTimeout(function () {
                        month_el.textContent = m_sel.querySelector('option:checked').textContent;
                    },1);
                });
                m_prev.innerHTML = '<svg width="24.000000" height="24.000000" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><clipPath id="clip507_18093"><rect rx="0.000000" width="23.000000" height="23.000000" transform="translate(0.500000 0.500000)" fill="white" fill-opacity="0"/></clipPath></defs><g clip-path="url(#clip507_18093)"><path d="M13 15L10 12L13 9" stroke="#14181F" stroke-opacity="1.000000" stroke-width="2.000000" stroke-linejoin="round" stroke-linecap="round"/></g></svg>';
                m_next.innerHTML = '<svg width="24.000000" height="24.000000" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><clipPath id="clip507_18095"><rect rx="0.000000" width="23.000000" height="23.000000" transform="translate(0.500000 0.500000)" fill="white" fill-opacity="0"/></clipPath></defs><g clip-path="url(#clip507_18095)"><path d="M11 9L14 12L11 15" stroke="#14181F" stroke-opacity="1.000000" stroke-width="2.000000" stroke-linejoin="round" stroke-linecap="round"/></g></svg>';

            }

            let time_container = this.$refs.customCalendarContainer.querySelector('.flatpickr-time');
            if(time_container){
                let time_input = document.createElement('input');
                time_input.classList.add('flatpickr-time__input');
                let time_text = document.createElement('div');
                time_text.classList.add('flatpickr-time__text');
                time_text.textContent = "Выберите время";
                this.$refs.customCalendarContainer.querySelector('.flatpickr-time').appendChild(time_text);
                this.$refs.customCalendarContainer.querySelector('.flatpickr-time').appendChild(time_input);
                let hourInput = this.$refs.customCalendarContainer.querySelector(".flatpickr-hour");
                let minuteInput = this.$refs.customCalendarContainer.querySelector(".flatpickr-minute");

                time_input.value = hourInput.value + ":" + minuteInput.value;
                time_input.addEventListener("input", function () {
                    let v = this.value.replace(/\D/g, ""); // только цифры
                    if (v.length >= 3) {
                        v = v.slice(0, 2) + " : " + v.slice(2, 4);
                    }
                    this.value = v;
                    const [h, m] = v.split(" : ");

                    if (hourInput && h) {
                        hourInput.value = h;
                        hourInput.dispatchEvent(new Event("input", { bubbles: true }));
                        hourInput.dispatchEvent(new Event("change", { bubbles: true }));
                    }
                    if (minuteInput && m) {
                        minuteInput.value = m;
                        minuteInput.dispatchEvent(new Event("input", { bubbles: true }));
                        minuteInput.dispatchEvent(new Event("change", { bubbles: true }));
                    }
                });
            }
        }
    }
}
</script>
