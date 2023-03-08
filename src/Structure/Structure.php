<?php
namespace Alirezasalehizadeh\QuickMigration\Structure;

use Alirezasalehizadeh\QuickMigration\Enums\Index;
use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\Column;

class Structure
{

    private $columns = [];

    private $table;

    private $engine = "INNODB";

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function id()
    {
        return $this->columns[] = (new Column('id', Type::Int))
            ->nullable(false)
            ->autoIncrement(true)
            ->index(Index::Primary);
    }

    public function string(string $name, int $length)
    {
        return $this->columns[] = new Column($name, Type::Varchar, $length);
    }

    public function number(string $name, Type $type)
    {
        return $this->columns[] = new Column($name, $type);
    }

    public function text(string $name)
    {
        return $this->columns[] = new Column($name, Type::Text);
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
        return [$this->columns, [
            'table' => $this->table,
            'engine' => $this->engine,
        ]];
    }

}
