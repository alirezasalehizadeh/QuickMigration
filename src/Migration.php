<?php

namespace Alirezasalehizadeh\QuickMigration;

use PDO;
use Alirezasalehizadeh\QuickMigration\MigrationInterface;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropIndexCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\CreateIndexCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\CreateTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropIfExistsTableCommand;
use Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\ColumnTranslateManager;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\CommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\TableAlterTranslationManager;

abstract class Migration implements MigrationInterface
{
    protected $database;

    protected $translator;

    private $connection;

    private $sql = [];

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
        $this->sql['drop'] = (new CommandTranslator($command))->dropTableCommandTranslator();
        $this->run($this->sql['drop']);
    }

    public function dropIfExists(string $table)
    {
        $command = (new DropIfExistsTableCommand($this->database, $table))->getCommand();
        $this->sql['dropIfExists'] = (new CommandTranslator($command))->dropIfExistsTableCommandTranslator();
        $this->run($this->sql['dropIfExists']);
    }

    public function migrate()
    {
        $structureData = $this->set();
        $columns = $structureData['columns'];
        $table = $structureData['table'];

        //  Translate column objects to sql string
        $columnCommands = (new ColumnTranslateManager($this->translator))->translate($columns);

        //  Make `CREATE TABLE` sql command by `CreateTableCommand` object
        $command = (new CreateTableCommand($this->database, $table, $columnCommands))->getCommand();
        $this->sql['migrate'] = (new CommandTranslator($command))->createTableCommandTranslator();
    }

    public function createIndex(string $name, string $table, array $columns)
    {
        $command = (new CreateIndexCommand($name, $table, $columns))->getCommand();
        $this->sql['createIndex'] = (new CommandTranslator($command))->createIndexCommandTranslator();
    }

    public function dropIndex(string $name, string $table)
    {
        $command = (new DropIndexCommand($name, $table))->getCommand();
        $this->sql['dropIndex'] = (new CommandTranslator($command))->dropIndexCommandTranslator();
    }

    public function alterTable()
    {
        $alterCommands = $this->set();
        $translatedCommands =  (new TableAlterTranslationManager($alterCommands))->translate();
        foreach($translatedCommands as $command){
            $this->sql[] = $command;
        }
    }

    private function run(string $sql)
    {
        $this->connection->prepare($sql)->execute();
    }

    public function __toString()
    {
        $this->displayQuery = true;
        return implode("\n", $this->sql);
    }

    public function __destruct()
    {
        if($this->displayQuery === false){
            foreach ($this->sql as $sql) {
                $this->run($sql);
            }
        }
    }
}
