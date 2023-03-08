<?php
namespace Alirezasalehizadeh\QuickMigration;

use Alirezasalehizadeh\QuickMigration\CommandGenerator;
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
        $sql = (new CommandGenerator)->dropTableCommand($this->database, $table);
        $this->connection->prepare($sql)->execute();
    }

    public function migrate()
    {
        $data = $this->set();
        $columns = $data[0];
        $attribute = $data[1];

        //  Translate column objects to sql string
        $commands = (new TranslateManager($this->translator))->translate($columns);

        //  Generate `CREATE TABLE` sql command by `CommandGenerator` class
        $sql = (new CommandGenerator)->createTableCommand($this->database, $attribute['table'], $commands, $attribute['engine']);

        // Run the sql string by PDO connection
        $this->connection->prepare($sql)->execute();
    }
}
