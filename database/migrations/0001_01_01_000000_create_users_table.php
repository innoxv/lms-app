<?php

     use Illuminate\Database\Migrations\Migration;
     use Illuminate\Database\Schema\Blueprint;
     use Illuminate\Support\Facades\Schema;

     return new class extends Migration
     {
         public function up()
         {
             Schema::create('users', function (Blueprint $table) {
                 $table->integer('user_id')->autoIncrement()->primary();
                 $table->string('user_name', 50);
                 $table->string('email', 255);
                 $table->string('phone', 15);
                 $table->string('password', 255);
                 $table->string('role', 20);
                 $table->string('status', 8)->default('active');
             });
         }

         public function down()
         {
             Schema::dropIfExists('users');
         }
     };