<?php

namespace Phisby;

/**
 * Phisby data access
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class DataAccess
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get data
     *
     * @param string $path
     *
     * @return mixed
     */
    public function get($path)
    {
        if ($path == '.') {
            return $this->data;
        }

        return $this->getData($this->data, $path);
    }

    /**
     * Get data recursively
     *
     * @param mixed  $data
     * @param string $path
     * @param string $context
     *
     * @return mixed
     */
    public function getData($data, $path, $context = '')
    {
        $segments = explode('.', $path);
        $current  = array_shift($segments);
        $remainig = $segments ? implode('.', $segments) : null;
        $context  = $context ? $context . '.' . $current : $current;

        if (preg_match('/^(.+)\[(.*?)\]$/', $current, $matches)) {
            $current = $matches[2];
            $data    = $this->getData($data, $matches[1], $context);
        }

        if ( ! is_array($data) || ! array_key_exists($current, $data)) {
            throw new \OutOfBoundsException("Undefined index at '$context'");
        }

        $data    = $data[$current];
        $path    = $remainig;

        if ($path == null) {
            return $data;
        }

        return $this->getData($data, $path, $context);
    }
}
