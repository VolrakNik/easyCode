<?php

namespace App\Services;

use App\Models\Verification;
use App\Senders\SenderInterface;
use App\Verifiers\VerifierInterface;

class VerificationService
{
    public function __construct(public SenderInterface $sender, public VerifierInterface $verification) {}

    /**
     * @param int $userId
     * @param string $data
     * @return Verification
     */
    public function sendVerification(int $userId, string $data): Verification
    {
        $code = $this->verification->generateCode();
        $message = $this->verification->generateMessage($code);
        $this->sender->send($message);

        $verificationModel = new Verification();
        $verificationModel->code = $code;
        $verificationModel->user_id = $userId;
        $verificationModel->data = $data;
        $verificationModel->save();

        return $verificationModel;
    }

}
