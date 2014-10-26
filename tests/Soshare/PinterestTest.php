<?php
namespace Belt\Test\Soshare;

use Belt\Soshare\Pinterest;

class PinterestTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    private $network;

    public function setup()
    {
        $this->client  = $this->getMock('GuzzleHttp\ClientInterface');
        $this->network = new Pinterest($this->client);
    }

    public function testDeclareName()
    {
        $this->assertEquals('pinterest', $this->network->getName());
    }

    public function testGetShares()
    {
        $response = $this->getMock('GuzzleHttp\Message\ResponseInterface');
        $response
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue(
                file_get_contents(__DIR__.'/../fixtures/pinterest.json')
            ));

        $this->client
            ->expects($this->any())
            ->method('get')
            ->with('http://api.pinterest.com/v1/urls/count.json?url=http://apple.com')
            ->will($this->returnValue($response));

        $this->assertEquals(704, $this->network->getShares('http://apple.com'));
    }

    public function testReturnZeroOnException()
    {
        $this->client
            ->expects($this->any())
            ->method('get')
            ->will($this->throwException(new \RuntimeException()));

        $this->assertEquals(0, $this->network->getShares('http://apple.com'));
    }
}
