<?php

namespace PhisbyTest;

use Phisby\Response;

class ResponseTest extends TestCase
{
    public function testCreateResponse()
    {
        $status  = 200;
        $body    = '{}';
        $reason  = 'OK';
        $headers = [
            'Content-Type' => ['application/json; charset=utf-8']
        ];

        $request = new Response($status, $body, $headers, $reason);

        $this->assertSame($body, $request->getBody());
        $this->assertSame($headers, $request->getHeaders());
        $this->assertSame($status, $request->getStatusCode());
        $this->assertSame($reason, $request->getReasonPhrase());

        $this->assertFalse($request->hasHeader('Host'));
        $this->assertTrue($request->hasHeader('Content-Type'));
        $this->assertEquals(['application/json; charset=utf-8'], $request->getHeader('Content-Type'));
    }
}
