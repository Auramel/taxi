@extends('layouts.main')

@section('title') Пользователи @endsection

@section('content')
<div class="mb-4">
    <form class="row">
        <div class="col-10">
            <input
                name="search"
                class="form-control"
                type="text"
                placeholder="Введите имя, фамилию, телефон или username"
            >
        </div>

        <div class="col-2">
            <button class="btn btn-primary d-block w-100">
                Поиск
            </button>
        </div>
    </form>
</div>

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
                Забанен
            </th>

            <th>
                Присоединился
            </th>

            <th style="width:200px"></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>
                {{ $loop->iteration + $users->firstItem() - 1 }}
            </td>

            <td>
                {{ $user->first_name ?? '-' }}
            </td>

            <td>
                {{ $user->last_name ?? '-' }}
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

            <td>
                {{ $user->banned_at ?? 'Нет' }}
            </td>

            <td>
                {{ $user->created_at ?? '-' }}
            </td>

            <td>
                <a
                    href="{{ route('users.view', ['id' => $user->id]) }}"
                    class="btn btn-primary d-block w-100"
                >
                    Подробнее
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}
@endsection
