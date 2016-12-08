$(document).ready(function () {

    $('.service').owlCarousel({
        items: 3,
        autoPlay: true,
        navigation : true, // Show next and prev buttons
        slideSpeed : 300,
        navigationText: [
            "<i class='fa fa-chevron-left'></i>",
            "<i class='fa fa-chevron-right'></i>"],
        transitionStyle:"fade"
    });


});