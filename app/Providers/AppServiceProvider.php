<?php

namespace App\Providers;

use App\Models\OrganizationSetting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $settings = OrganizationSetting::where('organization_id', 1)
            ->pluck('value', 'key'); // get all settings as ['key' => 'value']

        if ($settings->isNotEmpty()) {
            config([
                'mail.default' => $settings->get('email_provider', config('mail.default')),

                'mail.mailers.smtp.host' => $settings->get('email_host', config('mail.mailers.smtp.host')),
                'mail.mailers.smtp.port' => $settings->get('email_port', config('mail.mailers.smtp.port')),
                'mail.mailers.smtp.username' => $settings->get('email_username', config('mail.mailers.smtp.username')),
                'mail.mailers.smtp.password' => $settings->get('email_password', config('mail.mailers.smtp.password')),
                'mail.mailers.smtp.encryption' => $settings->get('email_encryption', config('mail.mailers.smtp.encryption')),

                'mail.from.address' => $settings->get('email_from_address', config('mail.from.address')),
                'mail.from.name' => $settings->get('email_from_name', config('mail.from.name')),
            ]);
        }
    }
}
