<?php
namespace Alirezasalehizadeh\QuickMigration\Structure;

use Alirezasalehizadeh\QuickMigration\Enums\Index;
use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\Column;
use Alirezasalehizadeh\QuickMigration\Translation\MySqlTranslator;

class Structure
{

    private $columns = [];

    private $commands = [];

    private $table;

    private $engine = "INNODB";

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function id()
    {
        return $this->columns[] = (new Column('id', Type::Int, null))
            ->nullable(false)
            ->autoIncrement(true)
            ->index(Index::Primary);
    }

    public function string(string $name, int $length)
    {
        return $this->columns[] = new Column($name, Type::Varchar, $length);
    }

    public function number(string $name, Type $type, $length)
    {
        return $this->columns[] = new Column($name, $type, $length);
    }

    public function text(string $name, int $length)
    {
        return $this->columns[] = new Column($name, Type::Text, $length);
    }

    public function timestamp(string $name)
    {
        return $this->columns[] = new Column($name, Type::Timestamp);
    }

    public function json(string $name)
    {
        return $this->columns[] = new Column($name, Type::Json);
    }

    public function done()
    {
        $this->__toSql();
        return [$this->commands, [
            'table' => $this->table,
            'engine' => $this->engine
        ]];
    }

    public function __toSql()
    {
        foreach ($this->columns as $column) {
            $this->commands[] = (new MySqlTranslator($column))->make();
        }
    }

}

