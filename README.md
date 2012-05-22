Fwk Events Utility

Used to dispatch events into PHP Applications.

## Usage

This is really simple and straightforward.

### Adding Listeners

```

<?php

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

```

<?php

/* ... */

// this removes all listeners from the dispatcher
$evd->removeAllListeners();

// this removes all listeners for a given event
$evd->removeListeners("eventName");


```

### Trigger Events

```

<?php

/* ... */

$event = new Fwk\Events\Event("eventName", array(
    "someData" => "someValue"
));
$event->extraData = "extraValue";

// dispatch event
$evd->notify($event);

```

## BSD Licence

Fwk is licensed under the 2-clauses BSD license, also known as the
simplified BSD license.

```
Copyright 2011-2012 Julien Ballestracci - All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following
conditions are met:

    * Redistributions of source code must retain the above copyright
      notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above
      copyright notice, this list of conditions and the following
      disclaimer in the documentation and/or other materials provided
      with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND
CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

```