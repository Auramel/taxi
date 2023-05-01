@extends('layouts.main')

@section('title') Создание таксопарка @endsection

@section('content')
<form
    action="{{ route('taxoparks.create_') }}"
    method="post"
>
    <div class="mb-2">
        <label
            class="form-label"
            for="name"
        >
            Название
        </label>

        <input
            id="name"
            class="form-control"
            name="name"
            placeholder="Таксопарк на проспекте"
            required
        >
    </div>

    <div class="mb-2">
        <label
            class="form-label"
            for="park_id"
        >
            ID парка
        </label>

        <input
            id="park_id"
            class="form-control"
            name="park_id"
            placeholder="3beb11d702c84c82a185c37c32d0b1a9"
            required
        >
    </div>

    <div class="mb-2">
        <label
            class="form-label"
            for="client_id"
        >
            ID клиента
        </label>

        <input
            id="client_id"
            class="form-control"
            name="client_id"
            placeholder="taxi/park/3beb11d702c84c82a185c37c32d0b1a9"
            required
        >
    </div>

    <div class="mb-2">
        <label
            class="form-label"
            for="api_key"
        >
            API ключ
        </label>

        <input
            id="api_key"
            class="form-control"
            name="api_key"
            placeholder="hGibGbXJIliVfzJBliqGLkcbMKmrN2Eo"
            required
        >
    </div>

    @csrf

    <button class="btn btn-success d-block w-100">
        Создать
    </button>
</form>
@endsection
