<div id="add_link_modal" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h3>Добавление ссылки на документ, видео или веб-страницу</h3>
            </div>
            <div class="modal-body">
                <form id="add_link_form" onsubmit="addLink(); return false;" class="form-inline">
                    <input type="hidden" name="record_type_id" value="1">
                    <div class="form-group">
                        <label class="col-sm-4">Введите наименование</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control fullwidth" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Выберите тип документа:</label>
                        <div class="col-sm-8">
                            <select name="achievement_type_id" class="selectpicker bs-select-hidden">
                                @if(isset($categories) and is_iterable($categories))
                                    @foreach($categories as $category)
                                        <option class="boldoption" disabled="disabled">{{$category->name}}</option>
                                        @if(isset($category->achievementsTypes) and is_iterable($category->achievementsTypes))
                                            @foreach($category->achievementsTypes as $achievementType)
                                                <option value="{{$achievementType->id}}">{{$achievementType->name}}</option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Введите ссылку:</label>
                        <div class="col-sm-8">
                            <input type="text" name="content" class="form-control fullwidth" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Кому доступен ресурс:</label>
                        <div class="col-sm-8">
                            <select class="selectpicker bs-select-hidden" name="access_id">
                                <option value="1">Всем</option>
                                <option value="2">Только сотрудникам организации</option>
                                <option value="3">Только мне</option>
                            </select>
                            <div class="btn-group bootstrap-select">
                                <button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown"
                                        title="Всем"><span class="filter-option pull-left">Всем</span>&nbsp;<span
                                        class="caret"></span></button>
                                <div class="dropdown-menu open">
                                    <ul class="dropdown-menu inner" role="menu">
                                        <li data-original-index="0" class="selected"><a tabindex="0" class="" style=""
                                                                                        data-tokens="null"><span
                                                    class="text">Всем</span><span
                                                    class="glyphicon glyphicon-ok check-mark"></span></a></li>
                                        <li data-original-index="1"><a tabindex="0" class="" style=""
                                                                       data-tokens="null"><span class="text">Только сотрудникам организации</span><span
                                                    class="glyphicon glyphicon-ok check-mark"></span></a></li>
                                        <li data-original-index="2"><a tabindex="0" class="" style=""
                                                                       data-tokens="null"><span
                                                    class="text">Только мне</span><span
                                                    class="glyphicon glyphicon-ok check-mark"></span></a></li>
                                    </ul>
                                </div>
                            </div>
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
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Закрыть окно
                </button>
            </div>
        </div>
    </div>
</div>
