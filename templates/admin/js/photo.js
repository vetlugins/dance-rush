$(document).ready(function(){

    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, { color: '#1AB394' });

    $('.fancybox').fancybox();

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

        var c = confirm(photo.alert.delete_album);

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

    $('#addPhotoAlbum').submit(function(){
        var values = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "/admin/ajax/add",
            data: 'insertPhotoAlbum=insertPhotoAlbum&'+values,
            beforeSend: function(){
                $('#addPhotoAlbum .result').html('<div class="loading">'+photo.alert.wait+'...</div>');
            },
            success: function(html){
                $('#addPhotoAlbum .result').html(html);
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
            data: 'loadPhotoAlbum=loadPhotoAlbum&id='+id,
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

    $('#editPhotoAlbum').submit(function(){
        var values = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "/admin/ajax/edit",
            data: 'editPhotoAlbum=editPhotoAlbum&'+values,
            beforeSend: function(){
                $('#editPhotoAlbum .result').html('<div class="loading">'+photo.alert.wait+'...</div>');
            },
            success: function(html){
                $('#editPhotoAlbum .result').html(html);
            }
        });
        return false;
    });

    $('#addPhotoAlbum,#editPhotoAlbum').bootstrapValidator({
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: photo.validator.notEmpty.title
                    }
                }
            },
            url: {
                validators: {
                    notEmpty: {
                        message: photo.validator.notEmpty.url
                    }
                }
            }
        }
    });

    Dropzone.options.uploadPhoto = {
        acceptedFiles: 'image/jpeg,image/jpg,image/JPEG,image/JPG',
        parallelUploads: 1
    };

    $('.photo-container .cover').click(function(){

        var parent = $(this).parent('div').parent('div'),
            id = $(this).attr('id'),
            album = $(this).attr('rel');

        $.ajax({
            type: "POST",
            url: "/admin/ajax/change",
            data: 'changeCoverPhotoAlbum=changeCoverPhotoAlbum&id='+id+'&album='+album,
            success: function(msg){
                $('.photo-container').find('.photo-cover-green').removeClass('photo-cover-green').addClass('photo-cover-default');
                parent.removeClass('photo-cover-default').addClass('photo-cover-green');
            }
        });

    });

    $('.photo-container .delete').click(function(){
        var parent = $(this).parent('div').parent('div');
        var id = $(this).attr('id');
        var c = confirm(photo.alert.delete_photo);
        if(c === true){

            $.ajax({
                type: "POST",
                url: "/admin/ajax/soft_delete",
                data: 'model=Photo_Items&id='+id,
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
