<?php

namespace App\Helpers;

abstract class NavigationItems
{
    public static function getItems(): array
    {
        return [
            'Пользователи' => route('users.list'),
            'Реферальная программа' => route('referrals.list'),
        ];
    }
}
