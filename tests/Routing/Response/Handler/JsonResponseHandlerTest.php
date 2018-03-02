<?php

/*
 * slim-routing (https://github.com/juliangut/slim-routing).
 * Slim framework routing.
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/slim-routing
 * @author Julián Gutiérrez <juliangut@gmail.com>
 */

declare(strict_types=1);

namespace Jgut\Slim\Routing\Tests\Response\Handler;

use Jgut\Slim\Routing\Response\Handler\JsonResponseHandler;
use Jgut\Slim\Routing\Response\PayloadResponse;
use Jgut\Slim\Routing\Tests\Stubs\ResponseStub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Generic JSON response handler tests.
 */
class JsonResponseHandlerTest extends TestCase
{
    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->request = $this->getMockBuilder(ServerRequestInterface::class)
            ->getMock();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Response type should be an instance of Jgut\Slim\Routing\Response\PayloadResponse
     */
    public function testInvalidResponseType()
    {
        (new JsonResponseHandler())->handle(new ResponseStub($this->request));
    }

    public function testHandleCollapsed()
    {
        $response = (new JsonResponseHandler())
            ->handle(new PayloadResponse(['data' => ['param' => 'value']], $this->request));

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals('{"data":{"param":"value"}}', (string) $response->getBody());
    }

    public function testHandlePrettified()
    {
        $response = (new JsonResponseHandler(true))
            ->handle(new PayloadResponse(['data' => ['param' => 'value']], $this->request));

        self::assertInstanceOf(ResponseInterface::class, $response);

        $responseContent = <<<'JSON'
{
    "data": {
        "param": "value"
    }
}
JSON;
        self::assertEquals($responseContent, (string) $response->getBody());
    }
}
