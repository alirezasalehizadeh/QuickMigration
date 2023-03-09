<?php
namespace Alirezasalehizadeh\QuickMigration;

use Alirezasalehizadeh\QuickMigration\Command\Commands\CreateTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropIfExistsTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropTableCommand;
use Alirezasalehizadeh\QuickMigration\MigrationInterface;
use Alirezasalehizadeh\QuickMigration\Translation\TranslateManager;
use PDO;

abstract class Migration implements MigrationInterface
{
    protected $database;

    protected $translator;

    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function set(): array
    {
        return [];
    }

    public function drop(string $table)
    {
        $sql = (new DropTableCommand($this->database, $table))->generate();
        $this->run($sql);
    }

    public function dropIfExists(string $table)
    {
        $sql = (new DropIfExistsTableCommand($this->database, $table))->generate();
        $this->run($sql);
    }

    public function migrate()
    {
        $data = $this->set();
        $columns = $data[0];
        $attribute = $data[1];

        //  Translate column objects to sql string
        $commands = (new TranslateManager($this->translator))->translate($columns);

        //  Generate `CREATE TABLE` sql command by `CommandGenerator` class
        $sql = (new CreateTableCommand($this->database, $attribute['table'], $commands))->generate();

        // Run the sql string by PDO connection
        $this->run($sql);
    }

    private function run(string $sql)
    {
        $this->connection->prepare($sql)->execute();
    }
}
