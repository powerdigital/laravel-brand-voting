<?php

namespace App\Services\SmsService\Providers;

use App\Services\SmsService\SmsProviderInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Throwable;

class SmsRuProvider implements SmsProviderInterface
{
    private const VALID_STATUS_CODES = [100, 101, 102, 103, 110];

    public function send(string $phone, string $message): bool
    {
        try {
            $apiKey = env('SMS_RU_KEY_ID', 'key_required');
            $url = "https://sms.ru/sms/send?api_id=$apiKey&to=$phone&msg=$message&json=1";
            $url .= 'local' === App::environment() ? '&test=1' : '';

            $body = file_get_contents($url);
            $response = json_decode($body, true);

            Log::info(sprintf('An SMS sent to %s, response body: %s', $url, $body));

            if (!isset($response['sms'])) {
                return false;
            }

            return in_array((int)$response['sms'][$phone]['status_code'], self::VALID_STATUS_CODES);
        } catch (Throwable $e) {
            Log::error(sprintf('SMS sending error: %s', $e->getMessage()));

            return false;
        }
    }
}
