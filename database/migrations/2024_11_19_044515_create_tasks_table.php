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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            
            $table->string('title');
            $table->date('due_date');
            $table->enum('priority', ['high', 'medium', 'low']);
            
            
            $table->text('description')->nullable();
            
            
            $table->boolean('is_completed')->default(false);
            $table->boolean('is_paid')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};