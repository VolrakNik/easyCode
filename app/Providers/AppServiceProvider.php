<?php

namespace App\Providers;

use App\Models\User;
use App\Senders\SenderInterface;
use App\Services\VerificationService;
use App\Verifiers\VerificationFactory;
use App\Verifiers\VerifierInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(VerificationService::class)->needs(SenderInterface::class)->give(function () {
            /** @var ?User $user */
            $user = Auth::user();
            return VerificationFactory::makeSender($user->verify_by ?? '');
        });

        $this->app->when(VerificationService::class)->needs(VerifierInterface::class)->give(function () {
            /** @var ?User $user */
            $user = Auth::user();
            return VerificationFactory::makeVerification($user->verify_by ?? '');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
