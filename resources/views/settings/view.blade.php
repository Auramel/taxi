@extends('layouts.main')

@section('title')
    Настройки
@endsection

@section('content')
    <form
        method="post"
        action="{{ route('settings.view_') }}"
    >
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title">
                    Отправлять письма
                </h2>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">
                        Отправлять на почту
                    </label>

                    <input
                        name="{{ \App\Models\Setting::MAIL_TO }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::mailTo() }}"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title">
                    Парсер почты
                </h2>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">
                        Host
                    </label>

                    <input
                        name="{{ \App\Models\Setting::HOST_PARSE }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::hostParse() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Port
                    </label>

                    <input
                        name="{{ \App\Models\Setting::PORT_PARSE }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::portParse() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Username
                    </label>

                    <input
                        name="{{ \App\Models\Setting::USERNAME_PARSE }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::usernameParse() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Password
                    </label>

                    <input
                        name="{{ \App\Models\Setting::PASSWORD_PARSE }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::passwordParse() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Protocol
                    </label>

                    <input
                        name="{{ \App\Models\Setting::PROTOCOL_PARSE }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::protocolParse() }}"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title">
                    Отправка почты
                </h2>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">
                        Host
                    </label>

                    <input
                        name="{{ \App\Models\Setting::HOST_SEND }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::hostSend() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Port
                    </label>

                    <input
                        name="{{ \App\Models\Setting::PORT_SEND }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::portSend() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Username
                    </label>

                    <input
                        name="{{ \App\Models\Setting::USERNAME_SEND }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::usernameSend() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Password
                    </label>

                    <input
                        name="{{ \App\Models\Setting::PASSWORD_SEND }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::passwordSend() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Protocol
                    </label>

                    <input
                        name="{{ \App\Models\Setting::PROTOCOL_SEND }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::protocolSend() }}"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title">
                    Экран авторизации
                </h2>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">
                        Текст приветствия
                    </label>

                    <input
                        name="{{ \App\Models\Setting::LOGIN_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::loginText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Кнопка "Зарегистироваться"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::REGISTER_BUTTON_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::registerButtonText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Кнопка "Войти по ВУ"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::LOGIN_BY_NUMBER_BUTTON_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::loginByNumberButtonText() }}"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title">
                    Меню
                </h2>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">
                        Текст приветствия
                    </label>

                    <input
                        name="{{ \App\Models\Setting::MENU_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::menuText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Кнопка "Добавить авто"
                    </label>

                    <input
                    name="{{ \App\Models\Setting::ADD_CAR_BUTTON_TEXT }}"
                    class="form-control"
                    value="{{ \App\Models\Setting::addCarButtonText() }}"
                    required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Кнопка "Выбрать авто"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::SELECT_CAR_BUTTON_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::selectCarButtonText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Кнопка "Выбрать НАЛ/БЕЗНАЛ"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::SELECT_PAYMENT_BUTTON_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::selectPaymentButtonText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Кнопка "Купить смену в долг"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::SHIFT_DEBT_PAYMENT_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::shiftDebtPaymentText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Значение кнопки "Купить смену в долг"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::SHIFT_DEBT_PAYMENT_VALUE }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::shiftDebtPaymentValue() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Кнопка "Обратно в меню"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::BACK_TO_MENU }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::backToMenu() }}"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title">
                    Запрос номера
                </h2>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">
                        Кнопка "Отправить мои данные"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::SEND_MY_CONTACT_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::sendMyContactText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Текст запроса номера
                    </label>

                    <input
                        name="{{ \App\Models\Setting::REQUEST_CONTACT_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::requestContactText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Текст ошибки "Телефон не совпал с номером из Яндекса"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::PHONE_NOT_EQUAL_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::phoneNotEqualText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Текст успешного сохранения номера
                    </label>

                    <input
                        name="{{ \App\Models\Setting::PHONE_SAVED_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::phoneSavedText() }}"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title">
                    Выбор таксопарка
                </h2>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">
                        Текст "Выберете таксопарк"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::SELECT_TAXOPARK_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::selectTaxoparkText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Текст "Таксопарк изменен"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::TAXOPARK_SAVED_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::taxoparkSavedText() }}"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title">
                    Операции с лимитом профиля
                </h2>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">
                        Кнопка "Наличными и картой"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::CARD_AND_CASH_PAYMENT_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::cardAndCashPaymentText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Значение кнопки "Наличными и картой"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::CARD_AND_CASH_PAYMENT_VALUE }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::cardAndCashPaymentValue() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Кнопка "Только безнал"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::CASH_PAYMENT_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::cashPaymentText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Значение кнопки "Только безнал"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::CASH_PAYMENT_VALUE }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::cashPaymentValue() }}"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title">
                    Экран "Вход по ВУ"
                </h2>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">
                        Текст для запроса данных ВУ
                    </label>

                    <input
                        name="{{ \App\Models\Setting::REQUEST_NUMBER_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::requestNumberText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Текст ошибки "Водитель не найден"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::DRIVER_NOT_FOUND_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::driverNotFoundText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Текст "Ваш профиль сохранен"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::DRIVER_SAVED_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::driverSavedText() }}"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title">
                    Экран "Выбрать авто"
                </h2>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">
                        Текст запроса VIN или госномера
                    </label>

                    <input
                        name="{{ \App\Models\Setting::REQUEST_VIN_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::requestVinText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Текст ошибки "Машина не найдена"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::CAR_NOT_FOUND_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::carNotFoundText() }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Текст "Авто выбрано"
                    </label>

                    <input
                        name="{{ \App\Models\Setting::CAR_SELECTED_TEXT }}"
                        class="form-control"
                        value="{{ \App\Models\Setting::carSelectedText() }}"
                        required
                    >
                </div>
            </div>
        </div>

        @csrf

        <button class="btn btn-success d-block w-100 mb-4">
            Сохранить
        </button>
    </form>
@endsection
