<?php
namespace Belt\Test\Soshare;

use Belt\Soshare\Twitter;

class TwitterTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    private $network;

    public function setup()
    {
        $this->client  = $this->getMock('GuzzleHttp\ClientInterface');
        $this->network = new Twitter($this->client);
    }

    public function testDeclareName()
    {
        $this->assertEquals('twitter', $this->network->getName());
    }

    public function testGetShares()
    {
        $response = $this->getMock('GuzzleHttp\Message\ResponseInterface');
        $response
            ->expects($this->any())
            ->method('json')
            ->will($this->returnValue(json_decode(
                file_get_contents(__DIR__.'/../fixtures/twitter.json')
            )));

        $this->client
            ->expects($this->any())
            ->method('get')
            ->with('http://cdn.api.twitter.com/1/urls/count.json?url=http://apple.com')
            ->will($this->returnValue($response));

        $this->assertEquals(1836, $this->network->getShares('http://apple.com'));
    }

    public function testReturnZeroOnException()
    {
        $this->client
            ->expects($this->any())
            ->method('get')
            ->with('http://cdn.api.twitter.com/1/urls/count.json?url=http://apple.com')
            ->will($this->throwException(new \RuntimeException()));

        $this->assertEquals(0, $this->network->getShares('http://apple.com'));
    }
}
