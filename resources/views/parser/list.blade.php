@extends('layouts.main')

@section('title') Парсер почты @endsection

@section('content')
<div
    id="messages"
    class="accordion"
>
    @foreach ($messages as $message)
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#message-{{ $loop->index }}"
            >
                <div class="me-2">
                    @if (!$message->getFlags()->isEmpty())
                    <span class="d-block badge bg-success">
                        Прочитано
                    </span>
                    @else
                    <span class="d-block badge bg-danger">
                        Не прочитано
                    </span>
                    @endif
                </div>

                {{ $message->getSubject() }}
            </button>
        </h2>

        <div
            id="message-{{ $loop->index }}"
            class="accordion-collapse collapse"
            data-bs-parent="#messages"
        >
            <div class="accordion-body">
                {!! $message->getHTMLBody() !!}
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
