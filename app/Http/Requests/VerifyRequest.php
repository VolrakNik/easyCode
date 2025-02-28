<?php

namespace App\Http\Requests;

use App\Models\Verification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VerifyRequest extends FormRequest
{
    public Verification $verification;

    public function rules(): array
    {
        return [
            'uuid' => ['required', 'uuid'],
            'code' => ['required', 'int', 'digits:4'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $verification = Verification::where('uuid', '=', $this->input('uuid'))
                ->where('user_id', '=', Auth::id())
                ->first();
            $verificationCode = $verification->code ?? '';

            if (!Verification::verifyCode($this->input('code'), $verificationCode)) {
                $validator->errors()->add('code', 'Неверный код верификации.');
            } else {
                $this->verification = $verification;
            }
        });
    }
}
