<?php

namespace Fwk\Events;

if(!class_exists('\Fwk\Events\Dispatcher'))
    require_once __DIR__ .'/../Dispatcher.php';

if(!class_exists('\Fwk\Events\Event'))
    require_once __DIR__ .'/../Event.php';

/**
 * Test class for EventDispatcher.
 */
class DispatcherTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var EventDispatcher
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Dispatcher;
        $GLOBALS['testEvent'] = false;
    }

    /**
     */
    public function testOn()
    {
        $this->object->on('test.event', array($this, 'eventFunction'));
        $this->object->notify(new Event('test.event'));
        $this->assertTrue($GLOBALS['testEvent']);
    }

    // test function for event callback
    public function eventFunction($event)
    {
        $GLOBALS['testEvent'] = true;
    }

    /**
     */
    public function testRemoveListener()
    {
        $this->object->on('test.event', array($this, 'eventFunction'));
        $this->object->notify(new Event('test.event'));
        $this->assertTrue($GLOBALS['testEvent']);
        
        $GLOBALS['testEvent'] = false;
        $this->object->removeListener('test.event', array($this, 'eventFunction'));
        $this->object->notify(new Event('test.event'));
        $this->assertFalse($GLOBALS['testEvent']);
    }

    /**
     */
    public function testRemoveAllListeners()
    {
        $this->object->on('test.event', array($this, 'eventFunction'));
        
        $this->object->removeAllListeners('test.event');
        $this->object->notify(new Event('test.event'));
        $this->assertFalse($GLOBALS['testEvent']);
    }

    /**
     */
    public function testNotify()
    {
        $this->assertFalse($GLOBALS['testEvent']);
        $this->object->on('test.event', array($this, 'eventFunction'));

        $this->object->notify($event = new Event('test.event'));
        $this->assertTrue($GLOBALS['testEvent']);
        $this->assertTrue($event->isProcessed());
    }

}
