<?php

namespace App\Domains\Post\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use App\Support\Domains\Database\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->schema->create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->drop('categories');
    }
}
