<div id="add_file_modal" class="modal" style="padding-right: 20px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h3>Добавление файла</h3>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" id="addResourceWorkFile" onsubmit="addResourceWorkFile(); return false;" class="form-inline">
                    <input type="hidden" name="action" value="addFile">
                    <input type="hidden" name="record_type_id" value="1">
                    <input type="hidden" name="id" value="14410">
                    <div class="form-group">
                        <label class="col-sm-4">Введите наименование</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control fullwidth" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Выберите тип документа:</label>
                        <div class="col-sm-8">
                            <select name="achivement_type_id" class="selectpicker bs-select-hidden">
                                <option class="boldoption" disabled="disabled">Другое (ссылки, видеозаписи)</option><option value="28">Другое</option><option class="boldoption" disabled="disabled">Отзыв</option><option value="20">Другое</option><option value="13">Заключение</option><option value="15">Отзыв о работе</option><option value="16">Резюме</option><option value="19">Рекомендательное письмо</option><option value="14">Рецензия</option><option value="18">Характеристика</option><option value="17">Эссе</option><option class="boldoption" disabled="disabled">Подтверждение достижения</option><option value="5">Благодарность</option><option value="6">Грамота</option><option value="7">Диплом</option><option value="8">Другое</option><option value="9">Свидетельство</option><option value="10">Сертификат</option><option value="11">Ссылка</option><option value="12">Фото</option><option class="boldoption" disabled="disabled">Работа</option><option value="26">Дипломная работа</option><option value="23">Доклад</option><option value="27">Другое</option><option value="25">Контрольная работа</option><option value="24">Курсовая работа</option><option value="22">Публикация</option><option value="21">Реферат</option>							</select><div class="btn-group bootstrap-select"><button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" title="Резюме" aria-expanded="false"><span class="filter-option pull-left">Резюме</span>&nbsp;<span class="caret"></span></button><div class="dropdown-menu open" style="max-height: 727.271px; overflow: hidden; min-height: 102px;"><ul class="dropdown-menu inner" role="menu" style="max-height: 717.271px; overflow-y: auto; min-height: 92px;"><li data-original-index="0" class="disabled"><a tabindex="-1" class="boldoption" style="" data-tokens="null" href="#"><span class="text">Другое (ссылки, видеозаписи)</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="1" class=""><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Другое</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="2" class="disabled"><a tabindex="-1" class="boldoption" style="" data-tokens="null" href="#"><span class="text">Отзыв</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="3"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Другое</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="4"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Заключение</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="5" class=""><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Отзыв о работе</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="6" class="selected"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Резюме</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="7"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Рекомендательное письмо</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="8"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Рецензия</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="9"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Характеристика</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="10"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Эссе</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="11" class="disabled"><a tabindex="-1" class="boldoption" style="" data-tokens="null" href="#"><span class="text">Подтверждение достижения</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="12"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Благодарность</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="13"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Грамота</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="14"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Диплом</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="15"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Другое</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="16"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Свидетельство</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="17"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Сертификат</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="18"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Ссылка</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="19"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Фото</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="20" class="disabled"><a tabindex="-1" class="boldoption" style="" data-tokens="null" href="#"><span class="text">Работа</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="21"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Дипломная работа</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="22"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Доклад</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="23"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Другое</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="24"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Контрольная работа</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="25"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Курсовая работа</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="26"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Публикация</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="27"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Реферат</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul></div></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Выберите файл:</label>
                        <div class="col-sm-8">
                            <input type="file" name="file" class="form-control fullwidth" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Кому доступен ресурс:</label>
                        <div class="col-sm-8">
                            <select class="selectpicker bs-select-hidden" name="access_id">
                                <option value="1">Всем</option>
                                <option value="2">Только сотрудникам организации</option>
                                <option value="3">Только мне</option>
                            </select><div class="btn-group bootstrap-select"><button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" title="Всем" aria-expanded="false"><span class="filter-option pull-left">Всем</span>&nbsp;<span class="caret"></span></button><div class="dropdown-menu open" style="max-height: 574.229px; overflow: hidden; min-height: 0px;"><ul class="dropdown-menu inner" role="menu" style="max-height: 564.229px; overflow-y: auto; min-height: 0px;"><li data-original-index="0" class="selected"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Всем</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="1"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Только сотрудникам организации</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="2"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Только мне</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul></div></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Действия</label>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-lg btn-success">Добавить</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Закрыть окно</button>
            </div>
        </div>
    </div>
</div>
