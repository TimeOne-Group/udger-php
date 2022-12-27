<?php

namespace Tests\Functional;

use Codeception\Stub;
use Codeception\Test\Unit;
use Exception;
use Udger\Parser;
use Psr\Log\LoggerInterface;
use Udger\Helper\IP;

class ParserMultipleTest extends Unit
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
        $this->parser->setDataFile(dirname(__DIR__) . "/Support/Data/udgercache/udgerdb_v3.dat");
    }

    //tests

    /**
     * @throws Exception
     */
    public function testParseMultpileAgentStrings(): void
    {
        $handle = fopen(dirname(__DIR__) . "/Support/Data/agents.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $result = $this->parser->parse();
            }
            fclose($handle);
        } else {
            // error opening the file.
        }
    }
}

