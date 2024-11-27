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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // Applicant details
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile_number');
            $table->text('supporting_statement')->nullable();
            $table->string('cv_path')->nullable();

            $table->foreignId('vacancy_reference')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
