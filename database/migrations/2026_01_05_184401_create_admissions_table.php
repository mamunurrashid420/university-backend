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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->string('phone_number');
            $table->string('email');
            $table->string('hear_about_us')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('assisted_by')->nullable();

            // SSC Results
            $table->string('ssc_roll');
            $table->string('ssc_registration_no');
            $table->decimal('ssc_gpa', 3, 2);
            $table->string('ssc_board')->nullable();
            $table->unsignedSmallInteger('ssc_passing_year')->nullable();

            // HSC Results
            $table->string('hsc_roll')->nullable();
            $table->string('hsc_registration_no')->nullable();
            $table->decimal('hsc_gpa', 3, 2)->nullable();
            $table->string('hsc_board')->nullable();
            $table->unsignedSmallInteger('hsc_passing_year')->nullable();

            // Honors Results
            $table->decimal('honors_gpa', 3, 2)->nullable();
            $table->unsignedSmallInteger('honors_passing_year')->nullable();
            $table->string('honors_institution')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
