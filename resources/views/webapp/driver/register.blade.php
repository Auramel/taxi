@extends('layouts.webapp')

@section('title') Регистрация водителя @endsection

@section('content')
    <form
        action="{{ route('webapp.driver.register_') }}"
        method="post"
    >
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">
                    Контактная информация
                </h2>

                <div class="mb-4">
                    <label class="form-label">
                        Email
                    </label>

                    <input
                        name="email"
                        class="form-control"
                        type="email"
                        placeholder="email@mail.ru"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Адрес
                    </label>

                    <input
                        class="form-control"
                        name="address"
                        type="text"
                        placeholder="г. Уфа, Ленина 1"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Телефон
                    </label>

                    <input
                        id="phone"
                        class="form-control"
                        name="phone"
                        placeholder="+79871234567"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">
                    Водительское удостоверение
                </h2>

                <div class="mb-4">
                    <label class="form-label">
                        Страна выдача ВУ
                    </label>

                    <input
                        name="country"
                        class="form-control"
                        type="text"
                        placeholder="RUS"
                        required
                    >

                    <div class="form-text">
                        Трехбуквенный код
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Дата окончания действия ВУ
                    </label>

                    <input
                        class="form-control"
                        name="expiry_date"
                        type="date"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Дата выдачи ВУ
                    </label>

                    <input
                        class="form-control"
                        name="issue_date"
                        type="date"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Серия и номер ВУ
                    </label>

                    <input
                        id="number"
                        class="form-control"
                        name="number"
                        placeholder="070236"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Водительский стаж c
                    </label>

                    <input
                        class="form-control"
                        name="total_since_date"
                        type="date"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Имя
                    </label>

                    <input
                        class="form-control"
                        name="first_name"
                        placeholder="Вадим"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Фамилия
                    </label>

                    <input
                        class="form-control"
                        name="last_name"
                        placeholder="Иванов"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Отчество
                    </label>

                    <input
                        class="form-control"
                        name="middle_name"
                        placeholder="Артемович"
                        required
                    >
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
    document.getElementById('user').value = user.id;
@endpush
