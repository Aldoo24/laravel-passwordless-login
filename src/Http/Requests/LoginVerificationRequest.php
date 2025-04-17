<?php

namespace Aldo\LaravelPasswordlessLogin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class LoginVerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (! URL::hasValidSignature($this)) {
            return false;
        }

        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function failedAuthorization(): void
    {
        $message = __("passwordless::app.login.failed");

        if (! URL::signatureHasNotExpired($this)) {
            $message = __("passwordless::app.login.expired");
        }

        throw new HttpResponseException(
            redirect()->route('login.notice')->with([
                "status" => false,
                "message" => $message
            ])
        );
    }
}