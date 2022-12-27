<?php

namespace Tests\Functional;

use Codeception\Stub;
use Codeception\Test\Unit;
use Exception;
use Udger\Parser;
use Psr\Log\LoggerInterface;
use Udger\Helper\IP;

class ParserAccountTest extends Unit
{
    /**
     * @throws Exception
     */
    public function testAccount(): void
    {
        $parser = new Parser(
            Stub::makeEmpty(LoggerInterface::class),
            Stub::makeEmpty(IP::class));
        $parser->setAccessKey('nosuchkey');

        $this->expectException(Exception::class);
        $parser->account();
    }

    /**
     * @throws Exception
     */
    public function testAccountMissingKey(): void
    {
        $parser = new Parser(
            Stub::makeEmpty(LoggerInterface::class),
            Stub::makeEmpty(IP::class));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("access key not set");
        $parser->account();
    }
}
