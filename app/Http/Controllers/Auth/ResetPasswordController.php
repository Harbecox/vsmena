<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/';


    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $user->password = $password;
                $user->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
                Auth::guard()->login($user);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    protected function validationErrorMessages()
    {
        return [
            'email.required' => 'Укажите адрес электронной почты',
            'email.email' => 'Укажите корректный адрес электронной почты',
            'password.required' => 'Введите пароль',
            'password.min' => 'Пароль должен включать не менее 6 символов',
            'password.confirmed' => 'В полях "Пароль" и "Подтверждение пароля" следует ' .
                'указать одно и то же значение',
        ];
    }

    protected function sendResetResponse($response)
    {
        return redirect($this->redirectPath())
            ->with('status', 'Сброс пароля успешно выполнен');
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Указанный адрес электронной почты в списке отсутствует']);
    }
}
