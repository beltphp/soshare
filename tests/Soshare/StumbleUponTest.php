<?php
namespace Belt\Test\Soshare;

use Belt\Soshare\StumbleUpon;

class StumbleUponTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    private $network;

    public function setup()
    {
        $this->client  = $this->getMock('GuzzleHttp\ClientInterface');
        $this->network = new StumbleUpon($this->client);
    }

    public function testDeclareName()
    {
        $this->assertEquals('stumbleupon', $this->network->getName());
    }

    public function testGetShares()
    {
        $response = $this->getMock('GuzzleHttp\Message\ResponseInterface');
        $response
            ->expects($this->any())
            ->method('json')
            ->will($this->returnValue(json_decode(
                file_get_contents(__DIR__.'/../fixtures/stumbleupon.json')
            )));

        $this->client
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValue($response));

        $this->assertEquals(43035, $this->network->getShares('http://example.org'));
    }

    public function testReturnZeroOnException()
    {
        $this->client
            ->expects($this->any())
            ->method('get')
            ->will($this->throwException(new \RuntimeException()));

        $this->assertEquals(0, $this->network->getShares('http://examples.org'));
    }
}
