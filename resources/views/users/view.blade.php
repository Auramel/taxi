@extends('layouts.main')

@section('title') Просмотр пользователя - {{ $user->first_name }} @endsection

@section('content')
<h2>
    Telegram
</h2>

<div class="mb-4">
    @if (!is_null($user->banned_at))
    <a
        class="btn btn-success"
        href="{{ route('users.unban', ['id' => $user->id]) }}"
    >
        Разбанить
    </a>
    @else
    <a
        class="btn btn-danger"
        href="{{ route('users.ban', ['id' => $user->id]) }}"
    >
        Забанить
    </a>
    @endif
</div>

<table class="table table-striped align-middle mb-4">
    <tbody>
        <tr>
            <td>
                <b>
                    Имя
                </b>
            </td>

            <td>
                {{ $user->first_name ?? '-' }}
            </td>
        </tr>

        <tr>
            <td>
                <b>
                    Фамилия
                </b>
            </td>

            <td>
                {{ $user->last_name ?? '-' }}
            </td>
        </tr>

        <tr>
            <td>
                <b>
                    Username
                </b>
            </td>

            <td>
                @if (!empty($user->username))
                <a
                        href="https://t.me/{{ $user->username }}"
                        target="_blank"
                >
                    {{ '@' . $user->username }}
                </a>
                @else
                -
                @endif
            </td>
        </tr>

        <tr>
            <td>
                <b>
                    Забанен
                </b>
            </td>

            <td>
                {{ $user->banned_at ?? 'Нет' }}
            </td>
        </tr>

        <tr>
            <td>
                <b>
                    ID в яндексе
                </b>
            </td>

            <td>
                {{ $user->driver_id ?? '-' }}
            </td>
        </tr>

        <tr>
            <td>
                <b>
                    Присоединился
                </b>
            </td>

            <td>
                {{ $user->created_at }}
            </td>
        </tr>
    </tbody>
</table>

<h2>
    Рефераллы
</h2>

@if ($referrals->isEmpty())
Ничего не найдено
@else
<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>
                #
            </th>

            <th>
                Имя
            </th>

            <th>
                Фамилия
            </th>

            <th>
                Username
            </th>

            <th>
                Уровень
            </th>

            <th>
                Забанен
            </th>

            <th>
                Дата присоединения
            </th>

            <th style="width:200px"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($referrals as $referral)
        <tr>
            <td>
                {{ $loop->iteration + $referrals->firstItem() - 1 }}
            </td>

            <td>
                {{ $referral->income->first_name ?? '-' }}
            </td>

            <td>
                {{ $referral->income->last_name ?? '-' }}
            </td>

            <td>
                @if (!empty($referral->income->username))
                <a
                    href="https://t.me/{{ $referral->income->username }}"
                    target="_blank"
                >
                    {{ '@' . $referral->income->username }}
                </a>
                @else
                -
                @endif
            </td>

            <td>
                {{ $referral->level }}
            </td>

            <td>
                {{ $referral->income->banned_at ?? 'Нет' }}
            </td>

            <td>
                {{ $referral->created_at }}
            </td>

            <td>
                <a
                    href="{{ route('users.view', ['id' => $referral->income_tg_user_id]) }}"
                    class="btn btn-primary d-block w-100"
                >
                    Подробнее
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $referrals->links() }}
@endif
@endsection
