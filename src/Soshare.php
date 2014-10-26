<?php
namespace Belt;

use Belt\_;
use Belt\Matter;
use Belt\Soshare\NetworkInterface;

/**
 * @author Ramon Kleiss <ramonkleiss@gmail.com>
 */
class Soshare
{
    /** @var NetworkInterface[] */
    private $networks = array();

    /**
     * Get the number of shares for a given URL.
     *
     * @param string The URL to get the number of shares for.
     * @param array  (optional) The name (or an array of names) for the
     *               network(s) to check.
     *
     * @return integer
     */
    public function getShares($url, array $networks = array())
    {
        $networks = count($networks) ? $networks : $this->getNetworks();

        return _::create($networks)->map(function ($n) {
            return $this->getNetwork($n);
        })->reduce(function ($s, $n) use ($url) {
            return $s + $n->getShares($url);
        }, 0);
    }

    /**
     * Get shares seperated by network.
     *
     * @param string The URL to get the number of shares for.
     * @param array  (optional) The name (or an array of names) for the
     *               network(s) to check.
     *
     * @return array
     */
    public function getSharesByNetwork($url, array $networks = array())
    {
        $networks = count($networks) ? $networks : $this->getNetworks();

        return _::create($networks)->map(function ($n) {
            return $this->getNetwork($n);
        })->inject(array(), function ($r, $n) use ($url) {
            $r[$n->getName()] = $n->getShares($url);

            return $r;
        });
    }

    /**
     * Register a new social network.
     *
     * @param NetworkInterface
     */
    public function addNetwork(NetworkInterface $network)
    {
        $this->networks[$network->getName()] = $network;
    }

    /**
     * Get a network by it's name.
     *
     * @param string
     *
     * @return NetworkInterface|null
     */
    public function getNetwork($network)
    {
        return Matter::create($this->networks)->get($network)->get();
    }

    /**
     * Get a list of registered social networks.
     *
     * @return string[]
     */
    public function getNetworks()
    {
        return array_keys($this->networks);
    }
}
