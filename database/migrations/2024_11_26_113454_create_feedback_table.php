<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->unsignedBigInteger('privateTeacher')->nullable();
            $table->unsignedBigInteger('leftUser');

            $table->foreign('privateTeacher')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('leftUser')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('atsauksmes');
    }
};
