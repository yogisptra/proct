$(document).ready(function () {
    var wat = 0;
    var now = new Date();
    now.setSeconds(0);
    now.setMilliseconds(0);
    var options = {
        language: 'id',
        position: 'bottom left',
        autoClose: true,
        view: 'days',
        minView: 'days',
        dateFormat: 'dd/mm/yyyy',
        maxDate: false,
        minDate: false, //now
        timepicker: false,
    };

    $(".datepicker-input").datepicker(options);
});