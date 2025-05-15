<?php

namespace App\Webhook;

use Symfony\Component\RemoteEvent\Attribute\AsRemoteEventConsumer;
use Symfony\Component\RemoteEvent\Consumer\ConsumerInterface;
use Symfony\Component\RemoteEvent\RemoteEvent;

#[AsRemoteEventConsumer('mailtrap')]
class EmailEventConsumer implements ConsumerInterface
{
    /**
     * @param MailerDeliveryEvent|MailerEngagementEvent $event
     */
    public function consume(RemoteEvent $event): void
    {
       dump($event);
    }
}