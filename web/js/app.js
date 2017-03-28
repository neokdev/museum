$(function () {
    $("#order_dateVisit").datepicker({
        minDate: new Date(),
        maxDate: "+12M",
        dateFormat: "dd-MM-yy"
    });
});