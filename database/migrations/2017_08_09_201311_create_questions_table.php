<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
        * Run the migrations.
        *
        * @return void
        */
    public function up()
    {
        Schema::create("questions", function (Blueprint $table) {
            $table->uuid("id");
            $table->text("text");
            $table->enum("solution_type", ["open", "single", "multiple"]);
            $table->timestamps();

            $table->primary("id");
        });
    }

    /**
        * Reverse the migrations.
        *
        * @return void
        */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
