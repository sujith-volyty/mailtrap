<?php

namespace App\Scheduler;

use Symfony\Component\Console\Messenger\RunCommandMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Contracts\Cache\CacheInterface;

#[AsSchedule]
final class MainSchedule implements ScheduleProviderInterface
{
    public function __construct(
        private CacheInterface $cache,
    ) {
    }

    public function getSchedule(): Schedule
    {
        return (new Schedule())
            // ->add(
            //     RecurringMessage::cron(
            //         '0 0 * * *',
            //         new RunCommandMessage('app:send-booking-reminders')
            //     )
            // )
            ->add(RecurringMessage::cron(
                    '#midnight',
                    new RunCommandMessage('messenger:monitor:purge --exclude-schedules'),
                )
            )
            ->add(RecurringMessage::cron(
                    '#midnight',
                    new RunCommandMessage('messenger:monitor:schedule:purge'),
                )
            )
            ->stateful($this->cache)
            ->processOnlyLastMissedRun(true)
        ;
    }
}
