<?php

namespace Phisby;

use RuntimeException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

/**
 * Phisby Response
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class Response
{
    /**
     * @var string Reason phrase
     */
    private $reasonPhrase;

    /**
     * @var integer HTTP status code
     */
    private $statusCode = 200;

    /**
     * @var array HTTP header
     */
    private $headers = [];

    /**
     * @var mixed
     */
    private $body;

    /**
     * @param integer $status  Status code
     * @param mixed   $body    Response body
     * @param array   $headers Headers
     * @param string  $reason  Reason phrase
     */
    public function __construct($status, $body = null, array $headers = [], $reason = null)
    {
        $this->statusCode   = $status;
        $this->body         = $body;
        $this->headers      = $headers;
        $this->reasonPhrase = $reason;
    }

    /**
     * Get HTTP status code
     *
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string Get Reason phrase
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    /**
     * Get HTTP headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get HTTP header
     *
     * @param string $header
     *
     * @return string
     */
    public function getHeader($header)
    {
        return isset($this->headers[$header]) ? $this->headers[$header] : [];
    }

    /**
     * Check if the HTTP header exists
     *
     * @param string $header
     *
     * @return boolean
     */
    public function hasHeader($header)
    {
        return isset($this->headers[$header]);
    }

    /**
     * Get HTTP response body
     *
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Extract JSON data
     *
     * @return array
     */
    public function json()
    {
        $decoded = json_decode($this->body, true);
        $error   = json_last_error();

        if ($error === JSON_ERROR_NONE) {
            return $decoded;
        }

        if ($error === JSON_ERROR_DEPTH) {
            throw new RuntimeException('Could not decode JSON, maximum stack depth exceeded.');
        }

        if ($error === JSON_ERROR_STATE_MISMATCH) {
            throw new RuntimeException('Could not decode JSON, underflow or the nodes mismatch.');
        }

        if ($error === JSON_ERROR_DEPTH) {
            throw new RuntimeException('Could not decode JSON, maximum stack depth exceeded.');
        }

        if ($error === JSON_ERROR_CTRL_CHAR) {
            throw new RuntimeException('Could not decode JSON, unexpected control character found.');
        }

        if ($error === JSON_ERROR_SYNTAX) {
            throw new RuntimeException('Could not decode JSON, syntax error - malformed JSON.');
        }

        if ($error === JSON_ERROR_UTF8) {
            throw new RuntimeException('Could not decode JSON, malformed UTF-8 characters (incorrectly encoded?)');
        }

        throw new RuntimeException('Could not decode JSON.');
    }
}
