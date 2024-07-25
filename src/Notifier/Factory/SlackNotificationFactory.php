<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\SlackNotification;
use Symfony\Component\Notifier\Bridge\Slack\Block\SlackActionsBlock;
use Symfony\Component\Notifier\Bridge\Slack\Block\SlackSectionBlock;
use Symfony\Component\Notifier\Bridge\Slack\SlackOptions;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\Recipient;

class SlackNotificationFactory implements NotificationFactoryInterface
{
    public function create(string $message, string $email): ChatMessage
    {
        $options = (new SlackOptions())
            ->block((new SlackSectionBlock())
                ->text($message)
            )
            ->block((new SlackActionsBlock())
                ->button(
                    'Symfony documentation',
                    'https://www.symfony.com/doc',
                    'primary'
                )
            )
        ;
        $chat = (new SlackNotification())->asChatMessage(new Recipient($email));
        $chat->subject($message)->options($options);

        return $chat;
    }

    public static function getIndex(): string
    {
        return 'slack';
    }
}
