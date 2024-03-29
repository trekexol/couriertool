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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_agent_shipper');
            $table->unsignedBigInteger('id_agent_vendor');
            $table->unsignedBigInteger('id_client');
            $table->unsignedBigInteger('id_agency_office_location');
           $table->unsignedBigInteger('id_agency_destination')->nullable();
            $table->unsignedBigInteger('id_wharehouse');
            $table->unsignedBigInteger('id_origin_country');
            $table->unsignedBigInteger('id_destination_country');
            $table->unsignedBigInteger('id_delivery_company'); 
            
            $table->unsignedBigInteger('id_client_recipient')->nullable();

            $table->unsignedBigInteger('id_tula')->nullable();
            $table->unsignedBigInteger('id_paddle')->nullable();

            $table->decimal('starting_weight',64,2)->nullable();
            $table->decimal('final_weight',64,2)->nullable();
            $table->decimal('volume',64,2)->nullable();
            $table->decimal('cubic_foot',64,2)->nullable();

            $table->string('tracking',250);
            $table->timestamp('arrival_date');
            $table->string('content',250);
            $table->string('value',250);
            $table->string('number_transport_guide',50)->nullable();
            $table->string('service_type',15);
            $table->string('instruction',20);
            $table->string('instruction_type',15);
            $table->string('description',250);


            $table->boolean('high_value')->default(false);
            $table->boolean('dangerous_goods')->default(false);
            $table->boolean('sed')->default(false);
            $table->boolean('document')->default(false);
            $table->boolean('fragile')->default(false);

            $table->decimal('total_usd',64,2)->nullable();

            $table->string('status',20)->nullable();
            
           
            $table->foreign('id_agent_shipper')->references('id')->on('agents');
            $table->foreign('id_agent_vendor')->references('id')->on('agents');
            $table->foreign('id_client')->references('id')->on('clients');
            $table->foreign('id_agency_office_location')->references('id')->on('agencies');
            $table->foreign('id_agency_destination')->references('id')->on('agencies');
            $table->foreign('id_wharehouse')->references('id')->on('wharehouses');
            $table->foreign('id_origin_country')->references('id')->on('countries');
            $table->foreign('id_destination_country')->references('id')->on('countries');
            $table->foreign('id_delivery_company')->references('id')->on('delivery_companies');
            $table->foreign('id_client_recipient')->references('id')->on('clients');
            $table->foreign('id_tula')->references('id')->on('tulas');
            $table->foreign('id_paddle')->references('id')->on('paddles');
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
        Schema::dropIfExists('packages');
    }
};
