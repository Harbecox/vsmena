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

function calendarInit(){
    document.querySelectorAll(".datePicker").forEach(function (el) {
        let target = null;
        if(el.tagName == "INPUT"){
            target = el;
        }
        if(target || (target = el.querySelector('input'))){
            FlatPickerObj.make(target);
        }
    })
}

let FlatPickerObj = {
    input:null,
    m_prev:null,
    m_next:null,
    m_sel:null,
    month_el:null,
    calendarContainer:null,
    picker:null,
    cur_year:null,
    y_next:null,
    y_prev:null,
    make:function (input){
        this.input = input;
        this.calendarContainer = input.parentNode.querySelector('.customCalendarContainer');
        if(!this.calendarContainer){
            this.calendarContainer = document.createElement("DIV");
            this.calendarContainer.classList.add("customCalendarContainer");
            input.parentNode.appendChild(this.calendarContainer);
        }
        this.picker = flatpickr(input, {
            // mode: "range",
            dateFormat: "Y-m-d",
            "locale": Russian,
            appendTo: this.calendarContainer
        });

        let base_url = input.getAttribute('data-base-url');
        input.addEventListener('change', function (e) {
            if (e.target.value.indexOf('—') !== -1) {
                let dateRange = e.target.value.replace(' — ', ',');
                window.location.href = base_url + dateRange;
            }
        })
        this.cur_year = this.calendarContainer.querySelector(".cur-year");
        this.m_prev = document.querySelector('.flatpickr-prev-month');
        this.m_next = document.querySelector('.flatpickr-next-month');
        this.m_sel = document.querySelector('.flatpickr-monthDropdown-months');
        this.month_el = document.createElement('div');
        this.month_el.classList.add('flatpickr-month_el');
        if (this.m_next) {
            this.m_next.parentNode.insertBefore(this.month_el, this.m_next);
            this.month_el.textContent = this.m_sel.querySelector('option:checked').textContent + (this.cur_year ? " " + this.cur_year.value : "" );
            this.m_prev.innerHTML = '<svg width="24.000000" height="24.000000" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><clipPath id="clip507_18093"><rect rx="0.000000" width="23.000000" height="23.000000" transform="translate(0.500000 0.500000)" fill="white" fill-opacity="0"/></clipPath></defs><g clip-path="url(#clip507_18093)"><path d="M13 15L10 12L13 9" stroke="#14181F" stroke-opacity="1.000000" stroke-width="2.000000" stroke-linejoin="round" stroke-linecap="round"/></g></svg>';
            this.m_next.innerHTML = '<svg width="24.000000" height="24.000000" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><clipPath id="clip507_18095"><rect rx="0.000000" width="23.000000" height="23.000000" transform="translate(0.500000 0.500000)" fill="white" fill-opacity="0"/></clipPath></defs><g clip-path="url(#clip507_18095)"><path d="M11 9L14 12L11 15" stroke="#14181F" stroke-opacity="1.000000" stroke-width="2.000000" stroke-linejoin="round" stroke-linecap="round"/></g></svg>';
        }
        if(this.cur_year){
            this.y_next = document.createElement("SPAN");
            this.y_next.innerHTML = '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24.000000" height="24.000000" fill="none">\n' +
                '\t<path id="Vector" d="M13 8L17 12L13 16" stroke="rgb(20.4,23.8,30.6)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />\n' +
                '\t<path id="Vector" d="M7 8L11 12L7 16" stroke="rgb(20.4,23.8,30.6)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />\n' +
                '</svg>';
            this.y_next.classList.add('y_next');
            this.y_prev = document.createElement("SPAN");
            this.y_prev.innerHTML = '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24.000000" height="24.000000" fill="none">\n' +
                '\t<path id="Vector" d="M17 16L13 12L17 8" stroke="rgb(20.4,23.8,30.6)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />\n' +
                '\t<path id="Vector" d="M11 16L7 12L11 8" stroke="rgb(20.4,23.8,30.6)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />\n' +
                '</svg>\n';
            this.y_prev.classList.add('y_prev');
            this.m_prev.parentNode.prepend(this.y_prev);
            this.m_prev.parentNode.append(this.y_next);
        }
        this.events();
    },
    events:function (){
        this.m_prev.addEventListener('click', () => {
            this.m_sel.dispatchEvent(new Event('change', {bubbles: true}))
            this.setMonthEl()
        });
        this.m_next.addEventListener('click',  () => {
            this.m_sel.dispatchEvent(new Event('change', {bubbles: true}))
            this.setMonthEl()
        });
        this.y_next.addEventListener('click', () => {
            this.picker.changeMonth(12);
            this.setMonthEl()
        })
        this.y_prev.addEventListener('click', () => {
            this.picker.changeMonth(-12);
            this.setMonthEl()
        })
    },
    setMonthEl:function (){
        setTimeout(() => {
            let text = this.m_sel.querySelector('option:checked').textContent;
            if(this.cur_year){
                text += " " + this.cur_year.value;
            }
            this.month_el.textContent = text;
        }, 1);
    }
}



function modalInit(){
    document.querySelectorAll('.modal').forEach(function (modal) {
        document.querySelector('body').appendChild(modal);
    })
    document.querySelectorAll('.modal').forEach(function (modal,i) {
        let button = modal.querySelector('button[type="submit"]');
        if(button){
            button.addEventListener('click',function (){
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
        select.querySelector('.list').querySelectorAll('.item').forEach(function (item) {
            item.addEventListener('click', function (e) {
                form_input.querySelector('.selected_value').textContent = item.textContent;
                form_input.querySelector('input').value = item.dataset.id;
                form_input.querySelector('input').dispatchEvent(new Event('input', { bubbles: true }));
                select.classList.remove('open');
                item.classList.add('selected');
            })
        })
    })
}

async function validateForm(form, className) {
    const url = `/api/validator/${className}`;
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

        form.querySelectorAll('.success').forEach(function (el){
            el.classList.add('d-block')
            el.classList.remove('d-none')
        });

        const result = await response.json();
        if (response.status === 422 && result.errors) {
            for (const [field, messages] of Object.entries(result.errors)) {
                const input = form.querySelector(`[name="${field}"]`);
                if (input) {
                    input.parentNode.querySelectorAll('.error').forEach(function (error) {
                        error.classList.add('d-block');
                        error.classList.remove('d-none');
                        if(!error.classList.contains('non-text')){
                            error.textContent = messages[0];
                        }
                        // input.insertAdjacentElement('afterend', error);
                    })
                    input.parentNode.querySelectorAll('.success').forEach(function (success) {
                        success.classList.add('d-none');
                        success.classList.remove('d-block');
                    })
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
                validateForm(form, form.dataset.class);
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

// filtersInit();
calendarInit();
// modalInit();
// // selectInit();
formsInit();
// initClearFilters();


let notyf = new Notyf();
document.addEventListener('notyf:success', function (e) {
    notyf.success(e.detail.message);
})

document.addEventListener('notyf:error', function (e) {
    notyf.error(e.detail.message);
})

document.querySelectorAll('.input__with_label.password').forEach(function (input_elem){
    let input = input_elem.querySelector('input');
    input_elem.querySelectorAll('svg').forEach(function (svg){
        svg.addEventListener("click",function (){
            input_elem.classList.toggle('show');
            if(input.type == "password"){
                input.type = "text";
            }else{
                input.type = "password"
            }
        })
    })
});
