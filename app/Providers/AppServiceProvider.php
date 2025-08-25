<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Contracts\AuthorizationViewResponse;
use Laravel\Passport\Passport;

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
    // Implicitly grant "Super-Admin" role all permission checks using can()
    Gate::before(function ($user, $ability) {
      if ($user->hasRole('Super-Admin')) {
        return true;
      }
    });

    Passport::authorizationView('auth.oauth.authorize');
  }
}
