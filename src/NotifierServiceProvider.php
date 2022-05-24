<?php

namespace JalalLinuX\Notifier;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use JalalLinuX\Notifier\Rpc\RpcClientFacade;
use JalalLinuX\Notifier\Rpc\RpcClientWrapper;
use JalalLinuX\Notifier\Rpc\RpcServerFacade;
use JsonRPC\Server;
use ReflectionClass;

class NotifierServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Shared Client
        $this->app->singleton('JsonRpcClient', function ($app) {
            $options = $this->app['config']->get('notifier.client');
            return new RpcClientWrapper($options);
        });

        // Shared Server
        $this->app->bind('JsonRpcServer', function ($app, $params = []) {
            $options = $this->app['config']->get('notifier.server');
            $options = $this->app['config']->get('notifier.server');
            $class = new ReflectionClass(Server::class);
            return $class->newInstanceArgs($params);
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/notifier.php');
        $this->app->singleton('notifier', fn() => new NotifierService);
    }


    protected function mergeConfigFrom($path, $key = 'notifier')
    {
        $config_usr = $this->app['config']->get($key, []);
        $config_pkg = require $path;

        // merge config arrays
        $config = [];
        $config['client'] = array_merge($config_pkg['client'], @$config_usr['client'] ?: []);
        $config['server'] = array_merge($config_pkg['server'], @$config_usr['server'] ?: []);

        $this->app['config']->set($key, $config);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register Facades
        $loader = AliasLoader::getInstance();
        $loader->alias('RpcClient', RpcClientFacade::class);
        $loader->alias('RpcServer', RpcServerFacade::class);


        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/notifier.php' => config_path('notifier.php'),
            ], 'config');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['JsonRpcClient', 'JsonRpcServer'];
    }
}
