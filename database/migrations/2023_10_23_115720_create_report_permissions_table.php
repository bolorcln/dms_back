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
        Schema::create('report_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained();
            $table->string('action_type');
            $table->string('action');
            $table->string('for');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('group_id')->nullable()->constrained();

            $table->boolean('manual_data_upload_flag');
            $table->text('data_source_url')->nullable();
            $table->foreignId('report_upload_type_id')->nullable()->constrained('report_upload_types');
            $table->boolean('allow_manual_data_upload')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_permissions');
    }
};
