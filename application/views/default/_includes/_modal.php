<!-- Modal
<div class="modal fade" id="enroll" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Хочу танцевать в DANCE RUSH</h4>
            </div>
            <div class="modal-body">
                <form id="sendEnroll" role="form">
                    <div class="form-group">
                        <label for="name">Ваше имя</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Ваш телефон</label>
                        <input type="text"  name="phone" id="phone" required data-inputmask="'mask': '+7(999)999 99 99'" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-outline-primary">Отправить заявку</button>
            </div>
        </div>
    </div>
</div>
-->

<!-- Модальные окна-->
<div class="modal fade" id="modalContactSuccess" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title"><i class="icon icon-paper-plane"></i>Отлично!<br>Ваша письмо успешно отправлено!</h3>
        </div>
    </div>
</div>
<div class="modal fade" id="modalContactError" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title"><i class="icon icon-optin-monster"></i>Ошибка</h3>
        </div>
    </div>
</div>
