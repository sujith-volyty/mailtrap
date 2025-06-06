<?php

namespace App\EventListener;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\Event\MessageEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

final class GlobalFromEmailListener
{
    public function __construct(
        #[Autowire('%global_from_email%')]
        private string $fromEmail,
    ) {
    }

    #[AsEventListener(event: MessageEvent::class)]
    public function onMessageEvent(MessageEvent $event): void
    {
        $message = $event->getMessage();
        if (!$message instanceof TemplatedEmail) {
            return;
        }
        if ($message->getFrom()) {
            return;
        }
        $message->from($this->fromEmail);
    }
}
