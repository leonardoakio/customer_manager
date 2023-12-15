<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('address_id');
            $table->string('name');
            $table->string('mother_name');
            $table->string('document')->unique();
            $table->string('cns')->unique();
            $table->string('picture_url');
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('addresses');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['address_id']);
        });

        Schema::dropIfExists('customers');
    }
};
