<?php
namespace Belt\Soshare;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Belt\Matter;

/**
 * @author Ramon Kleiss <ramonkleiss@gmail.com>
 */
class Facebook implements NetworkInterface
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
        return 'facebook';
    }

    /**
     * {@inheritDoc}
     */
    public function getShares($url)
    {
        try {
            $json = $this->client->get($this->getUrl($url))->json();
        } catch (\Exception $e) {
            return 0;
        }

        return Matter::create($json)->get('shares')->get() ?: 0;
    }

    /**
     * @param string
     *
     * @return string
     */
    private function getUrl($url)
    {
        return sprintf('http://graph.facebook.com/?id=%s', $url);
    }
}
