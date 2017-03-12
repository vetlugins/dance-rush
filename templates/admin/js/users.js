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

    $('#formUser').bootstrapValidator({
        fields: {
            login: {
                validators: {
                    notEmpty: {
                        message: validator.notEmpty.login
                    }
                }
            },
            username: {
                validators: {
                    notEmpty: {
                        message: validator.notEmpty.username
                    }
                }
            },
            role: {
                validators: {
                    notEmpty: {
                        message: validator.notEmpty.role
                    }
                }
            }
            ,
            email: {
                validators: {
                    notEmpty: {
                        message: validator.notEmpty.email
                    },
                    emailAddress: {
                        message: validator.uncorrected.email
                    }
                }
            }
        }
    });

    $("#password").password({
        eyeClass: 'fa',
        eyeOpenClass: 'fa-eye',
        eyeCloseClass: 'fa-eye-slash'
    })
});


