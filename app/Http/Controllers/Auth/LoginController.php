<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SmsService\SmsProviderFactory;
use App\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Throwable;

class LoginController extends Controller
{
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
            $code = random_int(1000, 9999);
            Log::info(sprintf('Code %s for the phone number %s generated', $code, $phone));

            User::updateOrCreate(['phone' => $phone], ['password' => Hash::make($code), 'active' => 1]);

            $provider = (new SmsProviderFactory(env('SMS_SERVICE')))->get();

            if ($provider->send($phone, $code)) {
                return response()->json(['success' => true], Http::HTTP_OK);
            }

            throw new Exception('Не удалось отправить код подтверждения. Возможно указан неверный номер телефона');
        } catch (Throwable $e) {
            Log::info(
                sprintf(
                    'Code sending error: phone - %s, message - %s',
                    $phone,
                    $e->getMessage()
                )
            );

            return response()->json(['success' => false, 'message' => 'Ошибка отправки кода авторизации']);
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
