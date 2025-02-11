<?php
namespace Shahbazi\RedisManager;

use Illuminate\Support\ServiceProvider;

class RedisManagerServicePorvider extends ServiceProvider {


    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'redis-manager');
        $this->loadRoutesFrom(__DIR__ . '/../routes/redis-manager.php');
    }

    public function register()
    {

    }

}
