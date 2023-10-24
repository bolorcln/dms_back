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
        Schema::create('report_permission_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_permission_id')->constrained('report_permissions')->cascadeOnDelete();
            $table->string('name');
            $table->string('type');
            $table->string('value_type');
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_permission_parameters');
    }
};
