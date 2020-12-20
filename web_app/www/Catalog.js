$(document).ready(function(){

    $("#catalog_button").click(function(){
        $('#catalog_container').slideToggle('fast', function() {
            if ($(this).is(':visible'))
                $(this).css('display','flex');
        });
    });
});