<?php

namespace App\Verifiers;

interface VerifierInterface
{
    public function generateMessage(int $code): string;
    public function generateCode(): int;
}
