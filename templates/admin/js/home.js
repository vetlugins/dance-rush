(function($) {
    "use strict";

    // ToDo
    $('.checkbox').on('ifChecked', function(event){
        $(this).parents('li').addClass('through');
        var id = $(this).parents('li').attr('id');
        $.ajax({ url: "/admin/ajax/change", data: 'status=ifChecked&changeTodo=changeTodo&id='+id,type: "POST",});
    });
    $('.checkbox').on('ifUnchecked', function(event){
        $(this).parents('li').removeClass('through');
        var id = $(this).parents('li').attr('id');
        $.ajax({ url: "/admin/ajax/change", data: 'status=ifUnchecked&changeTodo=changeTodo&id='+id,type: "POST",});
    });

    $('#formAddTodo').submit(function(){

        var form   = $(this),
            result = form.find('.result'),
            values = form.serialize();

        var val = $('#myTodo').find('#title').val();

        form.ajaxForm();

        form.ajaxSubmit({
            type: "POST",
            url: '/admin/ajax/add',
            data: values,
            beforeSend: function(){
                result.html('<img src="'+via_host_skins_admin +'img/loaders/3_l.gif"> Секундочку...');
            },
            success: function(html) {

                if(html == 1){
                    result.html('<span style="color: green;">Добавлено</span>');

                    var todo = '<li>';
                    todo += '<span class="text">'+val+'</span>';
                    todo += '<small class="label label-info"><i class="fa fa-clock-o"></i> только что</small>';
                    todo += '</li>';

                    $('.no-todo').fadeOut().remove();

                    $('.todo').prepend(todo);

                }else{
                    result.html('<span style="color: red">Вы не ввели название</span>');
                }

            }
        });

        return false;
    });

    $('a.deleteTodo').click(function(){


        var id = $(this).parents('li').attr('id');
        var parents = $(this).parents('li');

        $.ajax({
            type: "POST",
            url: "/admin/ajax/delete",
            data: 'deleteTodo=deleteTodo&id='+id,
            success: function(html){

                parents.fadeOut(function(){
                    parents.remove();
                });
            }
        });
        return false;
    });

    $('.deleteAllTodo').click(function(){

        var todo = $('.todo');

        $.ajax({
            type: "POST",
            url: "/admin/ajax/delete",
            data: 'deleteAllTodo=deleteAllTodo',
            success: function(html){

                todo.fadeOut(function(){
                    todo.remove();
                });

            }
        });

        return false;
    });

//////////////////////////////////////////////////////
})(jQuery);

$(document).ready(function() {
    $.simpleWeather({
        location: 'Kaluga',
        woeid: '',
        unit: 'c',
        success: function(weather) {
            html = '<h2><i class="icon-'+weather.code+'"></i> '+weather.temp+'&deg;'+weather.units.temp+'</h2>';

            $("#weather").html(html);
        },
        error: function(error) {
            $("#weather").html('<p>'+error+'</p>');
        }
    });
});


$(document).ready(function() {
    // Create two variable with the names of the months and days in an array
    var monthNames = [ "Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря" ];
    var dayNames= ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"];

    // Create a newDate() object
    var newDate = new Date();
    // Extract the current date from Date object
    newDate.setDate(newDate.getDate());
    // Output the day, date, month and year
    $('#Date').html(newDate.getDate());
    $('#Month').html(monthNames[newDate.getMonth()]);
    $('#Week').html(dayNames[newDate.getDay()]);

    setInterval( function() {
        // Create a newDate() object and extract the seconds of the current time on the visitor's
        var seconds = new Date().getSeconds();
        // Add a leading zero to seconds value
        $("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
    },1000);

    setInterval( function() {
        // Create a newDate() object and extract the minutes of the current time on the visitor's
        var minutes = new Date().getMinutes();
        // Add a leading zero to the minutes value
        $("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
    },1000);

    setInterval( function() {
        // Create a newDate() object and extract the hours of the current time on the visitor's
        var hours = new Date().getHours();
        // Add a leading zero to the hours value
        $("#hours").html(( hours < 10 ? "0" : "" ) + hours);
    }, 1000);


});