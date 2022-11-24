<?php
namespace Pavelrockjob\Esia\Providers;

use Illuminate\Support\ServiceProvider;

class EsiaProvider extends ServiceProvider
{
    public function boot(){
        $this->publishes([
            __DIR__.'/../config/esia.php' => config_path('esia.php'),
        ]);
    }


}
