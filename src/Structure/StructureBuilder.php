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

    public function id(string $name = 'id')
    {
        $this->bigInt($name)
            ->autoIncrement()
            ->primary()
            ->unsigned();
    }

    public function uuid(string $name = 'uuid', int $length = 32)
    {
        return $this->string($name, $length)->primary();
    }

    public function ulid(string $name = 'ulid', int $length = 26)
    {
        return $this->string($name, $length)->primary();
    }

    public function string(string $name, int $length = 255)
    {
        return $this->addColumn($name, Type::Varchar, $length);
    }

    public function number(string $name)
    {
        return $this->addColumn($name, Type::Int);
    }

    public function text(string $name)
    {
        return $this->addColumn($name, Type::Text);
    }

    public function timestamp(string $name)
    {
        return $this->addColumn($name, Type::Timestamp);
    }

    public function timestamps()
    {
        array_push(
            $this->columns,
            $this->addColumn('created_at', Type::Timestamp)->nullable(),
            $this->addColumn('updated_at', Type::Timestamp)->nullable()
        );
    }

    public function json(string $name)
    {
        return $this->addColumn($name, Type::Json);
    }

    public function enum(string $name, array $enums)
    {
        return $this->addColumn($name, Type::Enum, $enums);
    }

    public function array(string $name, array $values)
    {
        return $this->addColumn($name, Type::Set, $values);
    }

    public function foreign(string $column)
    {
        return $this->addForeignColumn($column, '');
    }

    public function done()
    {
        return ['columns' => $this->columns, 'table' => $this->table];
    }

    private function addColumn(string $name, Type|string $type, mixed $value = null)
    {
        return $this->columns[] = ColumnFactory::create($name, $type, $value);
    }

    private function addForeignColumn(string $name, Type|string $type, mixed $value = null)
    {
        return $this->columns[] = ColumnFactory::foreign($name, $type, $value);
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

        return $this->addColumn($arguments[0], $name);
    }
}
