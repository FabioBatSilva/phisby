<?php

namespace Phisby;

use RuntimeException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Phisby\Constraint\StatusCodeConstraint;
use Phisby\Constraint\HeadersConstraint;
use Phisby\Constraint\JSONTypesConstraint;
use Phisby\Constraint\BodyContainsConstraint;
use Phisby\Constraint\JSONConstraint;

/**
 * Phisby is a library designed to easily test REST API endpoints
 *
 * Example:
 * <code>
 * <?php
 * use Phisby\Phisby;
 *
 * $frisby = new Phisby();
 *
 * $frisby
 *   ->get('http://localhost/api/1.0/users/3.json')
 *   ->expectStatus(200)
 *   ->expectJSONTypes('.', [
 *     'id'        => 'integer',
 *     'username'  => 'string',
 *     'is_admin'  => 'boolean'
 *   ])
 *   ->expectJSON('.', [
 *     'id'        => 3,
 *     'username'  => 'johndoe',
 *     'is_admin'  => false
 *   ])
 *   ->send();
 *
 * </code>
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class Phisby
{
    /**
     * @var array Request options
     */
    private $client;

    /**
     * @var \Phisby\Phisby[]
     */
    private $children = [];

    /**
     * @var \Phisby\Expectation
     */
    private $expectation;

    /**
     * @var array Request options
     */
    private $options = [];

    /**
     * @var string Request method
     */
    private $method;

    /**
     * @var array Request data
     */
    private $data;

    /**
     * @var string Request url
     */
    private $url;

    /**
     * @var callable Assertion failure callback
     */
    private $onFailureCallback;

    /**
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client      = $client;
        $this->expectation = new Expectation();
    }

    /**
     * Creates a new Phisby
     *
     * @return \Phisby\Phisby
     */
    public function create()
    {
        $phisby = new Phisby($this->client);

        $phisby->withOptions($this->options);

        $this->children[] = $phisby;

        return $phisby;
    }

    /**
     * @return \Phisby\Response[]
     */
    public function sendAll()
    {
        $responses = [];

        foreach ($this->children as $phisby) {
            $responses[] = $phisby->send();
        }

        return $responses;
    }

    /**
     * @return \Phisby\Response
     */
    public function send()
    {
        $options = $this->options;
        $method  = $this->method;
        $url     = $this->url;

        if ($this->data !== null) {
            $options['json'] = $this->data;
        }

        try {
            $resp = $this->client->request($method, $url, $options);
        } catch (RequestException $e) {
            if (!$e->hasResponse()) {
                throw $e;
            }

            $resp = $e->getResponse();
        }

        $status   = $resp->getStatusCode();
        $body     = $resp->getBody();
        $headers  = $resp->getHeaders();
        $reason   = $resp->getReasonPhrase();
        $response = new Response($status, $body, $headers, $reason);

        try {
            $this->expectation->assert($response);
        } catch (RuntimeException $e) {
            if ($this->onFailureCallback == null) {
                throw $e;
            }

            call_user_func_array($this->onFailureCallback, [$e, $response]);
        }

        return $response;
    }

    /**
     * Assertion failure callback
     *
     * @param callable $callable
     *
     * @return \Phisby\Phisby
     */
    public function onFailure(callable $callable)
    {
        $this->onFailureCallback = $callable;

        return $this;
    }

    /**
     * Reset phisby
     *
     * @return \Phisby\Phisby
     */
    public function clear()
    {
        $this->children = [];
        $this->options  = [];
        $this->url      = null;
        $this->method   = null;

        $this->expectation->clear();

        return $this;
    }

    /**
     * Set the request options
     *
     * @param array $options
     *
     * @return \Phisby\Phisby
     */
    public function withOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * HTTP GET Request
     *
     * @param string $url
     * @param array  $options
     *
     * @return \Phisby\Phisby
     */
    public function get($url, array $options = [])
    {
        $this->url     = $url;
        $this->method  = 'GET';
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * HTTP PUT Request
     *
     * @param string $url
     * @param array  $data
     * @param array  $options
     *
     * @return \Phisby\Phisby
     */
    public function put($url, array $data = [], array $options = [])
    {
        $this->url     = $url;
        $this->method  = 'PUT';
        $this->data    = $data;
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * HTTP POST Request
     *
     * @param string $url
     * @param array  $data
     * @param array  $options
     *
     * @return \Phisby\Phisby
     */
    public function post($url, array $data = [], array $options = [])
    {
        $this->url     = $url;
        $this->method  = 'POST';
        $this->data    = $data;
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * HTTP PATCH Request
     *
     * @param string $url
     * @param array  $data
     * @param array  $options
     *
     * @return \Phisby\Phisby
     */
    public function patch($url, array $data = [], array $options = [])
    {
        $this->url     = $url;
        $this->method  = 'PATCH';
        $this->data    = $data;
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * HTTP DELETE Request
     *
     * @param string $url
     * @param array  $data
     * @param array  $options
     *
     * @return \Phisby\Phisby
     */
    public function delete($url, array $data = [], array $options = [])
    {
        $this->url     = $url;
        $this->method  = 'DELETE';
        $this->data    = $data;
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * HTTP OPTIONS Request
     *
     * @param string $url
     * @param array  $options
     *
     * @return \Phisby\Phisby
     */
    public function options($url, array $options = [])
    {
        $this->url     = $url;
        $this->method  = 'OPTIONS';
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * Assert the HTTP status code
     *
     * @param integer $statusCode
     *
     * @return \Phisby\Phisby
     */
    public function expectStatus($statusCode)
    {
        $this->expectation->add(new StatusCodeConstraint((int) $statusCode));

        return $this;
    }

    /**
     * Assert the HTTP response body as JSON and check values
     *
     * @param string $path
     * @param string $data
     *
     * @return \Phisby\Phisby
     */
    public function expectJSON($path, array $data)
    {
        $this->expectation->add(new JSONConstraint($path, $data));

        return $this;
    }

    /**
     * Assert the HTTP response body as JSON and check types
     *
     * @param string $path
     * @param string $types
     *
     * @return \Phisby\Phisby
     */
    public function expectJSONTypes($path, array $types)
    {
        $this->expectation->add(new JSONTypesConstraint($path, $types));

        return $this;
    }

    /**
     * Assert the HTTP response headers
     *
     * @param array $headers
     *
     * @return \Phisby\Phisby
     */
    public function expectHeaders($headers)
    {
        $this->expectation->add(new HeadersConstraint($headers));

        return $this;
    }

    /**
     * Assert the response body contains
     *
     * @param string $content
     *
     * @return \Phisby\Phisby
     */
    public function expectBodyContains($content)
    {
        $this->expectation->add(new BodyContainsConstraint($content));

        return $this;
    }
}
