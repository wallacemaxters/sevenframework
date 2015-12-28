<?php


namespace WallaceMaxters\SevenFramework\Http;


use InvalidArgumentException;
use DateTime;

/**
 * Represents a cookie.
 *
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 */
class Cookie
{

    protected $name;

    protected $value;

    protected $domain;

    protected $expire;

    protected $path;

    protected $secure = false;

    protected $httpOnly = true;

    public function __construct(string $name, string $value = null, $expire = 0, string $path = '/')
    {
        
        $this->setName($name);

        $this->setPath($path);

        $this->value = $value;

        $this->expire = new DateTime($expire);
    }

    /**
     * Returns the cookie as a string.
     *
     * @return string The cookie
     */
    public function __toString()
    {
        $str = urlencode($this->getName()) . '=';

        if (! $this->getValue()) {

            ///$str .= 'deleted; expires=' . gmdate('D, d-M-Y H:i:s T', time() - 31536001);

            $str .= 'deleted; expires=' . (new DateTime('-1 year'))->format('D, d-M-Y H:i:s T');

        } else {

            $str .= urlencode($this->getValue());

            if ($this->getExpiresTime() !== 0) {
                //$str .= '; expires=' . gmdate('D, d-M-Y H:i:s T', $this->getExpiresTime());
                $str .= '; expires=' . $this->getExpiresTime()->format('D, d-M-Y H:i:s T');
            }
        }

        if ($this->path) {
            $str .= '; path=' . $this->path;
        }

        if ($this->domain) {
            $str .= '; domain=' . $this->domain;
        }

        if ($this->isSecure()) {
            $str .= '; secure';
        }

        if ($this->isHttpOnly()) {
            $str .= '; httponly';
        }

        return $str;
    }

    /**
     * Gets the name of the cookie.
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Gets the value of the cookie.
     *
     * @return string
     *
     * @api
     */
    public function getValue() : string
    {
        return $this->value;
    }

    /**
     * Gets the domain that the cookie is available to.
     *
     * @return string
     *
     * @api
     */
    public function getDomain() : string
    {
        return $this->domain;
    }

    /**
     * @return int
     */
    public function getExpiresTime() : string
    {
        return $this->expire;
    }

    /**
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * @return bool
     */
    public function isSecure() : bool
    {
        return $this->secure;
    }

    /**
     * @return bool
     */
    public function isHttpOnly() : bool
    {
        return $this->httpOnly;
    }

    /**
     * @return bool
     */
    public function isExpired() : bool
    {
        return $this->expire < new DateTime;
    }


    public function setPath(string $path)
    {
        $this->path = ($path === '') ? '/' : $path;
    }

    public function setSecure(boolean $secure)
    {
        $this->secure = $secure;
    }

    public function setHttpOnly(boolean $httponly)
    {
        $this->httpOnly = $httponly;
    }

    public function setName(string $name)
    {
        if (preg_match("/[=,; \t\r\n\013\014]/", $name)) {

            throw new InvalidArgumentException(
                "The cookie name \"{$name}\" contains invalid characters."
            );

        } elseif ($name === '') {
            throw new InvalidArgumentException('The cookie name cannot be empty.');
        }

        $this->name = $name;
    }

    public function setExpiresFromDateTime(DateTime $date)
    {
        // prevent modify after set

        $this->expire = clone $date;   
    }

    public function setExpires(string $time)
    {
        $this->expire = new DateTime($time);
    }

    public function setDomain(string $domain)
    {
        $this->domain = $domain;

        return $this;
    }

}
