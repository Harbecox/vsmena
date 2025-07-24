<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Matrix\Exception;
use Symfony\Component\ErrorHandler\Error\ClassNotFoundError;

class ValidateController extends Controller
{
    function validate(Request $request,$validator_class)
    {
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
            return response()->json(true);
        }
    }
}
