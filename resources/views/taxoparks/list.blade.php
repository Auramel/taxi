@extends('layouts.main')

@section('title') Пользователи @endsection

@section('content')
<div class="mb-4">
    <a
        class="btn btn-success"
        href="{{ route('taxoparks.create') }}"
    >
        Добавить
    </a>
</div>

@if ($taxoparks->isEmpty())
    Ничего не найдено
@else
    <table class="table table-striped align-middle">
        <thead>
        <tr>
            <th>
                #
            </th>

            <th>
                Название
            </th>

            <th>
                API ключ
            </th>

            <th>
                Пользователей
            </th>

            <th style="width:200px"></th>
            <th style="width:200px"></th>
        </tr>
        </thead>

        <tbody>
        @foreach ($taxoparks as $taxopark)
            <tr>
                <td>
                    {{ $loop->iteration + $taxoparks->firstItem() - 1 }}
                </td>

                <td>
                    {{ $taxopark->name }}
                </td>

                <td>
                    {{ $taxopark->api_key }}
                </td>

                <td>
                    {{ $taxopark->tgUsers->count() }}
                </td>

                <td>
                    <a
                            href="{{ route('taxoparks.view', ['id' => $taxopark->id]) }}"
                            class="btn btn-primary d-block w-100"
                    >
                        Подробнее
                    </a>
                </td>

                <td>
                    <a
                            href="{{ route('taxoparks.delete', ['id' => $taxopark->id]) }}"
                            class="btn btn-danger d-block w-100"
                    >
                        Удалить
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

{{ $taxoparks->links() }}
@endsection
