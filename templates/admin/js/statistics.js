$(document).ready(function(){

   $('.select-page').click(function(){

       var id = $(this).attr('data-id');

       $.ajax({
           url:'/admin/ajax/statistics',
           data:{'id': id},
           type: 'POST',
           success: function(data){

               var obj = $.parseJSON(data);

               $('#pageStat').find('#pageTitle').html(obj.page);

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
                       data:['������','���������']
                   },
                   calculable : true,
                   xAxis : [
                       {
                           type : 'category',
                           boundaryGap : false,
                           data : [],
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
                           name:'������',
                           type:'line',
                           data:[],
                           markPoint : {
                               data : [
                                   {type : 'max', name: '��������'},
                                   {type : 'min', name: '�������'}
                               ]
                           },
                           color: ['#97cc64']
                       },
                       {
                           name:'���������',
                               type:'line',
                           data:[],
                           markPoint : {
                               data : [
                                   {type : 'max', name: '��������'},
                                   {type : 'min', name: '�������'}
                               ]
                           },
                           color: ['#ffd963']
                       }
                   ]
               });

               $('#pageStat').modal('show');
           }
       });




   });

});


