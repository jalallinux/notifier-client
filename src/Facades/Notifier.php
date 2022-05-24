<?php

namespace JalalLinuX\Notifier\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * Notifier facades method
 * @method self init(string $userUuid, string $provider)
 * @method Collection databaseSend(string $title, string $message, string $type, string $icon, string $color = null, string $url = null)
 * @method Collection kafkaSend(string $topic, array $body, array $headers, string $key)
 * @method Collection smsSend(string $phone, string $message)
 * @method Collection smsSendTemplate(string $phone, string $code, array $params = [])
 * @method Collection mailSend(string $toName, string $toMail, string $subject, string $html)
 * @method Collection mailSendTemplate(string $toName, string $toMail, string $subject, string $template, array $options = [])
 * @method Collection pushSend(string $token, string $body, string $title, string $link = null, string $icon = null, string $sound = null)
 * @author JalalZadeh
 */
class Notifier extends Facade
{
    /**
     * facade accessor
     * @return string
     * @author JalalZadeh
     */
    protected static function getFacadeAccessor(): string
    {
        return 'notifier';
    }
}
