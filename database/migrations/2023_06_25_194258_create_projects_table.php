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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('type_id');
            $table->json('keywords');
            $table->text('description');
            $table->json('technologies');
            $table->integer('supervisor_id')->index();
            $table->text('look_to_future')->nullable();
            $table->float('score');
            $table->float('rate');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('created_at');

            $table->foreign('supervisor_id')->references('id')->on('teachers');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
