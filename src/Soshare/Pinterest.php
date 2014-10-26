<?php
namespace Belt\Soshare;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * @author Ramon Kleiss <ramonkleiss@gmail.com>
 */
class Pinterest implements NetworkInterface
{
    /** @var ClientInterface */
    private $client;

    /**
     * @param ClientInterface
     */
    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'pinterest';
    }

    /**
     * {@inheritDoc}
     */
    public function getShares($url)
    {
        try {
            $content = $this->client->get($this->getUrl($url))->getBody();
        } catch (\Exception $e) {
            return 0;
        }

        if (preg_match('/"count":(\d+)/', $content, $matches)) {
            return (integer) $matches[1];
        } else {
            return 0;
        }
    }

    /**
     * @param string
     *
     * @return string
     */
    private function getUrl($url)
    {
        return sprintf('http://api.pinterest.com/v1/urls/count.json?url=%s', $url);
    }
}
