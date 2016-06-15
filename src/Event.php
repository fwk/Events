<?php
/**
 * Fwk
 *
 * Copyright (c) 2011-2012, Julien Ballestracci <julien@nitronet.org>.
 * All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * PHP Version 5.3
 *
 * @category  EventDispatcher
 * @package   Fwk\Events
 * @author    Julien Ballestracci <julien@nitronet.org>
 * @copyright 2011-2014 Julien Ballestracci <julien@nitronet.org>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://www.nitronet.org/fwk
 */
namespace Fwk\Events;

use \ArrayObject;

/**
 * Event
 * 
 * This class represents an Event to be triggered into an EventDispatcher
 *
 * @category Event
 * @package  Fwk\Events
 * @author   Julien Ballestracci <julien@nitronet.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://www.nitronet.org/fwk
 */
class Event extends ArrayObject
{
    /**
     * This event's name
     * @var string
     */
    protected $name;

    /**
     * Tells if this event has been processed
     * @var boolean
     */
    protected $processed = false;

    /**
     * Stop propagation ?
     * @var boolean
     */
    protected $stopped = false;

    /**
     * Creates the event and attach some data
     *
     * @param string $name Event name
     * @param array  $data Event data
     * 
     * @return void
     */
    public function __construct($name, $data = array())
    {
        parent::__construct($data);
        $this->setFlags(\ArrayObject::ARRAY_AS_PROPS);
        $this->name = $name;
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
     * @param boolean $processed Processed or not
     * 
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
     * Tells if the event is stopped
     *
     * @return boolean
     */
    public function isStopped()
    {
        return $this->stopped;
    }

    /**
     * Tells if this event is processed
     *
     * @return boolean
     */
    public function isProcessed()
    {
        return $this->processed;
    }

    /**
     * Retrieve the $key parameter
     *
     * @param string $key Parameter name
     * 
     * @return mixed
     */
    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * Sets a parameter for this event
     *
     * @param string $key   Parameter name
     * @param mixed  $value Parameter value
     * 
     * @return void
     */
    public function __set($key, $value)
    {
        return $this->offsetSet($key, $value);
    }

    /**
     * Tells if the $key parameter is defined for this event
     *
     * @param string $key Parameter name
     * 
     * @return boolean
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }
}