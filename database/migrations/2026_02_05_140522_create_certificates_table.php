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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('roll')->index();
            $table->string('registration_number')->index();
            $table->unsignedSmallInteger('passing_year')->index();
            $table->string('name');
            $table->string('program');
            $table->string('batch')->nullable();
            $table->string('session')->nullable();
            $table->string('cgpa_or_class')->nullable();
            $table->timestamps();

            // Composite unique index for verification lookup
            $table->unique(['roll', 'registration_number', 'passing_year'], 'certificates_roll_reg_year_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
