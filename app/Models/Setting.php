<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSettings
 */
class Setting extends Model
{
    public const CARD_AND_CASH_PAYMENT_TEXT = 'card_and_cash_payment_text';

    public const CARD_AND_CASH_PAYMENT_VALUE = 'card_and_cash_payment_value';

    public const CASH_PAYMENT_TEXT = 'cash_payment_text';

    public const CASH_PAYMENT_VALUE = 'cash_payment_text';

    public const SHIFT_DEBT_PAYMENT_TEXT = 'shift_debt_payment_text';

    public const SHIFT_DEBT_PAYMENT_VALUE = 'shift_debt_payment_text';

    public const BACK_TO_MENU = 'back_to_menu';

    public const REQUEST_NUMBER_TEXT = 'request_number_text';

    public const DRIVER_NOT_FOUND_TEXT = 'driver_not_found_text';

    public const DRIVER_SAVED_TEXT = 'driver_saved_text';

    public const REQUEST_VIN_TEXT = 'request_vin_text';

    public const CAR_NOT_FOUND_TEXT = 'car_not_found_text';

    public const CAR_SELECTED_TEXT = 'car_selected_text';

    public const MENU_TEXT = 'menu_text';

    public const LOGIN_TEXT = 'login_text';

    public const REGISTER_BUTTON_TEXT = 'register_button_text';

    public const LOGIN_BY_NUMBER_BUTTON_TEXT = 'login_by_number_button_text';

    public const ADD_CAR_BUTTON_TEXT = 'add_car_button_text';

    public const SELECT_CAR_BUTTON_TEXT = 'select_car_button_text';

    public const SELECT_PAYMENT_BUTTON_TEXT = 'select_payment_button_text';

    public const SEND_MY_CONTACT_TEXT = 'send_my_contact_text';

    public const REQUEST_CONTACT_TEXT = 'request_contact_text';

    public const PHONE_NOT_EQUAL_TEXT = 'phone_not_equal_text';

    public const PHONE_SAVED_TEXT = 'phone_saved_text';

    public const SELECT_TAXOPARK_TEXT = 'select_taxopark_text';

    public const TAXOPARK_SAVED_TEXT = 'taxopark_saved_text';

    protected $table = 'settings';

    public static function cardAndCashPaymentText(): string
    {
        return self::whereName(self::CARD_AND_CASH_PAYMENT_TEXT)
            ->first()->value
            ?? 'Наличными и картой';
    }

    public static function cardAndCashPaymentValue(): string
    {
        return self::whereName(self::CARD_AND_CASH_PAYMENT_VALUE)
            ->first()->value
            ?? '10';
    }

    public static function cashPaymentText(): string
    {
        return self::whereName(self::CASH_PAYMENT_TEXT)
            ->first()->value
            ?? 'Только безнал';
    }

    public static function cashPaymentValue(): string
    {
        return self::whereName(self::CASH_PAYMENT_VALUE)
            ->first()->value
            ?? '150000';
    }

    public static function shiftDebtPaymentText(): string
    {
        return self::whereName(self::SHIFT_DEBT_PAYMENT_TEXT)
            ->first()->value
            ?? 'Купить смену в долг';
    }

    public static function shiftDebtPaymentValue(): string
    {
        return self::whereName(self::SHIFT_DEBT_PAYMENT_VALUE)
            ->first()->value
            ?? '-950';
    }

    public static function backToMenu(): string
    {
        return self::whereName(self::BACK_TO_MENU)
            ->first()->value
            ?? '🔙 Обратно в меню';
    }

    public static function requestNumberText(): string
    {
        return self::whereName(self::REQUEST_NUMBER_TEXT)
            ->first()->value
            ?? 'Введите ваше ВУ в формате: 1212123456';
    }

    public static function driverNotFoundText(): string
    {
        return self::whereName(self::DRIVER_NOT_FOUND_TEXT)
            ->first()->value
            ?? 'Профль не найден. Попробуйте снова';
    }

    public static function driverSavedText(): string
    {
        return self::whereName(self::DRIVER_SAVED_TEXT)
            ->first()->value
            ?? 'Ваш профиль сохранен';
    }

    public static function requestVinText(): string
    {
        return self::whereName(self::REQUEST_VIN_TEXT)
            ->first()->value
            ?? 'Введите VIN код или госномер полностью (пример А101АА102)';
    }

    public static function carNotFoundText(): string
    {
        return self::whereName(self::CAR_NOT_FOUND_TEXT)
            ->first()->value
            ?? 'Авто не найдено. В диспетчерской с такими данными есть уже несколько автомобилей, поэтому выйдите в меню и нажмите сменить авто, заполните все данные и автомобиль поменяется';
    }

    public static function carSelectedText(): string
    {
        return self::whereName(self::CAR_SELECTED_TEXT)
            ->first()->value
            ?? 'Авто выбрано';
    }

    public static function loginText(): string
    {
        return self::whereName(self::LOGIN_TEXT)
            ->first()->value
            ?? 'Для работы с ботом зарегистрируйтесь в парке. Если Вы уже зарегистрированы в парке, то выполните вход по ВУ. После регистрации необходимо выполнить вход по ВУ';
    }

    public static function registerButtonText(): string
    {
        return self::whereName(self::REGISTER_BUTTON_TEXT)
            ->first()->value
            ?? 'Зарегистрироваться';
    }

    public static function loginByNumberButtonText(): string
    {
        return self::whereName(self::LOGIN_BY_NUMBER_BUTTON_TEXT)
            ->first()->value
            ?? 'Войти по ВУ';
    }

    public static function menuText(): string
    {
        return self::whereName(self::MENU_TEXT)
            ->first()->value
            ?? 'Для навигации используй кнопки ниже';
    }

    public static function addCarButtonText(): string
    {
        return self::whereName(self::ADD_CAR_BUTTON_TEXT)
            ->first()->value
            ?? 'Добавить авто';
    }

    public static function selectCarButtonText(): string
    {
        return self::whereName(self::SELECT_CAR_BUTTON_TEXT)
            ->first()->value
            ?? 'Выбрать авто';
    }

    public static function selectPaymentButtonText(): string
    {
        return self::whereName(self::SELECT_PAYMENT_BUTTON_TEXT)
            ->first()->value
            ?? 'Выбрать НАЛ/БЕЗНАЛ';
    }

    public static function sendMyContactText(): string
    {
        return self::whereName(self::SEND_MY_CONTACT_TEXT)
            ->first()->value
            ?? 'Отправить мои данные';
    }

    public static function requestContactText(): string
    {
        return self::whereName(self::REQUEST_CONTACT_TEXT)
            ->first()->value
            ?? 'Пришлите ваш контакт для подтверждения вашей личности';
    }

    public static function phoneNotEqualText(): string
    {
        return self::whereName(self::PHONE_NOT_EQUAL_TEXT)
            ->first()->value
            ?? 'Ваш номер не совпадает с номером указанным в Яндексе. Свяжитесь с менеджером для обновления информации и повторите снова.';
    }

    public static function phoneSavedText(): string
    {
        return self::whereName(self::PHONE_SAVED_TEXT)
            ->first()->value
            ?? 'Данные успешно подтверждены.';
    }

    public static function selectTaxoparkText(): string
    {
        return self::whereName(self::SELECT_TAXOPARK_TEXT)
            ->first()->value
            ?? 'Выберете таксопарк';
    }

    public static function taxoparkSavedText(): string
    {
        return self::whereName(self::TAXOPARK_SAVED_TEXT)
            ->first()->value
            ?? 'Таксопарк изменен.';
    }
}
