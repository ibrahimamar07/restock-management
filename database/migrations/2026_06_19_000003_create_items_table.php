<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('items')) {
            Schema::create('items', function (Blueprint $table) {
                $table->id('idItem');
                $table->unsignedBigInteger('idStore');
                $table->string('itemName');
                $table->decimal('itemPrice', 15, 2)->default(0);
                $table->integer('stock')->default(0);
                $table->timestamps();

                $table->foreign('idStore')->references('idStore')->on('stores')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
