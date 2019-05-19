<?php

namespace App\Services\SmsService;

use App\Services\SmsService\Providers\EpochtaProvider;
use App\Services\SmsService\Providers\SmsCenterProvider;
use App\Services\SmsService\Providers\SmsRuProvider;
use Exception;

/**
 * Class SmsProviderFactory
 * @package App\Services\SmsService
 */
class SmsProviderFactory
{
    private const PROVIDER_SMS_RU = 'smsru';

    private const PROVIDER_SMS_CENTER = 'smscenter';

    private const PROVIDER_EPOCHTA = 'epochta';

    private const SMS_PROVIDERS = [
        self::PROVIDER_SMS_RU => SmsRuProvider::class,
        self::PROVIDER_SMS_CENTER => SmsCenterProvider::class,
        self::PROVIDER_EPOCHTA => EpochtaProvider::class,
    ];

    /**
     * List of Sms Provider instances
     *
     * @var SmsProviderInterface
     */
    private $provider;

    /**
     * @param string $provider Sms provider name
     * @throws Exception
     */
    public function __construct(string $provider)
    {
        if (!isset($this->provider)) {
            if (isset(self::SMS_PROVIDERS[$provider])) {
                $providerClass = self::SMS_PROVIDERS[$provider];

                $this->provider = new $providerClass();
            } else {
                throw new Exception(sprintf('Invalid Sms provider name: %s', $provider));
            }
        }
    }

    /**
     * @param string $provider Sms provider name
     * @return SmsProviderInterface
     * @throws Exception
     */
    public function get()
    {
        return $this->provider;
    }
}
