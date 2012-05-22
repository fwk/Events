<?php

/**
 * Fwk
 *
 * Copyright (c) 2010-2011, Julien Ballestracci <julien@nitronet.org>.
 * All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    Fwk
 * @subpackage Events
 * @author     Julien Ballestracci <julien@nitronet.org>
 * @copyright  2011-2012 Julien Ballestracci <julien@nitronet.org>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       http://www.phpfwk.com
 */
namespace Fwk\Events;

/**
 * This class represents an Event to be triggered into an EventDispatcher
 */
class Event extends \ArrayObject
{
    /**
     * This event's name
     *
     * @var string
     */
    protected $name;
    
    /**
     * Tells if this event has been processed
     * 
     * @var boolean
     */
    protected $processed;
    
    /**
     * Stop propagation ?
     * 
     * @var boolean
     */
    protected $stopped;

    /**
     * Creates the event with its data
     *
     * @param string $name
     * @param array $data
     * @return void
     */
    public function __construct($name, $data = array()) {
        $this->name = $name;
        $this->processed = false;
        $this->stopped = false;
        
        parent::__construct($data);
        $this->setFlags(\ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * Returns this event name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the data
     *
     * @return array
     */
    public function getData()
    {
        return $this->getArrayCopy();
    }

    /**
     * Sets the processed flag
     *
     * @param boolean $processed 
     * @return Event
     */
    public function setProcessed($processed)
    {
        $this->processed = (boolean)$processed;

        return $this;
    }
    
    /**
     * Stops event propagation
     * 
     * @return void
     */
    public function stop()
    {
        $this->stopped = true;
    }
    
    /**
     * Tells if the event has been stopped
     * 
     * @return boolean 
     */
    public function isStopped()
    {
        return $this->stopped;
    }

    /**
     * Tells if this event has been processed
     * 
     * @return boolean
     */
    public function isProcessed()
    {
        return $this->processed;
    }

    /**
     * Retrieve a variable {$key}
     * 
     * @return void
     */
    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * Sets a variable for this event
     * 
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function __set($key, $value)
    {
        return $this->offsetSet($key, $value);
    }

    /**
     * Tells if a variable {$key} exists for this event
     * 
     * @param string $key
     * @return boolean
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }
}