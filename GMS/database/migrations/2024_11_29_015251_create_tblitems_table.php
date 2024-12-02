<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblitems', function (Blueprint $table) {
            $table->increments('id'); // Use increments for primary key in older Laravel
            $table->unsignedInteger('workshop_id'); // FK to workshop table
            $table->unsignedInteger('product_id'); // FK for product
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('workshop_id')->references('id')->on('workshops')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblitems');
    }
}
