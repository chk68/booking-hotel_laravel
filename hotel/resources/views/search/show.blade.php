@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Результаты поиска отелей</h1>

        @if ($availableHotels->isEmpty())
            <p>Нет доступных отелей для выбранных дат.</p>
        @else
            <ul>
                @foreach($availableHotels as $hotel)
                    <li>
                        <h2><a href="{{ route('rooms.show', ['hotel' => $hotel->id]) }}">{{ $hotel->name }}</a></h2>

                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
