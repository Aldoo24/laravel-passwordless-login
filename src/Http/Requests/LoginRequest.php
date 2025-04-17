<?php

namespace Aldo\LaravelPasswordlessLogin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email|max:255|exists:users",
            "remember_me" => "nullable"
        ];
    }
}