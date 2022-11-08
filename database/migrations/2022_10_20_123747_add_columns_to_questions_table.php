<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->text("memo")->nullable(); // 기타메모
            $table->text("reason_remove")->nullable(); // 삭제사유
            $table->string("user_remove")->nullable(); // 삭제자
            $table->string("user_create")->nullable(); // 작성자
            $table->boolean("public")->default(true); // 공개여부
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
        Schema::table('questions', function (Blueprint $table) {
            //
        });
    }
}
