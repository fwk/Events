Documentation is on its way ;)
(test again)

## Adding Listeners

``` php
use Fwk\Events\Dispatcher,
    Fwk\Events\Event;

$evd = new Dispatcher();

// closures listeners
$evd->on("eventName", function(Fwk\Events\Event $event) {
    // do some stuff
});

// Class methods starting by "on[EventCamelCasedName]" can also be added as 
// listeners
class MyListener 
{
    public function onEventName(Fwk\Events\Event $event) {
        // do some stuff
    }
}

$evd->addListener(new MyListener());
```

## Removing Listeners

``` php
/* ... */

// this removes all listeners for a given event
$evd->removeAllListeners("eventName");

// this removes a listener (callable) for a given event
$evd->removeListener("eventName", array($listener, "onListenerMethod"));
```

### Trigger Events

``` php
/* ... */

$event = new Fwk\Events\Event("eventName", array(
    "someData" => "someValue"
));
$event->extraData = "extraValue";

// dispatch event
$evd->notify($event);
```
