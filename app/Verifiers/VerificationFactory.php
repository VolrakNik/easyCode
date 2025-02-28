<?php

namespace App\Verifiers;

use App\Models\User;
use App\Senders\EmailSender;
use App\Senders\PhoneSender;
use App\Senders\SenderInterface;

class VerificationFactory
{
    /**
     * @param string $verifyBy
     * @return SenderInterface
     */
    public static function makeSender(string $verifyBy): SenderInterface
    {
        return match ($verifyBy) {
            User::VERIFY_BY_PHONE => (static function () {
                return new PhoneSender();
            })(),
            default => new EmailSender()
        };
    }

    /**
     * @param string $verifyBy
     * @return VerifierInterface
     */
    public static function makeVerification(string $verifyBy): VerifierInterface
    {
        return match ($verifyBy) {
            User::VERIFY_BY_PHONE => (static function () {
                return new PhoneVerifier();
            })(),
            default => new EmailVerifier()
        };
    }
}
