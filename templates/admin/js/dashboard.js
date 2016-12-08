(function($) {
    "use strict";
    // number count
    $('.timer').countTo();

    //TagsInput
    $("[data-toggle='tags']").tagsinput({
        tagClass: function(item) {
            return 'label label-primary';
        }
    });

    $(".alert").alert();

    //events
    $('#events').slimScroll({
        height: '260px'
    });
    // chat scroll
    $('#chat-box').slimScroll({
        height: '260px'
    });
    //newbie
    $('#newbie').slimScroll({
        height: '260px'
    });

    //iCheck
    $("input[type='checkbox'], input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });

    // flot
    // преобразуем даты в UTC
    for(var j = 0; j < all_data.length; ++j) {
        for(var i = 0; i < all_data[j].data.length; ++i)
            all_data[j].data[i][0] = Date.parse(all_data[j].data[i][0]);
    }
    var C= ["#e65353","#7fb9d1"];
    var plot = $.plot("#placeholder", all_data, {
        series: {
            lines: {
                show: true,
                fill: true
            },
            points: {
                show: true
            },
            shadowSize: 0
        },
        grid: {
            hoverable: true,
            clickable: true,
            aboveData: true,
            borderWidth: 0
        },
        xaxis: {
            mode: "time",
            timeformat: "%d/%m"
        },
        legend:{
            noColumns: 0,
            margin: [0,-23],
            labelBoxBorderColor: null
        },
        colors: C,
        tooltip: true
    });

    function showTooltip(x, y, contents) {
        $("<div id='flot_tip' style='z-index: 9999'>" + contents + "</div>").css({
            top: y - 20,
            left: x + 5
        }).appendTo("body").fadeIn(200);
    }

    var previousPoint = null;

    function _getDate(x) {
        var month_names = new Array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
        var d = new Date(x);
        var current_date = d.getDate();
        var current_month = d.getMonth();
        var current_year = d.getFullYear();

        return current_date + " " + month_names[current_month] 	+ " " + current_year;

    }

    $('#placeholder').bind('plothover', function (event, pos, item) {
        if (item) {
            if (previousPoint != item.dataIndex) {
                previousPoint = item.dataIndex;
                $('#flot_tip').remove();
                var x = item.datapoint[0],
                    y = item.datapoint[1],
                    date = _getDate(x);
                showTooltip(item.pageX, item.pageY,
                    y + " " + item.series.label + " за " + date + "");
            }
        } else {
            $('#flot_tip').remove();
            previousPoint = null;
        }
    });


    // jvectormap
    $('#map').vectorMap({
        map: 'europe_merc_en',
        zoomMin: '3',
        backgroundColor: "#fff",
        focusOn: { x: 0.5, y: 0.7, scale: 3 },
        markers: [
            {latLng: [42.5, 1.51], name: 'Andorra'},
            {latLng: [43.73, 7.41], name: 'Monaco'},
            {latLng: [47.14, 9.52], name: 'Liechtenstein'},
            {latLng: [41.90, 12.45], name: 'Vatican City'},
            {latLng: [43.93, 12.46], name: 'San Marino'},
            {latLng: [35.88, 14.5], name: 'Malta'}
        ],
        markerStyle: {
            initial: {
                fill: '#fa4547',
                stroke: '#fa4547',
                "stroke-width": 6,
                "stroke-opacity": 0.3
            }
        },
        regionStyle: {
            initial: {
                fill: '#e4e4e4',
                "fill-opacity": 1,
                stroke: 'none',
                "stroke-width": 0,
                "stroke-opacity": 1
            }
        }
    });

    //ionTabs
    $.ionTabs("#tabs_1",{
        "tabId": "#Tab__ru"
    });

    $('.fancybox').fancybox();

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
        location: 'Navoi',
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