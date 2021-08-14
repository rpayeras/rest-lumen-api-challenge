<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExternalIdFieldAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('joysail_members', function(Blueprint $table){
            $table->unsignedBigInteger('external_id')->nullable();
        });

        Schema::table('joysail_teams', function(Blueprint $table){
            $table->unsignedBigInteger('external_id')->nullable();
        });

        Schema::table('joysail_attendants', function(Blueprint $table){
            $table->unsignedBigInteger('external_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('joysail_teams', function(Blueprint $table){
            $table->dropColumn('external_id');
        });
        Schema::table('joysail_members', function(Blueprint $table){
            $table->dropColumn('external_id');
        });
        Schema::table('joysail_attendants', function(Blueprint $table){
            $table->dropColumn('external_id');
        });
    }
}
