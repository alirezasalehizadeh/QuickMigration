<?php

namespace Alirezasalehizadeh\QuickMigration\Structure;

use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\Column;
use Alirezasalehizadeh\QuickMigration\Structure\Constraints\Foreign;

class StructureBuilder
{

    private $columns = [];

    public function __construct(private string $table)
    {
    }

    public function id()
    {
        $this->bigInt('id')
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

    public function timestamps()
    {
        $this->columns[] = (new Column('created_at', Type::Timestamp))->nullable();
        $this->columns[] = (new Column('updated_at', Type::Timestamp))->nullable();
    }

    public function json(string $name)
    {
        return $this->columns[] = new Column($name, Type::Json);
    }

    public function enum(string $name, array $enums)
    {
        return $this->columns[] = new Column($name, Type::Enum, $enums);
    }

    public function foreign(string $column)
    {
        return $this->columns[] = new Foreign($column, '');
    }

    public function done()
    {
        return ['columns' => $this->columns, 'table' => $this->table];
    }

    public function __call($name, $arguments)
    {
        if (str_starts_with($name, 'foreign')) {
            $column = strtolower(
                preg_replace(
                    '/(?<!^)[A-Z]/',
                    '_$0',
                    explode('foreign', $name)[1]
                )
            );

            return $this->foreign($column);
        }

        return $this->columns[] = new Column($arguments[0], $name);
    }
}
