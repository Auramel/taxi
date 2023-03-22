@extends('layouts.webapp')

@section('title') Регистрация автомобиля @endsection

@section('content')
    @php

    $colors = [
        'Белый',
        'Желтый',
        'Бежевый',
        'Черный',
        'Голубой',
        'Серый',
        'Красный',
        'Оранжевый',
        'Синий',
        'Зеленый',
        'Коричневый',
        'Фиолетовый',
        'Розовый',
    ];

    @endphp

    <form
        action="{{ route('webapp.car.register_') }}"
        method="post"
    >
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">
                    Документы на ТС
                </h2>

                <div class="mb-4">
                    <label class="form-label">
                        Государственный регистрационный номер
                    </label>

                    <input
                        name="licence_plate_number"
                        class="form-control"
                        placeholder="1234567890"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Номер свидетельства о регистрации ТС
                    </label>

                    <input
                        name="registration_certificate"
                        class="form-control"
                        placeholder="1234567890"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="card-title">
                    Информация о ТС
                </h2>

                <div class="mb-4">
                    <label class="form-label">
                        Марка ТС
                    </label>

                    <input
                        class="form-control"
                        name="brand"
                        placeholder="Mercedes-Benz"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Цвет ТС
                    </label>

                    <select
                        name="color"
                        class="form-control"
                    >
                        @foreach ($colors as $color)
                        <option value="{{ $color }}">
                            {{ $color }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Модель ТС
                    </label>

                    <input
                        class="form-control"
                        name="model"
                        placeholder="E-klasse"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        VIN
                    </label>

                    <input
                        class="form-control"
                        name="vin"
                        placeholder="WBA..."
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Модель ТС
                    </label>

                    <select
                        name="year"
                        class="form-control"
                    >
                        @for ($i = 2008; $i <= (int) \Carbon\Carbon::now()->year; $i++)
                        <option value="{{ $i }}">
                            {{ $i }}
                        </option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        @csrf

        <input id="user" name="user" type="hidden">

        <button class="mt-4 btn btn-success d-block w-100">
            Сохранить
        </button>
    </form>
@endsection

@push('scripts')
    document.getElementById('user').value = tgUser.id;
@endpush
