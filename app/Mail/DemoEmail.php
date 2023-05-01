<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemoEmail extends Mailable
{
    use Queueable, SerializesModels;

    private string $phone;
    private string $fio;
    private string $message;

    public function __construct(
        string $phone,
        string $fio,
        string $message,
    )
    {
        $this->phone = $phone;
        $this->fio = $fio;
        $this->message = $message;
    }

    public function build(): DemoEmail
    {
        return $this->from('taxoparka@yandex.ru')
            ->subject($this->message)
            ->view('mails.demo', [
                'phone' => $this->phone,
                'fio' => $this->fio,
                'title' => $this->message,
            ]);
    }
}
