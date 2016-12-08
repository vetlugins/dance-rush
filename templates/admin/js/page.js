$(document).ready(function(){
    //Switchery
    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, { color: '#1AB394' });


///////////////////////////////////////////////////////////////////////////
    // sortPage
    $(function() {
        $(".list-drag-n-drop, .list-drag-n-drop .parent").sortable({tolerance: "pointer", opacity: 0.6, cursor: 'move', update: function() {

            var order = $(this).sortable("serialize") + '&sortPage=sortPage';
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
    $('a#hideShowPage').click(function(){

        var id = $(this).attr('rel');
        var result = $(this);
        var this_class = $(this);

        $.ajax({
            type: "POST",
            url: "/admin/ajax/hideShow",
            data: 'hideShowPage=hideShowPage&id='+id,
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
    $('#formAddPage select#lang').change(function(){

        var lang = $(this).val();
        var parent = $('#formAddPage select#parent_id');

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

        var c = confirm("Удалить эту страницу?");

        if(c === true){

                $.ajax({
                    type: "POST",
                    url: "/admin/ajax/delete",
                    data: 'deletePage=deletePage&id='+id,
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
    /*$('a#infoPage').click(function(){
        $(this).parent('div').find('.infoPage').slideToggle();
    });*/
    $('a#infoPage').on('show.bs.dropdown', function () {
        $(this).parent('div').find('.infoPage').addClass('animated flipInY');
    });
    $('a#infoPage').on('hide.bs.dropdown', function () {
        $(this).parent('div').find('.infoPage').removeClass('animated flipInY');
    });

    $('.collapse-parent').click(function(b){
        b.preventDefault();
        var $box = $(this).parent('div').parent('div').parent('li').find('.parent');
        $box.slideToggle("slow");
    });

    $('#formAddPage #title').liTranslit({
        elAlias: $('#formAddPage #url')
    });

    $('#formAddPage').bootstrapValidator({
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: 'Введите название страницы'
                    }
                }
            },
            url: {
                validators: {
                    notEmpty: {
                        message: 'Введите URL страницы'
                    }
                }
            }
        }
    });


////////////////////////////////////////////////////////////////////////////
});

CKEDITOR.replace('text', {
    height: '400px'
});