<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* Run the migrations. */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->ulid('public_id')->unique();
            $table->string('name', 50);
            $table->string('client', 50);
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->decimal('project_value', 15, 2)->default(0);
            $table->date('date_start');
            $table->date('date_deadline');
            $table->date('date_end')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->foreignId('user_created')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('user_updated')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /* Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

