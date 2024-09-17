<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class EmailVerifyController extends Controller
{

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function verify(Request $request, $id, $hash) {


        Log::debug($id);
        // Находим пользователя по ID
        $user =  $this->userService->getUserById($id);

        // Проверяем, что hash соответствует email пользователя
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid or expired link'], 403);
        }

        // Проверяем валидность подписи и срока действия ссылки
        if (! URL::hasValidSignature($request)) {
            return response()->json(['message' => 'Invalid or expired signature'], 403);
        }

        // Если email уже подтвержден
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        // Подтверждаем email
        if ($user->markEmailAsVerified()) {
            event(new Verified($user)); // Событие подтверждения
        }

        // Возвращаем успешный ответ
        return response()->json(['message' => 'Email verified successfully'], 200);
        }





}
