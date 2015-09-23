<?php

namespace Phisby;

use GuzzleHttp\Client;
use PHPUnit_Framework_TestCase;

/**
 * Phisby TestCase
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
abstract class PhisbyTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var $phisby \Phisby\Phisby
     */
    protected $phisby;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->phisby = $this->createPhisby();
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    protected function createClient()
    {
        return new Client();
    }

    /**
     * @return \Phisby\Phisby
     */
    protected function createPhisby()
    {
        $client = $this->createClient();
        $phisby = new Phisby($client);

        return $phisby;
    }
}
