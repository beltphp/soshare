<?php
namespace Belt\Test\Soshare;

use Belt\Soshare\LinkedIn;

class LinkedInTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    private $network;

    public function setup()
    {
        $this->client  = $this->getMock('GuzzleHttp\ClientInterface');
        $this->network = new LinkedIn($this->client);
    }

    public function testDeclareName()
    {
        $this->assertEquals('linkedin', $this->network->getName());
    }

    public function testGetShares()
    {
        $response = $this->getMock('GuzzleHttp\Message\ResponseInterface');
        $response
            ->expects($this->any())
            ->method('json')
            ->will($this->returnValue(json_decode(
                file_get_contents(__DIR__.'/../fixtures/linkedin.json')
            )));

        $this->client
            ->expects($this->any())
            ->method('get')
            ->with('http://www.linkedin.com/countserv/count/share?format=json&url=http://apple.com')
            ->will($this->returnValue($response));

        $this->assertEquals(748, $this->network->getShares('http://apple.com'));
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
