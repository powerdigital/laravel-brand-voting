<?php

namespace App\Services\SmsService\Providers;

use App\Services\SmsService\SmsProviderInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class EpochtaProvider implements SmsProviderInterface
{
    private const API_URL = 'http://api.atompark.com/members/sms/xml.php';

    public function send(string $phone, string $message): bool
    {
        try {
            $username = env('EPOCHTA_USERNAME');
            $password = env('EPOCHTA_PASSWORD');

            $src = "<?xml version='1.0' encoding='UTF-8'?>
                <SMS>
                    <operations>
                        <operation>SEND</operation>
                    </operations>
                    <authentification>
                        <username>$username</username>
                        <password>$password</password>
                    </authentification>
                    <message>
                        <sender>hrbrand</sender>
                        <text>$message</text>
                    </message>
                    <numbers>
                        <number>$phone</number>
                    </numbers>
                </SMS>";

            $curl = curl_init();
            $options = array(
                CURLOPT_URL => self::API_URL,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_POST => true,
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 15,
                CURLOPT_TIMEOUT => 100,
                CURLOPT_POSTFIELDS => array('XML' => $src),
            );

            curl_setopt_array($curl, $options);

            $body = curl_exec($curl);
            Log::info(sprintf('An SMS sent to %s', $src));
            Log::info(sprintf('Epochta response body: %s', $body));

            if (false === $body) {
                throw new Exception('Http request failed');
            }

            curl_close($curl);

            return true;
        } catch (Exception $e) {
            Log::error(sprintf('SMS sending error: %s', $e->getMessage()));

            return false;
        }
    }
}
