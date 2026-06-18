<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            // create item_id column without foreign key constraint to avoid ordering issues
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('content');
            $table->timestamps();
        });

        // Add foreign key constraints only if referenced tables exist
        if (Schema::hasTable('items')) {
            Schema::table('notes', function (Blueprint $table) {
                $table->foreign('item_id')->references('idItem')->on('items')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('notes', function (Blueprint $table) {
                $table->foreign('user_id')->references('idUser')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('notes');
    }
}
