<?php

namespace App\Services\SmsService;

interface SmsProviderInterface
{
    /**
     * @param string $phone
     * @param string $message
     * @return boolean
     */
    public function send(string $phone, string $message): bool;
}
