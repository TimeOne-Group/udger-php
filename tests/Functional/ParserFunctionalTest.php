<?php

namespace Tests\Functional;

use Codeception\Stub;
use Codeception\Test\Unit;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Udger\Parser;
use Udger\Helper\IP;

class ParserFunctionalTest extends Unit
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
        date_default_timezone_set('Europe/Paris');
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler(dirname(__DIR__) . '/_log/test.log', Logger::DEBUG));

        $this->parser = new Parser($log, Stub::makeEmpty(IP::class));
    }

    /**
     * @throws Exception
     */
    private function withSQLite(): void
    {
        $this->parser->setDataFile(dirname(__DIR__) . "/Support/Data/udgercache/udgerdb_v3.dat");
    }

    private function withMySQL(): void
    {
        $this->parser->setMySQLConnection('mysql:host=db;dbname=udger;charset=UTF8', 'udger', 'udger');
    }

    /**
     * @throws Exception
     */
    public function testParse(): void
    {
        $this->withSQLite();
        $this->assertFirefox();
    }

    /**
     * @throws Exception
     */
    public function testParseWithMySQL(): void
    {
        $this->withMySQL();
        $this->assertFirefox();
    }

    /**
     * @throws Exception
     */
    public function testParseBot(): void
    {
        $this->withSQLite();
        $this->parser->setUA('PINGOMETER_BOT_(HTTPS://PINGOMETER.COM)');
        $result = $this->parser->parse();

        self::assertArrayHasKey("user_agent", $result);
        self::assertEquals("PINGOMETER_BOT_(HTTPS://PINGOMETER.COM)",
            $result["user_agent"]["ua_string"]);
        self::assertEquals("Crawler", $result["user_agent"]["ua_class"]);
        self::assertEquals("crawler", $result["user_agent"]["ua_class_code"]);
        self::assertEquals("PINGOMETER", $result["user_agent"]["ua"]);
        self::assertEquals("", $result["user_agent"]["ua_version"]);
        self::assertEquals("", $result["user_agent"]["ua_version_major"]);
        self::assertEquals("", $result["user_agent"]["ua_uptodate_current_version"]);
        self::assertEquals("PINGOMETER", $result["user_agent"]["ua_family"]);
        self::assertEquals("pingometer", $result["user_agent"]["ua_family_code"]);
        self::assertEquals("", $result["user_agent"]["ua_family_homepage"]);
        self::assertEquals("Pingometer, LLC", $result["user_agent"]["ua_family_vendor"]);
        self::assertEquals("pingometer_llc", $result["user_agent"]["ua_family_vendor_code"]);
        self::assertEquals("http://pingometer.com/", $result["user_agent"]["ua_family_vendor_homepage"]);
        self::assertEquals("bot_pingometer.png", $result["user_agent"]["ua_family_icon"]);
        self::assertEquals("", $result["user_agent"]["ua_family_icon_big"]);
        self::assertEquals("https://udger.com/resources/ua-list/bot-detail?bot=PINGOMETER#id20112",
            $result["user_agent"]["ua_family_info_url"]);
        self::assertEquals("", $result["user_agent"]["ua_engine"]);
        self::assertEquals("", $result["user_agent"]["os"]);
        self::assertEquals("", $result["user_agent"]["os_code"]);
        self::assertEquals("", $result["user_agent"]["os_homepage"]);
        self::assertEquals("", $result["user_agent"]["os_icon"]);
        self::assertEquals("", $result["user_agent"]["os_icon_big"]);
        self::assertEquals("",
            $result["user_agent"]["os_info_url"]);
        self::assertEquals("", $result["user_agent"]["os_family"]);
        self::assertEquals("", $result["user_agent"]["os_family_code"]);
        self::assertEquals("", $result["user_agent"]["os_family_vendor"]);
        self::assertEquals("", $result["user_agent"]["os_family_vendor_code"]);
        self::assertEquals("", $result["user_agent"]["os_family_vendor_homepage"]);
        self::assertEquals("", $result["user_agent"]["device_class"]);
        self::assertEquals("", $result["user_agent"]["device_class_code"]);
        self::assertEquals("", $result["user_agent"]["device_class_icon"]);
        self::assertEquals("", $result["user_agent"]["device_class_icon_big"]);
        self::assertEquals("", $result["user_agent"]["device_class_info_url"]);
        self::assertEquals("Site monitor", $result["user_agent"]["crawler_category"]);
        self::assertEquals("site_monitor", $result["user_agent"]["crawler_category_code"]);
        self::assertEquals("no", $result["user_agent"]["crawler_respect_robotstxt"]);
    }

    /**
     * @throws Exception
     */
    public function testParseEmpty(): void
    {
        $this->withSQLite();
        $this->parser->setUA("");

        $result = $this->parser->parse();
        self::assertArrayHasKey("user_agent", $result);
        self::assertArrayHasKey("ip_address", $result);
    }

    /**
     * @throws Exception
     */
    public function testParseNull(): void
    {
        $this->withSQLite();
        $this->parser->setUA(null);

        $result = $this->parser->parse();
        self::assertArrayHasKey("user_agent", $result);
        self::assertArrayHasKey("ip_address", $result);
    }

    /**
     * @throws Exception
     */
    private function assertFirefox(): void
    {
        $this->parser->setUA('Mozilla/5.0 (Windows NT 10.0; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0');
        $result = $this->parser->parse();

        self::assertArrayHasKey("user_agent", $result);
        self::assertEquals("Mozilla/5.0 (Windows NT 10.0; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0",
            $result["user_agent"]["ua_string"]);
        self::assertEquals("Browser", $result["user_agent"]["ua_class"]);
        self::assertEquals("browser", $result["user_agent"]["ua_class_code"]);
        self::assertEquals("Firefox 40.0", $result["user_agent"]["ua"]);
        self::assertEquals("40.0", $result["user_agent"]["ua_version"]);
        self::assertEquals("40", $result["user_agent"]["ua_version_major"]);
        self::assertEquals("50", $result["user_agent"]["ua_uptodate_current_version"]);
        self::assertEquals("Firefox", $result["user_agent"]["ua_family"]);
        self::assertEquals("firefox", $result["user_agent"]["ua_family_code"]);
        self::assertEquals("http://www.firefox.com/", $result["user_agent"]["ua_family_homepage"]);
        self::assertEquals("Mozilla Foundation", $result["user_agent"]["ua_family_vendor"]);
        self::assertEquals("mozilla_foundation", $result["user_agent"]["ua_family_vendor_code"]);
        self::assertEquals("http://www.mozilla.org/", $result["user_agent"]["ua_family_vendor_homepage"]);
        self::assertEquals("firefox.png", $result["user_agent"]["ua_family_icon"]);
        self::assertEquals("firefox_big.png", $result["user_agent"]["ua_family_icon_big"]);
        self::assertEquals("https://udger.com/resources/ua-list/browser-detail?browser=Firefox",
            $result["user_agent"]["ua_family_info_url"]);
        self::assertEquals("Gecko", $result["user_agent"]["ua_engine"]);
        self::assertEquals("Windows 10", $result["user_agent"]["os"]);
        self::assertEquals("windows_10", $result["user_agent"]["os_code"]);
        self::assertEquals("https://en.wikipedia.org/wiki/Windows_10", $result["user_agent"]["os_homepage"]);
        self::assertEquals("windows10.png", $result["user_agent"]["os_icon"]);
        self::assertEquals("windows10_big.png", $result["user_agent"]["os_icon_big"]);
        self::assertEquals("https://udger.com/resources/ua-list/os-detail?os=Windows 10",
            $result["user_agent"]["os_info_url"]);
        self::assertEquals("Windows", $result["user_agent"]["os_family"]);
        self::assertEquals("windows", $result["user_agent"]["os_family_code"]);
        self::assertEquals("Microsoft Corporation.", $result["user_agent"]["os_family_vendor"]);
        self::assertEquals("microsoft_corporation", $result["user_agent"]["os_family_vendor_code"]);
        self::assertEquals("https://www.microsoft.com/about/", $result["user_agent"]["os_family_vendor_homepage"]);
        self::assertEquals("Desktop", $result["user_agent"]["device_class"]);
        self::assertEquals("desktop", $result["user_agent"]["device_class_code"]);
        self::assertEquals("desktop.png", $result["user_agent"]["device_class_icon"]);
        self::assertEquals("desktop_big.png", $result["user_agent"]["device_class_icon_big"]);
        self::assertEquals("https://udger.com/resources/ua-list/device-detail?device=Desktop",
            $result["user_agent"]["device_class_info_url"]);
        self::assertArrayHasKey("crawler_category", $result["user_agent"]);
        self::assertArrayHasKey("crawler_category_code", $result["user_agent"]);
        self::assertArrayHasKey("crawler_respect_robotstxt", $result["user_agent"]);
    }
}
