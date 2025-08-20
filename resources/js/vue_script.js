import axios from 'axios';
import { createApp,nextTick } from 'vue';
import VSelect from "@/components/VSelect.vue";
import FormExample from "@/components/FormExample.vue";
import Vicon from "@/components/Vicon.vue";
import VInput from "@/components/VInput.vue";
import VInputDateTime from "@/components/VInputDateTime.vue";
import VChoise from "@/components/VChoise.vue";

const axiosInstance = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
});

const vueApp = createApp({
    // delimiters: ['{[', ']}'],
    data: () => ({

    }),
});

vueApp.config.compilerOptions.delimiters = ['{[', ']}'];
vueApp.config.globalProperties.axios = axiosInstance;
vueApp.component('VSelect', VSelect);
vueApp.component('FormExample', FormExample);
vueApp.component('VInputDateTime', VInputDateTime);
vueApp.component('VChoice', VChoise);
vueApp.component('VIcon', Vicon);

vueApp.mount('#app');


const vueApp_header_modal = createApp({
    // delimiters: ['{[', ']}'],
    data: () => ({

    }),
});

vueApp_header_modal.config.compilerOptions.delimiters = ['{[', ']}'];
vueApp_header_modal.config.globalProperties.axios = axiosInstance;
vueApp_header_modal.component('VSelect', VSelect);
vueApp_header_modal.component('FormExample', FormExample);
vueApp_header_modal.component('VIcon', Vicon);
vueApp_header_modal.component('VInput', VInput);
vueApp_header_modal.component('VInputDateTime', VInputDateTime);

vueApp_header_modal.mount('#app_header_modal');


const app_reward = createApp({
    // delimiters: ['{[', ']}'],
    data: () => ({

    }),
});

app_reward.config.compilerOptions.delimiters = ['{[', ']}'];
app_reward.config.globalProperties.axios = axiosInstance;
app_reward.component('VSelect', VSelect);
app_reward.component('RewardForm', RewardForm);
app_reward.component('VIcon', Vicon);
app_reward.component('VInput', VInput);
app_reward.component('VChoise', VChoise);
app_reward.component('VInputDateTime', VInputDateTime);

app_reward.mount('#app_reward');

import 'bootstrap';
import flatpickr from "flatpickr";

function filtersInit(){
    let filters = document.querySelectorAll('.filter');
    filters.forEach(function (filter) {
        filter.addEventListener('click', function (e) {
            filter.classList.toggle('show');
            if(filter.querySelector('#datePicker')){
                filter.querySelector('#datePicker').click();
            }
        })
        document.addEventListener('click', function (e) {
            if (!filter.contains(e.target)) {
                filter.classList.remove('show');
            }
        });
    });
}

import { Russian } from "flatpickr/dist/l10n/ru.js"
import * as url from "node:url";
import {Notyf} from "notyf";
import 'notyf/notyf.min.css';
import RewardForm from "@/components/RewardForm.vue";

function calendarInit(){
    let input = document.querySelector('#datePicker');
    if(!input){
        return;
    }
    let picker = flatpickr("#datePicker", {mode: "range","locale": Russian,appendTo:input.parentNode.querySelector('.customCalendarContainer')});
    // let flatpickr_calendar = document.querySelector('.flatpickr-calendar');
    // input.parentNode.insertBefore(flatpickr_calendar, input);
    let base_url = input.getAttribute('data-base-url');
    input.addEventListener('change', function (e) {
        if(e.target.value.indexOf('—') !== -1){
            let dateRange = e.target.value.replace(' — ',',');
            window.location.href = base_url + dateRange;
        }
    })
    let m_prev = document.querySelector('.flatpickr-prev-month');
    let m_next = document.querySelector('.flatpickr-next-month');
    let m_sel = document.querySelector('.flatpickr-monthDropdown-months');
    let month_el = document.createElement('div');
    month_el.classList.add('flatpickr-month_el');
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

function modalInit(){
    document.querySelectorAll('.modal').forEach(function (modal) {
        document.querySelector('body').appendChild(modal);
    })
    document.querySelectorAll('.modal').forEach(function (modal,i) {
        let button = modal.querySelector('button[type="submit"]');
        if(button){
            console.log(1,i);
            button.addEventListener('click',function (){
                console.log(2);
                modal.querySelector('form').dispatchEvent(new Event('submit', { bubbles: true }))
            })
        }
    })
}

function selectInit(){
    document.querySelectorAll(".x-select").forEach(function (select) {
        let form_input = select.querySelector('.form-input');
        form_input.addEventListener('click', function (e) {
            select.classList.toggle('open');
        })
        let selected = select.querySelector('.item.selected');
        if(selected){
            selected.classList.remove('selected');
        }
        try{
            select.querySelector('.list').querySelectorAll('.item').forEach(function (item) {
                item.addEventListener('click', function (e) {
                    form_input.querySelector('.selected_value').textContent = item.textContent;
                    form_input.querySelector('input').value = item.dataset.id;
                    form_input.querySelector('input').dispatchEvent(new Event('input', { bubbles: true }));
                    select.classList.remove('open');
                    item.classList.add('selected');
                })
            })
        }catch (err){}
    })
}

async function validateForm(form, className) {
    const url = `http://127.0.0.1:8000/api/validator/${className}`;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    delete data._method;

    form.querySelectorAll('.error').forEach(function (el){
        el.classList.remove('d-block')
        el.classList.add('d-none')
    });

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        if (response.status === 422 && result.errors) {
            for (const [field, messages] of Object.entries(result.errors)) {
                const input = form.querySelector(`[name="${field}"]`);
                if (input) {
                    let error = input.parentNode.querySelector('.error');
                    error.classList.add('d-block');
                    error.classList.remove('d-none');
                    error.textContent = messages[0];
                    input.insertAdjacentElement('afterend', error);
                }
            }
            return false;
        } else if (response.ok) {
            form.submit();
            return false;
        } else {
            console.error(result);
            return false;
        }

    } catch (err) {
        console.error(err);
        //alert('Сетевая ошибка');
        return false;
    }
}

