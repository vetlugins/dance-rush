$(window).load(function(){
    $('#loader').fadeOut("slow");
});
$(document).ready(function () {

    /* RS slider
     ---------------------------------------------------------------------- */
    $('.tp-banner').show().revolution({
        dottedOverlay:"none",
        delay:16000,
        startwidth:1170,
        startheight:700,
        hideThumbs:200,

        thumbWidth:100,
        thumbHeight:50,
        thumbAmount:5,

        navigationType:"none",
        navigationArrows:"solo",
        navigationStyle:"preview4",

        touchenabled:"on",
        onHoverStop:"on",

        swipe_velocity: 0.7,
        swipe_min_touches: 1,
        swipe_max_touches: 1,
        drag_block_vertical: false,

        parallax:"mouse",
        parallaxBgFreeze:"on",
        parallaxLevels:[7,4,3,2,5,4,3,2,1,0],

        keyboardNavigation:"off",

        navigationHAlign:"center",
        navigationVAlign:"top",
        navigationHOffset:0,
        navigationVOffset:20,

        soloArrowLeftHalign:"left",
        soloArrowLeftValign:"center",
        soloArrowLeftHOffset:20,
        soloArrowLeftVOffset:0,

        soloArrowRightHalign:"right",
        soloArrowRightValign:"center",
        soloArrowRightHOffset:20,
        soloArrowRightVOffset:0,

        shadow:0,
        fullWidth:"off",
        fullScreen:"on",

        spinner:"spinner4",

        stopLoop:"off",
        stopAfterLoops:-1,
        stopAtSlide:-1,

        shuffle:"off",

        autoHeight:"on",
        forceFullWidth:"off",

        hideThumbsOnMobile:"off",
        hideNavDelayOnMobile:1500,
        hideBulletsOnMobile:"off",
        hideArrowsOnMobile:"off",
        hideThumbsUnderResolution:0,

        hideSliderAtLimit:0,
        hideCaptionAtLimit:0,
        hideAllCaptionAtLilmit:0,
        startWithSlide:0,
        fullScreenOffsetContainer: ".header"

    });

    /* WOW
     ----------------------------------------------------------------------
    new WOW().init();*/

    /* Fancybox
     ----------------------------------------------------------------------*/
    $('.fancybox').fancybox({
        openEffect	: 'elastic',
        closeEffect	: 'elastic',
        padding: 0,

        helpers : {
            title : {
                type : 'inside'
            }
        }
    });

    /* Inputmask
     ----------------------------------------------------------------------*/
    $(":input").inputmask();

    /* owlCarousel
     ----------------------------------------------------------------------
    $('.partners-all').owlCarousel({
        items: 5,
        autoPlay: true,
        navigation : true,
        slideSpeed : 300,
        navigationText: [
            "<i class='fa fa-chevron-left'></i>",
            "<i class='fa fa-chevron-right'></i>"],
        transitionStyle:"fade"
    });*/

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

    /* Счетчик
     ----------------------------------------------------------------------*/
    var cc = 1;

    if ($('.timer').length > 0) {
        $(window).scroll(function(){
            var targetPos = $('.timer').offset().top;
            var winHeight = $(window).height();
            var scrollToElem = targetPos - winHeight;
            var winScrollTop = $(this).scrollTop();

            if (winScrollTop > scrollToElem) {
                if (cc < 2){

                    cc = cc + 2;
                    $(document).ready(function () {
                        $('.timer').countTo();
                    });
                }
            }
        });
    }

    /* Masonry
     ----------------------------------------------------------------------*/
    $('.grid').masonry({
        // options
        itemSelector: '.grid-item'
    });

    $('.grid-blog').masonry({
     // options
     itemSelector: '.article'
     });

    /* Загрузка новостей
     ----------------------------------------------------------------------*/
    $('.load-news img').hide();

    $( ".load-news button" ).click(function() {

        $.ajax({
            type: "POST",
            url: "/ajax/"+lang+"/load",
            data: 'loadNews=loadNews&news='+news+'&category='+category,
            cache: false,
            beforeSend: function() {
                jQuery('.load-news img').fadeIn( );
            },
            success: function(response){

                jQuery('.load-news img').fadeOut( );

                if(response != 0){
                    $(".grid-blog").append(response);
                    news = news + ammount;
                }
            }
        });

        return false;

    });

    /* Загрузка комментарий
     ----------------------------------------------------------------------*/
    $('.load-comment img').hide();

    $( ".load-comment button" ).click(function() {

        var id = $(this).attr('id');

        $.ajax({
            type: "POST",
            url: "/ajax/"+lang+"/load",
            data: 'loadComment=loadComment&news='+news+'&id='+id,
            cache: false,
            beforeSend: function() {
                jQuery('.load-comment img').fadeIn( );
            },
            success: function(response){

                jQuery('.load-comment img').fadeOut( );

                if(response != 0){
                    $("#show_comments").append(response);
                    news = news + ammount;
                }
            }
        });

        return false;

    });

    /* Перход комментариями
     ----------------------------------------------------------------------*/
    $('.go_comments').click( function(){
        var scroll_el = $(this).attr('href');
        if ($(scroll_el).length != 0) {
            $('html, body').animate({ scrollTop: $(scroll_el).offset().top }, 500);
        }
        return false;
    });

    /* Добавление комментарий
     ----------------------------------------------------------------------*/
    $('#formComments').submit( function(){
        var values = $(this).serialize();

        $('#comments').find('#show_error').slideUp('slow');

        $('#formComments').find('#show_error').slideUp('slow');

        $.ajax({
            type: "POST",
            url: "/ajax/"+lang+"/save",
            data: 'insertComment=insertComment&'+values,
            beforeSend: function(){
                $('#formComments').find('input[type=submit]').val(alert.wait+'...');
            },
            success: function(json){

                $('#formComments').find('input[type=submit]').val(button.add);

                var obj = $.parseJSON(json);

                if(obj.status == 'error'){
                    $('#comments').find('#show_error').slideDown('slow',function(){
                        $(this).html(obj.error)
                    });
                }
                if(obj.status == 'ok'){
                    $('#show_comments').prepend(obj.comment);
                    $('#comments').find('.tag').html(obj.count)
                }

            }
        });

        return false;
    });

    /* Подписка
     ----------------------------------------------------------------------*/
    $('#subscribe').submit( function(){
        var values = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "/ajax/"+lang+"/save",
            data: 'insertSubscribe=insertSubscribe&'+values,
            beforeSend: function(){
                $('#subscribe').find('input[type=submit]').val(alert.wait+'...');
            },
            success: function(json){

                var obj = $.parseJSON(json);

                if(obj.status == 'error'){
                    $('.result_subscribe').slideDown('slow',function(){
                        $(this).html('<div class="alert alert-danger">'+obj.text+'</div>')
                    });
                }
                if(obj.status == 'ok'){
                    $('#subscribe').slideUp('slow');
                    $('.result_subscribe').slideDown('slow',function(){
                        $(this).html('<div class="alert alert-success">'+obj.text+'</div>')
                    });
                }

            }
        });

        return false;
    });

    /* Рейтинг комментария
     ----------------------------------------------------------------------*/
    $('.rating').click(function(){

        var selection = $(this);
        var id = selection.attr('id');

        $.ajax({
            type: "POST",
            url: "/ajax/"+lang+"/save",
            data: 'likeComment=likeComment&id='+id,
            cache: false,
            success: function(response){
                selection.find('b').html(response);
            }
        });

        return false;

    });

    /* Заявка от компании
     ---------------------------------------------------------------------- */
    $('#enroll_company_form').validate({
        onfocusout: false,
        onkeyup: false,
        rules: {
            name: "required",
            phone: "required"
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        messages: {
            name: "Напишите свое имя",
            phone: "Напишите номер телефона"
        },

        highlight: function (element) {
            $(element)
                .text('').addClass('error')
        },

        success: function (element) {
            element
                .text('').addClass('valid')
        }
    });

    $('#enroll_company_form').submit(function () {
        // submit the form
        if ($(this).valid()) {
            $('#enroll_company_submit').button('loading');
            var action = $(this).attr('action');
            $.ajax({
                url: 'ajax/'+lang+'/send',
                type: 'POST',
                data: {
                    name: $('#enroll_company_name').val(),
                    phone: $('#enroll_company_phone').val(),
                    enroll: 'company'
                },
                success: function () {
                    $('#enroll_company_submit').button('reset');
                    //Use modal popups to display messages
                    $('#modalContactSuccess').modal('show');

                    $('#enroll_company_name').val('');
                    $('#enroll_company_phone').val('');
                },
                error: function () {
                    $('#enroll_company_submit').button('reset');
                    //Use modal popups to display messages
                    $('#modalContactError').modal('show');
                }
            });
        } else {
            $('#enroll_company_submit').button('reset')
        }
        return false;
    });

    /* Заявка на запись в студию
     ---------------------------------------------------------------------- */
    $('#enroll_client_form').validate({
        onfocusout: false,
        onkeyup: false,
        rules: {
            name: "required",
            phone: "required"
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        messages: {
            name: "Напишите свое имя",
            phone: "Напишите номер телефона"
        },

        highlight: function (element) {
            $(element)
                .text('').addClass('error')
        },

        success: function (element) {
            element
                .text('').addClass('valid')
        }
    });

    $('#enroll_client_form').submit(function () {
        // submit the form
        if ($(this).valid()) {
            $('#enroll_client_submit').button('loading');
            var action = $(this).attr('action');
            $.ajax({
                url: 'ajax/'+lang+'/send',
                type: 'POST',
                data: {
                    name: $('#enroll_client_name').val(),
                    phone: $('#enroll_client_phone').val(),
                    enroll: 'client'
                },
                success: function () {
                    $('#enroll_clienty_submit').button('reset');
                    //Use modal popups to display messages
                    $('#modalContactSuccess').modal('show');

                    $('#enroll_client_name').val('');
                    $('#enroll_client_phone').val('');
                },
                error: function () {
                    $('#enroll_client_submit').button('reset');
                    //Use modal popups to display messages
                    $('#modalContactError').modal('show');
                }
            });
        } else {
            $('#enroll_company_submit').button('reset')
        }
        return false;
    });

    /* Письмо с сайта
     ---------------------------------------------------------------------- */
    $('#contact_form').validate({
        onfocusout: false,
        onkeyup: false,
        rules: {
            name: "required",
            email: {
                required: true,
                email: true
            },
            message: "required"
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        messages: {
            name: "Напишите свое имя?",
            email: {
                required: "Напишите свой email?",
                email: "Введеный email не верный!"
            },
            message: "Напишите письмо"
        },

        highlight: function (element) {
            $(element)
                .text('').addClass('error')
        },

        success: function (element) {
            element
                .text('').addClass('valid')
        }
    });

    $('#contact_form').submit(function () {
        // submit the form
        if ($(this).valid()) {
            $('#contact_submit').button('loading');
            var action = $(this).attr('action');
            $.ajax({
                url: 'ajax/'+lang+'/send',
                type: 'POST',
                data: {
                    name: $('#contact_name').val(),
                    email: $('#contact_email').val(),
                    message: $('#contact_message').val(),
                    letter: 'letter'
                },
                success: function () {
                    $('#contact_submit').button('reset');
                    //Use modal popups to display messages
                    $('#modalContactSuccess').modal('show');

                    $('#contact_name').val('');
                    $('#contact_email').val('');
                    $('#contact_message').val('');
                },
                error: function () {
                    $('#contact_submit').button('reset');
                    //Use modal popups to display messages
                    $('#modalContactError').modal('show');
                }
            });
        } else {
            $('#contact_submit_forum').button('reset')
        }
        return false;
    });
});
