<?php

namespace App\Verifiers;

class EmailVerifier implements VerifierInterface
{
    public function generateMessage(int $code): string
    {
        return "Ваш код: $code. Можете проигнорировать письмо, если оно к Вам не относится";
    }

    public function generateCode(): int
    {
        return random_int(1000, 9999);
    }
}
