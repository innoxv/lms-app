<?php

     use Illuminate\Database\Migrations\Migration;
     use Illuminate\Database\Schema\Blueprint;
     use Illuminate\Support\Facades\Schema;

     return new class extends Migration
     {
         public function up()
         {
             Schema::create('loan_offers', function (Blueprint $table) {
                 $table->integer('offer_id')->autoIncrement()->primary();
                 $table->integer('lender_id');
                 $table->foreign('lender_id')->references('lender_id')->on('lenders')->onDelete('cascade');
                 $table->string('loan_type', 255);
                 $table->decimal('interest_rate', 5, 2);
                 $table->decimal('max_amount', 15, 2);
                 $table->integer('max_duration');
             });
         }

         public function down()
         {
             Schema::dropIfExists('loan_offers');
         }
     };