<?php

namespace WallaceMaxters\SevenFramework\Http;

use BadMethodCallException;
use WallaceMaxters\SevenFramework\Http\Parameters\{Parameters,Header,Server,Files};

/**
 * Representa a requisição do cliente
 * */

class Request
{

    /**
    * Method of request
    * @var string
    */
    protected $method = 'GET';

    /**
    * @var \WallaceMaxters\SevenFramework\Http\Parameters\Server
    */
    protected $server;

    /**
    * @var \WallaceMaxters\SevenFramework\Http\Parameters\Parameters
    */
    protected $query;

    /**
    * @var \WallaceMaxters\SevenFramework\Http\Parameters\Parameters
    */
    protected $request;

    /**
    * @var \WallaceMaxters\SevenFramework\Http\Parameters\Parameters
    */
    protected $cookie;

    /**
    * @param string $method
    */

    public function __construct()
    {
        $this->setQuery(new Parameters($_GET))
             ->setRequest(new Parameters($_POST))
             ->setServer(new Server($_SERVER))
             ->setCookie(new Parameters($_COOKIE))
             ->setFiles(new Files($_FILES));
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    public function isMethod($method)
    {
        return $this->getMethod() == strtoupper($method);
    }

    public function setQuery(Parameters $query)
    {
        $this->query = $query;

        return $this;
    }

    public function getQuery(): Parameters
    {
        return $this->query;
    }

    public function setRequest(Parameters $request)
    {
        $this->request = $request;

        return $this;
    }

    public function getRequest() : Parameters
    {
        return $this->request;
    }

    public function setServer(Server $server)
    {
        $this->server = $server;

        return $this;
    }

    public function getServer() : Parameters
    {
        return $this->server;
    }


    public function setCookie(Parameters $cookie)
    {
        $this->cookie = $cookie;

        return $this;
    }

    public function getCookie(): Parameters
    {
        return $this->cookie;
    }


    public function setFiles(Files $files)
    {
        $this->files = $files;

        return $this;
    }

    public function getFiles() : Files
    {
        return $this->files;
    }

    public function getUri()
    {
        return $this->server->get('REQUEST_URI') ?? '/';
    }

    public function getScheme() : string
    {
        return $this->isSecure() ? 'https' : 'http';
    }

    public function getHost()
    {
        return $this->server->get('HTTP_HOST');
    }

    public function getSchemeAndHost()
    {
        return $this->getScheme() . '://' . $this->getHost();
    }

    public function isSecure() : bool
    {   
        return $this->server->get('HTTPS', 'off') === 'on';
    }

    public function getPathinfo() : string
    {
        return $this->server->get('PATH_INFO') ?? '/';
    }

    public function isAjax() : boolean
    {
        return $this->getServer('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest';
    }

    public function __get(string $name)
    {
        $externalVariables = ['request', 'query', 'cookie', 'server', 'files'];

        if (in_array($name, $externalVariables)) {

            return $this->$name;
        }
    }


}


