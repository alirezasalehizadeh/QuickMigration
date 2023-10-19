<?php

namespace Alirezasalehizadeh\QuickMigration\Test\Utils;

use PDO;
use PHPUnit\Framework\TestCase;
use Alirezasalehizadeh\QuickMigration\Migration;

class ExportMigrationFileTest extends TestCase
{

    private Migration $migration;
    private PDO $connection;
    private string $fileName = 'temp';

    protected function setUp(): void
    {
        $this->connection = new PDO('sqlite::memory:');
        $this->migration = new TempMigration($this->connection);
        $this->migration->setAutoRun(false);
    }

    protected function tearDown(): void
    {
        if (file_exists($file = $this->fileName . '.sql')) unlink($file);
    }

    /** @test */
    public function canExportMigrationFileTest()
    {
        $this->migration->dropIfExists('table');
        $this->migration->migrate();
        $this->migration->export($this->fileName);

        $this->assertFileExists($this->fileName . '.sql');

        $this->expectException(\Exception::class);
        (new TempMigration($this->connection))->setAutoRun(false)->dropIfExists('table');
        (new TempMigration($this->connection))->setAutoRun(false)->migrate();
        (new TempMigration($this->connection))->export($this->fileName);
    }
}
