<script src="/templates/plugins/echarts/echarts.min.js" type="text/javascript"></script>

<div class="row">
    <div class="col-lg-8">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-signal"></i>
                <h3><?php echo __('Сводная статистика') ?> <?php echo __('за последний месяц') ?></h3>
                <div class="pull-right box-toolbar"></div>
            </div>
            <div class="box-body">
                <div id="chart" style="width: 100%; height: 372px"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-thumb-tack"></i>
                <h3><?php echo __('Популярные страницы') ?></h3>
            </div>
            <div class="box-body no-padding" style="height:393px; overflow: auto">
                <table class="table table-responsive" style="width: 100%;">
                    <thead>
                        <tr>
                            <th><?php echo __('URL страницы') ?></th>
                            <th></th>
                            <th class="text-center"><i class="fa fa-eye" title="<?php echo __('Просмотры') ?>" data-toggle="tooltip"></i></th>
                            <th class="text-center"><i class="fa fa-users" title="<?php echo __('Визиты') ?>" data-toggle="tooltip"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach($metrics['pages'] as $value){
                            echo '<tr>
                                    <td style="word-break:break-all; width: 60%"><a class="select-page" data-id="'.$value['id'].'" href="#" data-toggle="tooltip" title="'.__('Статистика страницы').'">'.$value['page'].'</a></td>
                                    <td style="width: 10%" class="text-center"><a href="'.$value['page'].'" target="_blank" title="'.__('Переход на страницу').'" data-toggle="tooltip"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
                                    <td style="width: 15%" class="text-center">'.$value['views'].'</td>
                                    <td style="width: 15%" class="text-center">'.$value['visits'].'</td>
                                  </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-lg-4">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-venus-mars" aria-hidden="true"></i>
                <h3><?php echo __('Пол') ?></h3>
            </div>
            <div class="box-body no-padding" style="height:393px; overflow: auto">
                <div id="chart-gender" style="width: 100%; height: 372px"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-users" aria-hidden="true"></i>
                <h3><?php echo __('Возраст') ?></h3>
            </div>
            <div class="box-body no-padding" style="height:393px; overflow: auto">
                <div id="chart-age" style="width: 100%; height: 372px"></div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-lg-8">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <h3><?php echo __('Количество визитов по дням недели') ?></h3>
            </div>
            <div class="box-body no-padding" style="height:393px; overflow: auto">
                <div id="chart-day-week" style="width: 100%; height: 372px"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-users" aria-hidden="true"></i>
                <h3><?php echo __('Отказность') ?></h3>
            </div>
            <div class="box-body no-padding" style="height:393px; overflow: auto">
                <div id="chart-exemption" style="width: 100%; height: 372px"></div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="pageStat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo __('Посещаемость страницы') ?> <span id="pageTitle"></span></h4>
            </div>
            <div class="modal-body no-padding">
                <div id="chart-page" style="height: 372px; margin: 0 auto"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><?php echo __('Закрыть') ?></button>
            </div>
        </div>
    </div>
</div>

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
                /*markLine : {
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

    echarts.init(document.getElementById('chart-gender')).setOption( {
        title : {
            subtext: '',
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c}({d}%)"
        },
        legend: {
            orient : 'vertical',
            x : 'left',
            data: [<?php echo $metrics['gender']['name'] ?>]
        },

        calculable : true,
        series : [
            {
                name:'Всего визитов',
                type:'pie',
                radius : '55%',
                center: ['50%', '50%'],
                color: colors,
                data:[
                    <?php echo $metrics['gender']['data'] ?>
                ]
            }
        ]
    });

    echarts.init(document.getElementById('chart-age')).setOption( {
        title : {
            subtext: '',
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c}({d}%)"
        },
        legend: {
            orient : 'vertical',
            x : 'left',
            data: [<?php echo $metrics['age']['name'] ?>]
        },

        calculable : true,
        series : [
            {
                name:'Всего визитов',
                type:'pie',
                radius : '55%',
                center: ['50%', '50%'],
                color: colors,
                data:[
                    <?php echo $metrics['age']['data'] ?>
                ]
            }
        ]
    });

    echarts.init(document.getElementById('chart-day-week')).setOption( {
        title : {
            subtext: '',
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c}({d}%)"
        },
        legend: {
            orient : 'vertical',
            x : 'left',
            data: [<?php echo $metrics['day_week']['days'] ?>]
        },

        calculable : true,
        series : [
            {
                name:'Всего визитов',
                type:'pie',
                radius : '55%',
                center: ['50%', '50%'],
                color: colors,
                data:[
                    <?php echo $metrics['day_week']['data'] ?>
                ]
            }
        ]
    });

    echarts.init(document.getElementById('chart-exemption')).setOption( {
        title : {
            subtext: '',
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c}({d}%)"
        },
        legend: {
            orient : 'vertical',
            x : 'left',
            data: [<?php echo $metrics['exemption']['name'] ?>]
        },

        calculable : true,
        series : [
            {
                name:'Всего визитов',
                type:'pie',
                radius : '55%',
                center: ['50%', '50%'],
                color: colors,
                data:[<?php echo $metrics['exemption']['data'] ?>]
            }
        ]
    });

</script>