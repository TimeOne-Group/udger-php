<?php

namespace Tests\Functional;

use Codeception\Stub;
use Codeception\Test\Unit;
use Exception;
use Udger\Parser;
use Psr\Log\LoggerInterface;
use Udger\Helper\IP;

class MissingDatfileTest extends Unit
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
    }

    public function testParseWithMissingDatfile(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Unable to find database source");
        $this->parser->parse();
    }
}