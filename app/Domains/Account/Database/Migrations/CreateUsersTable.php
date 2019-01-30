<?php

namespace App\Domains\Account\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use App\Support\Domains\Database\Migration;
use App\Domains\Account\Database\Seeders\UserSeeder;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->schema->create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        UserSeeder::registerDefaultAdmin();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->drop('users');
    }
}
