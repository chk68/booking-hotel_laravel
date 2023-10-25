@extends('layouts.app')
@push('styles')
    <link href="{{ asset('styles/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('styles/rooms.css') }}" rel="stylesheet">
    <link href="{{ asset('styles/profile.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="container">
        <div class="user-profile">
            <div class="user-info">
                <h1>Профиль пользователя</h1>
                <p>Имя: {{ $user->name }}</p>
                <p>Фамилия: {{ $user->last_name }}</p>
                <p>Номер телефона: {{ $user->phone_number }}</p>
            </div>
            <div class="user-details">
                <h2>Детали пользователя</h2>
                <p>Айди пользователя: {{ $user->id }}</p>
                <p>Дата регистрации: {{ $user->created_at }}</p>
                <p>Почта: {{ $user->email }}</p>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Выйти</button>
        </form>
    </div>
@endsection
