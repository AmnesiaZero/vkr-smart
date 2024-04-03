@extends('layouts.main')

@section('content')
<main>
    <div class="container py-5 fs-m">
        <div class="row justify-content-center pb-3">
            <div class="col-lg-5">
                <div class="bg-grey br-40 p-5">
                    <div class="text-before-form">
                        <h2 class="">Восстановление пароля</h2>
                        <p class="mb-5 text-grey fs-14 lh-17"> Для восстановления утерянного пароля введите адрес электронной почты, который Вы указали при регистрации аккаунта</p>
                    </div>
                    <form class="auth mb-5" action="" method="POST">
                        <div class="form-group">
                            <label for="email">Введите свой адрес электронной почты</label>
                            <input id="email" type="text" name="email" placeholder="" class="form-control">
                        </div>
                    </form>
                    <button type="button" class="btn br-100 btn-primary w-100">восстановить пароль</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
