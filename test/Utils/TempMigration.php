<?php

namespace Alirezasalehizadeh\QuickMigration\Test\Utils;

use Alirezasalehizadeh\QuickMigration\Migration;
use Alirezasalehizadeh\QuickMigration\Structure\Structure;
use Alirezasalehizadeh\QuickMigration\Structure\StructureBuilder;

class TempMigration extends Migration
{
    protected $database = 'test';

    public function set(): array
    {
        return Structure::create('temp_user', function (StructureBuilder $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }
}
