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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained();
            // Vacancy Info
            $table->string('title', 100);
            $table->string('description', 500)->nullable();
            $table->text('skills_required')->nullable();
            $table->date('application_open_date')->nullable();
            $table->date('application_close_date')->nullable();
            $table->string('industry', 100)->nullable();
            $table->enum('vacancy_type', ['full-time', 'part-time', 'contract', 'temporary', 'internship'])->nullable();
            $table->string('reference_number')->unique();
            $table->string('logo')->nullable(); // Store the file path of the logo
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
