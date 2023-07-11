<?php

namespace Alirezasalehizadeh\QuickMigration;

use Alirezasalehizadeh\QuickMigration\Command\Commands\CreateIndexCommand;
use PDO;
use Alirezasalehizadeh\QuickMigration\MigrationInterface;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\CreateTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropIfExistsTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropIndexCommand;
use Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\ColumnTranslateManager;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\CreateIndexCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\DropTableCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\CreateTableCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\DropIfExistsTableCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\DropIndexCommandTranslator;

abstract class Migration implements MigrationInterface
{
    protected $database;

    protected $translator;

    private $connection;

    private $sql;

    private $displayQuery = false;

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
        $this->sql[] = (new DropTableCommandTranslator($command))->make();
    }

    public function dropIfExists(string $table)
    {
        $command = (new DropIfExistsTableCommand($this->database, $table))->getCommand();
        $this->sql[] = (new DropIfExistsTableCommandTranslator($command))->make();
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
        $this->sql[] = (new CreateTableCommandTranslator($command))->make();
    }

    public function createIndex(string $name, string $table, array $columns)
    {
        $command = (new CreateIndexCommand($name, $table, $columns))->getCommand();
        $this->sql[] = (new CreateIndexCommandTranslator($command))->make();
    }

    public function dropIndex(string $name, string $table)
    {
        $command = (new DropIndexCommand($name, $table))->getCommand();
        $this->sql[] = (new DropIndexCommandTranslator($command))->make();
    }

    private function run(string $sql)
    {
        $this->connection->prepare($sql)->execute();
    }

    public function __toString()
    {
        $this->displayQuery = true;
        return $this->sql ? implode("\n", $this->sql) : '';
    }

    public function __destruct()
    {
        if(! $this->displayQuery && ! is_null($this->sql)){
            foreach ($this->sql as $sql) {
                $this->run($sql);
            }
        }
    }
}
