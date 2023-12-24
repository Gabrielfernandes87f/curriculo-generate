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
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->string('projects_link')->nullable();
            $table->string('project')->nullable();
            $table->string('linkedin')->nullable();
            $table->text('about')->nullable();
            $table->text('education')->nullable();
            $table->text('course')->nullable();
            $table->string('course_link')->nullable();
            $table->text('expertise')->nullable();
            $table->string('languages')->nullable();
            $table->text('experience')->nullable();
            $table->string('Skills')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
