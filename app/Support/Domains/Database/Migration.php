<?php

namespace App\Support\Domains\Database;

use Illuminate\Database\Migrations\Migration as DefaultMigration;

abstract class Migration extends DefaultMigration
{
    /**
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $schema;

    function __construct()
    {
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    abstract public function up(): void;

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    abstract public function down(): void;
}
