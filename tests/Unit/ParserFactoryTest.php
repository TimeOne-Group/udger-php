<?php

namespace Tests\Unit;

use ArgumentCountError;
use Codeception\Test\Unit;
use Exception;
use Udger\ParserFactory;
use Udger\Parser;

class ParserFactoryTest extends Unit
{
    /**
     * @var ParserFactory
     */
    protected ParserFactory $factory;

    protected function _before(): void
    {
        $this->factory = new ParserFactory('/dev/null');
    }

    public function testGetParser(): void
    {
        self::assertInstanceOf(Parser::class, $this->factory->getParser());
    }

    public function testNewFactoryWithoutPathShouldFail(): void
    {
        $this->expectException(ArgumentCountError::class);
        new ParserFactory();
    }

    /**
     * @throws Exception
     */
    public function testGetParserFromDataFile(): void
    {
        self::assertInstanceOf(Parser::class, ParserFactory::buildParserFromDataFile('/dev/null'));
    }

    public function testGetParserFromMySQL(): void
    {
        self::assertInstanceOf(
            Parser::class,
            ParserFactory::buildParserFromMySQL('dsn', 'user', 'password')
        );
    }
}
