$(document).ready(function(){
    //Switchery
    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, { color: '#1AB394' });

///////////////////////////////////////////////////////////////////////////
    $('#title').liTranslit({
        elAlias: $('#url')
    });

    $(function() {
        $(".list-drag-n-drop, .list-drag-n-drop .parent").sortable({tolerance: "pointer", opacity: 0.6, cursor: 'move', update: function() {

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
    // hideShow Page
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
    // change lang parent for add page
    $('#formPage select#lang').change(function(){

        var lang = $(this).val();
        var parent = $('#formPage select#parent_id');

        parent.find('option').remove();

        $.ajax({
            type: "POST",
            url: "/admin/ajax/change",
            data: 'changeLangPage=changeLangPage&lang='+lang,
            success: function(html){
                parent.append(html);
            }
        });

        return false;
    });
    /////////////////////////////////////////////////////
    $('a#delete').click(function(){

        var id = $(this).attr('rel');
        var parents = $(this).parent('div').parent('div').parent('li');

        var c = confirm(page.alert.delete);

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
    /////////////////////////////////////////////////////
    $('a#infoPage').on('show.bs.dropdown', function () {
        $(this).parent('div').find('.infoPage').addClass('animated flipInY');
    });
    $('a#infoPage').on('hide.bs.dropdown', function () {
        $(this).parent('div').find('.infoPage').removeClass('animated flipInY');
    });
    /////////////////////////////////////////////////////
    $('.collapse-parent').click(function(b){
        b.preventDefault();
        var $box = $(this).parent('div').parent('div').parent('li').find('.parent');
        $box.slideToggle("slow");
    });
    /////////////////////////////////////////////////////
    $('#formPage').bootstrapValidator({
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: page.validator.notEmpty.title
                    }
                }
            },
            url: {
                validators: {
                    notEmpty: {
                        message: page.validator.notEmpty.url
                    }
                }
            }
        }
    });
    /////////////////////////////////////////////////////
});

CKEDITOR.replace('text', {
    height: '400px'
});