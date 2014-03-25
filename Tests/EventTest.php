<?php

namespace Fwk\Events;

if(!class_exists('\Fwk\Events\Event'))
    require_once __DIR__ .'/../Event.php';

/**
 * Test class for Event.
 * Generated by PHPUnit on 2010-12-22 at 14:22:34.
 */
class EventTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Event
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Event('test.event', array('test' => 'testValue'));
    }

    /**
     * @todo Implement testGetName().
     */
    public function testGetName()
    {
        $this->assertEquals('test.event', $this->object->getName());
    }

    /**
     */
    public function testGetData()
    {
        $this->assertTrue(is_array($this->object->getData()));
    }

    /**
     */
    public function testSetProcessed()
    {
        $this->assertFalse($this->object->isProcessed());
        $this->object->setProcessed(true);
        $this->assertTrue($this->object->isProcessed());
    }
    
    public function testDataAsObjectProperties()
    {
        $this->assertFalse(isset($this->object->test2));
        $this->assertTrue(isset($this->object->test));
        $this->assertEquals('testValue', $this->object->test);
        $this->assertFalse($this->object->__isset('test2'));
        $this->assertTrue($this->object->__isset('test'));
        $this->assertEquals('testValue', $this->object->__get('test'));
        $this->object->__set('test2', 'testValue2');
        $this->assertTrue($this->object->__isset('test2'));
    }
}
