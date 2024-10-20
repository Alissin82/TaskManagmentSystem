import './bootstrap';

import '@majidh1/jalalidatepicker';
import $ from 'jquery';

jalaliDatepicker.startWatch({
    minDate: "attr",
    maxDate: "attr",
    changeMonthRotateYear: true,
    time: true,
    hideAfterChange: true
});
