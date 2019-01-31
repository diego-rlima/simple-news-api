<?php

namespace App\Domains\Post\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use App\Support\Domains\Database\Migration;

class CreatePostCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->schema->create('post_category', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedInteger('category_id');

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('CASCADE');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->drop('post_category');
    }
}
