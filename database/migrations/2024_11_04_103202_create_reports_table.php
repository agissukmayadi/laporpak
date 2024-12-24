<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description');
            $table->text('note_rejected')->nullable();
            $table->string('region');
            $table->string('latitude');
            $table->string('longitude');
            $table->enum('priority', ['Rendah', 'Menengah', 'Tinggi'])->nullable();
            $table->enum('status', ['Pending', 'Accepted', 'In Progress', 'Completed', 'Rejected'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
