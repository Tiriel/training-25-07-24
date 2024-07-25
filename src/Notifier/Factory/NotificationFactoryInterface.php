<?php

namespace App\Notifier\Factory;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Notification\Notification;

#[AutoconfigureTag('app.notification_factory')]
interface NotificationFactoryInterface
{
    public function create(string $message, string $email): ChatMessage;

    public static function getIndex(): string;
}
