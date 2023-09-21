<?php

namespace Alirezasalehizadeh\QuickMigration;

interface MigrationInterface
{
    public function set(): array;

    public function drop(string $table);

    public function migrate();

    public function dropIndex(string $name, string $table);

    public function createIndex(string $name, string $table, array $columns);
}
