<?php

namespace Alirezasalehizadeh\QuickMigration\Utils;

trait Exportable
{
    public function export(string $fileName)
    {
        if (empty($this->sql)) throw new \Exception('There are no command to run, make sure you create an object of the Migration class and call your commands on it');
        $commands = array_map(fn ($sql) => $sql . ";", $this->sql);
        file_put_contents("$fileName.sql", implode("\n", $commands));
    }
}
