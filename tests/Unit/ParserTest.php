<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Codeception\Stub;
use Exception;
use Udger\Parser;
use Psr\Log\LoggerInterface;
use Udger\Helper\IP;

class ParserTest extends Unit
{
    /**
     * @var Parser
     */
    protected Parser $parser;

    /**
     * @throws Exception
     */
    protected function _before(): void
    {
        $this->parser = new Parser(
            Stub::makeEmpty(LoggerInterface::class),
            Stub::makeEmpty(IP::class));
        $this->parser->setDataFile("/dev/null");
    }

    public function testSetDataFile()
    {
        $this->expectException(Exception::class);
        self::assertTrue($this->parser->setDataFile("/this/is/a/missing/path"));
    }

    public function testSetAccessKey(): void
    {
        self::assertTrue($this->parser->setAccessKey("123456"));
    }

    public function testSetUA(): void
    {
        self::assertTrue($this->parser->setUA("agent"));
    }

    public function testSetIP(): void
    {
        self::assertTrue($this->parser->setIP("0.0.0.0"));
    }

    public function testAccount(): void
    {
        $this->expectException(Exception::class);
        $this->parser->account();
    }
}
