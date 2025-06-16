<?php

     use Illuminate\Database\Migrations\Migration;
     use Illuminate\Database\Schema\Blueprint;
     use Illuminate\Support\Facades\Schema;

     return new class extends Migration
     {
         public function up()
         {
             Schema::create('lenders', function (Blueprint $table) {
                 $table->integer('lender_id')->autoIncrement()->primary();
                 $table->string('name', 50);
                 $table->string('email', 255);
                 $table->string('phone', 15);
                 $table->string('password', 255);
                 $table->string('address', 255);
                 $table->string('status', 20)->default('active');
                 $table->timestamp('registration_date');
                 $table->decimal('total_loans', 15, 2);
                 $table->decimal('average_interest_rate', 5, 2);
                 $table->integer('user_id');
                 $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
             });
         }

         public function down()
         {
             Schema::dropIfExists('lenders');
         }
     };