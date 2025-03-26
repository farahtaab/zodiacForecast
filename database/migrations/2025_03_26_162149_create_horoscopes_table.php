<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('horoscopes', function (Blueprint $table) {
            $table->id();
            $table->string('sign');
            $table->string('lang');
            $table->string('time'); // today, week, month...
            $table->text('prediction');
            $table->date('date'); // para saber de qué día es la predicción
            $table->timestamps();

            $table->unique(['sign', 'lang', 'time', 'date']); // evita duplicados
        });
    }

    public function down()
    {
        Schema::dropIfExists('horoscopes');
    }
};
