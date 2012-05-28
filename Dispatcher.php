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
 * @package    Fwk
 * @subpackage Events
 * @author     Julien Ballestracci <julien@nitronet.org>
 * @copyright  2011-2012 Julien Ballestracci <julien@nitronet.org>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       http://www.phpfwk.com
 */
namespace Fwk\Events;

/**
 * This class is an Event Dispatcher
 * It can be herited by other classes or used as-is.
 *
 */
class Dispatcher
{
    /**
     * Listeners attached to this dispatcher
     *
     * @var array
     */
    protected $listeners;

    /**
     * Adds a listener
     *
     * @param string $name     Event name
     * @param mixed  $listener PHP Callable
     *
     * @return boolean
     */
    public function on($name, $listener)
    {
        $name = strtolower($name);
        if (!isset($this->listeners[$name])) {
            $this->listeners[$name] = array();
        }

        array_push($this->listeners[$name], $listener);

        return true;
    }

    /**
     * Reflects a class and transform all methods starting by 'on' to
     * event callable
     *
     * @param mixed $listenerObj The listener object
     *
     * @return void
     */
    public function addListener($listenerObj)
    {
        if (!\is_object($listenerObj)) {
            throw new \InvalidArgumentException("Argument is not an object");
        }

        $reflector      = new \ReflectionObject($listenerObj);
        foreach ($reflector->getMethods() as $method) {
            $name   = $method->getName();

            if(\strpos($name, 'on') !== 0)
                    continue;

            $eventName  = strtolower(\substr($name, 2));
            $callable   = array($listenerObj, $name);

            $this->on($eventName, $callable);
        }
    }

    /**
     * Removes a specific listener
     *
     * @param string $name     Event name
     * @param mixed  $listener PHP Callable
     *
     * @return boolean
     */
    public function removeListener($name, $listener)
    {
        $name   = strtolower($name);
        if (!isset($this->listeners[$name])) {
            return false;
        }

        $del = false;
        foreach ($this->listeners[$name] as $idx => $callable) {
            if ($listener === $callable) {
                unset($this->listeners[$name][$idx]);
                $del = true;
            }
        }

        return $del;
    }

    /**
     * Removes all listeners for a specific event
     *
     * @param string $name Event name
     *
     * @return boolean
     */
    public function removeAllListeners($name)
    {
        $name   = strtolower($name);
        if (!isset($this->listeners[$name])) {
            return false;
        }

        unset($this->listeners[$name]);

        return true;
    }

    /**
     * Notify listeners for a given event
     *
     * @param Event $event The Event to be dispatched
     *
     * @return boolean (true if processed)
     */
    public function notify(Event $event)
    {
        $name = strtolower($event->getName());
        if(!isset($this->listeners[$name]) ||
                !is_array($this->listeners[$name]) ||
                        !count($this->listeners[$name])) {

            return false;
        }

        foreach ($this->listeners[$name] as $callable) {
            if (!$event->isStopped()) {
                \call_user_func($callable, $event);
                $event->setProcessed(true);
            }
        }

        return true;
    }
}
