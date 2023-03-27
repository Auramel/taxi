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

$file = file_get_contents(storage_path('cars.json'));
$cars = json_decode($file);
$brands = [];
$models = [];
$modelsWithoutBrand = [];

foreach ($cars as $key => $car) {
    if (empty($car->models)) {
        continue;
    }

    foreach ($car->models as $name) {
        $models[] = $key . ' ' . $name;
        $modelsWithoutBrand[] = $name;
    }

    $brands[] = $key;
}

@endphp

<form
    action="{{ route('webapp.car.register_') }}"
    method="post"
    class="my-4"
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

                <select
                    class="form-control"
                    name="brand"
                    required
                >
                    @foreach ($brands as $brand)
                    <option value="{{ $brand }}">
                        {{ $brand }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">
                    Цвет ТС
                </label>

                <select
                    name="color"
                    class="form-control"
                    required
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

                <select
                    class="form-control"
                    name="model"
                    required
                >
                    @foreach ($models as $model)
                    <option value="{{ $modelsWithoutBrand[$loop->index] }}">
                        {{ $model }}
                    </option>
                    @endforeach
                </select>
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
                    Год выпуска
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
