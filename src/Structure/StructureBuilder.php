<?php

namespace Alirezasalehizadeh\QuickMigration\Structure;

use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\ColumnFactory;

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
        return $this->columns[] = ColumnFactory::create($name, Type::Varchar, $length);
    }

    public function number(string $name)
    {
        return $this->columns[] = ColumnFactory::create($name, Type::Int);
    }

    public function text(string $name)
    {
        return $this->columns[] = ColumnFactory::create($name, Type::Text);
    }

    public function timestamp(string $name)
    {
        return $this->columns[] = ColumnFactory::create($name, Type::Timestamp);
    }

    public function timestamps()
    {
        array_push(
            $this->columns,
            ColumnFactory::create('created_at', Type::Timestamp)->nullable(),
            ColumnFactory::create('updated_at', Type::Timestamp)->nullable()
        );
    }

    public function json(string $name)
    {
        return $this->columns[] = ColumnFactory::create($name, Type::Json);
    }

    public function enum(string $name, array $enums)
    {
        return $this->columns[] = ColumnFactory::create($name, Type::Enum, $enums);
    }

    public function foreign(string $column)
    {
        return $this->columns[] = ColumnFactory::foreign($column, '');
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

        return $this->columns[] = ColumnFactory::create($arguments[0], $name);
    }
}
