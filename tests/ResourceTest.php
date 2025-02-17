<?php
/*
 * This file is part of tiktokshop-client.
 *
 * (c) Jin <j@sax.vn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NVuln\TiktokShop\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use NVuln\TiktokShop\Errors\ResponseException;
use NVuln\TiktokShop\Resource;
use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    protected $resource;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resource = $this->getMockForAbstractClass(Resource::class);
    }

    public function testCall()
    {
        $client = new Client([
            'handler' => HandlerStack::create(new MockHandler([
                new Response(200, [], '{"code": 100000, "message": "error message"}'),
            ]))
        ]);

        $this->resource->useHttpClient($client);

        $this->expectException(ResponseException::class);
        $this->resource->call('GET', 'http://fake_request.com');
    }
}
