$(document).ready(function(){

   $('.select-page').click(function(){

       var id = $(this).attr('data-id');

       $.ajax({
           url:'/admin/ajax/statistics',
           data:{'id': id},
           type: 'POST',
           success: function(data){

               var obj = $.parseJSON(data),
                   width = $('#pageStat').find('.modal-dialog').width(),
                   views = [obj.views],
                   visits = [obj.visits];

               console.log(views);

               $('#pageStat').find('#pageTitle').html(obj.page);

               $('#chart-page').css('width',width+'px');

               echarts.init(document.getElementById('chart-page')).setOption( {
                   grid:{
                       x: 50,
                       x2: 50,
                       y: 50,
                       y2: 35
                   },
                   tooltip : {
                       trigger: 'axis'
                   },
                   legend: {
                       data:[statistics.visits,statistics.views]
                   },
                   calculable : true,
                   xAxis : [
                       {
                           type : 'category',
                           boundaryGap : false,
                           data :  obj.date,
                   axisTick: 'hide',
                   axisLine: {
                       lineStyle: {
                           width: 0
                       }
                   },
                   axisLabel: {
                       textStyle:{
                           color: '#a4a4a4'
                       }
                   }
               }
               ],
               yAxis : [
                   {
                       type : 'value',
                       axisTick: 'hide',
                       axisLine: {
                           lineStyle: {
                               width: 0
                           }
                       },
                       axisLabel: {
                           textStyle:{
                               color: '#a4a4a4'
                           }
                       }
                   }
               ],
                   series : [
                   {
                       name:statistics.visits,
                       type:'line',
                       data:visits,
                       markPoint : {
                       data : [
                           {type : 'max', name: statistics.max},
                           {type : 'min', name: statistics.min}
                       ]
                   },
                   color: ['#97cc64']
                   },
                   {
                       name:statistics.views,
                           type:'line',
                           data:views,
                           markPoint : {
                               data : [
                                   {type : 'max', name: statistics.max},
                                   {type : 'min', name: statistics.min}
                               ]
                           },
                           color: ['#ffd963']
                   }
               ]
           });

           $('#pageStat').modal('show');

           }
       });


        return false;

   });

});


