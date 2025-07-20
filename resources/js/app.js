import 'bootstrap';
import flatpickr from "flatpickr";

function filtersInit(){
    let filters = document.querySelectorAll('.filter');
    filters.forEach(function (filter) {
        filter.addEventListener('click', function (e) {
            filter.classList.toggle('show');
            filter.querySelector('#datePicker').click();
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



function calendarInit(){
    let picker = flatpickr("#datePicker", {mode: "range","locale": Russian});
    let flatpickr_calendar = document.querySelector('.flatpickr-calendar');
    let input = document.querySelector('#datePicker');
    input.parentNode.insertBefore(flatpickr_calendar, input);
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

filtersInit();
calendarInit();
