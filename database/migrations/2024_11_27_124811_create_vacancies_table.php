<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\VacancyTypeEnum;
use App\Enums\IndustryEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            // Vacancy Info
            $table->string('title', 100);
            $table->string('description', 500)->nullable();
            $table->text('skills_required')->nullable();
            $table->date('application_open_date')->nullable();
            $table->date('application_close_date')->nullable();
            $table->enum('industry', array_column(IndustryEnum::cases(), 'value'))->nullable();
            $table->enum('vacancy_type', array_column(VacancyTypeEnum::cases(), 'value'))->nullable();
            $table->string('reference_number')->unique();
            
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
