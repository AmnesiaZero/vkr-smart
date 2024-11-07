@extends('layouts.site.main')
@section('content')
    <main>
        <div class="container py-5 mb-5">
            <div class="row">
                <div class="col-lg-12 px-lg-0 px-4">
                    <h3>Введите код проверки</h3>
                    <div class="row">
                        <div class="col-sm-3">
                            <form class="form" id="check_form" onsubmit="openReport(); return false;">
                                <div class="form-group">
                                    <input id="check_code" type="text" class="form-control" name="check_code"
                                           style="font-size:18px;height:50px;" placeholder="Введите проверочный код"
                                           required="">
                                </div>
                                <div class="form-group mt-3">
                                    <button class="btn  btn-lg btn-block btn-primary px-5" type="submit">Проверить</button>
                                </div>

                            </form>
                        </div>
                        <div class="col-sm-9">
                            <div id="alerts"></div>
                        </div>
                        <div>
                        </div>
                    </div>
                    <div id="report_container"></div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="/js/site/check_reference.js"></script>

    @include('layouts.dashboard.include.tmpls.works.report')

@endsection
