<?php

namespace Alirezasalehizadeh\QuickMigration;

interface MigrationInterface
{
    public function set(): array;

    public function drop(string $table);

    public function migrate();
}
