<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameResponsiblePhonesAndDniToObrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('obras', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->integer('phone')->nullable()->after('responsible');
            $table->integer('dni')->nullable()->after('responsible');
            $table->string('responsible_2')->nullable();
            $table->integer('dni_2')->nullable();
            $table->integer('phone_2')->nullable();
            $table->string('responsible_3')->nullable();
            $table->integer('dni_3')->nullable();
            $table->integer('phone_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('obras', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('dni');
            $table->dropColumn('phone');
            $table->dropColumn('responsible_2');
            $table->dropColumn('dni_2');
            $table->dropColumn('phone_2');
            $table->dropColumn('responsible_3');
            $table->dropColumn('dni_3');
            $table->dropColumn('phone_3');
        });
    }
}
