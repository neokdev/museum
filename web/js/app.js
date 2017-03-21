$(function () {
    $("#order_dateVisit").datepicker({
        minDate: new Date(),
        maxDate: "+12M",
        dateFormat: "dd-mm-yy"
    });
});