<?php

namespace App\Responses;

class DniConsultationResponse
{
    public bool $success;
    public array $data;
    public ?string $message;
    public ?int $status;

    public function __construct(bool $success, array $data = [], ?string $message = null, ?int $status = null)
    {
        $this->success = $success;
        $this->data = $data;
        $this->message = $message;
        $this->status = $status;
    }
}
