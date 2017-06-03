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
    });

    $('.section-params').click(function() {

        var id = $(this).attr('id');

        var section = $('#section-params'),
            section_id = section.find('#section_id').val(id);

        if(id != 0){

            $.ajax({
                type: "POST",
                url: '/admin/ajax/load',
                data: 'loadParamsSection=loadParamsSection&id='+id,
                success: function(data){

                    section.modal('show');

                    var obj = $.parseJSON(data);

                    section.find('#title').val(obj.title);
                    section.find('#myModalLabel').html(params.edit_section);
                    section.find('#buttonParamsSection').val(button.edit);
                }
            });
            return false;

        }else{
            section.modal('show');
            section.find('#myModalLabel').html(params.add_section);
            section.find('#buttonParamsSection').val(button.add);
        }

    });

    $('#section-params').on('hide.bs.modal', function (e) {
        window.location.reload();
    });

    form.initialize($("#paramsSection"));

});

var form_rules = {
    fields: {
        title: {
            validators: {
                notEmpty: {
                    message: validator.notEmpty.title
                }
            }
        }
    }
};

var form = {

    initialize : function (section) {

        section.bootstrapValidator(form_rules).on('submit',form.submitForm);

        return false;
    },

    submitForm: function (e) {

        if (e.isDefaultPrevented()) {

            var title      = $(this).find('#title').val(),
                section_id = $(this).find('#section_id').val(),
                form       = $(this), action;

            if(section_id == 0) action = '/admin/ajax/add';
            else action = '/admin/ajax/edit';

            $.ajax({
                type: "POST",
                url: action,
                data: 'paramsSection=paramsSection&section_id='+section_id+'&title='+title,
                success: function(data){
                    form.find('.result').html(data);
                }
            });

            return false;
        }

        return false;
    }
};