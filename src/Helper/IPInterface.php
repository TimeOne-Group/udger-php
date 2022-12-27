<?php

namespace Udger\Helper;

/**
 * @author tiborb
 */
interface IPInterface
{
    public const IPv4 = 4;
    public const IPv6 = 6;

    public function getIpVersion($ip);

    public function getIpLong($ip);

    public function getIp6array($ip);
}
