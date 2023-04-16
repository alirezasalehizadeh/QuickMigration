<?php
namespace Alirezasalehizadeh\QuickMigration;

use PDO;
use Alirezasalehizadeh\QuickMigration\MigrationInterface;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\CreateTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropIfExistsTableCommand;
use Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\ColumnTranslateManager;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\DropTableCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\CreateTableCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\DropIfExistsTableCommandTranslator;

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
        $command = (new DropTableCommand($this->database, $table))->getCommand();
        $sql = (new DropTableCommandTranslator($command))->make();
        $this->run($sql);
    }

    public function dropIfExists(string $table)
    {
        $command = (new DropIfExistsTableCommand($this->database, $table))->getCommand();
        $sql = (new DropIfExistsTableCommandTranslator($command))->make();
        $this->run($sql);
    }

    public function migrate()
    {
        $data = $this->set();
        $columns = $data[0];
        $attribute = $data[1];

        //  Translate column objects to sql string
        $columnCommands = (new ColumnTranslateManager($this->translator))->translate($columns);
        
        //  Make `CREATE TABLE` sql command by `CreateTableCommand` object
        $command = (new CreateTableCommand($this->database, $attribute['table'], $columnCommands))->getCommand();
        $sql = (new CreateTableCommandTranslator($command))->make();

        // Run the sql string by PDO connection
        $this->run($sql);
    }

    private function run(string $sql)
    {
        $this->connection->prepare($sql)->execute();
    }
}
