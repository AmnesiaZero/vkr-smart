@extends('layouts.dashboard.platform')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                @if(isset($users))
                    <h4>Статистика авторизаций администраторов и разработчиков платформы</h4>
                    <table class="table">
                        <thead>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>User Login</th>
                        <th>Date</th>
                        </thead>
                        <tbody>
                        @foreach($users as $userElement)
                            <tr>
                                <th>{{ $userElement->id }}</th>
                                <th>
                                    <p class="m-0 fw-bold">{{ $userElement->name }}</p>
                                    <p class="m-0 fw-normal text-muted">{{ $userElement->roles[0]->name }}</p>
                                    <p class="m-0 fw-normal text-muted">{{ $userElement->organization->name }}</p>
                                </th>
                                <th>{{ $userElement->login }}</th>
                                <th style="white-space: nowrap">{{ $userElement->created_at }}</th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
