<?php

namespace App\Notifier;

use App\Notifier\Factory\NotificationFactoryInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Notification\ChatNotificationInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

class AppNotifier
{
    public function __construct(
        protected readonly ChatterInterface $notifier,
        /** @var NotificationFactoryInterface[] $factories */
        #[TaggedIterator('app.notification_factory', defaultIndexMethod: 'getIndex')]
        protected iterable $factories,
    )
    {
        $this->factories = $factories instanceof \Traversable ? iterator_to_array($factories) : $factories;
    }

    public function sendNotification(string $message, $user = null): void
    {
        $user = new class {
            public function getEmail(): string
            {
                return 'admin@admin.com';
            }
            public function getPreferredChannel(): string
            {
                return 'slack';
            }
        };

        $notification = $this->factories[$user->getPreferredChannel()]
            ->create($message, $user->getEmail());

        $this->notifier->send($notification);
    }
}
