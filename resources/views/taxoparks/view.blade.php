@extends('layouts.main')

@section('title') Просмотр таксопарка - {{ $taxopark->name }} @endsection

@section('content')
<div class="mb-4">
    <a
        class="btn btn-danger"
        href="{{ route('taxoparks.delete', ['id' => $taxopark->id]) }}"
    >
        Удалить
    </a>
</div>

<table class="table table-striped align-middle mb-4">
    <tbody>
        <tr>
            <td>
                <b>
                    Название
                </b>
            </td>

            <td>
                {{ $taxopark->name }}
            </td>
        </tr>

        <tr>
            <td>
                <b>
                    ID парка
                </b>
            </td>

            <td>
                {{ $taxopark->park_id }}
            </td>
        </tr>

        <tr>
            <td>
                <b>
                    ID клиента
                </b>
            </td>

            <td>
                {{ $taxopark->client_id }}
            </td>
        </tr>

        <tr>
            <td>
                <b>
                    API ключ
                </b>
            </td>

            <td>
                {{ $taxopark->api_key }}
            </td>
        </tr>

        <tr>
            <td>
                <b>
                    Пользователей
                </b>
            </td>

            <td>
                {{ $taxopark->tgUsers->count() }}
            </td>
        </tr>
    </tbody>
</table>
@endsection
