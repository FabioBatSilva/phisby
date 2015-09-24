<?php

namespace PhisbyTest;

use Phisby\Phisby;
use Phisby\PhisbyTestCase;

class PhisbyTest extends PhisbyTestCase
{
    public function testSendRequestOptions()
    {
        $url      = '/users/1.json';
        $client   = $this->getMock('GuzzleHttp\ClientInterface');
        $phisby   = new Phisby($client);
        $response = $this->createResponse(200, [], []);
        $options  = [
            'headers'  => [
                'Content-Type' => 'application/json'
            ]
        ];

        $client
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('GET'), $this->equalTo($url), $this->equalTo($options))
            ->willReturn($response);

        $phisby->create()
            ->get($url, $options)
            ->expectStatus(200)
            ->send();
    }

    public function testWithOptionsRequestOptions()
    {
        $url      = '/users/1.json';
        $client   = $this->getMock('GuzzleHttp\ClientInterface');
        $phisby   = new Phisby($client);
        $response = $this->createResponse(200, [], []);
        $options  = [
            'headers'  => [
                'Content-Type' => 'application/json'
            ]
        ];

        $phisby->withOptions($options);

        $client
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('GET'), $this->equalTo($url), $this->equalTo($options))
            ->willReturn($response);

        $phisby->create()
            ->get($url)
            ->expectStatus(200)
            ->send();
    }

    public function testClear()
    {
        $url      = '/users/1.json';
        $mock     = $this->getMock('GuzzleHttp\ClientInterface');
        $client   = $this->getMock('GuzzleHttp\ClientInterface');
        $phisby   = new Phisby($client);
        $response = $this->createResponse(200, [], []);
        $options  = [
            'headers'  => [
                'Content-Type' => 'application/json'
            ]
        ];

        $phisby->withOptions($options);
        $phisby->get('/users/1.json');
        $f = $phisby->create();

        $this->assertEquals($url, $this->getPropertyValue($phisby, 'url'));
        $this->assertEquals('GET', $this->getPropertyValue($phisby, 'method'));
        $this->assertEquals($options, $this->getPropertyValue($phisby, 'options'));
        $this->assertEquals([$f], $this->getPropertyValue($phisby, 'children'));

        $phisby->clear();

        $this->assertNull($this->getPropertyValue($phisby, 'url'));
        $this->assertNull($this->getPropertyValue($phisby, 'method'));
        $this->assertEquals([], $this->getPropertyValue($phisby, 'options'));
        $this->assertEquals([], $this->getPropertyValue($phisby, 'children'));
    }

    public function testSendPostRequest()
    {
        $status  = 200;
        $url     = '/users/1.json';
        $data    = [
            'id'    => 1,
            'name'  => 'user 1'
        ];

        $types  = [
            'id'    => 'integer',
            'name'  => 'string'
        ];

        $headers = [
            'Content-Type' => ['application/json; charset=utf-8']
        ];

        $client   = $this->getMock('GuzzleHttp\ClientInterface');
        $phisby   = new Phisby($client);
        $response = $this->createResponse($status, $data, $headers);
        $options  = [
            'json' => $data
        ];

        $client
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('POST'), $this->equalTo($url), $this->equalTo($options))
            ->willReturn($response);

        $resp = $phisby->create()
            ->post($url, $data)
            ->expectStatus($status)
            ->expectHeaders($headers)
            ->expectJSONTypes('.', $types)
            ->expectJSON('.', $data)
            ->send();

        $this->assertInstanceOf('Phisby\Response', $resp);
        $this->assertEquals($status, $resp->getStatusCode());
        $this->assertEquals($headers, $resp->getHeaders());
        $this->assertEquals(json_encode($data), $resp->getBody());
        $this->assertEquals($data, $resp->json());
    }

    public function testSentPutRequest()
    {
        $status  = 200;
        $url     = '/users/2.json';
        $data    = [
            'id'    => 2,
            'name'  => 'user 2'
        ];

        $types  = [
            'id'    => 'integer',
            'name'  => 'string'
        ];

        $headers = [
            'Content-Type' => ['application/json; charset=utf-8']
        ];

        $client   = $this->getMock('GuzzleHttp\ClientInterface');
        $phisby   = new Phisby($client);
        $response = $this->createResponse($status, $data, $headers);
        $options  = [
            'json' => $data
        ];

        $client
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('PUT'), $this->equalTo($url), $this->equalTo($options))
            ->willReturn($response);

        $resp = $phisby->create()
            ->put($url, $data)
            ->expectStatus($status)
            ->expectHeaders($headers)
            ->expectJSONTypes('.', $types)
            ->expectJSON('.', $data)
            ->send();

        $this->assertInstanceOf('Phisby\Response', $resp);
        $this->assertEquals($status, $resp->getStatusCode());
        $this->assertEquals($headers, $resp->getHeaders());
        $this->assertEquals(json_encode($data), $resp->getBody());
        $this->assertEquals($data, $resp->json());
    }

    public function testSendPutRequest()
    {
        $status  = 200;
        $url     = '/users/3.json';
        $data    = [
            'id'    => 3,
            'name'  => 'user 3'
        ];

        $types  = [
            'id'    => 'integer',
            'name'  => 'string'
        ];

        $headers = [
            'Content-Type' => ['application/json; charset=utf-8']
        ];

        $client   = $this->getMock('GuzzleHttp\ClientInterface');
        $phisby   = new Phisby($client);
        $response = $this->createResponse($status, $data, $headers);
        $options  = [
            'json' => $data
        ];

        $client
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('PATCH'), $this->equalTo($url), $this->equalTo($options))
            ->willReturn($response);

        $resp = $phisby->create()
            ->patch($url, $data)
            ->expectStatus($status)
            ->expectHeaders($headers)
            ->expectJSONTypes('.', $types)
            ->expectJSON('.', $data)
            ->send();

        $this->assertInstanceOf('Phisby\Response', $resp);
        $this->assertEquals($status, $resp->getStatusCode());
        $this->assertEquals($headers, $resp->getHeaders());
        $this->assertEquals(json_encode($data), $resp->getBody());
        $this->assertEquals($data, $resp->json());
    }

    public function testSendPatchRequest()
    {
        $status  = 200;
        $url     = '/users/4.json';
        $data    = [
            'id'    => 4,
            'name'  => 'user 4'
        ];

        $types  = [
            'id'    => 'integer',
            'name'  => 'string'
        ];

        $headers = [
            'Content-Type' => ['application/json; charset=utf-8']
        ];

        $client   = $this->getMock('GuzzleHttp\ClientInterface');
        $phisby   = new Phisby($client);
        $response = $this->createResponse($status, $data, $headers);
        $options  = [
            'json' => $data
        ];

        $client
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('DELETE'), $this->equalTo($url), $this->equalTo($options))
            ->willReturn($response);

        $resp = $phisby->create()
            ->delete($url, $data)
            ->expectStatus($status)
            ->expectHeaders($headers)
            ->expectJSONTypes('.', $types)
            ->expectJSON('.', $data)
            ->send();

        $this->assertInstanceOf('Phisby\Response', $resp);
        $this->assertEquals($status, $resp->getStatusCode());
        $this->assertEquals($headers, $resp->getHeaders());
        $this->assertEquals(json_encode($data), $resp->getBody());
        $this->assertEquals($data, $resp->json());
    }

    public function testSendGetRequest()
    {
        $status  = 200;
        $url     = '/users/4.json';
        $data    = [
            'id'    => 4,
            'name'  => 'user 4'
        ];

        $types  = [
            'id'    => 'integer',
            'name'  => 'string'
        ];

        $headers = [
            'Content-Type' => ['application/json; charset=utf-8']
        ];

        $client   = $this->getMock('GuzzleHttp\ClientInterface');
        $phisby   = new Phisby($client);
        $response = $this->createResponse($status, $data, $headers);

        $client
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('GET'), $this->equalTo($url))
            ->willReturn($response);

        $resp = $phisby->create()
            ->get($url)
            ->expectStatus($status)
            ->expectHeaders($headers)
            ->expectJSONTypes('.', $types)
            ->expectJSON('.', $data)
            ->send();

        $this->assertInstanceOf('Phisby\Response', $resp);
        $this->assertEquals($status, $resp->getStatusCode());
        $this->assertEquals($headers, $resp->getHeaders());
        $this->assertEquals(json_encode($data), $resp->getBody());
        $this->assertEquals($data, $resp->json());
    }

    public function testSendOptionsRequest()
    {
        $status  = 200;
        $url     = '/users/4.json';
        $data    = [
            'id'    => 4,
            'name'  => 'user 4'
        ];

        $types  = [
            'id'    => 'integer',
            'name'  => 'string'
        ];

        $headers = [
            'Content-Type' => ['application/json; charset=utf-8']
        ];

        $client   = $this->getMock('GuzzleHttp\ClientInterface');
        $phisby   = new Phisby($client);
        $response = $this->createResponse($status, $data, $headers);

        $client
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('OPTIONS'), $this->equalTo($url))
            ->willReturn($response);

        $resp = $phisby->create()
            ->options($url)
            ->expectStatus($status)
            ->expectHeaders($headers)
            ->expectJSONTypes('.', $types)
            ->expectJSON('.', $data)
            ->send();

        $this->assertInstanceOf('Phisby\Response', $resp);
        $this->assertEquals($status, $resp->getStatusCode());
        $this->assertEquals($headers, $resp->getHeaders());
        $this->assertEquals(json_encode($data), $resp->getBody());
        $this->assertEquals($data, $resp->json());
    }

    public function testSendAllRequests()
    {
        $status  = 200;
        $url     = '/users/1.json';
        $data    = [
            'id'    => 1,
            'name'  => 'user 1'
        ];

        $types  = [
            'id'    => 'integer',
            'name'  => 'string'
        ];

        $headers = [
            'Content-Type' => ['application/json; charset=utf-8']
        ];

        $client   = $this->getMock('GuzzleHttp\ClientInterface');
        $phisby   = new Phisby($client);
        $response = $this->createResponse($status, $data, $headers);

        $client
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('GET'), $this->equalTo($url))
            ->willReturn($response);

        $phisby->create()
            ->get('/users/1.json')
            ->expectStatus(200)
            ->expectHeaders([
                'Content-Type' => 'application/json; charset=utf-8'
            ])
            ->expectJSONTypes('.', [
                'id'    => 'integer',
                'name'  => 'string'
            ])
            ->expectJSON('.',[
                'id'   => 1,
                'name' => 'user 1'
            ]);

        $responses = $phisby->sendAll();

        $this->assertCount(1, $responses);
        $this->assertInstanceOf('Phisby\Response', $responses[0]);
        $this->assertEquals(200, $responses[0]->getStatusCode());
    }

    /**
     * @param integer $status  Status code
     * @param mixed   $body    Response body
     * @param array   $headers Headers
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function createResponse($status, $body, array $headers)
    {
        $response = $this->getMock('Psr\Http\Message\ResponseInterface');

        if ($body !== null && ! is_string($body)) {
            $body = json_encode($body);
        }

        $response
            ->method('getStatusCode')
            ->willReturn($status);

        $response
            ->method('getHeaders')
            ->willReturn($headers);

        $response
            ->method('getBody')
            ->willReturn($body);

        return $response;
    }

    /**
     * @param object $object
     * @param string $property
     *
     * @return mixed
     */
    protected function getPropertyValue($object, $property)
    {
        $reflection = new \ReflectionProperty($object, $property);

        $reflection->setAccessible(true);

        return $reflection->getValue($object);
    }
}
