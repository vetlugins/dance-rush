<section class="min-height p-0 m-0">
    <div id="map" class="min-height"></div>
</section>

<section class="block min-height bg-color-dark font-color-white p-0 m-0">
    <div class="container">
        <h2 class="section-title text-center">Наши контакты</h2>
        <div class="col-md-6 contacts">
            <div class="address">
                <h3>Калуга</h3>
                <p><i class="icon icon-thumb-tack"></i> <?php echo Params::obtain('address') ?></p>
                <p><i class="icon icon-thumb-tack"></i> <?php echo Params::obtain('address_branch_1') ?></p>

                <h3>Товарково</h3>
                <p><i class="icon icon-thumb-tack"></i> <?php echo Params::obtain('address_branch_2') ?></p>
            </div>
            <div class="phone">
                <h3>Наши телефоны</h3>
                <p><i class="icon icon-tablet"></i> <?php echo Params::obtain('phone1') ?> </p>
                <p><i class="icon icon-tablet"></i> <?php echo Params::obtain('phone2') ?> </p>
            </div>
            <div class="email">
                <h3>Электронная почта</h3>
                <p><i class="icon icon-envelope-o"></i> <a href="mailto:dance_rush@mail.ru"><?php echo Params::obtain('email') ?></a> </p>
            </div>
            <!--<div class="social">
                <h3>Социальные сети</h3>
                <p><i class="icon icon-bubbles"></i> <a href="mailto:dance_rush@mail.ru">dance_rush@mail.ru</a> </p>
            </div>-->
        </div>
        <div class="col-md-6">
            <div class="form-container">
                <form role="form" id="contact_form" novalidate="novalidate" >
                    <div class="form-group">
                        <input type="text" class="form-control" id="contact_name" placeholder="Имя" name="name">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="contact_email" placeholder="E-mail" name="email">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" id="contact_message" placeholder="Ваше письмо" rows="6"></textarea>
                    </div>
                    <button type="submit" id="contact_submit" data-loading-text="•••" class="btn btn-lg btn-block btn-primary">Отправить письмо</button>
                    <input type="hidden" name="letter" value="letter">
                </form>
            </div>
        </div>
    </div>
</section>

    <script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
	<script>
        var myMap;

        ymaps.ready(function () {
            myMap = new ymaps.Map('map', {
                zoom: 16,
                center: [<?php echo Params::obtain('ya_map_lat_general') ?>, <?php echo Params::obtain('ya_map_lon_general') ?>],
                controls: []
            }, {
                searchControlProvider: 'yandex#search'
            });

            myMap.behaviors.disable('scrollZoom');

            var myPlacemark = new ymaps.Placemark([<?php echo Params::obtain('ya_map_lat_general') ?>, <?php echo Params::obtain('ya_map_lon_general') ?>], {
                balloonContent: '<p style="width: 250px; height: 90px;text-align: center;"><?php echo Params::obtain('address') ?><br><br><span style="font-weight: bold;">Студия современного танца <br>Братьев Курбановых <br>"DANCERUSH"</span></p>'
            }, {
                balloonPanelMaxMapArea: 0
            });
            myMap.geoObjects.add(myPlacemark);

            observeEvents(myMap);

            myPlacemark.balloon.open();
        });

        function observeEvents (map) {
            var mapEventsGroup;
            map.geoObjects.each(function (geoObject) {
                geoObject.balloon.events
                    // При открытии балуна начинаем слушать изменение центра карты.
                    .add('open', function (e1) {
                        var placemark = e1.get('target');
                        // Вызываем функцию в двух случаях:
                        mapEventsGroup = map.events.group()
                            // 1) в начале движения (если балун во внешнем контейнере);
                            .add('actiontick', function (e2) {
                                if (placemark.options.get('balloonPane') == 'outerBalloon') {
                                    setBalloonPane(map, placemark, e2.get('tick'));
                                }
                            })
                            // 2) в конце движения (если балун во внутреннем контейнере).
                            .add('actiontickcomplete', function (e2) {
                                if (placemark.options.get('balloonPane') != 'outerBalloon') {
                                    setBalloonPane(map, placemark, e2.get('tick'));
                                }
                            });
                        // Вызываем функцию сразу после открытия.
                        setBalloonPane(map, placemark);
                    })
                    // При закрытии балуна удаляем слушатели.
                    .add('close', function () {
                        mapEventsGroup.removeAll();
                    });
            });
        }

        function setBalloonPane (map, placemark, mapData) {
            mapData = mapData || {
                    globalPixelCenter: map.getGlobalPixelCenter(),
                    zoom: map.getZoom()
                };

            var mapSize = map.container.getSize(),
                mapBounds = [
                    [mapData.globalPixelCenter[0] - mapSize[0] / 2, mapData.globalPixelCenter[1] - mapSize[1] / 2],
                    [mapData.globalPixelCenter[0] + mapSize[0] / 2, mapData.globalPixelCenter[1] + mapSize[1] / 2]
                ],
                balloonPosition = placemark.balloon.getPosition(),
            // Используется при изменении зума.
                zoomFactor = Math.pow(2, mapData.zoom - map.getZoom()),
            // Определяем, попадает ли точка привязки балуна в видимую область карты.
                pointInBounds = ymaps.util.pixelBounds.containsPoint(mapBounds, [
                    balloonPosition[0] * zoomFactor,
                    balloonPosition[1] * zoomFactor
                ]),
                isInOutersPane = placemark.options.get('balloonPane') == 'outerBalloon';

            // Если точка привязки не попадает в видимую область карты, переносим балун во внутренний контейнер
            if (!pointInBounds && isInOutersPane) {
                placemark.options.set({
                    balloonPane: 'balloon',
                    balloonShadowPane: 'shadows'
                });
                // и наоборот.
            } else if (pointInBounds && !isInOutersPane) {
                placemark.options.set({
                    balloonPane: 'outerBalloon',
                    balloonShadowPane: 'outerBalloon'
                });
            }
        }
	</script>
