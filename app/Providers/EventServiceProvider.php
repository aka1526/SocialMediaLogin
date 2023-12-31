<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // ... other providers
            \SocialiteProviders\Line\LineExtendSocialite::class.'@handle',
            \SocialiteProviders\Facebook\FacebookExtendSocialite::class.'@handle',
            \SocialiteProviders\Google\GoogleExtendSocialite::class.'@handle'
        ],
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        //     'Socialite' => Laravel\Socialite\Facades\Socialite::class,
        //     \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        //         'SocialiteProviders\Line\LineExtendSocialite@handle',
        //         \SocialiteProviders\Facebook\FacebookExtendSocialite::class.'@handle',
        //         \SocialiteProviders\Google\GoogleExtendSocialite::class.'@handle'
        //     ],
        // ],

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
