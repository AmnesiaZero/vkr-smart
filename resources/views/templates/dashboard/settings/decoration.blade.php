@extends('layouts.dashboard.main')

@section('content')
<div class="col-xl-9 col-lg-8 col-md-7">
    <div class="container-filter">
        <div class="container">
            <div id="organzation-alerts">
            </div>
            <form class="form form-horizontal" enctype="multipart/form-data" action="personalize.html" method="post">
                <input type="hidden" value="save" name="action">
                <div class="form-group">
                    <label class="control-label col-sm-3 col-md-3">Изменение логотипа системы:</label>
                    <div class="col-sm-9 col-md-9">
                        <p>Для изменения текущего логотипа, выберите изображение логотипа организации:</p>
                        <input type="file" name="logotype_path">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3 col-md-3">Тип справки о найденных заимствованиях:</label>
                    <div class="col-sm-9 col-md-9">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>
                                    <input type="radio" value="0" name="reference_type" checked=""> Включена таблица заимствований <br>
                                    <img src="/assets/templates/bs3/img/long.png" alt="">
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <label>
                                    <input type="radio" value="1" name="reference_type"> Исключена таблица заимствований <br>
                                    <img src="/assets/templates/bs3/img/short.png" alt="">
                                </label>
                            </div>
                        </div>
                    </div>
                </div><hr>
                <div class="form-group">
                    <label class="control-label col-sm-3 col-md-3">Изменение размера шрифта текста процента оригинальности в справке о найденных заимствованиях:</label>
                    <div class="col-sm-9 col-md-9">
                        <select class="form-control" name="percent_size">
                            <option value="12">12px</option><option value="13">13px</option><option value="14">14px</option><option value="15">15px</option><option value="16">16px</option><option value="17">17px</option><option value="18">18px</option><option value="19">19px</option><option value="20">20px</option><option value="21">21px</option><option value="22">22px</option><option value="23">23px</option><option value="24">24px</option><option value="25">25px</option><option value="26">26px</option><option value="27">27px</option><option value="28" selected="">28px</option><option value="29">29px</option><option value="30">30px</option><option value="31">31px</option><option value="32">32px</option>					</select>
                    </div>
                </div><hr>
                <div class="form-group">
                    <label class="control-label col-sm-3 col-md-3">Скрыть дату загрузки документа из справки?</label>
                    <div class="col-sm-9 col-md-9">
                        <select class="form-control" name="createdon_exclude">
                            <option value="1" selected="">Да</option>
                            <option value="0">Нет, отображать дату загрузки</option>
                        </select>
                    </div>
                </div><hr>
                <div class="form-group">
                    <label class="control-label col-sm-3 col-md-3">Скрыть дату защиты из справки?</label>
                    <div class="col-sm-9 col-md-9">
                        <select class="form-control" name="protectdate_exclude">
                            <option value="1" selected="">Да</option>
                            <option value="0">Нет, отображать дату защиты</option>
                        </select>
                    </div>
                </div><hr>
                <div class="form-group">
                    <label class="control-label col-sm-3 col-md-3">Скрыть портфолио от проверяющих?</label>
                    <div class="col-sm-9 col-md-9">
                        <select class="form-control" name="checking_portfolio_hide">
                            <option value="1" selected="">Да</option>
                            <option value="0">Нет, отображать портфолио</option>
                        </select>
                    </div>
                </div><hr>
                <div class="form-group">
                    <label class="control-label col-sm-3 col-md-3">Действия:</label>
                    <div class="col-sm-9 col-md-9">
                        <button type="submit" class="btn btn-success btn-lg">Сохранить изменения</button>
                    </div>
                </div>
            </form>
            <form class="form form-horizontal" action="personalize.html" method="post">
                <input type="hidden" value="remove" name="action">
                <div class="form-group">
                    <label class="control-label col-sm-3 col-md-3"></label>
                    <div class="col-sm-9 col-md-9">
                        <button type="submit" class="btn btn-danger btn-lg">Вернуть первоначальные настройки</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
