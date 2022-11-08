<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewspapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newspapers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("curation_id");
            $table->foreign("curation_id")->references("id")->on("curations")->onDelete("cascade");
            $table->string("url");
            $table->string("img_url")->nullable();
            $table->integer("order")->default(1);
            $table->string("title")->nullable();
            $table->string("category")->nullable();
            $table->text("description")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newspapers');
    }
}
