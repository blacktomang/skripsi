<?php

namespace App\Providers;

use App\Models\CompanyProfile;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Paginator::useBootstrap();
        Blade::directive('dateFormat', function ($date) {
            //  h:i a
            return "<?= Carbon\Carbon::parse($date)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('l, j F Y'); ?>";
        });
        $url = URL::current();
        if (!str_contains($url, 'dashboard')) {
            view()->composer('*', function ($view) {
                $companyProfile = CompanyProfile::first();
                $view->with(['companyProfile' => $companyProfile]);
            });
        }
    }
}
