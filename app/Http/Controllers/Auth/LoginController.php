<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Http;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Throwable;

class LoginController extends Controller
{
    private const CORRECT_CODES = [100, 101, 102, 103, 110];

    private const SMS_SERVICE_SMS_RU = 'smsru';
    private const SMS_SERVICE_SMSCENTER = 'smscenter';
    private const SMS_SERVICE_EPOCHTA = 'epochta';

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getAuthCode(Request $request)
    {
        $phone = $request->get('phone');

        try {
            $code = $this->generateCode($phone);

            if (null === $code) {
                throw new Exception('Не удалось сгенерировать код подтверждения');
            }

            User::updateOrCreate(['phone' => $phone], ['password' => Hash::make($code), 'active' => 1]);

            $smsService = env('SMS_SERVICE');
            Log::info('Current SMS service: ' . $smsService);

            $smsStatus = false;

            if (self::SMS_SERVICE_SMS_RU === $smsService) {
                $smsStatus = $this->sendSmsRu($phone, $code);
            } elseif (self::SMS_SERVICE_SMSCENTER === $smsService) {
                $smsStatus = $this->sendSmsCenter($phone, $code);
            } elseif (self::SMS_SERVICE_EPOCHTA === $smsService) {
                $smsStatus = $this->sendEpochta($phone, $code);
            } else {
                Log::error(sprintf('Неизвестный сервис отправки сообщений: %s', $smsService));
            }

            if ($smsStatus) {
                return response()->json(['success' => true], Http::HTTP_OK);
            }

            throw new Exception('Не удалось отправить код подтверждения. Возможно указан неверный номер телефона');
        } catch (Throwable $e) {
            Log::info(
                sprintf(
                    'Code generating and sending error: phone - %s, message - %s',
                    $phone,
                    $e->getMessage()
                )
            );

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function generateCode(string $phone): ?int
    {
        $code = null;

        try {
            $code = random_int(1000, 9999);

            Log::info(sprintf('Code %s for the phone number %s successfully generated', $code, $phone));

            return $code;
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }

        return $code;
    }

    private function sendSmsRu(string $phone, string $message): bool
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

            return in_array((int)$response['sms'][$phone]['status_code'], self::CORRECT_CODES);
        } catch (Throwable $e) {
            Log::error(sprintf('SMS sending error: %s', $e->getMessage()));

            return false;
        }
    }

    private function sendSmsCenter(string $phone, string $message): bool
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

    private function sendEpochta(string $phone, string $message): bool
    {
        try {
            $url = 'http://api.atompark.com/members/sms/xml.php';
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
                CURLOPT_URL => $url,
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
            Log::info(sprintf('An SMS sent to %s', $body));
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

    /**
     * Handle an authentication attempt.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        if (Auth::attempt($credentials)) {
            $authenticated = true;
            $status = Http::HTTP_OK;

            Log::info(sprintf('User successfully authenticated with credentials: %s', json_encode($credentials)));
        } else {
            $authenticated = false;
            $status = Http::HTTP_UNAUTHORIZED;

            Log::error(sprintf('Cannot authenticate user with credentials: %s', json_encode($credentials)));
        }

        return response()->json(['success' => $authenticated], $status);
    }
}
