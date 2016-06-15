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

/**
 * Dispatcher
 * 
 * This class is an Event Dispatcher
 * It can be herited by other classes or used as-is.
 *
 * @category Dispatcher
 * @package  Fwk\Events
 * @author   Julien Ballestracci <julien@nitronet.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://www.nitronet.org/fwk
 */
class Dispatcher
{
    /**
     * Listeners attached to this dispatcher
     * @var array
     */
    protected $listeners;

    /**
     * Adds a listener
     *
     * @param string $name     Event name
     * @param mixed  $listener PHP Callable
     *
     * @return Dispatcher
     */
    public function on($name, $listener)
    {
        $name = strtolower($name);
        if (!isset($this->listeners[$name])) {
            $this->listeners[$name] = array();
        }

        array_push($this->listeners[$name], $listener);

        return $this;
    }

    /**
     * Reflects a class and transform all methods starting by 'on' to
     * event callable
     *
     * @param mixed $listenerObj The listener object
     *
     * @return Dispatcher
     */
    public function addListener($listenerObj)
    {
        if (!\is_object($listenerObj) || $listenerObj instanceof \Closure) {
            throw new \InvalidArgumentException("Argument is not an object");
        }

        $reflector = new \ReflectionObject($listenerObj);
        foreach ($reflector->getMethods() as $method) {
            $name       = $method->getName();
            if (\strpos($name, 'on') !== 0) {
                continue;
            }

            $eventName  = strtolower(\substr($name, 2));
            $callable   = array($listenerObj, $name);

            $this->on($eventName, $callable);
        }
        
        return $this;
    }

    /**
     * Removes a specific listener
     *
     * @param string $name     Event name
     * @param mixed  $listener PHP Callable
     *
     * @return Dispatcher
     */
    public function removeListener($name, $listener)
    {
        $name   = strtolower($name);
        if (!isset($this->listeners[$name])) {
            return $this;
        }

        foreach ($this->listeners[$name] as $idx => $callable) {
            if ($listener === $callable) {
                unset($this->listeners[$name][$idx]);
            }
        }

        return $this;
    }

    /**
     * Removes all listeners for a specific event
     *
     * @param string $name Event name
     *
     * @return Dispatcher
     */
    public function removeAllListeners($name)
    {
        $name = strtolower($name);
        unset($this->listeners[$name]);

        return $this;
    }

    /**
     * Notify listeners for a given event
     *
     * @param string|Event $event The Event to be dispatched (or event name)
     * @param array        $data  Shortcut when using $event as a string. If an Event
     * instance is provided, this param will be ignored.
     *
     * @return Event The event
     */
    public function notify($event, array $data = array())
    {
        if (is_string($event)) {
            $event = new Event($event, $data);
        }
        
        $name = strtolower($event->getName());
        if (!isset($this->listeners[$name]) 
            || !is_array($this->listeners[$name]) 
            || !count($this->listeners[$name])
        ) {
            return $event;
        }

        foreach ($this->listeners[$name] as $callable) {
            if (!$event->isStopped()) {
                call_user_func($callable, $event);
                $event->setProcessed(true);
            }
        }

        return $event;
    }
}