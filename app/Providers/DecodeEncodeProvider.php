<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DecodeEncodeProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once base_path() . '/app/Helpers/Base64Helper.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
