<?php
namespace Alirezasalehizadeh\QuickMigration\Structure;

use Alirezasalehizadeh\QuickMigration\Enums\Attribute;
use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\Column;

class Structure
{

    private $columns = [];

    private $table;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function id()
    {
        return $this->columns[] = (new Column('id', 'BIGINT'))
            ->autoIncrement()
            ->primary()
            ->unsigned();
    }

    public function string(string $name, int $length = 255)
    {
        return $this->columns[] = new Column($name, Type::Varchar, $length);
    }

    public function number(string $name)
    {
        return $this->columns[] = new Column($name, Type::Int);
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

    public function enum(string $name, array $enums)
    {
        return $this->columns[] = (new Column($name, Type::Enum, $enums));
    }

    public function foreign(string $name, array $references)
    {
        return $this->number($name)->setForeignKey($references);
    }

    public function done()
    {
        return [$this->columns, ['table' => $this->table]];
    }

    public function __call($name, $arguments)
    {
        return $this->columns[] = new Column($arguments[0], strtoupper($name));
    }

}
