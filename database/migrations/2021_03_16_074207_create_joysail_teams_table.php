<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoysailTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joysail_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->decimal('loa')->nullable();
            $table->decimal('draft')->nullable();
            $table->decimal('beam')->nullable();
            $table->string('sail_number');
            $table->datetime('date_arrival');
            $table->datetime('date_departure');
            $table->string('class')->nullable();
            $table->string('external_diver_required')->nullable();
            $table->string('car_plate_number')->nullable();
            $table->decimal('container_size')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_vat')->nullable();
            $table->string('company_zip_city')->nullable();
            $table->unsignedBigInteger('boat_id')->nullable();
            $table->timestamps();

            $table->index('boat_id');

            $table->foreign('boat_id')
                ->references('id')
                ->on('joysail_teams')
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
        Schema::dropIfExists('joysail_teams');
    }
}
