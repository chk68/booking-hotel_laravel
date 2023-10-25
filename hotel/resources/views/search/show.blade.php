
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Результаты поиска отелей</h1>

        @if ($availableHotels->isEmpty())
            <p>Нет доступных отелей для выбранных дат.</p>
        @else
            <ul class="hotel-list">
                @foreach($availableHotels as $hotel)
                    <li class="hotel-item">
                        <div class="hotel-image">
                            <img src="{{ asset('storage/' . $hotel->image_path) }}" alt="Изображение отеля">
                        </div>
                        <div class="hotel-details">
                            <h2><a href="{{ route('rooms.show', ['hotel' => $hotel->id]) }}">{{ $hotel->name }}</a></h2>
                            @if (strlen($hotel->description) > 300)
                                {{ substr($hotel->description, 0, 300) . '...' }}
                            @else
                                {{ $hotel->description }}
                            @endif
                        </div>
                        <div class="hotel-booking">
                            <p>
                                Минимальная цена: {{ $hotel->rooms->min('price') }} -
                                Максимальная цена: {{ $hotel->rooms->max('price') }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    @push('styles')
        <link href="{{ asset('styles/styles.css') }}" rel="stylesheet">
        <link href="{{ asset('styles/search.css') }}" rel="stylesheet">
    @endpush

@endsection

