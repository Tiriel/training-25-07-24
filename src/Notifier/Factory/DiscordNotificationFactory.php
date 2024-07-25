<?php

namespace App\Notifier\Factory;

use App\Notifier\Factory\NotificationFactoryInterface;
use App\Notifier\Notification\DiscordNotification;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\Recipient;

class DiscordNotificationFactory implements NotificationFactoryInterface
{

    public function create(string $message, string $email): ChatMessage
    {
        return (new DiscordNotification($message))->asChatMessage(new Recipient($email));
    }

    public static function getIndex(): string
    {
        return 'discord';
    }
}
