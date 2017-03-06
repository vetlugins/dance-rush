<div class="row">
    <div class="col-lg-8">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-signal"></i>
                <h3><?php echo Kohana::message('admin', 'titles.'.$params['module'].'.statistics') ?></h3>
                <div class="pull-right box-toolbar"></div>
            </div>
            <div class="box-body">
                <div id="chart" style="width: 100%; height: 372px"></div>
                <script src="/templates/plugins/echarts/echarts.min.js" type="text/javascript"></script>
                <script>
                    var colors = ['#97cc64','#ffd963','#fd5a3e','#77b6e7','#a955b8','#dc9d6b','#ea527f'];

                    echarts.init(document.getElementById('chart')).setOption( {
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
                            data:['Визиты','Просмотры','Пользователи']
                        },
                        calculable : true,
                        xAxis : [
                            {
                                type : 'category',
                                boundaryGap : false,
                                data : [<?php echo $metrics['visits']['date'] ?>],
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
                                data:[<?php echo $metrics['visits']['data'] ?>],
                                markPoint : {
                                    data : [
                                        {type : 'max', name: 'Максимум'},
                                        {type : 'min', name: 'Минимум'}
                                    ]
                                },
                                /*markLine : {
                                    data : [
                                        {type : 'average', name: 'Среднее'}
                                    ]
                                },*/
                                color: ['#97cc64']
                            },
                            {
                                name:'Просмотры',
                                type:'line',
                                data:[<?php echo $metrics['views']['data'] ?>],
                                markPoint : {
                                    data : [
                                        {type : 'max', name: 'Максимум'},
                                        {type : 'min', name: 'Минимум'}
                                    ]
                                },
                               /* markLine : {
                                    data : [
                                        {type : 'average', name: 'Среднее'}
                                    ]
                                },*/
                                color: ['#ffd963']
                            },
                            {
                                name:'Пользователи',
                                type:'line',
                                data:[<?php echo $metrics['users']['data'] ?>],
                                markPoint : {
                                    data : [
                                        {type : 'max', name: 'Максимум'},
                                        {type : 'min', name: 'Минимум'}
                                    ]
                                },
                                /*markLine : {
                                    data : [
                                        {type : 'average', name: 'Среднее'}
                                    ]
                                },*/
                                color: ['#fd5a3e']
                            }

                        ]
                    });
                </script>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-thumb-tack"></i>
                <h3>Сейчас в Калуге</h3>
            </div>
            <div class="box-body no-padding">
                <div class="date-now">
                    <div class="col-md-4 date-time">
                        <h2 id="Date"></h2>
                        <h4><span id="hours"></span>:<span id="min"></span>:<span id="sec"></span></h4>
                    </div>
                    <div class="col-md-8 month-week">
                        <h2 id="Month"></h2>
                        <h4 id="Week"></h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="weather"></div>
            </div>
        </div>
    </div>
</div>


