<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Udger\Helper\IP;
use Udger\Helper\IPInterface;

/**
 *
 * @author tiborb
 */
class IPTest extends Unit
{
    /**
     * @var IP
     */
    protected IP $object;

    protected function _before(): void
    {
        $this->object = new IP();
    }

    public function testInterface(): void
    {
        self::assertInstanceOf(IPInterface::class, $this->object);
    }

    public function testGetInvalidIpVerison(): void
    {
        self::assertFalse($this->object->getIpVersion("banana"));
    }

    public function testGetEmptyIpVerison(): void
    {
        self::assertFalse($this->object->getIpVersion(""));
    }

    public function testGetValidIpVerison(): void
    {
        self::assertEquals(4, $this->object->getIpVersion("0.0.0.0"));
        self::assertEquals(4, $this->object->getIpVersion("127.0.0.1"));
    }

    public function testGetValidIp6LoopbackVerison(): void
    {
        self::assertEquals(6, $this->object->getIpVersion("::1"));
    }

    public function testGetValidIp6Verison(): void
    {
        self::assertEquals(6, $this->object->getIpVersion("FE80:CD00:0000:0CDE:1257:0000:211E:729C"));
        self::assertEquals(6, $this->object->getIpVersion("FE80:CD00:0:CDE:1257:0:211E:729C"));
    }

    public function testGetIpLong(): void
    {
        self::assertEquals(0, $this->object->getIpLong("0.0.0.0"));
    }
}
