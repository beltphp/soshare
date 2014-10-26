<?php
namespace Belt\Soshare;

/**
 * @author Ramon Kleiss <ramonkleiss@gmail.com>
 */
interface NetworkInterface
{
    /**
     * Get the name of the network.
     *
     * @return string
     */
    public function getName();

    /**
     * Get the number of shares for the given URL.
     *
     * @param string
     *
     * @return integer
     */
    public function getShares($url);
}
