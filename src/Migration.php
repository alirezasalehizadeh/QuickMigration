<?php
namespace Alirezasalehizadeh\QuickMigration;

use PDO;
use Alirezasalehizadeh\QuickMigration\CommandGenerator;
use Alirezasalehizadeh\QuickMigration\MigrationInterface;

abstract class Migration implements MigrationInterface 
{
    protected $database;

    private $connection;

    function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function set() : array{
        return [];
    }

    public function drop(string $table){
        $sql = (new CommandGenerator)->dropTableCommand($this->database, $table);
        $this->connection->prepare($sql)->execute();
    }
    
    public function migrate()
    {
        $data = $this->set();
        $commands = $data[0];
        $attribute = $data[1];
        $sql = (new CommandGenerator)->createTableCommand($this->database, $attribute['table'], $commands, $attribute['engine']);
        $this->connection->prepare($sql)->execute();
    }
}
