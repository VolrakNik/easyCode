<?php

namespace App\Verifiers;

class PhoneVerifier implements VerifierInterface
{
    public function generateMessage(int $code): string
    {
        return "Ваш код: $code. Можете проигнорировать сообщение, если оно к Вам не относится";
    }

    public function generateCode(): int
    {
        return random_int(1000, 9999);
    }
}
