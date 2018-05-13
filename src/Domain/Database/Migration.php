<?php

namespace Lenzy\Support\Domain\Database;

use Illuminate\Database\Migrations\Migration as LaravelMigration;

abstract class Migration extends LaravelMigration
{
    /**
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $schema;

    public function __construct()
    {
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Execute as migrações.
     */
    abstract public function up();

    /**
     * Inverta as migrações.
     */
    abstract public function down();
}
