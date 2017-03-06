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

    $(function() {
        $(".list-drag-n-drop").sortable({tolerance: "pointer", opacity: 0.6, cursor: 'move', update: function() {

            var order = $(this).sortable("serialize") + '&model='+model;
            $.post("/admin/ajax/sort", order, function(theResponse){

                var msg = theResponse;
                var position = "top-right";
                var scrollpos = $(document).scrollTop();
                if(scrollpos < 50) position = "customtop-right";
                $.jGrowl(msg, { life: 10000, position: position});
            });
        }
        });
    });

    //Date picker
    $('.datepicker-input').datetimepicker({
        lang: 'ru',
        format: 'Y-m-d H:i:s'
    });

    $('.file-inputs').bootstrapFileInput();

    $('.fancybox').fancybox();

    $('a#hideShow').click(function(){

        var id = $(this).attr('rel');
        var result = $(this);
        var this_class = $(this);

        $.ajax({
            type: "POST",
            url: "/admin/ajax/hideShow",
            data: 'model='+model+'&id='+id,
            success: function(html){

                if (this_class.hasClass("btn-success")) {
                    this_class.removeClass("btn-success").addClass("btn-warning");
                } else {
                    this_class.removeClass("btn-warning").addClass("btn-success");
                }
                result.html(html);
            }
        });

        return false;
    });

    $('a#delete').click(function(){

        var id = $(this).attr('rel');
        var parents = $(this).parent('td').parent('tr');

        var c = confirm(alert.delete);

        if(c === true){

                $.ajax({
                    type: "POST",
                    url: "/admin/ajax/soft_delete",
                    data: 'model='+model+'&id='+id,
                    success: function(html){

                        parents.fadeOut(function(){

                            var msg = html;
                            var position = "top-right";
                            var scrollpos = $(document).scrollTop();
                            if(scrollpos < 10) position = "customtop-right";
                            $.jGrowl(msg, { life: 10000, position: position});

                            parents.remove();
                        });
                    }
                });
        }
    });

    $('#form').bootstrapValidator({
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: validator.notEmpty.title
                    }
                }
            },
            url: {
                validators: {
                    notEmpty: {
                        message: validator.notEmpty.url
                    }
                }
            }
        }
    });

    // change lang parent for add page
    $('#form select#lang').change(function(){

        var lang = $(this).val();
        var parent = $('#form select#category_url');

        parent.find('option').remove();

        $.ajax({
            type: "POST",
            url: "/admin/ajax/change",
            data: 'changeLangBlogCategory=changeLangBlogCategory&lang='+lang,
            success: function(html){
                parent.append(html);
            }
        });

        return false;
    });

    $('#title').liTranslit({
        elAlias: $('#url')
    });


    // Drop zone
    Dropzone.options.uploadPhoto = {
        acceptedFiles: 'image/jpeg,image/jpg,image/JPEG,image/JPG',
        maxFilesize: 1
    };

    $('#add-field-link').click(function() {
        $('<div class="video-link margin-bottom-sm">'+
            '<input type="text" name="video_link[]" class="form-control">'+
            '</div>').fadeIn('slow').appendTo('.video-link-input');
    });

    $('#remove-field-link').click(function() {
        $('.video-link:last').remove();
    });

    $('#add-field-html').click(function() {
        $('<div class="html-code margin-bottom-sm">'+
        '<div class="form-group margin-bottom-sm">'+
        '<div class="col-sm-12">'+
        '<input type="file" name="video_cover[]" class="btn btn-info file-inputs" title="Выберите скриншот видео">'+
        '</div>'+
        '</div>'+
        '<div class="form-group margin-bottom-sm">'+
        '<div class="col-sm-12">'+
        '<textarea name="video-html[]" class="form-control" placeholder="HTML код"></textarea>'+
        '</div>'+
        '</div> '+
          '</div>   ').fadeIn('slow').appendTo('.video-html-input');

        $('.html-code:last').find('.file-inputs').bootstrapFileInput();

    });

    $('#remove-field-html').click(function() {
        $('.html-code:last').remove();
    });

    $('.add_photo').hide();

    $('#add_photo').click(function() {
        $('.add_photo').slideDown('slow');
        $('#add_video').fadeOut().remove();
        $(this).attr('disable');
    });

    $('.add_video').hide();

    $('#add_video').click(function() {
        $('.add_video').slideDown('slow');
        $('#add_photo').fadeOut().remove();
        $(this).attr('disable');
    });
});

CKEDITOR.replace('text', {
    height: '400px'
});
CKEDITOR.replace('description', {
    height: '200px'
});