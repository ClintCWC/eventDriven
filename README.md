# eventDriven
add event driven actions to your app

add items/functions to your app that can be trigger when some event happens

Usage
$config['debug_event'] =  false/true; //can be very difficult to trouble shoot when things go wrong, so enabling this will output some useful debugging info.

$event->someEventName[] =  function(){stuff to do when event is called;}; //you can add multiple instances all with different stuff

$event->trigger('someEventName'); // add this to where you want the event to be trigger (like after saving some data or something)

(someEventName can be whatever you want)
