$(document).ready(function () {
    $('#dat_p').hide();
});

$(function () {
    $('#inlineRadio2').change(function(){
        $('#dat_p').show(); 
    })
})

$(function () {
    $('#inlineRadio1').change(function(){
        $('#dat_p').hide(); 
    })
})