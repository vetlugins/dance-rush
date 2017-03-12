$(document).ready(function(){

    $('.file-inputs').bootstrapFileInput();

    $(".multiple-roles").select2();

    $(":input").inputmask();

    $('#visits').dataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false
    });

});


