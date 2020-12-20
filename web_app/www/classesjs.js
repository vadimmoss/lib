$('.ul').click(function(event) {
    if($(this).children().children(".clchk").prop( "checked") === true){
        $(this).children().children(".clchk").prop( "checked", false );
        $(this).children().find(".clchk").prop( "checked", false );
        $(this).children().find("ul").slideToggle('fast');
    } else {
        $(this).parents().find(".clchk").prop( "checked", false );
        $(this).children().children(".clchk").prop( "checked", true );

    }

    $(this).children("ul>ul").slideToggle('fast');

    event.stopPropagation();
});