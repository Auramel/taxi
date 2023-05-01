@extends('layouts.auth')

@section('title') Авторизация @endsection

@section('content')
    <div
        class="m-auto"
        style="max-width: 330px"
    >
        <form
            action="{{ route('auth.login_') }}"
            method="POST"
        >

            <div class="mb-4">
                <input
                    type="password"
                    class="form-control"
                    name="password"
                    placeholder="Пароль"
                    required
                >
            </div>

            @csrf

            <button class="btn btn-success d-block w-100">
                Войти
            </button>
        </form>
    </div>
@endsection
