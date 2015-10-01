<?php

namespace PhisbyTest\Functional;

use Phisby\Phisby;
use Phisby\PhisbyTestCase;

/**
 * @group functional
 */
class PhisbyTest extends PhisbyTestCase
{
    public function testPostRequest()
    {
        $response = $this->phisby->create()
            ->post('http://httpbin.org/post', [
                'arr'  => [1,2,3],
                'str'  => 'string',
                'int'  => 123
            ])
            ->expectStatus(200)
            ->expectJSONTypes('json', [
                'arr' => 'array',
                'str' => 'string',
                'int' => 'integer'
            ])
            ->send();

        $this->assertInstanceOf('Phisby\Response', $response);
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
