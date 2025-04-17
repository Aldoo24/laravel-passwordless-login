<?php

namespace Aldo\LaravelPasswordlessLogin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|min:3|max:50",
            "email" => "required|email|max:255|unique:users",
        ];
    }
}