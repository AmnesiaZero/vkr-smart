<div id="add_file_modal" class="modal fade" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Добавление файла</h3>
            </div>
            <form id="add_file_form" class="form-inline">
                <div class="modal-body">
                    <input type="hidden" name="record_type_id" value="1">

                    <div class="d-flex flex-column gap-3">
                        <div class="row">
                            <label class="col-sm-4">Введите наименование</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control fullwidth" required=""
                                       placeholder="Ввод...">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-4">Выберите тип деятельности:</label>
                            <div class="col-sm-8">
                                <select name="achievement_mode_id" class="selectpicker bs-select-hidden w-100">
                                    @if(isset($modes) and is_iterable($modes))
                                        @foreach($modes as $mode)
                                            <option value="{{$mode->id}}">{{$mode->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Выберите тип документа:</label>
                            <div class="col-sm-8">
                                <select name="achievement_type_id" class="selectpicker bs-select-hidden w-100">
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
                        <div class="row">
                            <label class="col-sm-4">Загрузите файл</label>
                            <div class="col-sm-8">
                                <input type="file" name="achievement_file" class="form-control fullwidth"
                                       id="file_input" required="">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Кому доступен ресурс:</label>
                            <div class="col-sm-8">
                                <select class="selectpicker bs-select-hidden w-100" name="access_id">
                                    <option value="1">Всем</option>
                                    <option value="2">Только сотрудникам организации</option>
                                    <option value="3">Только мне</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary fs-14 text-grey py-1" onclick="closeModal('add_file_modal')">
                        Добавить
                    </button>
                    <button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1" data-bs-dismiss="modal"
                            aria-label="Close" onclick="closeModal('add_file_modal')">
                        Закрыть
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
