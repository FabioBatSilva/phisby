<?php

namespace PhisbyTest\Functional;

use Phisby\Phisby;
use Phisby\PhisbyTestCase;

/**
 * @group functional
 */
class PhisbyTest extends PhisbyTestCase
{
    public function testGithubUser()
    {
        $phisby = new Phisby();
        $phisby
            ->get('https://api.github.com/users/FabioBatSilva')
            ->expectStatus(200)
            ->expectHeaders([
                'Content-Type' => 'application/json; charset=utf-8'
            ])
            ->expectJSONTypes('.', [
                'id'    => 'integer',
                'login' => 'string',
                'url'   => 'string'
            ])
            ->expectJSON('.', [
                'id'    => '588172',
                'login' => 'FabioBatSilva',
                'url'   => 'https://api.github.com/users/FabioBatSilva',
            ]);

        $this->assertInstanceOf('Phisby\Response', $phisby->send());
    }

    public function testGithubSearch()
    {
        $this->phisby->create()
            ->get('https://api.github.com/search/repositories?q=doctrine+language:php&sort=stars&order=desc&per_page=1')
            ->expectStatus(200)
            ->expectHeaders([
                'Content-Type' => 'application/json; charset=utf-8'
            ])
            ->expectBodyContains('doctrine')
            ->expectJSONTypes('.', [
                'total_count'        => 'integer',
                'incomplete_results' => 'boolean',
                'items'              => 'array'
            ])
            ->expectJSONTypes('items[0]', [
                'id'      => 'integer',
                'name'    => 'string',
                'private' => 'boolean'
            ])
            ->expectJSON('items[0]',[
                'id'    => 597887,
                'name'  => 'doctrine2'
            ]);

        $responses = $this->phisby->sendAll();

        $this->assertCount(1, $responses);
        $this->assertInstanceOf('Phisby\Response', $responses[0]);
    }
}
