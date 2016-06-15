# Fwk\Events (Event Dispatcher)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fwk/Events/badges/quality-score.png?s=fd301aeae2aced90b4005e852c155c6993201f7f)](https://scrutinizer-ci.com/g/fwk/Events/)
[![Build Status](https://secure.travis-ci.org/fwk/Events.png?branch=master)](http://travis-ci.org/fwk/Events)
[![Code Coverage](https://scrutinizer-ci.com/g/fwk/Events/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/fwk/Events/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/fwk/events/v/stable.png)](https://packagist.org/packages/fwk/events) 
[![Total Downloads](https://poser.pugx.org/fwk/events/downloads.png)](https://packagist.org/packages/fwk/events) 
[![Latest Unstable Version](https://poser.pugx.org/fwk/events/v/unstable.png)](https://packagist.org/packages/fwk/events) 
[![License](https://poser.pugx.org/fwk/di/license.png)](https://packagist.org/packages/fwk/events)

Event Dispatcher for PHP 5.4+

## Installation

Via [Composer](http://getcomposer.org):

```
{
    "require": {
        "fwk/events": "dev-master",
    }
}
```

If you don't use Composer, you can still [download](https://github.com/fwk/Events/zipball/master) this repository and add it
to your ```include_path``` [PSR-0 compatible](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)

## Documentation

### Adding Listeners

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

### Removing Listeners

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

## Contributions / Community

- Issues on Github: https://github.com/fwk/Events/issues
- Follow *Fwk* on Twitter: [@phpfwk](https://twitter.com/phpfwk)

## Legal 

Fwk is licensed under the 3-clauses BSD license. Please read LICENSE for full details.
