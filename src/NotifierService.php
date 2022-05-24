<?php

namespace JalalLinuX\Notifier;

use Illuminate\Support\Collection;
use JalalLinuX\Notifier\Rpc\RpcClientFacade;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;

/**
 * Notifier Service
 * @author JalalZadeh
 */
class NotifierService
{
    private string $userUuid;

    private string $provider;

    /**
     * Send normal database message
     * @param string $title
     * @param string $message
     * @param string $type
     * @param string $icon
     * @param string|null $color
     * @param string|null $url
     * @return Collection
     * @author JalalZadeh
     */
    public function databaseSend(string $title, string $message, string $type, string $icon, string $color = null, string $url = null): Collection
    {
        return $this->sendRpc('database@send', [
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'icon' => $icon,
            'color' => $color,
            'url' => $url,
        ]);
    }

    /**
     * Send normally Kafka notification
     * @param string $topic
     * @param array $body
     * @param array $headers
     * @param string $key
     * @return Collection
     * @author JalalZadeh
     */
    public function kafkaSend(string $topic, array $body, array $headers, string $key): Collection
    {
        return $this->sendRpc('kafka@send', [
            'topic' => $topic,
            'body' => $body,
            'headers' => $headers,
            'key' => $key,
        ]);
    }

    /**
     * Send template sms message
     * @param string $phone
     * @param string $code
     * @param array $params
     * @return Collection
     * @author JalalZadeh
     */
    public function smsSendTemplate(string $phone, string $code, array $params = []): Collection
    {
        return $this->sendRpc('sms@sendTemplate', [
            'code' => $code,
            'phone' => $phone,
            'params' => $params,
        ]);
    }

    /**
     * Send normal sms message
     * @param string $phone
     * @param string $message
     * @return Collection
     * @author JalalZadeh
     */
    public function smsSend(string $phone, string $message): Collection
    {
        return $this->sendRpc('sms@send', [
            'phone' => $phone,
            'message' => $message,
        ]);
    }

    /**
     * Send template mail message
     * @param string $toName
     * @param string $toMail
     * @param string $subject
     * @param string $template
     * @param array $options
     * @return Collection
     * @author JalalZadeh
     */
    public function mailSendTemplate(string $toName, string $toMail, string $subject, string $template, array $options = []): Collection
    {
        return $this->sendRpc('mail@sendTemplate', [
            'subject' => $subject,
            'template' => $template,
            'options' => $options,
            'to' => [
                'name' => $toName,
                'address' => $toMail,
            ],
        ]);
    }

    /**
     * Send html mail message
     * @param string $toName
     * @param string $toMail
     * @param string $subject
     * @param string $html
     * @return Collection
     * @author JalalZadeh
     */
    public function mailSend(string $toName, string $toMail, string $subject, string $html): Collection
    {
        return $this->sendRpc('mail@send', [
            'subject' => $subject,
            'html' => $html,
            'to' => [
                'name' => $toName,
                'address' => $toMail,
            ],
        ]);
    }

    /**
     * Send normally push notification
     * @param string $token
     * @param string $body
     * @param string $title
     * @param string|null $link
     * @param string|null $icon
     * @param string|null $sound
     * @return Collection
     * @author JalalZadeh
     */
    public function pushSend(string $token, string $body, string $title, string $link = null, string $icon = null, string $sound = null): Collection
    {
        return $this->sendRpc('push@send', [
            'to' => $token,
            'option' => [
                'body' => $body,
                'title' => $title,
                'link' => $link,
                'icon' => $icon,
                'sound' => $sound,
            ],
        ]);
    }


    /**
     * Send rpc request to notification service
     * @param string $method
     * @param array $params
     * @return Collection
     * @author JalalZadeh
     */
    private function sendRpc(string $method, array $params): Collection
    {
        throw_if(
            empty($this->provider) || empty($this->userUuid) || is_null(config('notifier.client.url')),
            new \Exception("Notifier url or provider or user uuid is not set.", 400)
        );
        $params = array_merge($params, [
            'provider' => $this->provider,
        ]);

        config()->set('notifier.client.headers.x-user-uuid', $this->userUuid);
        return collect(RpcClientFacade::{$method}($params));
    }

    /**
     * @param string $userUuid
     * @param string $provider
     * @return NotifierService
     * @author JalalZadeh
     */
    public function init(string $userUuid, string $provider): static
    {
        $this->userUuid = $userUuid;
        $this->provider = $provider;
        return $this;
    }
}
