<?php

namespace App\Services\SmsService\Providers;

use App\Services\SmsService\SmsProviderInterface;
use Illuminate\Support\Facades\Log;
use Throwable;

class SmsCenterProvider implements SmsProviderInterface
{
    public function send(string $phone, string $message): bool
    {
        try {
            $login = env('SMS_CENTER_LOGIN');
            $password = env('SMS_CENTER_PASSWORD');

            $url = "https://smsc.ru/sys/send.php?login=$login&psw=$password&phones=+$phone&mes=$message";

            $body = file_get_contents($url);

            Log::info(sprintf('An SMS sent to %s, response body: %s', $url, $body));

            return false !== strpos($body, 'OK');
        } catch (Throwable $e) {
            Log::error(sprintf('SMS sending error: %s', $e->getMessage()));

            return false;
        }
    }
}
