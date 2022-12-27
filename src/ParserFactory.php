<?php

namespace Udger;

use Exception;
use Monolog\Logger;
use Monolog\Handler\NullHandler;
use Psr\Log\LoggerInterface;

/**
 * Description of ParserFactory
 *
 * @author tiborb
 */
class ParserFactory
{
    public const LOGGER_NAME = 'udger';

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var string $dataFile path to the data file
     */
    private string $dataFile;

    /**
     * @param string $dataFile path to the data file
     * @param LoggerInterface|null $logger
     */
    public function __construct(string $dataFile, LoggerInterface $logger = null)
    {
        $this->dataFile = $dataFile;
        $this->logger = self::buildLogger($logger);
    }

    /**
     * @param LoggerInterface|null $logger
     * @return LoggerInterface
     */
    private static function buildLogger(?LoggerInterface $logger): LoggerInterface
    {
        if (is_null($logger)) {
            $logger = new Logger(self::LOGGER_NAME);
            $logger->pushHandler(new NullHandler());
        }

        return $logger;
    }

    /**
     * @return Parser
     * @throws Exception
     */
    public function getParser(): Parser
    {
        $parser = new Parser($this->logger, new Helper\IP());
        $parser->setDataFile($this->dataFile);
        return $parser;
    }

    /**
     * @param string $dataFile
     * @param LoggerInterface|null $logger
     * @return Parser
     * @throws Exception
     */
    public static function buildParserFromDataFile(string $dataFile, LoggerInterface $logger = null): Parser
    {
        $parser = new Parser(self::buildLogger($logger), new Helper\IP());
        $parser->setDataFile($dataFile);
        return $parser;
    }

    /**
     * @param string $dsn
     * @param string $user
     * @param string $password
     * @param LoggerInterface|null $logger
     * @return Parser
     */
    public static function buildParserFromMySQL(string $dsn, string $user, string $password, LoggerInterface $logger = null): Parser
    {
        $parser = new Parser(self::buildLogger($logger), new Helper\IP());
        $parser->setMySQLConnection($dsn, $user, $password);
        return $parser;
    }
}
