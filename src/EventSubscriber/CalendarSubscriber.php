<?php

namespace App\EventSubscriber;

use App\Repository\CTRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private CTRepository $ctRepository,
        private UrlGeneratorInterface $router
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        $cts = $this->ctRepository
            ->createQueryBuilder('ct')
            ->where('ct.debut BETWEEN :start and :end OR ct.fin BETWEEN :start and :end')
            ->setParameter('start', $start->format('d-m-Y H:i:s'))
            ->setParameter('end', $end->format('d-m-Y H:i:s'))
            ->getQuery()
            ->getResult();

        foreach ($cts as $ct) {
            // this create the events with your data (here booking data) to fill calendar
            $ctEvent = new Event(
                $ct->getTitle(),
                $ct->getBeginAt(),
                $ct->getEndAt() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $ctEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
            $ctEvent->addOption(
                'url',
                $this->router->generate('app_booking_show', [
                    'id' => $ct->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($ctEvent);
        }
    }
}
