<?php

/**
 * SpecShaper\CalendarBundle\Event\CalendarEvents.php
 * 
 * @author     Written by Mark Ogilvie <mark.ogilvie@specshaper.com>, 1 2016
 * @copyright  (c) 2016, SpecShaper - All rights reserved
 * @license    http://URL name
 * @version     Release: 1.0.0
 * @since       Available since Release 1.0.0
 */
namespace SpecShaper\CalendarBundle\Event;

/**
 * CalendarEvents contains all event types for the SpecShaperCalendarBundle
 *
 * @author      Mark Ogilvie <mark.ogilvie@specshaper.com>
 */
final class CalendarEvents {

    
    /**
     * The specshaper_calendar.load_events is thrown each time a request is
     * made to load event enties. 
     * 
     * @var string
     */
    const CALENDAR_LOAD_EVENTS = 'specshaper_calendar.load_events';
    
    /**
     * The specshaper_calendar.new_event is thrown when a new event is about
     * to be persisted.
     * 
     * Hook into this event to modify the CalendarEvent proir to flushing.
     * 
     * @var string
     */
    const CALENDAR_NEW_EVENT = 'specshaper_calendar.new_event';
    
    /**
     * The specshaper_calendar.event_removed is thrown when an event is
     * about to be removed from the database.
     * 
     * Hook into this event to modify the CalendarEvent proir to flushing.
     * 
     * @var string
     */
    const CALENDAR_EVENT_REMOVED = 'specshaper_calendar.event_removed';
    
    /**
     * The specshaper_calendar.event_updated is thrown when an event is
     * about to be updated.
     *  
     * Hook into this event to modify the CalendarEvent proir to flushing.
     * 
     * @var string
     */
    const CALENDAR_EVENT_UPDATED = 'specshaper_calendar.event_updated';
    
    /**
     * The specshaper_calendar.event_updated is thrown when an event is
     * about to be updated.
     *  
     * Hook into this event to modify the CalendarEvent proir to flushing.
     * 
     * @var string
     */
    const CALENDAR_GET_ADDRESSES = 'specshaper_calendar.get_addresses';
    
    
}
