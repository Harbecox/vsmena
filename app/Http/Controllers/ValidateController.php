<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Matrix\Exception;
use Symfony\Component\ErrorHandler\Error\ClassNotFoundError;

class ValidateController extends Controller
{
    function validate(Request $request,$validator_class)
    {
        $is_login = $validator_class == "EmailCheckRequest";
        $validator_class = 'App\\Http\Requests\\'.$validator_class;
        if (!class_exists($validator_class)) {
            return response()->json([
                'error' => "Класс запроса валидации [$validator_class] не найден"
            ], 404);
        }
        $validator = new $validator_class;
        $rules = $validator->rules();
        $messages = $validator->messages();
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        } else {
            if($is_login){
                $user = User::query()->where('phone',$request->phone)->first();
                if(!Hash::check($request->password,$user->password)){
                    return response()->json([
                        'errors' => [
                            'password' => [
                                'Неправильный пароль'
                            ]
                        ],
                    ], 422);
                }
            }
            return response()->json(true);
        }
    }
}
