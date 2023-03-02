# QuickMigration

Run your migration quickly with Quick Migration!

##  Requirements

PHP >= 8.1
#### Available database:
* MySql


## Getting Started

#### Installation:
via Composer:
```
composer require alirezasalehizadeh/quick-migration:dev-main
```
#### Migration class template:
Create a `xMigration` class like this that must extends from `\Alirezasalehizadeh\QuickMigration\Migration` class:
``` php

use Alirezasalehizadeh\QuickMigration\Migration;
use Alirezasalehizadeh\QuickMigration\Structure\Structure;

class xMigration extends Migration
{

    protected $database = "database name";

    public function set(): array
    {

        $structure = new Structure('table name');


        // Write your structure here...


        return $structure->done();
    }

}
```

#### Run migration:
Next, create a object from `xMigration` class and run `migrate` method:
```php
// index.php

$connection = PDO connection object;

(new xMigration($connection))->migrate();
```
```
php index.php
```
##### drop table:
```php
// index.php

$connection = PDO connection object;

(new xMigration($connection))->drop('table name');
```
```
php index.php
```

## Usage

#### Structure methods:
```php
$structure->id();
$structure->string(string $name, int $length);
$structure->number(string $name, Type $type, $length);
$structure->text(string $name, int $length);
$structure->timestamp(string $name);
$structure->json(string $name)
```
#### Column attributes:
```php
$structure->number('test', Type::Int, null)
->index(Index::Primary)     // Set this as primary key
->nullable(true)            // Set this nullable or not
->index(Index::Unique)      // Set this unique
->default(1)                // Set default value
->autoIncrement(true);      // Set this auto increment
```
*Note: see the `UsersTableMigration` class in the `test` directory for the more details.

## Contributing
Send pull request or open issue for contributing.


## License

[MIT](LICENSE).

