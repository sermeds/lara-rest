<?php

namespace App\Exceptions;

use Exception;

class ReservationConflictException extends Exception
{
    protected $data;

    public function __construct(string $message, array $data = [])
    {
        parent::__construct($message);
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}

