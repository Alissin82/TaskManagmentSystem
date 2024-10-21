import './bootstrap';

import '@majidh1/jalalidatepicker';
import toastr from 'toastr';
import $ from 'jquery';

jalaliDatepicker.startWatch({
    minDate: "attr",
    maxDate: "attr",
    changeMonthRotateYear: true,
    time: true,
    hideAfterChange: true
});
