<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLangTimeDateIndexToHoroscopesTable extends Migration
{
    public function up()
    {
        Schema::table('horoscopes', function (Blueprint $table) {
            $table->index(['lang', 'time', 'date']);
        });
    }

    public function down()
    {
        Schema::table('horoscopes', function (Blueprint $table) {
            $table->dropIndex(['horoscopes_lang_time_date_index']);
        });
    }
}
