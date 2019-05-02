<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Throwable;

class LoginController extends Controller
{
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
        $code = $this->generateCode();

        if (null === $code) {
            return response()->json(['generated' => false], Http::HTTP_UNAUTHORIZED);
        }

        $phone = $request->get('phone');

        User::updateOrCreate(['phone' => $phone], ['password' => \Hash::make($code), 'active' => 1]);

        $response = $this->sendSms($phone, $code);

        Log::info(sprintf('Code %s generated and sent by phone number %s with response: %s', $code, $phone, $response));

        return response()->json(['generated' => true], Http::HTTP_OK);
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
        } else {
            $authenticated = false;
            $status = Http::HTTP_UNAUTHORIZED;
        }

        return response()->json(['success' => $authenticated], $status);
    }

    private function generateCode(): ?int
    {
        try {
            return random_int(1000, 9999);
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return null;
        }
    }

    private function sendSms(string $phone, string $code): string
    {
        $key = '43A48416-2A53-00B9-00F0-908D052A859A';

        $body = file_get_contents(
            "https://sms.ru/sms/send?api_id=$key&to=$phone&msg=$code&json=1&test=1"
        );

        return $body;
    }
}
