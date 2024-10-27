import './bootstrap';

import $ from 'jquery';
window.jQuery = $;
window.$ = $

import '@majidh1/jalalidatepicker';

import toastr from 'toastr';
window.toastr = toastr

import Echo from 'laravel-echo';
import io from 'socket.io-client';

window.io = io;
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

jalaliDatepicker.startWatch({
    minDate: "attr",
    maxDate: "attr",
    changeMonthRotateYear: true,
    time: true,
    hideAfterChange: true
});
