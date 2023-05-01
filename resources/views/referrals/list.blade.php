@extends('layouts.main')

@section('title') Реферальная программа @endsection

@section('content')
<div class="mb-4">
    <form class="row">
        <div class="col-10">
            <input
                name="search"
                class="form-control"
                type="text"
                placeholder="Введите имя, фамилию или username кого пригласили или кто пригласил"
            >
        </div>

        <div class="col-2">
            <button class="btn btn-primary d-block w-100">
                Поиск
            </button>
        </div>
    </form>
</div>

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
                Кто пригласил (имя)
            </th>

            <th>
                Кто пригласил (забанен)
            </th>

            <th style="width:200px"></th>

            <th>
                Кого пригласили (имя)
            </th>

            <th>
                Кого пригласили (забанен)
            </th>

            <th>
                Уровень
            </th>

            <th>
                Дата приглашения
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
                {{ $referral->from->first_name ?? '-' }}
            </td>

            <td>
                {{ $referral->from->banned_at ?? 'Нет' }}
            </td>

            <td>
                <a
                    href="{{ route('users.view', ['id' => $referral->from_tg_user_id]) }}"
                    class="btn btn-primary d-block w-100"
                >
                    Подробнее
                </a>
            </td>

            <td>
                {{ $referral->income->first_name ?? '-' }}
            </td>

            <td>
                {{ $referral->income->banned_at ?? 'Нет' }}
            </td>

            <td>
                {{ $referral->level }}
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
@endif

{{ $referrals->links() }}
@endsection
