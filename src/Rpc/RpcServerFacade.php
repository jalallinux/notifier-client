<?php

namespace JalalLinuX\Notifier\Rpc;

use Illuminate\Support\Facades\Facade;

class RpcServerFacade extends Facade {

    protected static function getFacadeAccessor() { return 'RpcServer'; }

}
