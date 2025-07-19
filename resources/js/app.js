import 'bootstrap';
import flatpickr from "flatpickr";

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

import { Russian } from "flatpickr/dist/l10n/ru.js"
flatpickr("#datePicker", {mode: "range","locale": Russian});
