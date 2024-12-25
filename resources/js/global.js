$(function() {
    $('form').submit(function(e) {
        $('button[type="submit"]').attr("disabled", "disabled")
        $('button[type="button"]').attr("disabled", "disabled")
        $('button[type="submit"]').html("Please wait...")
    });
})