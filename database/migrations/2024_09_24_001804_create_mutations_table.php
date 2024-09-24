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
        Schema::create('mutations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mutated_by');
            $table->unsignedBigInteger('mutated_item');
            $table->unsignedBigInteger('mutation_type');
            $table->integer('amount');
            $table->text('description');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('mutated_by')->references('id')->on('users');
            $table->foreign('mutated_item')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('mutation_type')->references('id')->on('mutation_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutations');
    }
};
