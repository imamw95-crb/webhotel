<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ReCaptchaService
{
    /**
     * Verify the reCAPTCHA v2 response token.
     */
    public function verify(?string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $token,
        ]);

        $body = $response->json();

        return ($body['success'] ?? false) === true;
    }
}
