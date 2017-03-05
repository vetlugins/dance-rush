$(document).ready(function(){

    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, { color: '#1AB394' });

    $('.file-inputs').bootstrapFileInput();

    $('.fancybox').fancybox();
    $('.fancybox-media').fancybox({
        openEffect  : 'none',
        closeEffect : 'none',
        padding : 0,
        helpers : {
            media : {}
        }
    });

    $(function() {
        $(".sortAlbum").sortable({tolerance: "pointer", opacity: 0.6, cursor: 'move', update: function() {

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

    $('a.deleteAlbum').click(function(){

        var id = $(this).attr('rel');
        var parents = $(this).parent('div').parent('div').parent('li');

        var c = confirm(video.alert.delete_album);

        if(c === true){

                $.ajax({
                    type: "POST",
                    url: "/admin/ajax/soft_delete",
                    data: 'model='+model+'&id='+id,
                    success: function(html){

                        parents.fadeOut(function(){

                            var position = "top-right";
                            var scrollpos = $(document).scrollTop();
                            if(scrollpos < 10) position = "customtop-right";
                            $.jGrowl(html, { life: 10000, position: position});

                            parents.remove();
                        });
                    }
                });
        }
    });

    $('#addVideoAlbum').submit(function(){
        var values = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "/admin/ajax/add",
            data: 'insertVideoAlbum=insertVideoAlbum&'+values,
            beforeSend: function(){
                $('#addVideoAlbum .result').html('<div class="loading">'+photo.alert.wait+'...</div>');
            },
            success: function(html){
                $('#addVideoAlbum .result').html(html);
            }
        });
        return false;
    });

    $('#addAlbum').on('hide.bs.modal', function (e) {
        window.location.reload();
    });

    $('.editAlbum').click(function() {

        var id = $(this).attr('id');

        $.ajax({
            type: "POST",
            url: '/admin/ajax/load',
            data: 'loadVideoAlbum=loadVideoAlbum&id='+id,
            success: function(data){

                $('#editAlbum').modal('show');

                var obj = $.parseJSON(data);

                $('#edit-title').val(obj.title);
                $('#edit-url').val(obj.url);
                $('#edit-lang').val(obj.lang);
                $('#edit-id').val(obj.id);

            }
        });
        return false;

    });

    $('#editAlbum').on('hide.bs.modal', function (e) {
        window.location.reload();
    });

    $('#editVideoAlbum').submit(function(){
        var values = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "/admin/ajax/edit",
            data: 'editVideoAlbum=editVideoAlbum&'+values,
            beforeSend: function(){
                $('#editVideoAlbum .result').html('<div class="loading">'+video.alert.wait+'...</div>');
            },
            success: function(html){
                $('#editVideoAlbum .result').html(html);
            }
        });
        return false;
    });

    $('#addVideoAlbum,#editVideoAlbum').bootstrapValidator({
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: video.validator.notEmpty.title
                    }
                }
            },
            url: {
                validators: {
                    notEmpty: {
                        message: video.validator.notEmpty.url
                    }
                }
            }
        }
    });

    $('.item-container .cover').click(function(){

        var parent = $(this).parent('div').parent('div'),
            id = $(this).attr('id'),
            album = $(this).attr('rel');

        $.ajax({
            type: "POST",
            url: "/admin/ajax/change",
            data: 'changeCoverVideoAlbum=changeCoverVideoAlbum&id='+id+'&album='+album,
            success: function(msg){
                $('.item-container').find('.item-cover-green').removeClass('item-cover-green').addClass('item-cover-default');
                parent.removeClass('item-cover-default').addClass('item-cover-green');
            }
        });

    });

    $('.item-container .delete').click(function(){
        var parent = $(this).parent('div').parent('div');
        var id = $(this).attr('id');
        var c = confirm(video.alert.delete_video);
        if(c === true){

            $.ajax({
                type: "POST",
                url: "/admin/ajax/soft_delete",
                data: 'model=Video_Items&id='+id,
                success: function(msg){

                    var msg = msg;
                    var position = "top-right";
                    var scrollpos = $(document).scrollTop();
                    if(scrollpos < 10) position = "customtop-right";
                    $.jGrowl(msg, { life: 10000, position: position});

                    parent.hide('explode',500);
                }
            });
        }
    });

});
