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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->int('gads');
            $table->string('limenis');
            $table->unsignedBigInteger('Mācību_priekšmets')->nullable();
            $table->unsignedBigInteger('Uzdevums')->nullable();
            $table->timestamps();

            $table->foreignId('macibu_prieksmets_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('uzdevums_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
};
