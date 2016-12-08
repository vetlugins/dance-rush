$(document).ready(function () {

    /* Mix-It-Up */

    $(".tabs-style-linebox nav li").click(function(){
        $(this).addClass('active');
        $(".tabs-style-linebox nav li").removeClass('active');
    });
    $('.gallery-photos-thumb').mixItUp();

    /* Mix-It-Up */

    // pretty photo function call
    $("a[data-gal^='prettyPhoto']").prettyPhoto({hook: 'data-gal'});

});