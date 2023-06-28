# QuickMigration

Run your migration quickly with Quick Migration!

##  Requirements

PHP >= 8.1
#### Available database:
* MySql
* PostgreSql


## Getting Started

#### Installation:
via Composer:
```
composer require alirezasalehizadeh/quick-migration
```
#### Migration class template:
Create a `xMigration` class like this that must extends from `\Alirezasalehizadeh\QuickMigration\Migration` class:
``` php

use Alirezasalehizadeh\QuickMigration\Migration;
use Alirezasalehizadeh\QuickMigration\Structure\Structure;

class xMigration extends Migration
{

    protected $database = "database name";

    protected $translator = "set database translator name from available translators array (default MySql)";

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
// OR
(new xMigration($connection))->dropIfExists('table name');
```
```
php index.php
```

## Usage

#### Structure methods:
```php
$structure->id();
$structure->string(string $name, int $length);
$structure->number(string $name, Type $type);
$structure->text(string $name);
$structure->timestamp(string $name);
$structure->json(string $name)
$structure->enum(string $name, array $enums)
```
#### Column attributes:
```php
$structure->number('test', Type::Int)
->primary()                 // Set this as primary key
->nullable()                // Set this nullable or not
->unique()                  // Set this unique
->default(1)                // Set default value
->autoIncrement();          // Set this auto increment
```
#### Custom column:
Sometimes it happens that you need a specific type of column that is not available in `Type` enum and you have to create it manually. `QuickMigration` has provided you with a quick and easy way to create a specific type of column!

To create a column, it is enough to set the `method name` equal to the `column type` and write the `column name` in the `first argument`, like this:
```php
// TINYTEXT type not defined in `Type` enum

$structure = new Structure('table name');

$structure->tinyText('foo');
// ...
```




## Contributing
Send pull request or open issue for contributing.


## License

[MIT](LICENSE).

