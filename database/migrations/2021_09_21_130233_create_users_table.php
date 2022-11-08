<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string("unique_id")->unique()->index(); // 이름
            $table->string("name")->nullable(); // 이름
            $table->integer("level")->default(1); // 레벨
            $table->integer("point")->default(0); // 경험치

            $table->unsignedBigInteger("template_id")->nullable();
            $table->foreign("template_id")->references("id")->on("templates");

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
