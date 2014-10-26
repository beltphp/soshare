<?php
namespace Belt\Test;

use Belt\Soshare;
use Belt\Soshare\Twitter;
use Belt\Soshare\Facebook;

class SoshareTest extends \PHPUnit_Framework_TestCase
{
    /** @var Soshare */
    private $soshare;

    /** @var ClientInterface */
    private $networks;

    public function setup()
    {
        $this->soshare  = new Soshare();
        $this->networks = [
            $this->getMock('Belt\Soshare\NetworkInterface'),
            $this->getMock('Belt\Soshare\NetworkInterface'),
            $this->getMock('Belt\Soshare\NetworkInterface'),
        ];

        $this->networks[0]
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('foo'));

        $this->networks[1]
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('bar'));

        $this->networks[2]
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('baz'));

        $this->soshare->addNetwork($this->networks[0]);
        $this->soshare->addNetwork($this->networks[1]);
        $this->soshare->addNetwork($this->networks[2]);
    }

    public function testWithAllNetworks()
    {
        $this->networks[0]
            ->expects($this->once())
            ->method('getShares')
            ->with('http://apple.com')
            ->will($this->returnValue(13));

        $this->networks[1]
            ->expects($this->once())
            ->method('getShares')
            ->with('http://apple.com')
            ->will($this->returnValue(42));

        $this->networks[2]
            ->expects($this->once())
            ->method('getShares')
            ->with('http://apple.com')
            ->will($this->returnValue(1337));

        $this->assertNull($this->soshare->getNetwork('foobar'));
        $this->assertSame($this->networks[0], $this->soshare->getNetwork('foo'));
        $this->assertSame($this->networks[1], $this->soshare->getNetwork('bar'));
        $this->assertSame($this->networks[2], $this->soshare->getNetwork('baz'));

        $this->assertEquals([ 'foo', 'bar', 'baz' ], $this->soshare->getNetworks());

        $this->assertEquals(1392, $this->soshare->getShares('http://apple.com'));
    }

    /**
     * @dataProvider networkProvider
     */
    public function testWithSpecificNetworks($expected, $networks)
    {
        $this->networks[0]
            ->expects($this->any())
            ->method('getShares')
            ->with('http://apple.com')
            ->will($this->returnValue(13));

        $this->networks[1]
            ->expects($this->any())
            ->method('getShares')
            ->with('http://apple.com')
            ->will($this->returnValue(42));

        $this->networks[2]
            ->expects($this->any())
            ->method('getShares')
            ->with('http://apple.com')
            ->will($this->returnValue(1337));

        $this->assertEquals($expected, $this->soshare->getShares('http://apple.com', $networks));
    }

    public function networkProvider()
    {
        return [
            [ 13, [ 'foo' ]],
            [ 42, [ 'bar' ]],
            [ 1337, [ 'baz' ]],
            [ 55, [ 'foo', 'bar' ]],
            [ 1350, [ 'foo', 'baz' ]],
            [ 1379, [ 'bar', 'baz' ]],
        ];
    }
}
