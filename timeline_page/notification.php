<?php
    // Refer to the PHP quickstart on how to setup the environment:
// https://developers.google.com/calendar/quickstart/php
// Change the scope to Google_Service_Calendar::CALENDAR and delete any stored
// credentials.

$event = new Google_Service_Calendar_Event(array(
    'summary' => 'meeting today',
    'location' => 'matunga,mumbai',
    'description' => 'to choose the better value for user',
    'start' => array(
      'dateTime' => 'Sunday, 4 August 2019, 2:01 pm',
      'timeZone' => 'Time zone in India (GMT+5:30)',
    ),
    'end' => array(
      'dateTime' => 'Monday, 5 August 2019, 2:01 pm',
      'timeZone' => 'Time zone in India (GMT+5:30)',
    ),
    'recurrence' => array(
      'RRULE:FREQ=DAILY;COUNT=2'
    ),
    'attendees' => array(
      array('email' => 'sanketbhondge123@gmail.com'),
      array('email' => '16ychauhan@gmail.com'),
      array('email' => 'nachiketdandare99@gmail.com')
    ),
    'reminders' => array(
      'useDefault' => FALSE,
      'overrides' => array(
        array('method' => 'email', 'minutes' => 24 * 60),
        array('method' => 'popup', 'minutes' => 10),
      ),
    ),
  ));
  
  $calendarId = 'primary';
  $event = $service->events->insert($calendarId, $event);
  printf('Event created: %s\n', $event->htmlLink);
?>