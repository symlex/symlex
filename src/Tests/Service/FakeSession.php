<?php

namespace App\Tests\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;

class FakeSession implements SessionInterface
{
    protected bool $started = false;
    protected string $sessionId = 'fake-session-id';
    protected string $sessionName = 'fake-session-name';
    protected array $attributes = array('user_id' => 1);
    protected array $bags = array();

    /**
     * Starts the session storage.
     *
     * @return bool    True if session started.
     *
     * @throws \RuntimeException If session fails to start.
     *
     * @api
     */
    public function start()
    {
        $this->started = true;
    }

    /**
     * Returns the session ID.
     *
     * @return string The session ID.
     *
     * @api
     */
    public function getId()
    {
        return $this->sessionId;
    }

    /**
     * Sets the session ID
     *
     * @param string $id
     *
     * @api
     */
    public function setId($id)
    {
        $this->sessionId = $id;
    }

    /**
     * Returns the session name.
     *
     * @return mixed The session name.
     *
     * @api
     */
    public function getName()
    {
        return $this->sessionName;
    }

    /**
     * Sets the session name.
     *
     * @param string $name
     *
     * @api
     */
    public function setName($name)
    {
        $this->sessionName = $name;
    }

    /**
     * Invalidates the current session.
     *
     * Clears all session attributes and flashes and regenerates the
     * session and deletes the old session from persistence.
     *
     * @param int $lifetime Sets the cookie lifetime for the session cookie. A null value
     *                          will leave the system settings unchanged, 0 sets the cookie
     *                          to expire with browser session. Time is in seconds, and is
     *                          not a Unix timestamp.
     *
     * @return bool    True if session invalidated, false if error.
     *
     * @api
     */
    public function invalidate($lifetime = null)
    {

    }

    /**
     * Migrates the current session to a new session id while maintaining all
     * session attributes.
     *
     * @param bool $destroy Whether to delete the old session or leave it to garbage collection.
     * @param int $lifetime Sets the cookie lifetime for the session cookie. A null value
     *                          will leave the system settings unchanged, 0 sets the cookie
     *                          to expire with browser session. Time is in seconds, and is
     *                          not a Unix timestamp.
     *
     * @return bool    True if session migrated, false if error.
     *
     * @api
     */
    public function migrate(bool $destroy = false, $lifetime = null)
    {

    }

    /**
     * Force the session to be saved and closed.
     *
     * This method is generally not required for real sessions as
     * the session will be automatically saved at the end of
     * code execution.
     */
    public function save()
    {

    }

    /**
     * Checks if an attribute is defined.
     *
     * @param string $name The attribute name
     *
     * @return bool    true if the attribute is defined, false otherwise
     *
     * @api
     */
    public function has($name)
    : bool {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Returns an attribute.
     *
     * @param string $name The attribute name
     * @param mixed $default The default value if not found.
     *
     * @return mixed
     *
     * @api
     */
    public function get($name, $default = null)
    {
        if ($this->has($name)) {
            return $this->attributes[$name];
        }

        return $default;
    }

    /**
     * Sets an attribute.
     *
     * @param string $name
     * @param mixed $value
     *
     * @api
     */
    public function set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Returns attributes.
     *
     * @return array Attributes
     *
     * @api
     */
    public function all()
    {
        return $this->attributes;
    }

    /**
     * Sets attributes.
     *
     * @param array $attributes Attributes
     */
    public function replace(array $attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->set($name, $value);
        }
    }

    /**
     * Removes an attribute.
     *
     * @param string $name
     *
     * @return mixed The removed value or null when it does not exist
     *
     * @api
     */
    public function remove($name) {
        unset($this->attributes[$name]);
    }

    /**
     * Clears all attributes.
     *
     * @api
     */
    public function clear() {
        $this->attributes = array();
    }

    /**
     * Checks if the session was started.
     *
     * @return bool
     */
    public function isStarted() {
        return $this->started;
    }

    /**
     * Registers a SessionBagInterface with the session.
     *
     * @param SessionBagInterface $bag
     */
    public function registerBag(SessionBagInterface $bag) {
        $this->bags[$bag->getName()] = $bag;
    }

    /**
     * Gets a bag instance by name.
     *
     * @param string $name
     *
     * @return SessionBagInterface
     */
    public function getBag($name) {
        return $this->bags[$bag->getName()];
    }

    /**
     * Gets session meta.
     *
     * @return MetadataBag
     */
    public function getMetadataBag() {
        $result = new MetadataBag();
        return $result;
    }
}