function formsInit(){
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if(form.dataset.class !== undefined){
                e.preventDefault();
                //validateForm(form, form.dataset.class);
            }else{
                form.submit();
            }
        })
    })
}

function initClearFilters() {
    document.querySelectorAll('.clear_filter').forEach(function (el) {
        el.addEventListener('click', function (e) {
            window.location.href = window.location.origin + window.location.pathname;
        })
    })
}

function initMenu(){
    document.querySelector('.menu_btn').addEventListener('click',function (){
        document.querySelector('body').classList.toggle('mobile_menu_open')
    });
    if (window.innerWidth <= 768) {
        let items = document.querySelectorAll('.menu_item');
        let h = items[1].offsetWidth;
        document.querySelectorAll('.menu_item').forEach(function (item){
            item.style.height = h + "px";
            item.style.width = h + "px";
        })
        let buttons = [
            '.AddEventModalButton',
            '.EventInfoModalButton',
            '.CloseEventModalButton',
        ];
        for(let i = 0;i < buttons.length;i++){
            let item = document.querySelector(buttons[i]);
            if(item){
                document.querySelector('.menu .menu_buttons').appendChild(item);
            }
        }
    }
}

function tableInit(){
    const table = document.querySelector(".x-table");
    if (!table) return;
    const rows = table.querySelectorAll(".x-table-row");
    if (rows.length === 0) return;
    const colCount = rows[0].querySelectorAll(".x-table-cell").length;
    if (rows[1].querySelectorAll(".x-table-cell").length === 1) {
        let width = 0;
        rows[0].querySelectorAll(".x-table-cell").forEach(row => {
            width += row.offsetWidth;
        })
        rows[1].querySelector(".x-table-cell").style.flex = "0 0 " + width + "px";
        return;
    }
    for (let colIndex = 0; colIndex < colCount; colIndex++) {
        let maxWidth = 0;
        rows.forEach(row => {
            const cell = row.querySelectorAll(".x-table-cell")[colIndex];
            if (cell) {
                cell.style.width = "auto";
                const width = cell.offsetWidth;
                if (width > maxWidth) {
                    maxWidth = width;
                }
            }
        });
        rows.forEach(row => {
            const cell = row.querySelectorAll(".x-table-cell")[colIndex];
            if (cell) {
                cell.style.flex = "0 0 " + maxWidth + "px";
            }
        });
    }
}

function fullPageCalendar(){
    let calendar = document.querySelector('.full_page_calendar');
    if(calendar){
        calendar.querySelectorAll('.text').forEach(function (item){
            item.textContent = item.textContent.replace('Не подтверждена','Не подтв.')
            item.textContent = item.textContent.replace('Подтверждена','Подтв.')
        });
    }
}

let notyf = new Notyf();

nextTick(() => {
    filtersInit();
    calendarInit();
    modalInit();
    selectInit();
    formsInit();
    initClearFilters();
    tableInit();
    initMenu();
    fullPageCalendar();
    document.addEventListener('notyf:success', function (e) {
        notyf.success(e.detail.message);
    })
    document.addEventListener('notyf:error', function (e) {
        notyf.error(e.detail.message);
    })
});

// setTimeout(function () {
//     modalInit();
// },100)
