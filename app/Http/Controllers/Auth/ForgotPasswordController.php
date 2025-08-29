<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        return $this->sendResetLinkResponse();
    }

    protected function sendResetLinkResponse()
    {
        return back()->with('status', 'Письмо со ссылкой на страницу сброса пароля ' .
            'успешно отправлено');
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()->withErrors(
            ['email' => 'Указанный адрес электронной почты в списке отсутствует']
        );
    }
}
