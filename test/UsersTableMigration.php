<?php
namespace Alirezasalehizadeh\QuickMigration\Test;

use Alirezasalehizadeh\QuickMigration\Enums\Index;
use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Migration;
use Alirezasalehizadeh\QuickMigration\Structure\Structure;

class UsersTableMigration extends Migration
{

    protected $database = "test";

    public function set(): array
    {

        $structure = new Structure('users');

        $structure->id();
        $structure->string('full_name', 50)->nullable(false);
        $structure->string('email', 50)->nullable(false)->index(Index::Unique);
        $structure->number('age', Type::Int, null)->nullable();

        return $structure->done();
    }

}
