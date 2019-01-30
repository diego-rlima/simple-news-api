<?php

namespace App\Domains\Upload\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use App\Support\Domains\Database\Migration;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->schema->create('uploads', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name', 200)->nullable();
            $table->string('path', 255);
            $table->json('data')->nullable();

            $table->nullableMorphs('owner');
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('uploads')
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
        $this->schema->drop('uploads');
    }
}
