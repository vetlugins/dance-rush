$(document).ready(function(){

    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, { color: '#1AB394' });

    var elem_2 = document.querySelector('.js-switch_2');
    var switchery_2 = new Switchery(elem_2, { color: '#1AB394' });

    var elem_3 = document.querySelector('.js-switch_3');
    var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });

    var elem_4 = document.querySelector('.js-switch_4');
    var switchery_4 = new Switchery(elem_4, { color: '#1AB394' });

    var elem_5 = document.querySelector('.js-switch_5');
    var switchery_5 = new Switchery(elem_5, { color: '#1AB394' });

    var elem_6 = document.querySelector('.js-switch_6');
    var switchery_6 = new Switchery(elem_6, { color: '#1AB394' });

    var elem_7 = document.querySelector('.js-switch_7');
    var switchery_7 = new Switchery(elem_7, { color: '#1AB394' });

    $('.fancybox').fancybox();

    $('.file-inputs').bootstrapFileInput();

    $('#params_value > div').hide();
    $('#params_value > div').eq(0).show();

    $('select#type').change(function(){
        $('#params_value > div').hide();
        $('#params_value').find('#'+$(this).val()).show();
        $('#params_value').find('input[name=type]').val($(this).val());
    })


});


