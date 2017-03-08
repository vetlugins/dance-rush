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
                   views = obj.views;

               $('#pageStat').find('#pageTitle').html(obj.page);

               $('#chart-page').css('width',width+'px');

               console.log(views);

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
                       data:['Визиты','Просмотры']
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
                       name:'Визиты',
                       type:'line',
                       data:[0,0,0,0,2,19,12,8,7,7,4,5,5,8,4,4,6,0,1,6,3,4,3,1,2,5,5,10,3,2],
                   markPoint : {
                   data : [
                       {type : 'max', name: 'Максимум'},
                       {type : 'min', name: 'Минимум'}
                   ]
               },
               color: ['#97cc64']
               },
               {
                   name:'Просмотры',
                       type:'line',
                   data:[0,0,0,0,15,52,22,14,43,16,19,9,10,14,8,21,41,0,6,27,6,6,12,1,3,30,57,50,17,5],
                   markPoint : {
                       data : [
                           {type : 'max', name: 'Максимум'},
                           {type : 'min', name: 'Минимум'}
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


