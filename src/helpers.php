<?php

use Illuminate\Support\Collection;
use JalalLinuX\Notifier\Rpc\RpcClientFacade;

if (!function_exists('sendNotification')) {
    /**
     * Sending RPC notification request
     * @param string $method
     * @param string $provider
     * @param array $params
     * @param string $userUuid
     * @return Collection
     * @author JalalZadeh
     */
    function sendNotification(string $userUuid, string $method, string $provider, array $params): Collection
    {
        $params = array_merge($params, ["provider" => $provider,]);
        config()->set('notifier.client.headers.x-user-uuid', $userUuid);
        return collect(RpcClientFacade::{$method}($params));
    }
}
