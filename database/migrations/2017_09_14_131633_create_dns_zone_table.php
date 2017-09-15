<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnsZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dns_zone', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250);
            $table->integer('dns_server_id')->unsigned();
            $table->timestamps();

	    $table->foreign('dns_server_id')->references('id')->on('dns_server');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dns_zone');
    }
}
