<?php

namespace App\Domains\Post\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use App\Support\Domains\Database\Migration;


class CreatePostsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->schema->create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->unsignedInteger('author')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('author')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->drop('posts');
    }
}
