<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoysailMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joysail_members', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone', 100)->nullable();
            $table->string('email')->nullable();
            $table->string('nationality')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->timestamps();

            $table->index('team_id');;

            $table->foreign('team_id')
                ->references('id')
                ->on('joysail_teams')
                ->onDelete('set null');

            $table->foreign('category_id')
                ->references('id')
                ->on('joysail_categories_members')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('joysail_members', function(Blueprint $table){
            $table->dropForeign('joysail_members_category_id_foreign');
        });

        Schema::dropIfExists('joysail_members');
    }
}
