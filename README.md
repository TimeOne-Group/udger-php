# Udger client for PHP (data ver. 3)

Fork from original lib : [Udger](https://github.com/udger/udger-php)

Local parser is very fast and accurate useragent string detection solution. Enables developers to locally install and integrate a highly-scalable product.
We provide the detection of the devices (personal computer, tablet, Smart TV, Game console etc.), operating system, client SW type (browser, e-mail client etc.)
and devices market name (example: Sony Xperia Tablet S, Nokia Lumia 820 etc.).
It also provides information about IP addresses (Public proxies, VPN services, Tor exit nodes, Fake crawlers, Web scrapers, Datacenter name .. etc.)

- Tested with more the 50.000 unique user agents.
- Up to date data provided by https://udger.com/

### Requirements
- php >= 7.2.0
- [PDO](https://www.php.net/manual/en/book.pdo.php)
   
#### For local DB
- [ext-sqlite3](https://php.net/manual/en/book.sqlite3.php)
- datafile v3 (udgerdb_v3.dat) from https://data.udger.com/

#### For DB MySQL
- PDO MySQL

### Features
- Fast
- LRU cache
- Released under the MIT
- From local file or MySQL server

### Install

```bash
composer require timeonegroup/udger-php
````

### Usage
You should review the included examples (`parse.php`, `account.php`)

#### Examples

##### With MySQL
```php
use Udger\ParserFactory;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// creates a new UdgerParser object
$parser = ParserFactory::buildParserFromMySQL('mysql:host=db;dbname=udger;charset=UTF8', 'udger', 'udger');
$parser->setUA('Mozilla/5.0 (Windows NT 10.0; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0');
$parser->setIP("66.249.64.73");

$ret = $parser->parse();
```

##### With Data file
```php
use Udger\ParserFactory;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// creates a new UdgerParser object
$parser = ParserFactory::buildParserFromDataFile(sys_get_temp_dir() . '/udgercache/udgerdb_v3.dat');
$parser->setUA('Mozilla/5.0 (Windows NT 10.0; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0');
$parser->setIP("66.249.64.73");

$ret = $parser->parse();
```

### Develop

### Initialize

```bash
docker compose up db -d
docker compose run --rm init
```

### Running tests  
```bash
docker compose run --rm php ./vendor/bin/codecept run
```

### Automatic updates download
- for autoupdate data use Udger data updater (https://udger.com/support/documentation/?doc=62)

### Documentation for programmers
- https://udger.com/pub/documentation/parser/PHP/html/

### Author
[TimeOne Group](https://www.timeonegroup.com)
